<?php

namespace Database\Seeders;

use App\Models\SejarahDesa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SejarahDesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SejarahDesa::updateOrCreate(
            ['id' => 1],
            [
                'sejarah' => '<p>Desa Bengkel memiliki sejarah yang berkembang seiring perjalanan waktu dan peran masyarakat dalam membangun desa.</p>'
            ]
        );
    }
}
