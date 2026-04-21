<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();

            // Relasi ke users (opsional)
            $table->foreignId('user_id')
                  ->nullable()
                  ->unique()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->string('nik', 16)->unique();
            $table->string('kk', 16)->nullable();
            $table->string('nama_lengkap', 100);
            $table->enum('jenis_kelamin', ['L', 'P']);

            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();

            $table->string('agama', 20)->nullable();
            $table->string('pendidikan', 30)->nullable();
            $table->string('kewarganegaraan', 30)->nullable();

            $table->string('status_perkawinan', 30)->nullable();
            $table->enum('gol_darah', ['A','B','AB','O','-'])->default('-');
            $table->string('shdk', 30)->nullable();

            $table->string('pekerjaan', 50)->nullable();

            $table->text('alamat')->nullable();
            $table->string('rt', 3)->nullable();
            $table->string('dusun', 50)->nullable();
            $table->string('desa', 50)->nullable();
            $table->string('kecamatan', 50)->nullable();

            $table->string('ayah', 100)->nullable();
            $table->string('ibu', 100)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduk');
    }
};
