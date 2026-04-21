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
        Schema::create('statistik_dusun', function (Blueprint $table) {
            $table->id();

            $table->string('nama_dusun');
            $table->string('nama_kepala_dusun');
            $table->integer('jumlah_laki_laki');
            $table->integer('jumlah_perempuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistik_dusun');
    }
};
