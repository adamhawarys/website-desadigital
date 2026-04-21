<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Agenda extends Model
{
    protected $fillable = [
    'judul', 
    'tanggal',
    'lokasi', 
    'detail'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Accessor custom
    public function getTanggalAgendaAttribute($value)
    {
        return Carbon::parse($value)
        ->locale('id')
        ->translatedFormat('d F Y'); // 03 Januari 2026
    }
}
