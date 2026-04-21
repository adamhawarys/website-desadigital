<?php

namespace App\Http\Controllers;

use App\Models\ProfilDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfilDesaController extends Controller
{
    public function index() 
    {
        $profil = ProfilDesa::first();

        return view('admin.profildesa.index', compact('profil'));
    }

    public function create()
    {
        // cegah buat profil baru kalau sudah ada
        if (ProfilDesa::exists()) {
            return redirect()->route('profil_desa')
                ->with('error', 'Profil desa sudah ada, silakan edit.');
        }

        return view('admin.profildesa.create');
    }

    public function store(Request $request)
    {
        // cegah duplikat
        if (ProfilDesa::exists()) {
            return redirect()->route('profil_desa')
                ->with('error', 'Profil desa sudah ada, silakan edit.');
        }

        $request->validate([
            'nama_desa' => 'required|string|max:100',
            'alamat'    => 'required|string',
            'kode_pos'  => 'required|digits:5',
            'kades'     => 'required|string|max:100',
            'sekdes'    => 'required|string|max:100',
            'logo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_desa.required' => 'Nama desa tidak boleh kosong',
            'alamat.required'    => 'Alamat desa tidak boleh kosong',
            'kode_pos.required'  => 'Kode pos tidak boleh kosong',
            'kode_pos.digits'    => 'Kode pos harus 5 digit',
            'kades.required'     => 'Nama kepala desa tidak boleh kosong',
            'sekdes.required'    => 'Nama sekretaris desa tidak boleh kosong',
            'logo.image'         => 'File harus berupa gambar',
            'logo.mimes'         => 'Format logo JPG, JPEG, PNG',
        ]);

        $profil = ProfilDesa::create($request->except('logo'));

        // =========================
        // SIMPAN LOGO
        // =========================
        if ($request->hasFile('logo')) {
            $file       = $request->file('logo');
            $folderPath = 'logo-desa';

            $namaFile = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                . '.' . $file->getClientOriginalExtension();

            $path = Storage::disk('s3')->putFileAs($folderPath, $file, $namaFile, 'public');

            $profil->logo = $path;
            $profil->save();
        }

        return redirect()->route('profil_desa')
            ->with('success', 'Profil desa berhasil ditambahkan');
    }

    public function edit()
    {
        $profil = ProfilDesa::first();

        if (!$profil) {
            abort(404, 'Profil desa belum tersedia');
        }

        return view('admin.profildesa.edit', compact('profil'));
    }

    public function update(Request $request, string $id)
    {
        $profil = ProfilDesa::findOrFail($id);

        $request->validate([
            'nama_desa' => 'required|string|max:100',
            'alamat'    => 'required|string',
            'kode_pos'  => 'required|digits:5',
            'kades'     => 'required|string|max:100',
            'sekdes'    => 'required|string|max:100',
            'logo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_desa.required' => 'Nama desa tidak boleh kosong',
            'alamat.required'    => 'Alamat desa tidak boleh kosong',
            'kode_pos.required'  => 'Kode pos tidak boleh kosong',
            'kode_pos.digits'    => 'Kode pos harus 5 digit',
            'kades.required'     => 'Nama kepala desa tidak boleh kosong',
            'sekdes.required'    => 'Nama sekretaris desa tidak boleh kosong',
            'logo.image'         => 'File harus berupa gambar',
            'logo.mimes'         => 'Format logo JPG, JPEG, PNG',
        ]);

        $profil->update($request->except('logo'));

        // =========================
        // SIMPAN LOGO
        // =========================
        if ($request->hasFile('logo')) {

            // hapus logo lama dari S3
            if ($profil->logo && Storage::disk('s3')->exists($profil->logo)) {
                Storage::disk('s3')->delete($profil->logo);
            }

            $file       = $request->file('logo');
            $folderPath = 'logo-desa';

            $namaFile = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                . '.' . $file->getClientOriginalExtension();

            $path = Storage::disk('s3')->putFileAs($folderPath, $file, $namaFile, 'public');

            $profil->logo = $path;
            $profil->save();
        }

        return redirect()->route('profil_desa')
            ->with('success', 'Profil desa berhasil diperbarui');
    }
}