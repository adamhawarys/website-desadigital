<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Persyaratan;
use Illuminate\Http\Request;

class PersyaratanController extends Controller
{
    public function index(Layanan $layanan)
    {
        $persyaratan = $layanan->persyaratan;
        return view('admin.persyaratan.index', compact('layanan', 'persyaratan'));
    }

    public function store(Request $request, Layanan $layanan)
    {
        $request->validate([
            'nama_persyaratan' => 'required'
        ]);

        $layanan->persyaratan()->create([
            'nama_persyaratan' => $request->nama_persyaratan,
            'tipe' => $request->tipe,
            'wajib' => $request->wajib ?? 0
        ]);

        return back()->with('success', 'Persyaratan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'nama_persyaratan' => 'required|string|max:255',
        'tipe'             => 'required|in:file,text',
        'wajib'            => 'required|in:0,1',
    ]);

    $persyaratan = Persyaratan::findOrFail($id);
    $persyaratan->update([
        'nama_persyaratan' => $request->nama_persyaratan,
        'tipe'             => $request->tipe,
        'wajib'            => $request->wajib,
    ]);

    return back()->with('success', 'Persyaratan berhasil diperbarui.');
}

    public function destroy($id)
    {
        Persyaratan::findOrFail($id)->delete();
        return back()->with('success', 'Persyaratan berhasil dihapus');
    }
}
