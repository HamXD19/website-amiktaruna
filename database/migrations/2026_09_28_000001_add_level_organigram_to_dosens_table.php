<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dosens', function (Blueprint $table) {
            $table->unsignedTinyInteger('level_organigram')->default(6)->after('jabatan')->comment('1: Pimpinan Utama, 2: Wakil Direktur, 3: Lembaga/Pusat/Kaprodi, 4: Kepala Bagian, 5: Staf/Tendik, 6: Dosen Pengajar');
        });
    }

    public function down(): void
    {
        Schema::table('dosens', function (Blueprint $table) {
            $table->dropColumn('level_organigram');
        });
    }
};
