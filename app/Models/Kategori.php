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
        try {
            self::seedOrganigramDefaults();
            $levels = self::where('modul', 'organigram')
                ->where('is_active', true)
                ->orderBy('level_organigram')
                ->orderBy('urutan')
                ->get();

            if ($levels->isNotEmpty()) {
                $result = [];
                foreach ($levels as $l) {
                    $result[$l->level_organigram] = $l->nama;
                }
                return $result;
            }
        } catch (\Throwable $e) {
            // fallback if table/column not available
        }

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

    public static function seedOrganigramDefaults(): void
    {
        try {
            if (self::where('modul', 'organigram')->count() === 0) {
                $defaults = [
                    [
                        'nama' => 'Level 1 - Direktur (Pimpinan Utama)',
                        'slug' => 'level-1-direktur',
                        'modul' => 'organigram',
                        'level_organigram' => 1,
                        'warna' => 'success',
                        'ikon' => '🏛️',
                        'keterangan' => 'Direktur AMIK Taruna Probolinggo',
                        'urutan' => 1,
                        'is_active' => true,
                    ],
                    [
                        'nama' => 'Level 2 - Wakil Direktur (Wadir I, II, III)',
                        'slug' => 'level-2-wakil-direktur',
                        'modul' => 'organigram',
                        'level_organigram' => 2,
                        'warna' => 'primary',
                        'ikon' => '👔',
                        'keterangan' => 'Wakil Direktur Bidang Akademik, Keuangan & Kemahasiswaan',
                        'urutan' => 2,
                        'is_active' => true,
                    ],
                    [
                        'nama' => 'Level 3 - Lembaga, Pusat & Unit Penunjang (PPM, LPPM, Perpustakaan, Kerjasama)',
                        'slug' => 'level-3-lembaga-pusat',
                        'modul' => 'organigram',
                        'level_organigram' => 3,
                        'warna' => 'info',
                        'ikon' => '🛡️',
                        'keterangan' => 'Kepala Pusat Penjaminan Mutu (PPM), Ketua LPPM, UPT Perpustakaan & Kerjasama',
                        'urutan' => 3,
                        'is_active' => true,
                    ],
                    [
                        'nama' => 'Level 4 - Ketua Program Studi (Kaprodi)',
                        'slug' => 'level-4-kaprodi',
                        'modul' => 'organigram',
                        'level_organigram' => 4,
                        'warna' => 'success',
                        'ikon' => '🎓',
                        'keterangan' => 'Pimpinan & Pelaksana Kurikulum Keilmuan Program Studi Vokasi',
                        'urutan' => 4,
                        'is_active' => true,
                    ],
                    [
                        'nama' => 'Level 5 - Kepala Bagian (Kabag)',
                        'slug' => 'level-5-kabag',
                        'modul' => 'organigram',
                        'level_organigram' => 5,
                        'warna' => 'warning',
                        'ikon' => '💼',
                        'keterangan' => 'Pelaksana Teknis Administrasi Akademik & Umum',
                        'urutan' => 5,
                        'is_active' => true,
                    ],
                    [
                        'nama' => 'Level 6 - Staf & Tenaga Kependidikan',
                        'slug' => 'level-6-staf-tendik',
                        'modul' => 'organigram',
                        'level_organigram' => 6,
                        'warna' => 'secondary',
                        'ikon' => '👤',
                        'keterangan' => 'Tenaga Kependidikan, Layanan Informasi & Perpustakaan',
                        'urutan' => 6,
                        'is_active' => true,
                    ],
                    [
                        'nama' => 'Level 7 - Dosen Pengajar Lainnya',
                        'slug' => 'level-7-dosen-pengajar',
                        'modul' => 'organigram',
                        'level_organigram' => 7,
                        'warna' => 'secondary',
                        'ikon' => '👨‍🏫',
                        'keterangan' => 'Tenaga Pendidik Sivitas Akademika AMIK Taruna',
                        'urutan' => 7,
                        'is_active' => true,
                    ],
                ];

                foreach ($defaults as $d) {
                    self::create($d);
                }
            }
        } catch (\Throwable $e) {
            // ignore if DB is migrating
        }
    }
}
