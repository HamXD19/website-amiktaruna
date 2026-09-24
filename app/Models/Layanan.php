<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $fillable = [
    'nama',
    'link',
    'logo',
    'warna',
    'deskripsi'
];

    protected static function booted()
    {
        static::deleting(function ($layanan) {
            if ($layanan->logo) {
                $path = public_path('uploads/' . $layanan->logo);
                if (file_exists($path) && is_file($path)) {
                    @unlink($path);
                }
            }
        });
    }
}
