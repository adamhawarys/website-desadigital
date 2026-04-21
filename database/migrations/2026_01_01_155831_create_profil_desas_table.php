<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('profil_desas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_desa', 150);
            $table->text('alamat')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('kades', 150)->nullable();
            $table->string('sekdes', 150)->nullable();
            $table->string('logo')->nullable(); // path file logo
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_desas');
    }
};
