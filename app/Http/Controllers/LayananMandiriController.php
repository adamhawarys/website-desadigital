<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\DetailPengajuan;
use App\Models\Layanan;
use App\Models\Penduduk;
use App\Models\Pengaduan;
use App\Models\Pengajuan;
use App\Models\ProfilDesa;
use App\Services\SqsService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LayananMandiriController extends Controller
{
    public function index()
    {
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

        // Validasi dinamis
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

        // Simpan pengajuan
        $pengajuan = Pengajuan::create([
            'user_id'           => Auth::id(),
            'layanan_id'        => $layanan->id,
            'keperluan'         => $request->keperluan,
            'tanggal_pengajuan' => now(),
            'status'            => 'Menunggu Diproses',
        ]);

        // Simpan detail pengajuan
        foreach ($request->input('detail', []) as $detailLayananId => $isi) {
            if ($isi === null || $isi === '') continue;
            DetailPengajuan::create([
                'pengajuan_id'      => $pengajuan->id,
                'detail_layanan_id' => (int) $detailLayananId,
                'isi'               => $isi,
            ]);
        }

        // Simpan berkas
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

        
        // NOTIF KE ADMIN via SQS -> Lambda -> SNS
        
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

                // ============================
        // AMBIL LOGO DESA → BASE64
        // ============================
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

        // ============================
        // AMBIL LOGO KABUPATEN → BASE64
        // ============================
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
            'profil'          => $profil,
            'template'        => $template,
            'logoBase64'      => $logoBase64,
            'logoKabBase64'   => $logoKabBase64,
            'tanggalDisetujui'=> $pengajuan->tanggal_disetujui
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