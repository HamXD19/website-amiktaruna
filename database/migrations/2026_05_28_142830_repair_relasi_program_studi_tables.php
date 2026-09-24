<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

        // PROFIL LULUSAN
        Schema::table('profil_lulusans', function (Blueprint $table) {

            if (!Schema::hasColumn('profil_lulusans','program_studi_id')) {

                $table->unsignedBigInteger('program_studi_id')
                      ->nullable()
                      ->after('id');

            }

        });

        // FASILITAS PRODI
        Schema::table('fasilitas_prodis', function (Blueprint $table) {

            if (!Schema::hasColumn('fasilitas_prodis','program_studi_id')) {

                $table->unsignedBigInteger('program_studi_id')
                      ->nullable()
                      ->after('id');

            }

        });

        // FAQ PRODI
        Schema::table('faq_prodis', function (Blueprint $table) {

            if (!Schema::hasColumn('faq_prodis','program_studi_id')) {

                $table->unsignedBigInteger('program_studi_id')
                      ->nullable()
                      ->after('id');

            }

        });

    }

    public function down()
    {
        //
    }
};