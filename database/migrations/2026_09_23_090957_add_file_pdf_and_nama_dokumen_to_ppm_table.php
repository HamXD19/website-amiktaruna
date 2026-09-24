<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ppm', function (Blueprint $table) {
            $table->string('file_pdf')->nullable()->after('gambar');
            $table->string('nama_dokumen')->nullable()->after('file_pdf');
            $table->text('deskripsi_dokumen')->nullable()->after('nama_dokumen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppm', function (Blueprint $table) {
            $table->dropColumn(['file_pdf', 'nama_dokumen', 'deskripsi_dokumen']);
        });
    }
};

