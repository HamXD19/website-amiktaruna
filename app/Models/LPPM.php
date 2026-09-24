<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LPPM extends Model
{
    protected $table='lppm';

    protected $fillable=[

        'deskripsi',

        'jesica_link',
        'jesica_image',

        'penelitian_link',
        'penelitian_image'

    ];
}