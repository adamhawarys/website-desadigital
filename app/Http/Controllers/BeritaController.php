<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{ 
    
    public function index(Request $request)
{
    $cari_berita = $request->get('table_search');

    $berita = Berita::with('penulis')
        ->when($cari_berita, function ($query) use ($cari_berita) {
            $query->where(function ($sub) use ($cari_berita) {
                $sub->where('judul', 'like', '%' . $cari_berita . '%')
                    ->orWhere('slug', 'like', '%' . $cari_berita . '%')
                    ->orWhere('konten', 'like', '%' . $cari_berita . '%');
            });
        })
        ->orderBy('tanggal_publikasi', 'desc')
        ->paginate(6);

        // tambahkan ringkasan konten untuk ditampilkan di tabel
    $berita->getCollection()->transform(function ($item) {
        $item->excerpt = Str::words(strip_tags($item->konten), 30, '...');
        return $item;
    });


    // biar pagination tetap bawa keyword
    $berita->appends(['table_search' => $cari_berita]);

    return view('admin.berita.index', compact('berita', 'cari_berita'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'judul'   => 'required|max:255',
        'slug'    => 'required|unique:berita,slug',
        'konten'  => 'required',
        'status'  => 'required',
        'gambar'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ], [
        'judul.required'  => 'Judul Tidak Boleh Kosong',
        'slug.required'   => 'Slug Tidak Boleh Kosong',
        'slug.unique'     => 'Slug Sudah Digunakan',
        'konten.required' => 'Konten Tidak Boleh Kosong',
        'status.required' => 'Status Harus Dipilih',
        'gambar.image'    => 'File Harus Berupa Gambar',
        'gambar.mimes'    => 'Format Gambar JPG, JPEG, PNG',
    ]);

    // upload ke s3
if ($request->hasFile('gambar')) {
    $file = $request->file('gambar');

    // buat nama file unik agar tidak ketimpa
    $namaFile = Str::slug($request->judul) . '-' . time() . '.' . $file->getClientOriginalExtension();

    // simpan ke folder berita_photos di S3 dan set public
    $gambar = Storage::disk('s3')->putFileAs(
        'berita_photos',
        $file,
        $namaFile,
        'public'
    );
} else {
     $gambar = 'images.png';
}


    $berita = new Berita;
    $berita->judul      = $request->judul;
    $berita->slug       = $request->slug;
    $berita->konten     = $request->konten;
    $berita->status     = $request->status;
    $berita->gambar     = $gambar; // hasilnya: "berita/judul-berita.jpg"
    $berita->penulis_id = Auth::id();
    $berita->tanggal_publikasi = now();

    $berita->save();

    return redirect()->route('berita.index')->with('success', 'Berita Berhasil Ditambahkan');
}


    /**
     * Display the specified resource.
     */
    public function detail(string $slug)
{
    $berita = Berita::with('penulis')
        ->where('slug', $slug)
        ->firstOrFail();

    $beritaTerbaru = Berita::where('status','published')
        ->where('id','!=',$berita->id)
        ->latest()
        ->take(5)
        ->get();


    return view('partials.berita.detail', compact('berita', 'beritaTerbaru'));
}



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.berita.edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $berita = Berita::findOrFail($id);

        $request->validate([
            'judul'   => 'required|max:255',
            'slug'    => 'required|unique:berita,slug,' . $berita->id,
            'konten'  => 'required',
            'status'  => 'required',
            'gambar'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'judul.required'  => 'Judul Tidak Boleh Kosong',
            'slug.required'   => 'Slug Tidak Boleh Kosong',
            'slug.unique'     => 'Slug Sudah Digunakan',
            'konten.required' => 'Konten Tidak Boleh Kosong',
            'status.required' => 'Status Harus Dipilih',
            'gambar.image'    => 'File Harus Berupa Gambar',
            'gambar.mimes'    => 'Format Gambar JPG, JPEG, PNG',
        ]);

        if ($request->hasFile('gambar')) {

            // Hapus gambar lama (jika ada dan bukan gambar default)
            if ($berita->gambar && $berita->gambar !== 'images.png' && Storage::disk('s3')->exists($berita->gambar)) {
                Storage::disk('s3')->delete($berita->gambar);
            }

            $file = $request->file('gambar');

            // buat nama file unik
            $namaFile = Str::slug($request->judul) . '-' . time() . '.' . $file->getClientOriginalExtension();

            // simpan ke folder berita_photos di S3 dan set public
            $gambar = Storage::disk('s3')->putFileAs(
                'berita_photos',
                $file,
                $namaFile,
                'public'
            );

            $berita->gambar = $gambar;

        } else {
            // Kalau tidak upload gambar baru dan gambar lama kosong, pakai default
            if (!$berita->gambar) {
                $berita->gambar = 'images.png';
            }
        }

        // Update data lain
        $berita->judul  = $request->judul;
        $berita->slug   = $request->slug ?: Str::slug($request->judul);
        $berita->konten = $request->konten;
        $berita->status = $request->status;

        $berita->save();

        return redirect()->route('berita.index')->with('success', 'Berita Berhasil Diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            // Cari berita berdasarkan ID
        $berita = Berita::findOrFail($id);

         // hapus gambar dari S3
        if ($berita->gambar && Storage::disk('s3')->exists($berita->gambar)) {
            Storage::disk('s3')->delete($berita->gambar);
        }

        // Hapus data berita dari database
        $berita->delete();

        // Redirect ke halaman daftar berita dengan pesan sukses
        return redirect()->route('berita.index')->with('success', 'Berita Berhasil Dihapus');
        }
}
