<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaPMB extends Model
{
    use HasFactory;

    protected $table = 'berita_pmbs';

    protected $fillable = [
        'judul',
        'slug',
        'penulis',
        'editor',
        'kategori',
        'isi',
        'gambar',
        'video',
        'file_pdf',
        'publish_at'
    ];

    protected $casts = [
        'publish_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }

    protected static function booted()
    {
        static::deleting(function ($berita) {
            if ($berita->gambar) {
                $path = public_path('uploads/beritapmb/gambar/' . $berita->gambar);
                if (file_exists($path) && is_file($path)) {
                    @unlink($path);
                }
            }
            if ($berita->file_pdf) {
                $path = public_path('uploads/beritapmb/pdf/' . $berita->file_pdf);
                if (file_exists($path) && is_file($path)) {
                    @unlink($path);
                }
            }
        });
    }
}

