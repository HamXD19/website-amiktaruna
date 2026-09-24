<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FasilitasProdi extends Model
{
protected $fillable = [
    'program_studi_id',
    'nama',
    'deskripsi',
    'icon'
];

   public function programStudi()
{
    return $this->belongsTo(ProgramStudi::class);
}
}