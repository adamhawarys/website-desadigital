<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Hapus kolom nik
            $table->dropUnique(['nik']); // karena ada index UNIQUE
            $table->dropColumn('nik');

            // Tambah kolom no_hp
            $table->string('no_hp', 20)->nullable()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Kembalikan nik jika rollback
            $table->string('nik', 16)->nullable()->unique()->after('email');

            // Hapus no_hp
            $table->dropColumn('no_hp');
        });
    }
};
