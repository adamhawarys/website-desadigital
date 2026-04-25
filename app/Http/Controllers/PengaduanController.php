<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Services\SqsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    // ============================
    // WARGA / GUEST
    // ============================

    public function create()
    {
        return view('pengaduan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'judul' => 'required|string|max:255',
            'isi'   => 'required|string',
            'foto'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama.required'  => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email'    => 'Format email tidak valid',
            'judul.required' => 'Judul tidak boleh kosong',
            'isi.required'   => 'Isi pengaduan tidak boleh kosong',
            'foto.image'     => 'File harus berupa gambar',
            'foto.mimes'     => 'Format foto harus jpg, jpeg, atau png',
            'foto.max'       => 'Ukuran foto maksimal 2MB',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = Storage::disk('s3')->putFile(
                'pengaduan_foto',
                $request->file('foto'),
                'public'
            );
        }

        $pengaduan = Pengaduan::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'nama'    => $request->nama,
            'email'   => $request->email,
            'judul'   => $request->judul,
            'isi'     => $request->isi,
            'foto'    => $fotoPath,
            'status'  => 'Menunggu',
        ]);

        // ============================
        // NOTIF KE ADMIN via SQS → Lambda → SNS
        // ============================
        try {
            $sqs        = new SqsService();
            $pesanAdmin = "Ada pengaduan baru masuk!\n\n"
                        . "Nama    : {$pengaduan->nama}\n"
                        . "Email   : {$pengaduan->email}\n"
                        . "Judul   : {$pengaduan->judul}\n"
                        . "Tanggal : " . now()->translatedFormat('d F Y H:i') . "\n\n"
                        . "Isi Pengaduan:\n{$pengaduan->isi}\n\n"
                        . "Silakan login ke dashboard admin untuk menindaklanjuti.";

            $sqs->kirimPesan('Pengaduan Baru: ' . $pengaduan->judul, $pesanAdmin, null, 'admin');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('[SQS] Gagal kirim notif admin pengaduan baru: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Pengaduan berhasil dikirim. Kami akan segera menindaklanjuti.');
    }

    // ============================
    // ADMIN
    // ============================

    public function index()
    {
        $pengaduans = Pengaduan::with(['balasanThread.user'])->latest()->paginate(10);
        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    public function balas(Request $request, $id)
    {
        $request->validate(['balasan' => 'required|string'], [
            'balasan.required' => 'Balasan tidak boleh kosong',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        \App\Models\PengaduanBalasan::create([
            'pengaduan_id' => $pengaduan->id,
            'user_id'      => Auth::id(),
            'isi'          => $request->balasan,
        ]);

        if ($pengaduan->status === 'menunggu') {
            $pengaduan->update(['status' => 'diproses']);
        }

        // Notif personal ke warga dihapus — warga cek dashboard
        return redirect()->route('admin.pengaduan.index')
            ->with('success', 'Balasan berhasil dikirim');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:menunggu,diproses,selesai']);

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update(['status' => $request->status]);

        // Notif personal ke warga dihapus — warga cek dashboard
        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if ($pengaduan->foto) {
            Storage::disk('s3')->delete($pengaduan->foto);
        }

        $pengaduan->delete();

        return redirect()->route('admin.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus');
    }
}