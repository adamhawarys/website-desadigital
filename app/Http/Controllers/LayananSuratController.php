<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\ProfilDesa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LayananSuratController extends Controller
{
    public function index()
    {
        $layanan = Layanan::orderBy('id', 'asc')->get();
        return view('admin.layanan.index', compact('layanan'));
    }

    public function create()
    {
        return view('admin.layanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required',
            'kode_layanan' => 'required|unique:layanan',
        ]);

        Layanan::create($request->all());

        return redirect()->route('layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan');
    }

    public function edit(Layanan $layanan)
    {
        return view('admin.layanan.edit', compact('layanan'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'nama_layanan' => 'required',
            'kode_layanan' => 'required|unique:layanan,kode_layanan,' . $layanan->id,
        ]);

        $layanan->update($request->all());

        return redirect()->route('layanan.index')
            ->with('success', 'Layanan berhasil diperbarui');
    }

    public function destroy(Layanan $layanan)
    {
        $layanan->delete();

        return redirect()->route('layanan.index')
            ->with('success', 'Layanan berhasil dihapus');
    }

    public function preview(Layanan $layanan)
    {
        $profil = ProfilDesa::first();

        if (!$layanan->template_surat) {
            return back()->with('error', 'Template surat belum diisi.');
        }

        $template = $layanan->template_surat;
        $template = str_replace('{{nama_lengkap}}',      'NAMA LENGKAP PEMOHON', $template);
        $template = str_replace('{{nik}}',               '1234567890123456', $template);
        $template = str_replace('{{kk}}',                '1234567890123456', $template);
        $template = str_replace('{{tempat_lahir}}',      'Mataram', $template);
        $template = str_replace('{{tanggal_lahir}}',     '01 Januari 1990', $template);
        $template = str_replace('{{jenis_kelamin}}',     'Laki-laki', $template);
        $template = str_replace('{{agama}}',             'Islam', $template);
        $template = str_replace('{{pekerjaan}}',         'Wiraswasta', $template);
        $template = str_replace('{{pendidikan}}',        'SMA/Sederajat', $template);
        $template = str_replace('{{kewarganegaraan}}',   'Indonesia', $template);
        $template = str_replace('{{status_perkawinan}}', 'Belum Kawin', $template);
        $template = str_replace('{{alamat}}',            'Jl. Contoh No. 1', $template);
        $template = str_replace('{{rt}}',                '001', $template);
        $template = str_replace('{{dusun}}',             'Dusun Contoh', $template);
        $template = str_replace('{{desa}}',              $profil->nama_desa ?? 'Bengkel', $template);
        $template = str_replace('{{kecamatan}}',         'Labuapi', $template);
        $template = str_replace('{{keperluan}}',         'Keperluan Contoh', $template);
        $template = str_replace('{{nomor_surat}}',       '000/PREVIEW/2026', $template);
        $template = str_replace('{{tanggal_disetujui}}', Carbon::now()->translatedFormat('d F Y'), $template);
        $template = str_replace('{{nama_desa}}',         $profil->nama_desa ?? 'Bengkel', $template);
        $template = str_replace('{{kades}}',             $profil->kades ?? 'Kepala Desa', $template);
        $template = str_replace('{{sekdes}}',            $profil->sekdes ?? 'Sekretaris Desa', $template);
        $template = str_replace('{{alamat_desa}}',       $profil->alamat ?? '-', $template);
        $template = str_replace('{{kode_pos}}',          $profil->kode_pos ?? '-', $template);

        // ============================
        // DATA TAMBAHAN (detail_layanan) → dummy
        // ============================
        $detailLayanan = $layanan->detailLayanan()->get();
        foreach ($detailLayanan as $detail) {
            $namaField = $detail->keterangan ?? null;
            if (!$namaField) continue;

            $placeholder = '{{' . Str::slug($namaField, '_') . '}}';
            $dummyValue  = strtoupper(Str::slug($namaField, '_'));
            
            $template    = str_replace($placeholder, '[' . $dummyValue . ']', $template);
        }

        // ============================
        // AMBIL LOGO DESA → BASE64
        // ============================
        $logoBase64 = null;
        if ($profil && $profil->logo) {
            try {
                $logoContent = Storage::disk('s3')->get($profil->logo);
                $ext         = strtolower(pathinfo($profil->logo, PATHINFO_EXTENSION));
                $mimeMap     = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png'];
                $logoMime    = $mimeMap[$ext] ?? 'image/png';
                $logoBase64  = 'data:' . $logoMime . ';base64,' . base64_encode($logoContent);
            } catch (\Exception $e) {
                $logoBase64 = null;
            }
        }

        // ============================
        // AMBIL LOGO KABUPATEN → BASE64
        // ============================
        $logoKabBase64 = null;
        try {
            $pathLogoKab = 'logo-desa/logo-lobar.png';
            if (Storage::disk('s3')->exists($pathLogoKab)) {
                $logoKabContent = Storage::disk('s3')->get($pathLogoKab);
                $logoKabBase64  = 'data:image/png;base64,' . base64_encode($logoKabContent);
            }
        } catch (\Exception $e) {
            $logoKabBase64 = null;
        }

        $pdf = Pdf::setOptions(['isRemoteEnabled' => true])
            ->loadView('surat.template', [
                'profil'          => $profil,
                'template'        => $template,
                'logoBase64'      => $logoBase64,
                'logoKabBase64'   => $logoKabBase64,
                'tanggalDisetujui'=> Carbon::now()->translatedFormat('d F Y'),
            ])->setPaper('a4', 'portrait');

        return $pdf->stream('preview-' . Str::slug($layanan->nama_layanan) . '.pdf');
    }
}