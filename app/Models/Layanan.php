<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    // use HasFactory;

    protected $table = 'layanan';

    protected $fillable = [
        'nama_layanan',
        'kode_layanan',
        'deskripsi',
        'template_surat',
    ];

    // relasi ke detail_layanan,persyaratan,pengajuan

    public function detailLayanan()
    {
        return $this->hasMany(DetailLayanan::class,'layanan_id');
    }
    public function persyaratan()
    {
        return $this->hasMany(Persyaratan::class);
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class);
    }
}