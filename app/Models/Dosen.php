<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $fillable = [

        'nama',
        'jabatan',
        'level_organigram',
        'foto',

        'bio',
        'nidn',
        'email',
        'pendidikan',
        'bidang_keahlian',
        'linkedin'

    ];

    public static function getOrganigramLevels(): array
    {
        return Kategori::getOrganigramLevels();
    }
} 