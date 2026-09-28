<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [

        /*
        |--------------------------------------------------------------------------
        | IDENTITAS WEBSITE
        |--------------------------------------------------------------------------
        */

        'nama_website',
        'tagline',

        /*
        |--------------------------------------------------------------------------
        | LOGO WEBSITE
        |--------------------------------------------------------------------------
        */

        'logo',

        /*
        |--------------------------------------------------------------------------
        | HERO SECTION
        |--------------------------------------------------------------------------
        */

        'hero_judul',
        'hero_highlight',
        'hero_subjudul',

        'hero_button_1_text',
        'hero_button_1_link',

        'hero_button_2_text',
        'hero_button_2_link',

        /*
        |--------------------------------------------------------------------------
        | HERO CAROUSEL
        |--------------------------------------------------------------------------
        */

        'hero_slide_1',
        'hero_slide_2',
        'hero_slide_3',

        /*
        |--------------------------------------------------------------------------
        | FOOTER & KONTAK
        |--------------------------------------------------------------------------
        */

        'footer_deskripsi',
        'alamat',
        'telepon',
        'email',
        'jam_operasional',
        'maps_embed_url',
        'badge_akreditasi',

        /*
        |--------------------------------------------------------------------------
        | SOSIAL MEDIA
        |--------------------------------------------------------------------------
        */

        'instagram',
        'youtube',
        'tiktok',
        'facebook',

        /*
        |--------------------------------------------------------------------------
        | KONTEN DINAMIS (JSON)
        |--------------------------------------------------------------------------
        */

        'page_headers',
        'home_facts',
        'home_pillars',
        'home_cta',
        'mobile_banners',
        'tentang_pillars',
        'akademik_values',
        'alumni_pillars',
        'pmb_pillars',
    ];

    protected $casts = [
        'page_headers' => 'array',
        'home_facts' => 'array',
        'home_pillars' => 'array',
        'home_cta' => 'array',
        'mobile_banners' => 'array',
        'tentang_pillars' => 'array',
        'akademik_values' => 'array',
        'alumni_pillars' => 'array',
        'pmb_pillars' => 'array',
    ];
}