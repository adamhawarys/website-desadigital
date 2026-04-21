<?php

namespace App\Http\Controllers;

use App\Models\StatistikDusun;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    

    public function index()
    {
        $data = StatistikDusun::all();
        return view('admin.statistik.index', compact('data'));
    }

    public function edit($id)
    {
        $statistik = StatistikDusun::findOrFail($id);
        return view('admin.statistik.edit', compact('statistik'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_dusun' => 'required',
            'nama_kepala_dusun' => 'required',
            'jumlah_laki_laki' => 'required|integer',
            'jumlah_perempuan' => 'required|integer',
        ]);

        $statistik = StatistikDusun::findOrFail($id);
        $statistik->update([
            'nama_dusun' => $request->nama_dusun,
            'nama_kepala_dusun' => $request->nama_kepala_dusun,
            'jumlah_laki_laki' => $request->jumlah_laki_laki,
            'jumlah_perempuan' => $request->jumlah_perempuan,
        ]);

        return redirect()
            ->route('statistik.index')
            ->with('success', 'Data statistik dusun berhasil diperbarui');
    }

    public function destroy($id)
    {
        $statistik = StatistikDusun::findOrFail($id);
        $statistik->delete();

        return redirect()
            ->route('statistik.index')
            ->with('success', 'Data statistik dusun berhasil dihapus');
    }
}
