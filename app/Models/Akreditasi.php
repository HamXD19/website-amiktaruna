<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akreditasi extends Model
{
    protected $fillable = [
        'judul',
        'tahun',
         'peringkat',
        'deskripsi',
        'gambar',
        'is_active'
    ];
}