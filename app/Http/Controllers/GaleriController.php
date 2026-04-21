<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GaleriController extends Controller
{
    /**
     * Tampilkan semua data galeri dengan pencarian.
     */
    public function index(Request $request)
    {
        $cari_galeri = $request->get('table_search');

        $galeri = Galeri::when($cari_galeri, function ($query) use ($cari_galeri) {
                $query->where(function ($sub) use ($cari_galeri) {
                    $sub->where('judul', 'like', '%' . $cari_galeri . '%')
                        ->orWhere('deskripsi', 'like', '%' . $cari_galeri . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Biar pagination tetap bawa keyword
        $galeri->appends(['table_search' => $cari_galeri]);

        return view('admin.galeri.index', compact('galeri', 'cari_galeri'));
    }

    /**
     * Tampilkan form tambah galeri.
     */
    public function create()
    {
        return view('admin.galeri.create');
    }

    /**
     * Simpan data galeri baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'foto'      => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'judul'     => 'nullable|max:255',
            'deskripsi' => 'nullable|string',
            'status'    => 'required|in:aktif,nonaktif',
        ], [
            'foto.required' => 'Foto Tidak Boleh Kosong',
            'foto.image'    => 'File Harus Berupa Gambar',
            'foto.mimes'    => 'Format Gambar JPG, JPEG, PNG, WEBP',
            'foto.max'      => 'Ukuran Gambar Maksimal 2MB',
            'status.required' => 'Status Harus Dipilih',
            'status.in'       => 'Status Tidak Valid',
        ]);

        // Upload foto ke S3
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            // Buat nama file unik
            $namaFile = Str::slug($request->judul ?? 'galeri') . '-' . time() . '.' . $file->getClientOriginalExtension();

            // Simpan ke folder galeri_photos di S3 dan set public
            $foto = Storage::disk('s3')->putFileAs(
                'galeri_photos',
                $file,
                $namaFile,
                'public'
            );
        } else {
            $foto = null;
        }

        $galeri = new Galeri;
        $galeri->foto      = $foto;
        $galeri->judul     = $request->judul;
        $galeri->deskripsi = $request->deskripsi;
        $galeri->status    = $request->status;

        $galeri->save();

        return redirect()->route('galeri.index')->with('success', 'Foto Berhasil Ditambahkan');
    }

    /**
     * Tampilkan detail satu item galeri.
     */
    public function show(string $id)
    {
        $galeri = Galeri::findOrFail($id);

        return view('admin.galeri.show', compact('galeri'));
    }

    /**
     * Tampilkan form edit galeri.
     */
    public function edit(string $id)
    {
        $galeri = Galeri::findOrFail($id);

        return view('admin.galeri.edit', compact('galeri'));
    }

    /**
     * Update data galeri ke database.
     */
    public function update(Request $request, string $id)
    {
        $galeri = Galeri::findOrFail($id);

        $request->validate([
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'judul'     => 'nullable|max:255',
            'deskripsi' => 'nullable|string',
            'status'    => 'required|in:aktif,nonaktif',
        ], [
            'foto.image'    => 'File Harus Berupa Gambar',
            'foto.mimes'    => 'Format Gambar JPG, JPEG, PNG, WEBP',
            'foto.max'      => 'Ukuran Gambar Maksimal 2MB',
            'status.required' => 'Status Harus Dipilih',
            'status.in'       => 'Status Tidak Valid',
        ]);

        if ($request->hasFile('foto')) {

            // Hapus foto lama dari S3 (jika ada)
            if ($galeri->foto && Storage::disk('s3')->exists($galeri->foto)) {
                Storage::disk('s3')->delete($galeri->foto);
            }

            $file = $request->file('foto');

            // Buat nama file unik
            $namaFile = Str::slug($request->judul ?? 'galeri') . '-' . time() . '.' . $file->getClientOriginalExtension();

            // Simpan ke folder galeri_photos di S3 dan set public
            $galeri->foto = Storage::disk('s3')->putFileAs(
                'galeri_photos',
                $file,
                $namaFile,
                'public'
            );
        }

        // Update data lain
        $galeri->judul     = $request->judul;
        $galeri->deskripsi = $request->deskripsi;
        $galeri->status    = $request->status;

        $galeri->save();

        return redirect()->route('galeri.index')->with('success', 'Foto Berhasil Diperbarui');
    }

    /**
     * Hapus data galeri beserta fotonya dari S3.
     */
    public function destroy(string $id)
    {
        // Cari galeri berdasarkan ID
        $galeri = Galeri::findOrFail($id);

        // Hapus foto dari S3
        if ($galeri->foto && Storage::disk('s3')->exists($galeri->foto)) {
            Storage::disk('s3')->delete($galeri->foto);
        }

        // Hapus data dari database
        $galeri->delete();

        return redirect()->route('galeri.index')->with('success', 'Foto Berhasil Dihapus');
    }

    /**
     * Toggle status aktif/nonaktif.
     */
    public function toggleStatus(string $id)
    {
        $galeri = Galeri::findOrFail($id);

        $galeri->status = $galeri->status === 'aktif' ? 'nonaktif' : 'aktif';
        $galeri->save();

        return back()->with('success', 'Status Berhasil Diubah');
    }
}