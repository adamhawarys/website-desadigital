<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persyaratan extends Model
{
    use HasFactory;

    protected $table = 'persyaratan'; 

    protected $fillable = [
        'layanan_id',
        'nama_persyaratan',
        'tipe',
        'wajib'
    ];

    

    // Persyaratan milik 1 layanan
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function berkas()
    {
        return $this->hasMany(Berkas::class);
    }
}