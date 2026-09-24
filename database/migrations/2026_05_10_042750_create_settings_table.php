<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | IDENTITAS WEBSITE
            |--------------------------------------------------------------------------
            */

            $table->string('nama_website')->nullable();
            $table->string('tagline')->nullable();

            /*
            |--------------------------------------------------------------------------
            | LOGO WEBSITE
            |--------------------------------------------------------------------------
            */

            $table->string('logo')->nullable();

            /*
            |--------------------------------------------------------------------------
            | HERO SECTION
            |--------------------------------------------------------------------------
            */

            $table->string('hero_judul')->nullable();
            $table->string('hero_highlight')->nullable();

            $table->text('hero_subjudul')->nullable();

            $table->string('hero_button_1_text')->nullable();
            $table->string('hero_button_1_link')->nullable();

            $table->string('hero_button_2_text')->nullable();
            $table->string('hero_button_2_link')->nullable();

            /*
            |--------------------------------------------------------------------------
            | HERO CAROUSEL
            |--------------------------------------------------------------------------
            */

            $table->string('hero_slide_1')->nullable();
            $table->string('hero_slide_2')->nullable();
            $table->string('hero_slide_3')->nullable();

            /*
            |--------------------------------------------------------------------------
            | FOOTER
            |--------------------------------------------------------------------------
            */

            $table->text('footer_deskripsi')->nullable();

            $table->text('alamat')->nullable();

            $table->string('telepon')->nullable();

            $table->string('email')->nullable();

            $table->string('jam_operasional')->nullable();

            /*
            |--------------------------------------------------------------------------
            | SOSIAL MEDIA
            |--------------------------------------------------------------------------
            */

            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('facebook')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};