<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Pengaduan;
use App\Models\Pengumuman;
use App\Models\PerangkatDesa;
use App\Models\SejarahDesa;
use App\Models\StatistikDusun;
use App\Models\VisiMisi;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PortalController extends Controller
{
    public function welcome()
    {
        $berita = Berita::orderBy('created_at', 'desc')
                        ->take(6)
                        ->where('status', 'published')
                        ->get();
        
        
        $galeri = Galeri::where('status', 'aktif')
                                     ->orderBy('created_at', 'desc')
                                     ->take(8) 
                                     ->get();

        $jumlahDusun    = StatistikDusun::count();
        $totalPerempuan = StatistikDusun::sum('jumlah_perempuan');
        $totalLakiLaki  = StatistikDusun::sum('jumlah_laki_laki');
        $totalPenduduk  = $totalPerempuan + $totalLakiLaki;
        $pegawai        = PerangkatDesa::orderByRaw("
                                FIELD(jabatan,
                                    'KEPALA DESA',
                                    'SEKRETARIS DESA',
                                    'BADAN PERMUSYAWARATAN DESA',
                                    'KASI PEMERINTAHAN',
                                    'KASI PERENCANAAN',
                                    'KAUR KESEJAHTERAAN RAKYAT',
                                    'KASI PELAYANAN',
                                    'KAUR TATA USAHA DAN UMUM',
                                    'KAUR KEUANGAN',
                                    'KADUS BENGKEL TIMUR INDUK',
                                    'KADUS BENGKEL TIMUR MEKAR',
                                    'KADUS BENGKEL UTARA TIMUR',
                                    'KADUS BENGKEL UTARA TENGAH',
                                    'KADUS BENGKEL UTARA BARAT',
                                    'KADUS BENGKEL BARAT',
                                    'KADUS BENGKEL SELATAN INDUK',
                                    'KADUS BENGKEL SELATAN MEKAR',
                                    'KADUS DATAR'
                                )
                            ")->get();

        $pengumuman = Pengumuman::orderBy('created_at', 'desc')
                                ->take(3)
                                ->where('status','aktif')
                                ->get();
        $agenda = Agenda::orderBy('tanggal', 'desc')->take(3)->get();

        $dusun               = StatistikDusun::all();
        $labelsDusun         = $dusun->pluck('nama_dusun');
        $jumlahPendudukDusun = $dusun->map(function ($item) {
            return $item->jumlah_laki_laki + $item->jumlah_perempuan;
        });

        $pengaduans = Pengaduan::with(['user', 'balasanThread.user'])->latest()->take(3)->get();

        
        $visitorHariIni = Visitor::whereDate('tanggal', today())->count();
        $visitorTotal   = Visitor::distinct('ip_address')->count();

        return view('welcome', compact(
            'jumlahDusun',
            'totalPerempuan',
            'totalLakiLaki',
            'totalPenduduk',
            'berita',
            'galeri',
            'pengumuman',
            'agenda',
            'pegawai',
            'labelsDusun',
            'jumlahPendudukDusun',
            'pengaduans',
            'visitorHariIni',
            'visitorTotal'
        ));
    }
     public function visimisi()
    {
        // Ambil 1 data visi misi
        $visimisi = VisiMisi::first();
        $sejarah  = SejarahDesa::first();

        return view('portal.visimisi', compact('visimisi'));
    }
     public function sejarah()
    {
        
        
        $sejarah  = SejarahDesa::first();

        return view('portal.sejarah_desa', compact('sejarah'));
    }
     public function pegawai()
    {
        
        
        $pegawai        = PerangkatDesa::orderByRaw("
                                FIELD(jabatan,
                                    'KEPALA DESA',
                                    'SEKRETARIS DESA',
                                    'BADAN PERMUSYAWARATAN DESA',
                                    'KASI PEMERINTAHAN',
                                    'KASI PERENCANAAN',
                                    'KAUR KESEJAHTERAAN RAKYAT',
                                    'KASI PELAYANAN',
                                    'KAUR TATA USAHA DAN UMUM',
                                    'KAUR KEUANGAN',
                                    'KADUS BENGKEL TIMUR INDUK',
                                    'KADUS BENGKEL TIMUR MEKAR',
                                    'KADUS BENGKEL UTARA TIMUR',
                                    'KADUS BENGKEL UTARA TENGAH',
                                    'KADUS BENGKEL UTARA BARAT',
                                    'KADUS BENGKEL BARAT',
                                    'KADUS BENGKEL SELATAN INDUK',
                                    'KADUS BENGKEL SELATAN MEKAR',
                                    'KADUS DATAR'
                                )
                            ")->get();

        return view('portal.pegawai', compact('pegawai'));
    }
     

    public function berita(Request $request)
    {
    $keyword = $request->get('table_search');
    $beritaTerbaru = Berita::where('status', 'published')
        ->when($keyword, function ($query) use ($keyword) {
                $query->where('judul', 'like', "%{$keyword}%");
            })
        ->orderBy('created_at', 'desc')
        ->paginate(6)
        ->appends(['table_search' => $keyword]);

    return view('portal.berita', compact('beritaTerbaru', 'keyword'));
    }


    public function pengumuman()
    {
    $pengumuman = Pengumuman::orderBy('created_at', 'desc')
                            ->take(3)
                            ->get();

    return view('portal.pengumuman', compact('pengumuman'));
    }

    public function agenda()
    {
        $agenda = Agenda::orderBy('tanggal', 'desc')
                        ->take(3)
                        ->get();
    return view('portal.agenda', compact('agenda'));
    }

    public function galeri()
    {
        
        $galeri = Galeri::where('status', 'aktif')
                        ->orderBy('created_at', 'desc')
                        ->paginate(8); // 

        
        return view('portal.galeri', compact('galeri'));
    }

    public function organisasi()
    {
    $organisasi = PerangkatDesa::all();
    $pegawai = $organisasi->first(); // 
    

    return view('portal.organisasi', compact('organisasi', 'pegawai'));
    }

    public function organisasiDetail($id)
    {
    $organisasi = PerangkatDesa::all();
    $pegawai = PerangkatDesa::findOrFail($id);

    return view('portal.struktur', compact('organisasi', 'pegawai'));
    }

    // public function statistik()
    // {
    
    // $totalPerempuan = StatistikDusun::sum('jumlah_perempuan');
    // $totalLakiLaki  = StatistikDusun::sum('jumlah_laki_laki');
    // $totalPenduduk  = $totalPerempuan + $totalLakiLaki;

    // return view('portal.statistik', compact('totalPenduduk','totalPerempuan', 'totalLakiLaki'));
    // }


    public function layanan()
    {
   

    return view('portal.layanan');
    }

    
    public function layanan_detail($slug)
    {
        
        $layanan = [
            'alur' => [
                'Pemohon login ke sistem Layanan Mandiri Desa Bengkel',
                'Pemohon mengunggah berkas sesuai persyaratan layanan (hanya sekali)',
                'Pemohon mengisi form permohonan secara online sesuai layanan yang dipilih',
                'Petugas akan melakukan verifikasi permohonan',
                'Pemohon bisa mencetak surat permohonan secara mandiri'
            ],

            'surat-keterangan-domisili' => [
                'judul' => 'Surat Keterangan Domisili',
                'deskripsi' => 'Layanan pembuatan surat domisili warga Desa Bengkel.',
                'syarat' => [
                    'Surat Pengantar dari Kepala Dusun',
                    'Fotokopi KTP',
                    'Fotokopi KK',
                ],
                'estimasi' => '1-2 Hari Kerja'
            ],
            'surat-keterangan-usaha' => [
                'judul' => 'Surat Keterangan Usaha',
                'deskripsi' => 'Layanan pembuatan surat keterangan usaha.',
                'syarat' => [
                    'Surat Pengantar dari Kepala Dusun',
                    'Fotokopi KTP',
                    'Fotokopi KK',
                    'Foto lokasi atau tempat usaha'
                ],
                'estimasi' => '1–2 Hari Kerja'
            ],
            'surat-keterangan-tidak-mampu' => [
                'judul' => 'Surat Keterangan Tidak Mampu',
                'deskripsi' => 'Layanan pembuatan surat keterangan tidak mampu.',
                'syarat' => [
                    'Surat Pengantar Kepala Dusun',
                    'Fotokopi KTP dan KK',
                    'Surat pernyataan tidak mampu (ditandatangani di atas materai Rp 10.000)',
                    'Data pendukung lain sesuai kebutuhan'
                ],
                'estimasi' => '1–2 Hari Kerja'
            ],
            'surat-rekomendasi' => [
                'judul' => 'Surat Rekomendasi',
                'deskripsi' => 'Layanan pembuatan surat rekomendasi.',
                'syarat' => [
                    'Surat Pengantar Kepala Dusun',
                    'Fotokopi KTP dan KK',
                    'Data pendukung lain sesuai kebutuhan'
                ],
                'estimasi' => '1–2 Hari Kerja'
            ],
            'surat-pengantar-permohonan-kk' => [
                'judul' => 'Surat Pengantar Permohonan KK',
                'deskripsi' => 'Layanan pembuatan surat pengantar permohonan KK.',
                'syarat' => [
                    'Surat Pengantar Kepala Dusun',
                    'Fotokopi KTP Kepala Keluarga',
                    [
                        'teks' => 'Mengisi Blangko Form F-1.15',
                        
                        'link' => 'https://s3-desadigital-bucket.s3.amazonaws.com/downloads/F-1.15.pdf' 
                    ],
                    'KK Lama (Jika untuk perubahan data atau penambahan anggota)',
                    'Akta Nikah/Kelahiran (ika untuk penambahan anggota atau membuat KK baru)', 
                    'Surat Pindah Untuk Penduduk Yang Baru (Belum Masuk Dalam Kartu Keluarga Lama)', 
                    'Data pendukung lain sesuai kebutuhan'
                ],
                'estimasi' => '1–2 Hari Kerja'
            ]
        ];

        // kalau slug tidak ada
        if (!isset($layanan[$slug])) {
            abort(404);
        }

        return view('partials.layanan.detail', [
    'detail' => $layanan[$slug],
    'alur'   => $layanan['alur']
]);

    
    }



    
}
