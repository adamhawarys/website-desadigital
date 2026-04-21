<?php

namespace Database\Seeders;

use App\Models\VisiMisi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisiMisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VisiMisi::create([
            'visi' => 'Mewujudkan desa yang maju, mandiri, dan sejahtera melalui partisipasi masyarakat dan teknologi.',
            'misi' => '1. Meningkatkan kualitas pendidikan dan kesehatan masyarakat.
                       2. Mendorong perekonomian desa melalui UMKM dan pertanian.
                       3. Memperkuat tata kelola pemerintahan desa yang transparan.
                       4. Mengembangkan infrastruktur dan sarana teknologi informasi.'
        ]);
    }
}
