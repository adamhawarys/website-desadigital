<?php

namespace App\Http\Controllers;

use App\Models\DetailPengajuan;
use App\Models\Pengajuan;
use App\Models\Layanan;
use App\Models\Penduduk;
use App\Models\User;
use App\Services\SuratService;
use App\Services\SqsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PengajuanController extends Controller
{
    /*
    | ADMIN SECTION
    */

    public function adminIndex()
    {
        $pengajuan = Pengajuan::with(['user', 'layanan'])
                        ->latest()
                        ->paginate(10);

        return view('admin.pengajuan.index', compact('pengajuan'));
    }

    public function adminCreate()
    {
        $layanan = Layanan::orderBy('nama_layanan', 'asc')->get();
        return view('admin.pengajuan.create', compact('layanan'));
    }

    public function adminCariNik(Request $request)
    {
        $request->validate(['nik' => 'required|digits:16']);

        $p = Penduduk::where('nik', $request->nik)->first();

        if (!$p) {
            return response()->json([
                'status'  => 'not_found',
                'message' => 'NIK tidak ditemukan. Silakan isi data pemohon manual.'
            ], 404);
        }

        return response()->json([
            'status' => 'found',
            'data'   => [
                'id'           => $p->id,
                'nik'          => $p->nik,
                'nama_lengkap' => $p->nama_lengkap,
                'alamat'       => $p->alamat,
                'rt'           => $p->rt,
                'dusun'        => $p->dusun,
                'desa'         => $p->desa,
                'kecamatan'    => $p->kecamatan,
            ]
        ]);
    }

    public function adminDetailLayanan(Layanan $layanan)
    {
        $fields = $layanan->detailLayanan()
            ->orderBy('id', 'asc')
            ->get(['id', 'keterangan', 'tipe_input', 'wajib']);

        return response()->json(['status' => 'success', 'data' => $fields]);
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'pemohon_mode' => 'required|in:found,manual',
            'layanan_id'   => 'required|exists:layanan,id',
            'keperluan'    => 'required|string|max:1000',
        ]);

        $layanan = Layanan::with('detailLayanan')->findOrFail($request->layanan_id);

        $rules = [];
        foreach ($layanan->detailLayanan as $f) {
            $wajib = (int) $f->wajib === 1;
            $key   = "detail.{$f->id}";

            $rules[$key] = [$wajib ? 'required' : 'nullable'];
            $tipe = strtolower($f->tipe_input);
            if ($tipe === 'number')   $rules[$key][] = 'numeric';
            elseif ($tipe === 'date') $rules[$key][] = 'date';
            else                      $rules[$key][] = 'string';
            $rules[$key][] = 'max:1000';
        }
        $request->validate($rules);

        $pendudukId = null;

        if ($request->pemohon_mode === 'found') {
            $request->validate(['penduduk_id' => 'required|exists:penduduk,id']);
            $pendudukId = (int) $request->penduduk_id;
        } else {
            $request->validate([
                'pemohon_nik'          => 'required|digits:16|unique:penduduk,nik',
                'pemohon_nama_lengkap' => 'required|string|max:255',
                'pemohon_alamat'       => 'nullable|string|max:255',
                'pemohon_rt'           => 'nullable|string|max:10',
                'pemohon_dusun'        => 'nullable|string|max:100',
                'pemohon_desa'         => 'nullable|string|max:100',
                'pemohon_kecamatan'    => 'nullable|string|max:100',
            ]);

            $p = Penduduk::create([
                'nik'          => $request->pemohon_nik,
                'nama_lengkap' => $request->pemohon_nama_lengkap,
                'alamat'       => $request->pemohon_alamat,
                'rt'           => $request->pemohon_rt,
                'dusun'        => $request->pemohon_dusun,
                'desa'         => $request->pemohon_desa,
                'kecamatan'    => $request->pemohon_kecamatan,
                'user_id'      => null,
            ]);

            $pendudukId = $p->id;
        }

        $pengajuan = Pengajuan::create([
            'user_id'           => null,
            'penduduk_id'       => $pendudukId,
            'layanan_id'        => $layanan->id,
            'keperluan'         => $request->keperluan,
            'tanggal_pengajuan' => now(),
            'status'            => 'Menunggu Diproses',
        ]);

        foreach ($request->input('detail', []) as $detailLayananId => $isi) {
            if ($isi === null || $isi === '') continue;
            DetailPengajuan::create([
                'pengajuan_id'      => $pengajuan->id,
                'detail_layanan_id' => (int) $detailLayananId,
                'isi'               => $isi,
            ]);
        }

        return redirect()
            ->route('pengajuan.index')
            ->with('success', 'Pengajuan berhasil dibuat.');
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::with([
            'user.penduduk',
            'layanan.persyaratan',
            'berkas.persyaratan',
            'detail.detailLayanan',
        ])->findOrFail($id);

        return view('admin.pengajuan.detail', compact('pengajuan'));
    }

    // APPROVE PENGAJUAN
    public function approve($id)
    {
        $pengajuan = Pengajuan::with(['layanan', 'user.penduduk', 'penduduk'])
                        ->findOrFail($id);

        $tahun       = now()->year;
        $bulanRomawi = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'][now()->month - 1];
        $kode        = strtoupper($pengajuan->layanan->kode_layanan ?? 'SURAT');

        $nomorUrut = Pengajuan::where('layanan_id', $pengajuan->layanan_id)
            ->where('status', 'Disetujui')
            ->whereYear('tanggal_disetujui', $tahun)
            ->count() + 1;

        $nomorSurat = sprintf('%s / %03d / DS-BKL / %s / %d', $kode, $nomorUrut, $bulanRomawi, $tahun);

        $pengajuan->update([
            'status'            => 'Disetujui',
            'tanggal_disetujui' => now(),
            'nomor_surat'       => $nomorSurat,
        ]);

        $pengajuan = $pengajuan->fresh(['layanan', 'user.penduduk', 'penduduk']);

        $suratService = new SuratService();
        $suratService->generateAndSimpan($pengajuan);

        // Notif ke warga dihapus — warga memantau status via dashboard
        return back()->with('success', 'Pengajuan berhasil disetujui');
    }

    // REJECT PENGAJUAN
    public function reject($id)
    {
        $pengajuan = Pengajuan::with(['layanan', 'user.penduduk', 'penduduk'])
                        ->findOrFail($id);

        $pengajuan->update(['status' => 'Ditolak']);

        // Notif ke warga dihapus — warga memantau status via dashboard
        return back()->with('success', 'Pengajuan berhasil ditolak');
    }

    public function destroy($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        $pengajuan->detail()->delete();
        $pengajuan->berkas()->delete();
        $pengajuan->delete();

        return redirect()
            ->route('pengajuan.index')
            ->with('success', 'Pengajuan berhasil dihapus.');
    }

    /*
    | USER SECTION
    */

    public function userIndex()
    {
        $pengajuans = Pengajuan::with('layanan')
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->paginate(10);

        return view('user.pengajuan.index', compact('pengajuans'));
    }

    public function create()
    {
        $layanan = Layanan::all();
        return view('user.pengajuan.create', compact('layanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required',
            'keperluan'  => 'required'
        ]);

        Pengajuan::create([
            'user_id'           => Auth::id(),
            'layanan_id'        => $request->layanan_id,
            'keperluan'         => $request->keperluan,
            'tanggal_pengajuan' => now(),
            'status'            => 'pending'
        ]);

        return redirect()
            ->route('user.pengajuan')
            ->with('success', 'Pengajuan berhasil dikirim');
    }
}