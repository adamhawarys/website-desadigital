<?php

namespace App\Http\Controllers;

use App\Models\PerangkatDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PerangkatDesaController extends Controller
{
    public function index(Request $request)
    {
    $keyword = $request->get('table_search');

    $pegawai = PerangkatDesa::query()
        ->when($keyword, function ($query) use ($keyword) {
            $query->where(function ($sub) use ($keyword) {
                $sub->where('nama_pejabat', 'like', "%{$keyword}%")
                    ->orWhere('jabatan', 'like', "%{$keyword}%")
                    ->orWhere('nomor_sk', 'like', "%{$keyword}%")
                    ->orWhere('alamat', 'like', "%{$keyword}%");
            });
        })
        // ->orderBy('id', 'desc') // atau latest()
        ->paginate(10);

    $pegawai->appends(['table_search' => $keyword]);

    return view('admin.pegawai.index', compact('pegawai', 'keyword'));
    }


     public function create()
    {
        return view('admin.pegawai.create');
    }

public function store(Request $request)
{
    $request->validate([
        'nama_pejabat' => 'required|max:150',
        'jabatan' => 'required|max:150',
        'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
        'tempat_lahir' => 'required|max:100',
        'tanggal_lahir' => 'required|date',
        'pendidikan' => 'required|max:100',
        'nomor_sk' => 'required|max:100',
        'tanggal_sk' => 'required|date',
        'alamat' => 'nullable|string|max:255',
        'foto' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
    ],[
        'nama_pejabat.required' => 'Nama Pejabat Tidak Boleh Kosong',
        'jabatan.required'      => 'Jabatan Tidak Boleh Kosong',
        'jenis_kelamin.required' => 'Jenis Kelamin Harus Dipilih',
        'tempat_lahir.required'  => 'Tempat Lahir Tidak Boleh Kosong',
        'tanggal_lahir.required' => 'Tanggal Lahir Tidak Boleh Kosong',
        'pendidikan.required'    => 'Pendidikan Tidak Boleh Kosong',
        'nomor_sk.required'      => 'Nomor SK Tidak Boleh Kosong',
        'tanggal_sk.required'    => 'Tanggal SK Tidak Boleh Kosong',
        'foto.image'             => 'File Foto Harus Berupa Gambar',
        'foto.mimes'             => 'Format Gambar Harus JPG, PNG, JPEG, GIF, SVG',
    ]);

// Upload ke S3
    if ($request->hasFile('foto')) {

        $file = $request->file('foto');

        $namaFile = Str::slug($request->nama_pejabat) . '-' . time() . '.' . $file->getClientOriginalExtension();

        $foto = Storage::disk('s3')->putFileAs(
            'perangkat_desa_photos',
            $file,
            $namaFile,
            'public'  
        );

    } else {
        $foto = null;
    }


    $pegawai = new PerangkatDesa;
    $pegawai->foto = $foto;
    $pegawai->nama_pejabat = $request->nama_pejabat;
    $pegawai->jabatan = $request->jabatan;
    $pegawai->jenis_kelamin = $request->jenis_kelamin;
    $pegawai->tempat_lahir = $request->tempat_lahir;
    $pegawai->tanggal_lahir = $request->tanggal_lahir;
    $pegawai->pendidikan = $request->pendidikan;
    $pegawai->nomor_sk = $request->nomor_sk;
    $pegawai->tanggal_sk = $request->tanggal_sk;
    $pegawai->alamat = $request->alamat;

    $pegawai->save();

    return redirect()->route('pegawai.index')->with('success', 'Data Pegawai Berhasil Ditambahkan');
}



    public function edit($id)
        {
            
            $pegawai = PerangkatDesa::findOrFail($id);
            
            
            return view('admin.pegawai.edit', compact('pegawai'));
        }

    public function update(Request $request, string $id)
    {
        $pegawai = PerangkatDesa::findOrFail($id);

        $request->validate([
            'nama_pejabat'   => 'required|max:150',
            'jabatan'        => 'required|max:150',
            'jenis_kelamin'  => 'required|in:Laki-Laki,Perempuan',
            'tempat_lahir'   => 'required|max:100',
            
            'pendidikan'     => 'required|max:100',
            'nomor_sk'       => 'required|max:100',
            'tanggal_sk'     => 'required|date',
            'alamat'         => 'nullable|string|max:255',
            'foto'           => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        // default: pakai foto lama
        $foto = $pegawai->foto;

        // kalau upload foto baru, ganti
        if ($request->hasFile('foto')) {

            // hapus foto lama di S3
            if ($pegawai->foto && Storage::disk('s3')->exists($pegawai->foto)) {
                Storage::disk('s3')->delete($pegawai->foto);
            }

            $file = $request->file('foto');
            $namaFile = Str::slug($request->nama_pejabat) . '-' . time() . '.' . $file->getClientOriginalExtension();

            $foto = Storage::disk('s3')->putFileAs(
                'perangkat_desa_photos',
                $file,
                $namaFile,
                'public'  
            );
        }

        // update semua field
        $pegawai->foto          = $foto;
        $pegawai->nama_pejabat  = $request->nama_pejabat;
        $pegawai->jabatan       = $request->jabatan;
        $pegawai->jenis_kelamin = $request->jenis_kelamin;
        $pegawai->tempat_lahir  = $request->tempat_lahir;
        
        $pegawai->pendidikan    = $request->pendidikan;
        $pegawai->nomor_sk      = $request->nomor_sk;
        $pegawai->tanggal_sk    = $request->tanggal_sk;
        $pegawai->alamat        = $request->alamat;

        $pegawai->save();

        return redirect()->route('pegawai.index')->with('success', 'Data Pegawai Berhasil Diperbarui');
    }


    public function destroy(string $id)
    {
        $pegawai = PerangkatDesa::findOrFail($id);

        if ($pegawai->foto && Storage::disk('s3')->exists($pegawai->foto)) {
            Storage::disk('s3')->delete($pegawai->foto);
        }


        $pegawai->delete();
        
        return redirect()->route('pegawai.index')->with('success', 'Data Perangkat Desa Berhasil Dihapus');
    }

    

}
