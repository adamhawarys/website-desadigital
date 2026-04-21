<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_pengajuan', function (Blueprint $table) {

            // Tambah kolom relasi baru
            $table->foreignId('detail_layanan_id')
                  ->nullable()
                  ->after('pengajuan_id')
                  ->constrained('detail_layanan')
                  ->onDelete('cascade');

            // Hapus kolom lama
            $table->dropColumn('keterangan');
        });
    }

    public function down(): void
    {
        Schema::table('detail_pengajuan', function (Blueprint $table) {

            // Balikin kolom lama kalau rollback
            $table->string('keterangan')->nullable();

            // Drop foreign key & kolom baru
            $table->dropForeign(['detail_layanan_id']);
            $table->dropColumn('detail_layanan_id');
        });
    }
};
