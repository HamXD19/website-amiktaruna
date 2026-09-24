<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    protected $fillable = [

        'nama_prodi',

        'slug',

        'tagline',

        'deskripsi',

        'visi',

        'misi',

        'akreditasi',

        'thumbnail',

        'kalender_akademik',

        'jadwal_semester'

    ];

    public function profilLulusans()
    {
        return $this->hasMany(
            ProfilLulusan::class
        );
    }

    public function fasilitas()
    {
        return $this->hasMany(
            FasilitasProdi::class
        );
    }

    public function faqs()
    {
        return $this->hasMany(
            FaqProdi::class
        );
    }

    public function dokumens()
    {
        return $this->hasMany(
            ProdiDokumen::class
        );
    }

    protected static function booted()
    {
        static::deleting(function ($prodi) {
            foreach ($prodi->dokumens as $dok) {
                $dok->delete();
            }

            foreach (['thumbnail', 'kalender_akademik', 'jadwal_semester'] as $field) {
                if ($prodi->$field) {
                    $path = public_path('uploads/program_studi/' . $prodi->$field);
                    if (file_exists($path) && is_file($path)) {
                        @unlink($path);
                    }
                }
            }
        });
    }
}

