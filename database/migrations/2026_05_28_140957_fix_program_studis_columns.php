<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('program_studis', function (Blueprint $table) {

            if (!Schema::hasColumn('program_studis','nama_prodi')) {
                $table->string('nama_prodi')->nullable();
            }

            if (!Schema::hasColumn('program_studis','tagline')) {
                $table->string('tagline')->nullable();
            }

            if (!Schema::hasColumn('program_studis','visi')) {
                $table->text('visi')->nullable();
            }

            if (!Schema::hasColumn('program_studis','misi')) {
                $table->text('misi')->nullable();
            }

            if (!Schema::hasColumn('program_studis','akreditasi')) {
                $table->string('akreditasi')->nullable();
            }

            if (!Schema::hasColumn('program_studis','thumbnail')) {
                $table->string('thumbnail')->nullable();
            }

            if (!Schema::hasColumn('program_studis','kalender_akademik')) {
                $table->string('kalender_akademik')->nullable();
            }

            if (!Schema::hasColumn('program_studis','jadwal_semester')) {
                $table->string('jadwal_semester')->nullable();
            }

        });
    }

    public function down()
    {
        //
    }
};