<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pegawai_desa', function (Blueprint $table) {
            $table->id();  // Kolom ID
            $table->string('foto')->nullable();  // Kolom foto, nullable
            $table->string('nama_pejabat', 150);  // Kolom nama pejabat
            $table->string('jabatan', 100)->nullable();  // Kolom jabatan, nullable
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);  // Kolom jenis kelamin
            $table->string('tempat_lahir', 100);  // Kolom tempat lahir
            $table->date('tanggal_lahir');  // Kolom tanggal lahir
            $table->string('pendidikan', 100);  // Kolom pendidikan
            $table->string('nomor_sk', 100);  // Kolom nomor SK
            $table->date('tanggal_sk');  // Kolom tanggal SK
            $table->text('alamat')->nullable();  // Kolom alamat, nullable

            $table->timestamps();  // Kolom timestamps (created_at, updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_desa');
    }
};
