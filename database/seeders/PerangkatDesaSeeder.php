<?php

namespace Database\Seeders;

use App\Models\PerangkatDesa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerangkatDesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PerangkatDesa::create([
            'foto' => 'pegawai/kades.jpg',
            'nama_pejabat' => 'H. MUHAMAD IDRUS, SP.',
            'jabatan' => 'Kepala Desa',
            'jenis_kelamin' => 'Laki-Laki',
            'tempat_lahir' => 'Lobar',
            'tanggal_lahir' => date('Y-m-d', strtotime('1965-12-31')),
            'pendidikan' => 'S1 ',
            'nomor_sk' => '01',
            'tanggal_sk' => date('Y-m-d', strtotime('2017-01-09')),
            'alamat' => 'Dusun Bengkel Selatann Induk, Rt 01, Desa Bengkel Kecamatan Labupai, Kabupaten Lombok Barat',
        ]);
    }
}
