<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $table = 'pengaduans';

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'judul',
        'isi',
        'foto',
        'status',
        'balasan',
        'tanggal_balasan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   public function balasanThread()
{
    return $this->hasMany(PengaduanBalasan::class);
}

}