<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPengajuan extends Model
{
    protected $table = 'detail_pengajuan';

    protected $fillable = [
        'pengajuan_id',
        'detail_layanan_id',
        'isi'
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function detailLayanan()
    {
        return $this->belongsTo(DetailLayanan::class, 'detail_layanan_id');
    }
}
