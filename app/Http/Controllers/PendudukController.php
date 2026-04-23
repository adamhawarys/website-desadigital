<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendudukController extends Controller
{
    /* ==========================
     *  ADMIN & PETUGAS SECTION
     * ========================== */

    /**
     * List data penduduk (Admin & Petugas)
     */
    public function index(Request $request)
    {
        $this->authorizeAdminPetugas();

        $cari = $request->get('table_search');

        $penduduk = Penduduk::query()
            ->when($cari, function ($query) use ($cari) {
                $query->where(function ($sub) use ($cari) {
                    $sub->where('nik', 'like', "%{$cari}%")
                        ->orWhere('kk', 'like', "%{$cari}%")
                        ->orWhere('nama_lengkap', 'like', "%{$cari}%")
                        ->orWhere('alamat', 'like', "%{$cari}%")
                        ->orWhere('dusun', 'like', "%{$cari}%")
                        ->orWhere('rt', 'like', "%{$cari}%");
                });
            })
            ->latest()
            ->paginate(10);

        $penduduk->appends(['table_search' => $cari]);

        if ($cari && $penduduk->total() == 0) {
            session()->flash('error', "Data penduduk tidak ditemukan untuk: {$cari}");
        }

        return view('admin.penduduk.index', compact('penduduk', 'cari'));
    }

    /**
     * Form tambah penduduk (Admin & Petugas)
     */
    public function create()
    {
        $this->authorizeAdminPetugas();

        return view('admin.penduduk.create', [
            'users' => User::where('role', 'Warga')
                ->whereDoesntHave('penduduk')
                ->get()
        ]);
    }

    /**
     * Simpan data penduduk (Admin & Petugas)
     */
    public function store(Request $request)
    {
        $this->authorizeAdminPetugas();

        $request->validate([
            'nik'              => 'required|digits:16|unique:penduduk,nik',
            'kk'               => 'nullable|digits:16',
            'nama_lengkap'     => 'required|string|max:100',
            'jenis_kelamin'    => 'required|in:L,P',
            'user_id'          => 'nullable|exists:users,id|unique:penduduk,user_id',
            'tanggal_lahir'    => 'nullable|date',
            'agama'            => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'pendidikan'       => 'nullable|in:Tidak/Belum Sekolah,Belum Tamat SD,Tamat SD,SLTP,SLTA,D1/D2,D3,S1,S2,S3',
            'status_perkawinan'=> 'nullable|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'gol_darah'        => 'nullable|in:A,B,AB,O,-',
            'shdk'             => 'nullable|in:Kepala Keluarga,Istri,Anak,Menantu,Cucu,Orang Tua,Mertua,Famili Lain,Pembantu,Lainnya',
            'rt'               => 'nullable|string|max:3',
        ]);

        Penduduk::create([
            'user_id'           => $request->user_id,
            'nik'               => $request->nik,
            'kk'                => $request->kk,
            'nama_lengkap'      => $request->nama_lengkap,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'tempat_lahir'      => $request->tempat_lahir,
            'tanggal_lahir'     => $request->tanggal_lahir,
            'agama'             => $request->agama,
            'pendidikan'        => $request->pendidikan,
            'kewarganegaraan'   => $request->kewarganegaraan,
            'status_perkawinan' => $request->status_perkawinan,
            'gol_darah'         => $request->gol_darah,
            'shdk'              => $request->shdk,
            'pekerjaan'         => $request->pekerjaan,
            'alamat'            => $request->alamat,
            'rt'                => $request->rt,
            'dusun'             => $request->dusun,
            'desa'              => $request->desa,
            'kecamatan'         => $request->kecamatan,
            'ayah'              => $request->ayah,
            'ibu'               => $request->ibu,
        ]);

        return redirect()
            ->route('penduduk.index')
            ->with('success', 'Data penduduk berhasil ditambahkan');
    }

    /**
     * Form edit penduduk (Admin & Petugas)
     */
    public function edit($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        $this->authorizeAdminPetugas();

        return view('admin.penduduk.edit', [
            'penduduk' => $penduduk,
            'users'    => User::where('role', 'Warga')
                ->whereDoesntHave('penduduk')
                ->orWhere('id', $penduduk->user_id)
                ->get()
        ]);
    }

    /**
     * Update data penduduk (Admin & Petugas)
     */
    public function update(Request $request, $id)
    {
        $penduduk = Penduduk::findOrFail($id);
        $this->authorizeAdminPetugas();

        $request->validate([
            'nik'              => 'required|digits:16|unique:penduduk,nik,' . $penduduk->id,
            'kk'               => 'nullable|digits:16',
            'nama_lengkap'     => 'required|string|max:100',
            'jenis_kelamin'    => 'required|in:L,P',
            'user_id'          => 'nullable|exists:users,id|unique:penduduk,user_id,' . $penduduk->id,
            'tanggal_lahir'    => 'nullable|date',
            'agama'            => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'pendidikan'       => 'nullable|in:Tidak/Belum Sekolah,Belum Tamat SD,Tamat SD,SLTP,SLTA,D1/D2,D3,S1,S2,S3',
            'status_perkawinan'=> 'nullable|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'gol_darah'        => 'nullable|in:A,B,AB,O,-',
            'shdk'             => 'nullable|in:Kepala Keluarga,Istri,Anak,Menantu,Cucu,Orang Tua,Mertua,Famili Lain,Pembantu,Lainnya',
            'rt'               => 'nullable|string|max:3',
        ]);

        $data = $request->only([
            'user_id', 'nik', 'kk', 'nama_lengkap', 'jenis_kelamin',
            'tempat_lahir', 'tanggal_lahir', 'agama', 'pendidikan',
            'kewarganegaraan', 'status_perkawinan', 'gol_darah', 'shdk',
            'pekerjaan', 'alamat', 'rt', 'dusun', 'desa', 'kecamatan',
            'ayah', 'ibu',
        ]);

        $penduduk->update($data);

        return redirect()
            ->route('penduduk.index')
            ->with('success', 'Data penduduk berhasil diperbarui');
    }

    /**
     * Hapus data penduduk (Admin)
     */
    public function destroy($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        if (Auth::user()->role !== 'Admin') {
            abort(403);
        }

        $penduduk->delete();

        return back()->with('success', 'Data penduduk berhasil dihapus');
    }

    /* ==========================
     *  HELPER
     * ========================== */

    private function authorizeAdminPetugas()
    {
        if (!in_array(Auth::user()->role, ['Admin', 'Petugas'])) {
            abort(403);
        }
    }
}