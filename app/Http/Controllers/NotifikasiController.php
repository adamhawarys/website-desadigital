<?php

namespace App\Http\Controllers;

use App\Services\SnsService;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    protected SnsService $sns;

    public function __construct(SnsService $sns)
    {
        $this->sns = $sns;
    }

    /**
     * Kirim pengumuman desa ke semua warga yang subscribe
     * POST /notifikasi/pengumuman
     */
    public function kirimPengumuman(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:100',
            'pesan' => 'required|string',
        ]);

        $messageId = $this->sns->publishPengumuman(
            $request->pesan,
            $request->judul
        );

        if (!$messageId) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim pengumuman.',
            ], 500);
        }

        return response()->json([
            'success'    => true,
            'message'    => 'Pengumuman berhasil dikirim ke seluruh warga.',
            'message_id' => $messageId,
        ]);
    }



    /**
     * Daftarkan email warga agar dapat notifikasi pengumuman
     * POST /notifikasi/subscribe
     */
    public function subscribeEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $subscriptionArn = $this->sns->daftarkanEmail($request->email);

        return response()->json([
            'success' => !is_null($subscriptionArn),
            'message' => $subscriptionArn
                ? 'Cek email Anda untuk konfirmasi pendaftaran notifikasi.'
                : 'Gagal mendaftarkan email.',
        ]);
    }
}