<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('pengaduan_balasan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pengaduan_id')->constrained('pengaduans')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->text('isi');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('pengaduan_balasan');
}
};
