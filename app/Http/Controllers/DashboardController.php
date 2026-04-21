<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Pengaduan; 
use App\Models\StatistikDusun;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $users = User::count(); 
        $jumlahDusun = StatistikDusun::count();   

        // === DATA GRAFIK DUSUN ===
        $dusun = StatistikDusun::all();
        $labels = $dusun->pluck('nama_dusun');
        $jumlahLakiLaki = $dusun->pluck('jumlah_laki_laki');
        $jumlahPerempuan = $dusun->pluck('jumlah_perempuan');

        // === HITUNG STATUS PENGAJUAN ===
        $totalPengajuan = Pengajuan::count();
        $diproses = Pengajuan::where('status', 'Menunggu Diproses')->count();
        $disetujui = Pengajuan::where('status', 'Disetujui')->count();
        $ditolak = Pengajuan::where('status', 'Ditolak')->count();

        // === HITUNG STATUS PENGADUAN ===
        $totalPengaduan = Pengaduan::count();
        $aduanMenunggu = Pengaduan::where('status', 'menunggu')->count(); 
        $aduanDiproses = Pengaduan::where('status', 'diproses')->count();
        $aduanSelesai  = Pengaduan::where('status', 'selesai')->count();

        $data = array(
            "title" => "Dashboard",
            "menuDashboard" => "active",
            "users" => $users,
            "jumlahDusun" => $jumlahDusun,

            // grafik
            "labels" => $labels,
            "jumlahLakiLaki" => $jumlahLakiLaki,
            "jumlahPerempuan" => $jumlahPerempuan,

            // pengajuan
            "diproses" => $diproses,
            "disetujui" => $disetujui,
            "ditolak" => $ditolak,
            "totalPengajuan" => $totalPengajuan,

            // pengaduan
            "totalPengaduan" => $totalPengaduan,
            "aduanMenunggu" => $aduanMenunggu,
            "aduanDiproses" => $aduanDiproses,
            "aduanSelesai" => $aduanSelesai,
        );

        return view('dashboard', $data);
    }
}