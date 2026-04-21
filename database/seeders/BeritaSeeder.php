<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Berita::create([
            'gambar' => 'berita/default.jpg',
            'judul' => 'King Emyu Siap Tsunami Trofi',
            'slug' => Str::slug('King Emyu Siap Tsunami Trofi'),
            'konten' => 'Tim King Emyu menargetkan tsunami trofi musim ini dan menunjukkan performa terbaik menjelang kompetisi.',
            'penulis_id' => 1,
            'status' => 'published',
            'tanggal_publikasi' => date('Y-m-d'),
        ]);
    }
}
