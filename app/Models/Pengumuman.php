<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';

    protected $fillable = [
        'judul',
        'kategori',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'lampiran'
    ];

    public function getTanggalMulaiAttribute($value)
    {
        return Carbon::parse($value)
        ->locale('id')
        ->translatedFormat('d F Y'); // 03 Januari 2026
    }

    public function getTanggalSelesaiAttribute($value)
    {
        return Carbon::parse($value)
        ->locale('id')
        ->translatedFormat('d F Y'); // 03 Januari 2026
    }

    public function getStatusAttribute($value)
    {
        // Kalo dari awal datanya udah 'berakhir' di database, balikin aja
        if ($value === 'berakhir') {
            return 'berakhir';
        }

        // Kalo masih 'aktif', kita cek tanggalnya
        // Pastikan tanggal_selesai nggak kosong
        if ($this->tanggal_selesai) {
            $tanggalSelesai = Carbon::parse($this->tanggal_selesai)->endOfDay();
            
            // Kalo hari ini udah ngelewatin tanggal_selesai
            if (now()->greaterThan($tanggalSelesai)) {
                return 'berakhir'; 
            }
        }

        return 'aktif';
    }
}

