<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Penduduk extends Model
{
    protected $table = 'penduduk';

    protected $fillable = [
        'user_id',
        'nik',
        'kk',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pendidikan',
        'kewarganegaraan',
        'status_perkawinan',
        'gol_darah',
        'shdk',
        'pekerjaan',
        'alamat',
        'rt',
        'dusun',
        'desa',
        'kecamatan',
        'ayah',
        'ibu',
    ];

    // Kolom tanggal yang harus diperlakukan sebagai tipe tanggal
    protected $casts = [
    'tanggal_lahir' => 'date',
]; 

    // // Accessor untuk tanggal_lahir
    // public function getTanggalLahirAttribute($value)
    // {
    //     return Carbon::parse($value)->format('d-m-Y');
    // }



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengajuan()
    {
        return $this->hasMany(\App\Models\Pengajuan::class);
    }
}
