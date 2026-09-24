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
        Schema::table('pmbs', function (Blueprint $table) {
            $table->string('subjudul')->nullable()->after('judul');
            $table->string('nama_gelombang')->nullable()->after('deskripsi');
            $table->string('status_gelombang')->nullable()->after('nama_gelombang');
            $table->string('periode_gelombang')->nullable()->after('status_gelombang');
            $table->string('kuota_info')->nullable()->after('periode_gelombang');
            $table->string('no_whatsapp')->nullable()->after('kuota_info');
            $table->string('brosur_file')->nullable()->after('link_portal');
            $table->longText('jalur_pendaftaran')->nullable()->after('brosur_file');
            $table->longText('alur_pendaftaran')->nullable()->after('jalur_pendaftaran');
            $table->longText('jadwal_gelombang')->nullable()->after('alur_pendaftaran');
            $table->longText('persyaratan_berkas')->nullable()->after('jadwal_gelombang');
            $table->longText('faq_list')->nullable()->after('persyaratan_berkas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pmbs', function (Blueprint $table) {
            $table->dropColumn([
                'subjudul',
                'nama_gelombang',
                'status_gelombang',
                'periode_gelombang',
                'kuota_info',
                'no_whatsapp',
                'brosur_file',
                'jalur_pendaftaran',
                'alur_pendaftaran',
                'jadwal_gelombang',
                'persyaratan_berkas',
                'faq_list',
            ]);
        });
    }
};
