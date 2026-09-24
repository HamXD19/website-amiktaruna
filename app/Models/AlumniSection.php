<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlumniSection extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'type',
        'layout',
        'image',
        'link',
        'is_active'
    ];
}