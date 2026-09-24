<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPM extends Model
{
    protected $table = 'ppm';

    protected $fillable = [

        'deskripsi',
        'nama_portal',
        'link_portal',
        'gambar',
        'file_pdf',
        'nama_dokumen',
        'deskripsi_dokumen'
    ];
}