<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilLulusan extends Model
{
    protected $fillable = [
        'program_studi_id',
        'judul',
        'deskripsi'
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }
}