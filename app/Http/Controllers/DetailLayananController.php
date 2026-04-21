<?php

namespace App\Http\Controllers;

use App\Models\DetailLayanan;
use App\Models\Layanan;
use Illuminate\Http\Request;

class DetailLayananController extends Controller
{
    // TAMPILKAN SEMUA FIELD BERDASARKAN LAYANAN
    public function index($layanan_id)
    {
        $layanan = Layanan::findOrFail($layanan_id);
        $detail = DetailLayanan::where('layanan_id', $layanan_id)->get();

        return view('admin.layanan.detail', compact('layanan', 'detail'));
    }

    // SIMPAN FIELD BARU
    public function store(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required',
            'keterangan' => 'required|string|max:255',
            'tipe_input' => 'required',
        ]);

        DetailLayanan::create([
            'layanan_id' => $request->layanan_id,
            'keterangan' => $request->keterangan,
            'tipe_input' => $request->tipe_input,
            'wajib' => $request->wajib ? 1 : 0,
        ]);

        return back()->with('success', 'Field berhasil ditambahkan');
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'keterangan' => 'required|string|max:255',
        'tipe_input' => 'required|in:text,textarea,number,date',
        'wajib'      => 'required|in:0,1',
    ]);

    $detail = DetailLayanan::findOrFail($id);
    $detail->update($request->only('keterangan','tipe_input','wajib'));

    return back()->with('success', 'Detail field berhasil diperbarui.');
}

    // HAPUS FIELD
    public function destroy($id)
    {
        $detail = DetailLayanan::findOrFail($id);
        $detail->delete();

        return back()->with('success', 'Field berhasil dihapus');
    }
}