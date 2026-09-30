<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class HalamanKustom extends Model
{
    protected $table = 'halaman_kustoms';

    protected $guarded = ['id'];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer',
    ];

    public function getGambarUrlAttribute()
    {
        if (!$this->gambar) {
            return null;
        }

        if (str_starts_with($this->gambar, 'http://') || str_starts_with($this->gambar, 'https://')) {
            return $this->gambar;
        }

        return asset('uploads/' . $this->gambar);
    }

    protected static function booted(): void
    {
        static::deleting(function (HalamanKustom $halaman) {
            if ($halaman->gambar && !str_starts_with($halaman->gambar, 'http')) {
                $filePath = public_path('uploads/' . $halaman->gambar);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }
        });
    }
}
