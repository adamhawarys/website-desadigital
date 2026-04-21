<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berkas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pengajuan_id')
                  ->constrained('pengajuan')
                  ->onDelete('cascade');

            $table->foreignId('persyaratan_id')
                  ->constrained('persyaratan')
                  ->onDelete('cascade');

            $table->string('file_path');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berkas');
    }
};