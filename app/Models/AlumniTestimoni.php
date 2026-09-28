<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniTestimoni extends Model
{
    use HasFactory;

    protected $table = 'alumni_testimonis';

    protected $fillable = [
        'nama',
        'program_studi',
        'tahun_lulus',
        'pekerjaan',
        'perusahaan',
        'testimoni',
        'foto',
        'rating',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rating'    => 'integer',
        'urutan'    => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
