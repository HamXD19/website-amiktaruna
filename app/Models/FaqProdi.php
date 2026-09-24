<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqProdi extends Model
{
protected $fillable = [
    'program_studi_id',
    'pertanyaan',
    'jawaban'
];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }
}