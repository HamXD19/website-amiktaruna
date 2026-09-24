<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPMDokumen extends Model
{
    protected $table = 'ppm_dokumens';

    protected $fillable = [
        'nama_dokumen',
        'kategori',
        'file_pdf',
        'deskripsi',
        'tahun',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    public function kategoriModel()
    {
        return $this->belongsTo(Kategori::class, 'kategori', 'slug');
    }

    protected static function booted()
    {
        static::deleting(function ($dokumen) {
            if ($dokumen->file_pdf) {
                $filePath = public_path('uploads/ppm/' . $dokumen->file_pdf);
                if (file_exists($filePath) && is_file($filePath)) {
                    @unlink($filePath);
                }
            }
        });
    }
}
