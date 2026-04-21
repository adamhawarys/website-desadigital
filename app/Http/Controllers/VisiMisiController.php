<?php

namespace App\Http\Controllers;

use App\Models\VisiMisi;
use Illuminate\Http\Request;

class VisiMisiController extends Controller
{
    public function index()
    {
                // Ambil 1 data saja
        $visimisi = VisiMisi::first();

        return view('admin.visimisi.index', compact('visimisi'));
    }

        

     public function update(Request $request)
    {
        $request->validate([
            'visi' => 'required',
            'misi' => 'required',
        ]);

        VisiMisi::updateOrCreate(
            ['id' => 1],
            [
                'visi' => $request->visi,
                'misi' => $request->misi,
            ]
        );

        return back()->with('success', 'Visi & Misi berhasil diperbarui');
    }

}
