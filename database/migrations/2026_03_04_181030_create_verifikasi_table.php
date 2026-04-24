<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('unique_id');
            $table->string('otp');
            $table->enum('type', ['register', 'reset_password']);
            $table->enum('send_via', ['email', 'sms', 'wa']);
            $table->integer('resend')->default(0);
            $table->enum('status', ['active', 'valid', 'invalid']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifikasi');
    }
};