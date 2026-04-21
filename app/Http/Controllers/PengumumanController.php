<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Services\SqsService; // <-- Jangan lupa import SqsService
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // <-- Jangan lupa import Log

class PengumumanController extends Controller
{
    /**
     * Tampilkan daftar pengumuman
     */
    public function index(Request $request)
    {
        $query = Pengumuman::query();

        // Search
        if ($request->filled('table_search')) {
            $query->where('judul', 'like', '%' . $request->table_search . '%')
                  ->orWhere('kategori', 'like', '%' . $request->table_search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->table_search . '%');
        }

        $pengumuman = $query->orderBy('tanggal_mulai', 'desc')
                            ->paginate(5)
                            ->withQueryString();

        return view('admin.pengumuman.index', compact('pengumuman'));
    }

    /**
     * Form tambah pengumuman
     */
    public function create()
    {
        return view('admin.pengumuman.create');
    }

    /**
     * Simpan pengumuman baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'            => 'required|string|max:255',
            'kategori'         => 'nullable|string|max:100',
            'deskripsi'        => 'required|string',
            'status'           => 'required|in:aktif,berakhir',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // 1. Simpan ke database dan tangkap datanya ke variabel $pengumuman
        $pengumuman = Pengumuman::create($request->all());

        // 2. Lempar tugas ke AWS SQS biar di-broadcast ke warga
        try {
            $sqs        = new SqsService();
            
            // Bikin format tanggal yang enak dibaca (Contoh: 03 April 2026)
            $tglMulai   = \Carbon\Carbon::parse($pengumuman->tanggal_mulai)->translatedFormat('d F Y');
            $tglSelesai = \Carbon\Carbon::parse($pengumuman->tanggal_selesai)->translatedFormat('d F Y');

            $pesanWarga = "Halo Warga Desa Bengkel,\n\n"
                        . "Ada pengumuman baru dari Pemerintah Desa:\n\n"
                        . "Judul     : {$pengumuman->judul}\n"
                        . "Kategori  : " . ($pengumuman->kategori ?? '-') . "\n"
                        . "Berlaku   : {$tglMulai} s/d {$tglSelesai}\n\n"
                        . "Isi Pengumuman:\n{$pengumuman->deskripsi}\n\n"
                        . "Demikian informasi ini kami sampaikan untuk diketahui bersama.\n"
                        . "Terima kasih.";

            // Tembak ke SQS dengan tipe 'warga'
            $sqs->kirimPesan('Pengumuman Desa: ' . $pengumuman->judul, $pesanWarga, null, 'broadcast');
        } catch (\Exception $e) {
            Log::error('[SQS] Gagal kirim notif pengumuman baru: ' . $e->getMessage());
        }

        return redirect()
            ->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan');
    }

    /**
     * Form edit pengumuman
     */
    public function edit(string $id)
    {
        $pengumuman = Pengumuman::findOrFail(($id));
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    /**
     * Update pengumuman
     */
    public function update(Request $request, string $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        $validated = $request->validate([
            'judul'           => 'required|string|max:255',
            'kategori'        => 'nullable|string|max:100',
            'deskripsi'       => 'required|string',
            'status'          => 'required|in:aktif,berakhir',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        // Hilangkan field tanggal kalau kosong agar tidak di-update ke null
        if (!$request->filled('tanggal_mulai')) {
            unset($validated['tanggal_mulai']);
        }
        if (!$request->filled('tanggal_selesai')) {
            unset($validated['tanggal_selesai']);
        }

        $pengumuman->update($validated);

        return redirect()
            ->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui');
    }

    /**
     * Hapus pengumuman
     */
    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return redirect()
            ->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus');
    }
}