<?php

namespace App\Http\Controllers;

use App\Mail\OtpEmail;
use App\Models\Berkas;
use App\Models\DetailPengajuan;
use App\Models\Layanan;
use App\Models\Penduduk;
use App\Models\Pengaduan;
use App\Models\Pengajuan;
use App\Models\ProfilDesa;
use App\Models\Verifikasi;
use App\Services\SnsService;
use App\Services\SqsService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LayananMandiriController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->sns_confirmed) {
            $sns = new SnsService();
            if ($sns->cekKonfirmasi($user->email)) {
                $user->update(['sns_confirmed' => true]);
            }
        }

        $penduduk = Penduduk::where('user_id', Auth::id())->first();

        $riwayatPengajuan = Pengajuan::with([
                'layanan',
                'detail.detailLayanan',
                'berkas.persyaratan'
            ])
            ->where('user_id', Auth::id())
            ->latest()
            ->take(10)
            ->get();

        $riwayatPengaduan = Pengaduan::where('user_id', Auth::id())
            ->latest()
            ->take(10)
            ->get();

        return view('layanan_mandiri.index', compact('penduduk', 'riwayatPengajuan', 'riwayatPengaduan'));
    }

    public function profil()
    {
        $penduduk = Penduduk::where('user_id', Auth::id())->first();
        return view('layanan_mandiri.profil', compact('penduduk'));
    }

    public function editData()
    {
        $penduduk = Penduduk::firstOrNew(['user_id' => Auth::id()]);
        return view('layanan_mandiri.edit_data', compact('penduduk'));
    }

    public function cariNik(Request $request)
    {
        $request->validate(['nik' => 'required|digits:16']);

        $penduduk = Penduduk::where('nik', $request->nik)->first();

        if (!$penduduk) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data penduduk dengan NIK tersebut tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $penduduk
        ]);
    }

    public function updateData(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $pendudukUser = Penduduk::where('user_id', $user->id)->first();

        $request->validate([
            'nik'           => 'required|digits:16',
            'nama_lengkap'  => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
        ]);

        $data = $request->only([
            'nik', 'kk', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir',
            'tanggal_lahir', 'agama', 'pendidikan', 'kewarganegaraan',
            'status_perkawinan', 'gol_darah', 'shdk', 'pekerjaan',
            'alamat', 'rt', 'dusun', 'desa', 'kecamatan', 'ayah', 'ibu',
        ]);

        if (!$pendudukUser) {
            $pendudukNik = Penduduk::where('nik', $request->nik)->first();

            if ($pendudukNik) {
                if ($pendudukNik->user_id !== null) {
                    return back()->with('error', 'Data penduduk ini sudah terhubung dengan akun lain');
                }
                $pendudukNik->update(array_merge($data, ['user_id' => $user->id]));
            } else {
                Penduduk::create(array_merge($data, ['user_id' => $user->id]));
            }
        } else {
            $pendudukUser->update($data);
        }

        return redirect()->route('profil')->with('success', 'Profil penduduk berhasil disimpan');
    }

    public function editProfil()
    {
        $user = Auth::user();
        return view('layanan_mandiri.edit_profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_hp'            => 'nullable|string|max:20',
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password'         => 'nullable|min:8|max:50',
            'confirm_password' => 'nullable|same:password',
        ], [
            'name.required'         => 'Nama tidak boleh kosong',
            'email.required'        => 'Email tidak boleh kosong',
            'email.email'           => 'Format email tidak valid',
            'email.unique'          => 'Email sudah digunakan',
            'foto.image'            => 'File harus berupa gambar',
            'foto.mimes'            => 'Format foto harus jpg, jpeg, atau png',
            'foto.max'              => 'Ukuran foto maksimal 2MB',
            'password.min'          => 'Password minimal 8 karakter',
            'confirm_password.same' => 'Konfirmasi password tidak sama',
        ]);

        $emailBerubah = $request->email !== $user->email;
        $emailBaru    = $request->email;

        // Jika email berubah → simpan ke pending, kirim OTP verifikasi
        if ($emailBerubah) {
            // Simpan email baru sementara di session
            session(['pending_email' => $emailBaru]);

            // Invalidate OTP lama
            Verifikasi::where('user_id', $user->id)
                ->where('type', 'ganti_email')
                ->where('status', 'active')
                ->update(['status' => 'invalid']);

            $otp    = rand(100000, 999999);
            $verify = Verifikasi::create([
                'user_id'   => $user->id,
                'unique_id' => uniqid(),
                'otp'       => md5($otp),
                'type'      => 'ganti_email',
                'send_via'  => 'email',
            ]);

            // Kirim OTP ke email BARU
            Mail::to($emailBaru)->send(new OtpEmail($otp, 'OTP - Verifikasi Email Baru'));

            // Simpan data profil lain dulu (nama, no_hp, foto, password) — tanpa email
            $user->name  = $request->name;
            $user->no_hp = $request->no_hp;

            if ($request->hasFile('foto')) {
                if ($user->foto && !str_starts_with($user->foto, 'https://lh')) {
                    Storage::disk('s3')->delete($user->foto);
                }
                $file     = $request->file('foto');
                $namaFile = 'foto-' . $user->id . '-' . time() . '.' . $file->getClientOriginalExtension();
                $user->foto = Storage::disk('s3')->putFileAs('profil_user', $file, $namaFile, 'public');
            }

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return redirect()->route('verifikasi_email.show', $verify->unique_id)
                ->with('info', 'Kode OTP telah dikirim ke email baru Anda. Silakan verifikasi.');
        }

        // Jika email TIDAK berubah → update biasa
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;

        if ($request->hasFile('foto')) {
            if ($user->foto && !str_starts_with($user->foto, 'https://lh')) {
                Storage::disk('s3')->delete($user->foto);
            }
            $file     = $request->file('foto');
            $namaFile = 'foto-' . $user->id . '-' . time() . '.' . $file->getClientOriginalExtension();
            $user->foto = Storage::disk('s3')->putFileAs('profil_user', $file, $namaFile, 'public');
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profil')->with('success', 'Profil akun berhasil diperbarui');
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFIKASI EMAIL BARU (setelah ganti email)
    |--------------------------------------------------------------------------
    */

    public function showVerifikasiEmail($unique_id)
    {
        $verify = Verifikasi::whereUserId(Auth::id())
            ->whereUniqueId($unique_id)
            ->whereStatus('active')
            ->whereType('ganti_email')
            ->first();

        if (!$verify) {
            return redirect()->route('layanan_mandiri.edit_profil')
                ->with('failed', 'OTP kedaluwarsa. Silakan coba ganti email lagi.');
        }

        return view('layanan_mandiri.verifikasi_email', compact('unique_id'));
    }

    public function verifikasiEmail(Request $request, $unique_id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $verify = Verifikasi::whereUserId($user->id)
            ->whereUniqueId($unique_id)
            ->whereStatus('active')
            ->whereType('ganti_email')
            ->first();

        if (!$verify) {
            return redirect()->route('layanan_mandiri.edit_profil')
                ->with('failed', 'OTP kedaluwarsa. Silakan coba ganti email lagi.');
        }

        // Cek expired 5 menit
        if ($verify->created_at->lt(now()->subMinutes(5))) {
            $verify->update(['status' => 'invalid']);
            return redirect()->route('layanan_mandiri.edit_profil')
                ->with('failed', 'OTP kedaluwarsa. Silakan coba ganti email lagi.');
        }

        // OTP salah
        if (md5($request->otp) != $verify->otp) {
            return back()->with('failed', 'Kode OTP tidak valid. Silakan coba lagi.');
        }

        // OTP benar → update email
        $emailBaru = session('pending_email');

        if (!$emailBaru) {
            return redirect()->route('layanan_mandiri.edit_profil')
                ->with('failed', 'Sesi habis. Silakan coba ganti email lagi.');
        }

        $emailLama = $user->email;

        $user->email             = $emailBaru;
        $user->email_verified_at = now();
        $user->sns_confirmed     = false; // reset SNS → perlu subscribe ulang
        $user->save();

        $verify->update(['status' => 'valid']);
        session()->forget('pending_email');

        // Daftarkan email baru ke SNS
        try {
            app(SnsService::class)->daftarkanEmail($emailBaru);
        } catch (\Exception $e) {
            Log::error('[SNS] Gagal daftarkan email baru: ' . $e->getMessage());
        }

        return redirect()->route('profil')
            ->with('success', 'Email berhasil diperbarui. Silakan konfirmasi email baru Anda.');
    }

    /*
    |--------------------------------------------------------------------------
    | LAYANAN, PENGAJUAN, dsb (tidak berubah)
    |--------------------------------------------------------------------------
    */

    public function daftarLayanan()
    {
        $layanan  = Layanan::orderBy('id', 'asc')->get();
        $penduduk = Penduduk::where('user_id', Auth::id())->first();
        return view('layanan_mandiri.layanan', compact('layanan', 'penduduk'));
    }

    public function create($id)
    {
        $layanan = Layanan::with(['persyaratan', 'detailLayanan'])->findOrFail($id);
        return view('layanan_mandiri.pengajuan', compact('layanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|exists:layanan,id',
            'keperluan'  => 'required|string|max:1000',
        ]);

        $layanan = Layanan::with(['detailLayanan', 'persyaratan'])->findOrFail($request->layanan_id);

        $rules = [];
        foreach ($layanan->detailLayanan as $field) {
            $isWajib = (int) $field->wajib === 1;
            $key     = "detail.{$field->id}";
            $tipe    = strtolower($field->tipe_input);

            if ($tipe === 'number') {
                $rules[$key] = [$isWajib ? 'required' : 'nullable', 'numeric'];
            } elseif ($tipe === 'date') {
                $rules[$key] = [$isWajib ? 'required' : 'nullable', 'date'];
            } else {
                $rules[$key] = [$isWajib ? 'required' : 'nullable', 'string', 'max:1000'];
            }
        }

        foreach ($layanan->persyaratan as $p) {
            $isWajib = (int) $p->wajib === 1;
            $rules["berkas.{$p->id}"] = [
                $isWajib ? 'required' : 'nullable',
                'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048',
            ];
        }

        $request->validate($rules);

        $pengajuan = Pengajuan::create([
            'user_id'           => Auth::id(),
            'layanan_id'        => $layanan->id,
            'keperluan'         => $request->keperluan,
            'tanggal_pengajuan' => now(),
            'status'            => 'Menunggu Diproses',
        ]);

        foreach ($request->input('detail', []) as $detailLayananId => $isi) {
            if ($isi === null || $isi === '') continue;
            DetailPengajuan::create([
                'pengajuan_id'      => $pengajuan->id,
                'detail_layanan_id' => (int) $detailLayananId,
                'isi'               => $isi,
            ]);
        }

        if ($request->hasFile('berkas')) {
            $user        = Auth::user();
            $tahun       = now()->year;
            $namaLayanan = Str::slug($layanan->nama_layanan);
            $namaUser    = Str::slug($user->name) . '_' . $user->id;
            $folderPath  = "berkas_pengajuan/{$tahun}/{$namaLayanan}/{$namaUser}/pengajuan_{$pengajuan->id}";

            foreach ($request->file('berkas') as $persyaratan_id => $file) {
                if (!$file) continue;
                $namaFile = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                    . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = Storage::disk('s3')->putFileAs($folderPath, $file, $namaFile);
                Berkas::create([
                    'pengajuan_id'   => $pengajuan->id,
                    'persyaratan_id' => (int) $persyaratan_id,
                    'file_path'      => $path,
                ]);
            }
        }

        try {
            $sqs        = new SqsService();
            $pesanAdmin = "Ada pengajuan surat baru dari warga!\n\n"
                        . "Nama    : " . Auth::user()->name . "\n"
                        . "Layanan : " . $layanan->nama_layanan . "\n"
                        . "Tanggal : " . now()->translatedFormat('d F Y H:i') . "\n\n"
                        . "Silakan login ke dashboard Admin untuk memproses pengajuan.";

            $sqs->kirimPesan('Pengajuan Surat Baru: ' . $layanan->nama_layanan, $pesanAdmin, null, 'admin');
        } catch (\Exception $e) {
            Log::error('[SQS] Gagal kirim notif admin pengajuan baru: ' . $e->getMessage());
        }

        return redirect()->route('layanan_mandiri')->with('success', 'Pengajuan berhasil dikirim.');
    }

    public function destroy($id)
    {
        $pengajuan   = Pengajuan::with('layanan')->findOrFail($id);
        $user        = Auth::user();
        $tahun       = Carbon::parse($pengajuan->tanggal_pengajuan)->year;
        $namaLayanan = Str::slug($pengajuan->layanan->nama_layanan);
        $namaUser    = Str::slug($user->name) . '_' . $user->id;
        $folderPath  = "berkas_pengajuan/{$tahun}/{$namaLayanan}/{$namaUser}/pengajuan_{$pengajuan->id}";

        Storage::disk('s3')->deleteDirectory($folderPath);
        $pengajuan->delete();

        return back()->with('success', 'Pengajuan berhasil dihapus.');
    }

    public function resetForm()
    {
        return view('layanan_mandiri.reset_password');
    }

    public function resetProses(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'password_lama'    => 'required',
            'password'         => 'required|min:8|max:50',
            'confirm_password' => 'required|same:password',
        ], [
            'password_lama.required'    => 'Password lama tidak boleh kosong',
            'password.required'         => 'Password baru tidak boleh kosong',
            'password.min'              => 'Password minimal 8 karakter',
            'confirm_password.required' => 'Konfirmasi password tidak boleh kosong',
            'confirm_password.same'     => 'Konfirmasi password tidak sama',
        ]);

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->with('failed', 'Password lama tidak sesuai.');
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('profil')->with('success', 'Password berhasil diubah.');
    }

    public function previewSurat($id)
    {
        $pengajuan = Pengajuan::with(['layanan', 'user.penduduk', 'penduduk'])
                        ->where('user_id', Auth::id())
                        ->findOrFail($id);

        $layanan  = $pengajuan->layanan;
        $penduduk = $pengajuan->penduduk ?? $pengajuan->user?->penduduk;
        $profil   = ProfilDesa::first();

        if (!$layanan || !$layanan->template_surat) {
            abort(404, 'Template surat belum tersedia.');
        }

        $template = $layanan->template_surat;
        $template = str_replace('{{nama_lengkap}}',  $penduduk->nama_lengkap ?? '-', $template);
        $template = str_replace('{{nik}}',           $penduduk->nik          ?? '-', $template);
        $template = str_replace('{{kk}}',            $penduduk->kk           ?? '-', $template);
        $template = str_replace('{{tempat_lahir}}',  $penduduk->tempat_lahir ?? '-', $template);
        $template = str_replace('{{tanggal_lahir}}',
            $penduduk->tanggal_lahir
                ? Carbon::parse($penduduk->tanggal_lahir)->translatedFormat('d F Y')
                : '-',
            $template
        );
        $jenisKelamin = match($penduduk->jenis_kelamin ?? '') {
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
            default => $penduduk->jenis_kelamin ?? '-'
        };
        $template = str_replace('{{jenis_kelamin}}',     $jenisKelamin, $template);
        $template = str_replace('{{agama}}',             $penduduk->agama             ?? '-', $template);
        $template = str_replace('{{pekerjaan}}',         $penduduk->pekerjaan         ?? '-', $template);
        $template = str_replace('{{pendidikan}}',        $penduduk->pendidikan        ?? '-', $template);
        $template = str_replace('{{kewarganegaraan}}',   $penduduk->kewarganegaraan   ?? '-', $template);
        $template = str_replace('{{status_perkawinan}}', $penduduk->status_perkawinan ?? '-', $template);
        $template = str_replace('{{alamat}}',            $penduduk->alamat            ?? '-', $template);
        $template = str_replace('{{rt}}',                $penduduk->rt                ?? '-', $template);
        $template = str_replace('{{dusun}}',             $penduduk->dusun             ?? '-', $template);
        $template = str_replace('{{desa}}',              $penduduk->desa              ?? '-', $template);
        $template = str_replace('{{kecamatan}}',         $penduduk->kecamatan         ?? '-', $template);
        $template = str_replace('{{keperluan}}',         $pengajuan->keperluan ?? '-', $template);
        $template = str_replace('{{nomor_surat}}',
            $pengajuan->nomor_surat ?? '(menunggu persetujuan)', $template);
        $template = str_replace('{{tanggal_disetujui}}',
            $pengajuan->tanggal_disetujui
                ? Carbon::parse($pengajuan->tanggal_disetujui)->translatedFormat('d F Y')
                : '(menunggu persetujuan)',
            $template
        );
        $template = str_replace('{{nama_desa}}',   $profil->nama_desa ?? '-', $template);
        $template = str_replace('{{kades}}',       $profil->kades     ?? '-', $template);
        $template = str_replace('{{sekdes}}',      $profil->sekdes    ?? '-', $template);
        $template = str_replace('{{alamat_desa}}', $profil->alamat    ?? '-', $template);
        $template = str_replace('{{kode_pos}}',    $profil->kode_pos  ?? '-', $template);

        $detailPengajuan = $pengajuan->detail()->with('detailLayanan')->get();
        foreach ($detailPengajuan as $detail) {
            $namaField = $detail->detailLayanan->keterangan ?? null;
            if (!$namaField) continue;
            $placeholder = '{{' . Str::slug($namaField, '_') . '}}';
            $template    = str_replace($placeholder, $detail->isi ?? '-', $template);
        }

        $logoBase64 = null;
        if ($profil && $profil->logo) {
            try {
                $logoContent = Storage::disk('s3')->get($profil->logo);
                $ext         = strtolower(pathinfo($profil->logo, PATHINFO_EXTENSION));
                $mimeMap     = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png'];
                $logoMime    = $mimeMap[$ext] ?? 'image/png';
                $logoBase64  = 'data:' . $logoMime . ';base64,' . base64_encode($logoContent);
            } catch (\Exception $e) {
                $logoBase64 = null;
            }
        }

        $logoKabBase64 = null;
        try {
            $pathLogoKab = 'logo-desa/logo-lobar.png';
            if (Storage::disk('s3')->exists($pathLogoKab)) {
                $logoKabContent = Storage::disk('s3')->get($pathLogoKab);
                $logoKabBase64  = 'data:image/png;base64,' . base64_encode($logoKabContent);
            }
        } catch (\Exception $e) {
            $logoKabBase64 = null;
        }

        return view('surat.template', [
            'profil'           => $profil,
            'template'         => $template,
            'logoBase64'       => $logoBase64,
            'logoKabBase64'    => $logoKabBase64,
            'tanggalDisetujui' => $pengajuan->tanggal_disetujui
                ? Carbon::parse($pengajuan->tanggal_disetujui)->translatedFormat('d F Y')
                : '',
        ]);
    }

    public function downloadSurat($id)
    {
        $pengajuan = Pengajuan::where('user_id', Auth::id())
                        ->where('status', 'Disetujui')
                        ->findOrFail($id);

        if (!$pengajuan->surat_pdf) {
            return back()->with('failed', 'File surat tidak tersedia.');
        }

        $namaFile = 'surat-' . Str::slug($pengajuan->layanan->nama_layanan) . '-' . $pengajuan->id . '.pdf';

        return Storage::disk('s3')->download($pengajuan->surat_pdf, $namaFile);
    }
}