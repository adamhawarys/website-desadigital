<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Galeri extends Model
{
    
    protected $table = 'galeri'; 
    
    
    protected $fillable = [
    'foto', 
    'judul',
    'deskripsi', 
    'status'
    ];

    // Di Model Galeri.php
public function getFotoUrlAttribute(): string
{
    return $this->foto
        ? Storage::disk('s3')->url($this->foto)
        : asset('images/default.jpg');
}
}