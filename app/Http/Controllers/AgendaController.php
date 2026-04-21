<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Services\SqsService; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AgendaController extends Controller
{
    public function index()
    {
        $agenda = Agenda::orderBy('tanggal', 'desc')->paginate(10);
        return view('admin.agenda.index', compact('agenda'));
    }

    public function create()
    {
        return view('admin.agenda.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'   => 'required|max:150',
            'tanggal' => 'required|date',
            'lokasi'  => 'required|string|max:255', 
            'detail'  => 'nullable|string',
        ]);

        // 1. Simpan ke database dulu
        $agenda = Agenda::create($request->only(['judul', 'tanggal', 'lokasi', 'detail'])); 

        // 2. Lempar tugas ke AWS SQS biar diterusin ke warga
        try {
            $sqs        = new SqsService();
            $pesanWarga = "Halo Warga Desa Bengkel,\n\n"
                        . "Ada agenda kegiatan baru yang dijadwalkan:\n\n"
                        . "Judul   : {$agenda->judul}\n"
                        . "Tanggal : " . \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('d F Y') . "\n"
                        . "Lokasi  : {$agenda->lokasi}\n\n"
                        . "Detail  :\n" . ($agenda->detail ?? '-') . "\n\n"
                        . "Mari berpartisipasi dalam kegiatan desa kita.\n"
                        . "Terima kasih.";

            // Tembak ke SQS 
            $sqs->kirimPesan('Agenda Baru: ' . $agenda->judul, $pesanWarga, null, 'broadcast');
        } catch (\Exception $e) {
            Log::error('[SQS] Gagal kirim notif agenda baru: ' . $e->getMessage());
        }

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);
        return view('admin.agenda.edit', compact('agenda'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'   => 'required|max:150',
            'tanggal' => 'required|date',
            'lokasi'  => 'required|string|max:255', 
            'detail'  => 'nullable|string',
        ]);

        $agenda = Agenda::findOrFail($id);
        $agenda->update($request->only(['judul', 'tanggal', 'lokasi', 'detail'])); 

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Agenda::findOrFail($id)->delete();
        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil dihapus.');
    }
}