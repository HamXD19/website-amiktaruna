<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPMPortal extends Model
{
    protected $table = 'ppm_portals';

    protected $fillable = [
        'nama',
        'link',
        'logo',
        'warna',
        'deskripsi',
        'urutan',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    protected static function booted()
    {
        static::deleting(function ($portal) {
            if ($portal->logo) {
                $filePath = public_path('uploads/ppm/' . $portal->logo);
                if (file_exists($filePath) && is_file($filePath)) {
                    @unlink($filePath);
                }
            }
        });
    }
}
