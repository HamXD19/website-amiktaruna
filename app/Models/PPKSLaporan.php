<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPKSLaporan extends Model
{
    use HasFactory;

    protected $table = 'ppks_laporans';

    protected $fillable = [
        'kode_tiket',
        'is_anonim',
        'nama_pelapor',
        'status_pelapor',
        'no_telp',
        'email',
        'kategori_kekerasan',
        'tanggal_kejadian',
        'lokasi_kejadian',
        'nama_terlapor',
        'kronologi',
        'dokumen_bukti',
        'kebutuhan_pendampingan',
        'status',
        'catatan_petugas'
    ];

    protected $casts = [
        'is_anonim' => 'boolean',
        'tanggal_kejadian' => 'date',
    ];

    protected static function booted()
    {
        static::deleting(function ($laporan) {
            if ($laporan->dokumen_bukti) {
                $path = public_path('uploads/ppks/' . $laporan->dokumen_bukti);
                if (file_exists($path) && is_file($path)) {
                    @unlink($path);
                }
            }
        });
    }

    public function getDisplayNameAttribute()
    {
        return $this->is_anonim ? 'Anonim (Identitas Dirahasiakan)' : ($this->nama_pelapor ?: 'Anonim');
    }
}
