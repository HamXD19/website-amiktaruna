<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LPPMPortal extends Model
{
    protected $table = 'lppm_portals';

    protected $fillable = [
        'nama',
        'link',
        'logo',
        'deskripsi',
        'warna',
        'urutan',
    ];

    protected static function booted()
    {
        static::deleting(function ($portal) {
            if ($portal->logo) {
                $path = public_path('uploads/lppm/' . $portal->logo);
                if (file_exists($path) && is_file($path)) {
                    @unlink($path);
                }
            }
        });
    }
}
