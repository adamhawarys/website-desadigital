<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Services\SqsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

        $berita->getCollection()->transform(function ($item) {
            $item->excerpt = Str::words(strip_tags($item->konten), 30, '...');
            return $item;
        });

        $berita->appends(['table_search' => $cari_berita]);

        return view('admin.berita.index', compact('berita', 'cari_berita'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

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

        if ($request->hasFile('gambar')) {
            $file     = $request->file('gambar');
            $namaFile = Str::slug($request->judul) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $gambar   = Storage::disk('s3')->putFileAs(
                'berita_photos',
                $file,
                $namaFile,
                'public'
            );
        } else {
            $gambar = 'images.png';
        }

        $berita                    = new Berita;
        $berita->judul             = $request->judul;
        $berita->slug              = $request->slug;
        $berita->konten            = $request->konten;
        $berita->status            = $request->status;
        $berita->gambar            = $gambar;
        $berita->penulis_id        = Auth::id();
        $berita->tanggal_publikasi = now();
        $berita->save();

        // Kirim notifikasi ke warga via SQS hanya jika status published
        if ($request->status === 'published') {
            try {
                $sqs     = new SqsService();
                $tanggal = \Carbon\Carbon::parse($berita->tanggal_publikasi)
                                         ->translatedFormat('d F Y');

                $pesanWarga = "Halo Warga Desa Bengkel,\n\n"
                            . "Ada berita terbaru dari Pemerintah Desa:\n\n"
                            . "Judul   : {$berita->judul}\n"
                            . "Tanggal : {$tanggal}\n\n"
                            . "Silakan kunjungi website desa untuk membaca berita selengkapnya di:\n"
                            . "https://desabengkel.site\n\n"
                            . "Terima kasih.";

                $sqs->kirimPesan(
                    'Berita Desa: ' . $berita->judul,
                    $pesanWarga,
                    null,
                    'broadcast'
                );
            } catch (\Exception $e) {
                Log::error('[SQS] Gagal kirim notif berita baru: ' . $e->getMessage());
            }
        }

        return redirect()->route('berita.index')->with('success', 'Berita Berhasil Ditambahkan');
    }

    public function detail(string $slug)
    {
        $berita = Berita::with('penulis')
            ->where('slug', $slug)
            ->firstOrFail();

        $beritaTerbaru = Berita::where('status', 'published')
            ->where('id', '!=', $berita->id)
            ->latest()
            ->take(5)
            ->get();

        return view('partials.berita.detail', compact('berita', 'beritaTerbaru'));
    }

    public function edit(string $id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.berita.edit', compact('berita'));
    }

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
            if ($berita->gambar && $berita->gambar !== 'images.png' && Storage::disk('s3')->exists($berita->gambar)) {
                Storage::disk('s3')->delete($berita->gambar);
            }

            $file     = $request->file('gambar');
            $namaFile = Str::slug($request->judul) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $gambar   = Storage::disk('s3')->putFileAs(
                'berita_photos',
                $file,
                $namaFile,
                'public'
            );
            $berita->gambar = $gambar;
        } else {
            if (!$berita->gambar) {
                $berita->gambar = 'images.png';
            }
        }

        $berita->judul  = $request->judul;
        $berita->slug   = $request->slug ?: Str::slug($request->judul);
        $berita->konten = $request->konten;
        $berita->status = $request->status;
        $berita->save();

        return redirect()->route('berita.index')->with('success', 'Berita Berhasil Diperbarui');
    }

    public function destroy(string $id)
    {
        $berita = Berita::findOrFail($id);

        if ($berita->gambar && Storage::disk('s3')->exists($berita->gambar)) {
            Storage::disk('s3')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Berita Berhasil Dihapus');
    }
}