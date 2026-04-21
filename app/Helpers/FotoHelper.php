<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FotoHelper
{
    public static function url(?string $foto): string
    {
        if (!$foto) {
            return Storage::disk('s3')->url('profil_user/default.png');
        }

        // Kalau foto dari Google (URL lengkap), langsung return
        if (str_starts_with($foto, 'http')) {
            return $foto;
        }

        // Kalau foto dari S3 (path)
        return Storage::disk('s3')->url($foto);
    }
}