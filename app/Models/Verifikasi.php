<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verifikasi extends Model
{
    protected $table = 'verifikasi';

    protected $fillable  = [
        'user_id',
        'unique_id',
        'otp',
        'type',
        'send_via',
        'resend',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}