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
    Schema::create('persyaratan', function (Blueprint $table) {
        $table->id();

        //  nama tabel tujuan
        $table->foreignId('layanan_id')
              ->constrained('layanan')
              ->onDelete('cascade');

        $table->string('nama_persyaratan');
        $table->enum('tipe', ['file', 'text'])->default('file');
        $table->boolean('wajib')->default(true);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persyaratan');
    }
};
