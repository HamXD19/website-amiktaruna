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
        'level_organigram',
        'warna',
        'ikon',
        'keterangan',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
        'level_organigram' => 'integer',
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

    public function beritaPmbs()
    {
        return $this->hasMany(BeritaPMB::class, 'kategori', 'slug');
    }

    public function lppmDokumens()
    {
        return $this->hasMany(LPPMDokumen::class, 'kategori', 'slug');
    }

    public function dokumenKampuses()
    {
        return $this->hasMany(DokumenKampus::class, 'kategori', 'slug');
    }

    public static function getOrganigramLevels(): array
    {
        return [
            1 => 'Level 1 - Direktur (Pimpinan Utama)',
            2 => 'Level 2 - Wakil Direktur (Wadir I, II, III)',
            3 => 'Level 3 - Lembaga, Pusat & Unit Penunjang (PPM, LPPM, Perpustakaan, Kerjasama)',
            4 => 'Level 4 - Ketua Program Studi (Kaprodi)',
            5 => 'Level 5 - Kepala Bagian (Kabag)',
            6 => 'Level 6 - Staf & Tenaga Kependidikan',
            7 => 'Level 7 - Dosen Pengajar Lainnya',
        ];
    }
}
