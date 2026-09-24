<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';

    protected $fillable = [
        'nama',
        'slug',
        'modul',
        'warna',
        'ikon',
        'keterangan',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForModul($query, $modul)
    {
        return $query->where(function ($q) use ($modul) {
            $q->where('modul', $modul)
              ->orWhere('modul', 'umum');
        });
    }

    public function beritas()
    {
        return $this->hasMany(Berita::class, 'kategori', 'slug');
    }

    public function prodiDokumens()
    {
        return $this->hasMany(ProdiDokumen::class, 'kategori', 'slug');
    }

    public function ppmDokumens()
    {
        return $this->hasMany(PPMDokumen::class, 'kategori', 'slug');
    }
}
