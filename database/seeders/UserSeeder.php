<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(['name' => 'Admin','email' => 'admin@gmail.com','status' => 'Active', 'role' => 'Admin', 'password' => 'admin123']);
        User::create(['name' => 'Petugas','email' => 'petugas@gmail.com','status' => 'Active', 'role' => 'Petugas', 'password' => 'petugas123']);
        User::create(['name' => 'Warga','email' => 'warga@gmail.com','status' => 'Active', 'role' => 'Warga', 'password' => 'warga123']);
    }
}
