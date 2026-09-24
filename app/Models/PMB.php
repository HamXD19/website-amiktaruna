<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PMB extends Model
{
    protected $table = 'pmbs';

    protected $fillable = [
        'judul',
        'subjudul',
        'deskripsi',
        'nama_gelombang',
        'status_gelombang',
        'periode_gelombang',
        'kuota_info',
        'no_whatsapp',
        'link_portal',
        'brosur_file',
        'jalur_pendaftaran',
        'alur_pendaftaran',
        'jadwal_gelombang',
        'persyaratan_berkas',
        'faq_list',
    ];

    protected $casts = [
        'jalur_pendaftaran'  => 'array',
        'alur_pendaftaran'   => 'array',
        'jadwal_gelombang'   => 'array',
        'persyaratan_berkas' => 'array',
        'faq_list'           => 'array',
    ];

    protected static function booted()
    {
        static::deleting(function ($pmb) {
            if ($pmb->brosur_file) {
                $path = public_path('uploads/pmb/' . $pmb->brosur_file);
                if (file_exists($path) && is_file($path)) {
                    @unlink($path);
                }
            }
        });
    }
}
