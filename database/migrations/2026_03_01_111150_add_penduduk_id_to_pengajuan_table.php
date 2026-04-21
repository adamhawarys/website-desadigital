<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->unsignedBigInteger('penduduk_id')->nullable()->after('user_id');
            $table->foreign('penduduk_id')->references('id')->on('penduduk')->nullOnDelete();

            // kalau pengajuan admin, user_id bisa null
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->dropForeign(['penduduk_id']);
            $table->dropColumn('penduduk_id');

            // balikkan kalau dulu NOT NULL (sesuaikan dengan kondisi awalmu)
            // $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};
