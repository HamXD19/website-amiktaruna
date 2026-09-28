<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_studis', function (Blueprint $table) {
            $table->string('jenjang')->default('Diploma 3 (D3)')->after('nama_prodi');
            $table->string('gelar')->default('A.Md.')->after('jenjang');
            $table->string('masa_studi')->default('3 Tahun (6 Semester)')->after('gelar');
            $table->string('kurikulum')->default('Berbasis Vokasi & KKNI')->after('masa_studi');
        });
    }

    public function down(): void
    {
        Schema::table('program_studis', function (Blueprint $table) {
            $table->dropColumn(['jenjang', 'gelar', 'masa_studi', 'kurikulum']);
        });
    }
};
