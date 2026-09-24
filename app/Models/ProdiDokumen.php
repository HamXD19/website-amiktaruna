<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdiDokumen extends Model
{
    protected $table = 'prodi_dokumens';

    protected $fillable = [
        'program_studi_id',
        'nama_dokumen',
        'kategori',
        'file_dokumen',
        'deskripsi',
        'tahun',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    public function kategoriModel()
    {
        return $this->belongsTo(Kategori::class, 'kategori', 'slug');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    protected static function booted()
    {
        static::deleting(function ($dokumen) {
            if ($dokumen->file_dokumen) {
                $filePath = public_path('uploads/program_studi/dokumen/' . $dokumen->file_dokumen);
                if (file_exists($filePath) && is_file($filePath)) {
                    @unlink($filePath);
                }
            }
        });
    }
}
