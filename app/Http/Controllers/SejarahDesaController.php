<?php

namespace App\Http\Controllers;

use App\Models\SejarahDesa;
use Illuminate\Http\Request;

class SejarahDesaController extends Controller
{
        public function index()
    {
        $sejarah = SejarahDesa::first();
        return view('admin.sejarah.index', compact('sejarah'));
    }

    public function update(Request $request)
    {
        $request->validate([
        'sejarah' => 'required',
    ], [
        'sejarah.required' => 'Sejarah desa tidak boleh kosong',
    ]);

    SejarahDesa::updateOrCreate(
        ['id' => 1],
        ['sejarah' => $request->sejarah]
    );

    return redirect()
        ->route('sejarah.index')
        ->with('success', 'Sejarah desa berhasil diperbarui');
    }
}


