<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailLayanan extends Model
{
    protected $table = 'detail_layanan';

    protected $fillable = [
        'layanan_id',
        'keterangan',
        'tipe_input',
        'wajib',
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

        public function detailPengajuan()
    {
        return $this->hasMany(DetailPengajuan::class);
    }
}
