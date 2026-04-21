<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
     protected $table = 'pengajuan';
    protected $fillable = [
        'user_id',
        'penduduk_id',
        'layanan_id',
        'nomor_surat',
        'keperluan',
        'status',
        'tanggal_pengajuan',
        'tanggal_disetujui',
        'surat_pdf'
    ];

    
    // RELASI TABEL
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function berkas()
    {
        return $this->hasMany(Berkas::class);
    }

    public function detail()
    {
        return $this->hasMany(DetailPengajuan::class, 'pengajuan_id');
    }
}
