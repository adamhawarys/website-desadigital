<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    protected $table = 'berkas';

    protected $fillable = [
        'pengajuan_id',
        'persyaratan_id',
        'file_path'
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function persyaratan()
    {
        return $this->belongsTo(Persyaratan::class);
    }
}
