<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PerangkatDesa extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'pegawai_desa';

    // Tentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'foto',
        'nama_pejabat',
        'jabatan',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'pendidikan',
        'nomor_sk',
        'tanggal_sk',
        'alamat'
    ];

    // Kolom tanggal yang harus diperlakukan sebagai tipe tanggal
    protected $dates = ['tanggal_lahir', 'tanggal_sk']; 

    // Accessor untuk tanggal_lahir
    public function getTanggalLahirAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

     // Accessor untuk tanggal_sk
    public function getTanggalSkAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

      public function setNamaPejabatAttribute($value)
    {
        $this->attributes['nama_pejabat'] = mb_strtoupper($value, 'UTF-8');
    }

    public function setJabatanAttribute($value)
    {
        $this->attributes['jabatan'] = mb_strtoupper($value, 'UTF-8');
    }
}
