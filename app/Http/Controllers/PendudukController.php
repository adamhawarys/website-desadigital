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

    // biar keyword tetap kebawa saat klik pagination
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
            // warga yang belum punya data penduduk
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
            'nik' => 'required|digits:16|unique:penduduk,nik',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'user_id' => 'nullable|exists:users,id|unique:penduduk,user_id',
            'tanggal_lahir' => 'nullable|date',
        ]);

        Penduduk::create([
            'user_id' => $request->user_id, // boleh NULL
            'nik' => $request->nik,
            'kk' => $request->kk,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'pendidikan' => $request->pendidikan,
            'kewarganegaraan' => $request->kewarganegaraan,
            'status_perkawinan' => $request->status_perkawinan,
            'gol_darah' => $request->gol_darah,
            'shdk' => $request->shdk,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'dusun' => $request->dusun,
            'desa' => $request->desa,
            'kecamatan' => $request->kecamatan,
            'ayah' => $request->ayah,
            'ibu' => $request->ibu,
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
            'users' => User::where('role', 'Warga')
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
            'nik' => 'digits:16|unique:penduduk,nik,' . $penduduk->id,
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            
            'user_id' => 'nullable|exists:users,id|unique:penduduk,user_id,' . $penduduk->id,
        ]);

         $data = $request->only([
        'user_id',
        'nik',
        'kk',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pendidikan',
        'kewarganegaraan',
        'status_perkawinan',
        'gol_darah',
        'shdk',
        'pekerjaan',
        'alamat',
        'rt',
        'dusun',
        'desa',
        'kecamatan',
        'ayah',
        'ibu',
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
     *  WARGA SECTION (NANTI)
     * ========================== */

    /**
     * Profil penduduk milik warga
     */
    // public function showMyProfile()
    // {
    //     if (Auth::user()->role !== 'Warga') {
    //         abort(403);
    //     }

    //     return view('warga.penduduk.show', [
    //         'penduduk' => Auth::user()->penduduk
    //     ]);
    // }

    /**
     * Simpan / klaim data penduduk oleh warga
     */
    // public function storeMyProfile(Request $request)
    // {
    //     if (Auth::user()->role !== 'Warga') {
    //         abort(403);
    //     }

    //     if (Auth::user()->penduduk) {
    //         return back()->with('error', 'Data penduduk sudah ada');
    //     }

    //     $request->validate([
    //         'nik' => 'required|digits:16|unique:penduduk,nik',
    //         'nama_lengkap' => 'required',
    //         'jenis_kelamin' => 'required|in:L,P',
    //     ]);

    //     Penduduk::create([
    //         'user_id' => Auth::id(),
    //         'nik' => $request->nik,
    //         'nama_lengkap' => $request->nama_lengkap,
    //         'jenis_kelamin' => $request->jenis_kelamin,
    //     ]);

    //     return redirect()
    //         ->route('warga.dashboard')
    //         ->with('success', 'Profil penduduk berhasil disimpan');
    // }

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
