<?php

namespace App\Services;

use App\Models\Pengajuan;
use App\Models\ProfilDesa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SuratService
{
    public function generateAndSimpan(Pengajuan $pengajuan): ?string
    {
        $layanan  = $pengajuan->layanan;
        $penduduk = $pengajuan->penduduk
            ?? $pengajuan->user?->penduduk
            ?? null;

        if (!$penduduk) return null;

        $profil = ProfilDesa::first();

        if (!$layanan || !$layanan->template_surat) {
            return null;
        }

        // ============================
        // REPLACE PLACEHOLDER
        // ============================
        $template = $layanan->template_surat;

        // Data profil desa
        $template = str_replace('{{nama_desa}}',   $profil->nama_desa ?? '-', $template);
        $template = str_replace('{{alamat_desa}}', $profil->alamat    ?? '-', $template);
        $template = str_replace('{{kode_pos}}',    $profil->kode_pos  ?? '-', $template);
        $template = str_replace('{{kades}}',       $profil->kades     ?? '-', $template);
        $template = str_replace('{{sekdes}}',      $profil->sekdes    ?? '-', $template);

        // Data pemohon
        $template = str_replace('{{nama_lengkap}}',  $penduduk->nama_lengkap  ?? '-', $template);
        $template = str_replace('{{nik}}',           $penduduk->nik           ?? '-', $template);
        $template = str_replace('{{kk}}',            $penduduk->kk            ?? '-', $template);
        $template = str_replace('{{tempat_lahir}}',  $penduduk->tempat_lahir  ?? '-', $template);
        $template = str_replace('{{tanggal_lahir}}',
            $penduduk->tanggal_lahir
                ? Carbon::parse($penduduk->tanggal_lahir)->translatedFormat('d F Y')
                : '-', $template);
        
        $jenisKelamin = match($penduduk->jenis_kelamin ?? '') {
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
            default => $penduduk->jenis_kelamin ?? '-'
        };
        $template = str_replace('{{jenis_kelamin}}',     $jenisKelamin, $template);
        $template = str_replace('{{agama}}',             $penduduk->agama             ?? '-', $template);
        $template = str_replace('{{pekerjaan}}',         $penduduk->pekerjaan         ?? '-', $template);
        $template = str_replace('{{pendidikan}}',        $penduduk->pendidikan        ?? '-', $template);
        $template = str_replace('{{kewarganegaraan}}',   $penduduk->kewarganegaraan   ?? '-', $template);
        $template = str_replace('{{status_perkawinan}}', $penduduk->status_perkawinan ?? '-', $template);
        $template = str_replace('{{alamat}}',            $penduduk->alamat            ?? '-', $template);
        $template = str_replace('{{rt}}',                $penduduk->rt                ?? '-', $template);
        $template = str_replace('{{dusun}}',             $penduduk->dusun             ?? '-', $template);
        $template = str_replace('{{desa}}',              $penduduk->desa              ?? '-', $template);
        $template = str_replace('{{kecamatan}}',         $penduduk->kecamatan         ?? '-', $template);

        // Data pengajuan
        $template = str_replace('{{keperluan}}',   $pengajuan->keperluan   ?? '-', $template);
        $template = str_replace('{{nomor_surat}}', $pengajuan->nomor_surat ?? '-', $template);
        $template = str_replace('{{tanggal_disetujui}}',
            $pengajuan->tanggal_disetujui
                ? Carbon::parse($pengajuan->tanggal_disetujui)->translatedFormat('d F Y')
                : '-',
            $template
        );

        // ============================
        // DATA TAMBAHAN (detail_pengajuan)
        // ============================
        $detailPengajuan = $pengajuan->detail()->with('detailLayanan')->get();

        foreach ($detailPengajuan as $detail) {
            $namaField  = $detail->detailLayanan->keterangan ?? null;
            if (!$namaField) continue;

            $placeholder = '{{' . Str::slug($namaField, '_') . '}}';
            
            $template    = str_replace($placeholder, $detail->isi ?? '-', $template);
        }

        // ===============================================
        // AMBIL DUA LOGO (KAB & DESA) DARI S3 → BASE64
        // ===============================================
        
        // 1. LOGO DESA (Dinonaktifkan jika kosong)
        $logoBase64 = null;
        if ($profil && $profil->logo) {
            try {
                $logoContent = Storage::disk('s3')->get($profil->logo);
                $logoBase64 = 'data:image/png;base64,' . base64_encode($logoContent);
            } catch (\Exception $e) { $logoBase64 = null; }
        }

        // 2. LOGO KABUPATEN (Lombok Barat - Statis di S3)
        $logoKabBase64 = null;
        try {
            $pathLogoKab = 'logo-desa/logo-lobar.png';
            if (Storage::disk('s3')->exists($pathLogoKab)) {
                $logoKabContent = Storage::disk('s3')->get($pathLogoKab);
                $logoKabBase64 = 'data:image/png;base64,' . base64_encode($logoKabContent);
            }
        } catch (\Exception $e) { $logoKabBase64 = null; }

        // ============================
        // GENERATE PDF
        // ============================
        $pdf = Pdf::setOptions(['isRemoteEnabled' => true])
            ->loadView('surat.template', [
                'profil'           => $profil,
                'template'         => $template,
                'logoBase64'       => $logoBase64,      // Logo Desa (Kanan)
                'logoKabBase64'    => $logoKabBase64,   // Logo Kabupaten (Kiri)
                'tanggalDisetujui' => $pengajuan->tanggal_disetujui 
                                        ? Carbon::parse($pengajuan->tanggal_disetujui)->translatedFormat('d F Y') 
                                        : now()->translatedFormat('d F Y'),
            ])->setPaper('a4', 'portrait');

        // ============================
        // SIMPAN KE S3
        // ============================
        $tahun       = now()->year;
        $namaLayanan = Str::slug($layanan->nama_layanan);
        $namaFile    = "pengajuan_{$pengajuan->id}.pdf";
        $path        = "surat-terbit/{$tahun}/{$namaLayanan}/{$namaFile}";

        Storage::disk('s3')->put($path, $pdf->output(), 'public');

        $pengajuan->update(['surat_pdf' => $path]);

        return $path;
    }
}