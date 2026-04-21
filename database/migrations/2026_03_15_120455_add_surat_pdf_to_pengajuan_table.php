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
    Schema::table('pengajuan', function (Blueprint $table) {
        $table->string('surat_pdf')->nullable()->after('tanggal_disetujui');
    });
}

public function down(): void
{
    Schema::table('pengajuan', function (Blueprint $table) {
        $table->dropColumn('surat_pdf');
    });
}
};
