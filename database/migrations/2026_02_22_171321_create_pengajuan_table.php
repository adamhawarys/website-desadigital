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
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('layanan_id')
                ->constrained('layanan')
                ->onDelete('cascade');
            
            $table->string('nomor_surat')
                ->nullable()
                ->unique(); // biar gak duplicate

            $table->text('keperluan')->nullable();;

            $table->enum('status', ['Menunggu Diproses','Disetujui','Ditolak'])
                ->default('Menunggu Diproses');

            $table->date('tanggal_pengajuan');

            $table->timestamp('tanggal_disetujui')
                ->nullable();

            $table->timestamps();
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};
