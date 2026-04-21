<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatistikDusun extends Model
{
    protected $table = 'statistik_dusun';

    protected $fillable = [
        'nama_dusun',
        'nama_kepala_dusun',
        'jumlah_laki_laki',
        'jumlah_perempuan',
        
    ];
}
