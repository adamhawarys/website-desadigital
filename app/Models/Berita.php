<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $fillable = [
        'gambar',
        'judul',
        'slug',
        'konten',
        'penulis_id',
        'status',
        'tanggal_publikasi' // Admin/petugas akan isi manual
    ];

    // Tidak perlu protected $dates jika tanggal publikasi diisi manual

    // Relasi ke user (penulis)
    public function penulis()
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }

    // Scope untuk berita yang publish
    public function scopePublish($query)
    {
        return $query->where('status', true)
                     ->orderBy('tanggal_publikasi', 'desc');
    }

     // Accessor untuk tanggal_publikasi
    public function getTanggalPublikasiAttribute($value)
    {
        return Carbon::parse($value)
        ->locale('id')
        ->translatedFormat('d F Y'); // 03 Januari 2026
    }

     // Mutator untuk slug otomatis dan memastikan slug unik
    public function setSlugAttribute($value)
    {
        // Jika slug tidak diisi, buat slug otomatis dari judul
        if (empty($value)) {
            $slug = Str::slug($this->judul);

            // Pastikan slug unik
            $slugOriginal = $slug;
            $count = 1;

            // Cek apakah slug sudah ada di database
            while (Berita::where('slug', $slug)->exists()) {
                $slug = $slugOriginal . '-' . $count;  // Tambahkan angka jika slug sudah ada
                $count++;
            }

            // Set slug yang unik
            $this->attributes['slug'] = $slug;
        } else {
            $this->attributes['slug'] = $value;
        }
    }
    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = mb_strtoupper($value, 'UTF-8');
    }
}
