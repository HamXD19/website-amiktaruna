<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('profil_lulusans', function (Blueprint $table) {

            if (!Schema::hasColumn('profil_lulusans','program_studi_id')) {

                $table->unsignedBigInteger('program_studi_id')
                      ->nullable()
                      ->after('id');

            }

        });
    }

    public function down()
    {
        Schema::table('profil_lulusans', function (Blueprint $table) {

            $table->dropColumn('program_studi_id');

        });
    }
};