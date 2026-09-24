<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

        Schema::table('profil_lulusans', function (Blueprint $table) {

            if (!Schema::hasColumn('profil_lulusans','judul')) {

                $table->string('judul')->nullable();

            }

            if (!Schema::hasColumn('profil_lulusans','deskripsi')) {

                $table->text('deskripsi')->nullable();

            }

        });

        Schema::table('fasilitas_prodis', function (Blueprint $table) {

            if (!Schema::hasColumn('fasilitas_prodis','nama')) {

                $table->string('nama')->nullable();

            }

            if (!Schema::hasColumn('fasilitas_prodis','deskripsi')) {

                $table->text('deskripsi')->nullable();

            }

            if (!Schema::hasColumn('fasilitas_prodis','icon')) {

                $table->string('icon')->nullable();

            }

        });

    }

    public function down()
    {
        //
    }
};