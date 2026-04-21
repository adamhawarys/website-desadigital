<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('agendas', function (Blueprint $table) {
        // Menambahkan kolom lokasi sebelum kolom detail
        $table->string('lokasi')->nullable()->after('tanggal'); 
    });
}

public function down()
{
    Schema::table('agendas', function (Blueprint $table) {
        $table->dropColumn('lokasi');
    });
}
};
