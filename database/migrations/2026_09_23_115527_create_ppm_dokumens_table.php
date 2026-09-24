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
        Schema::create('ppm_dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dokumen');
            $table->string('kategori')->default('spmi-mutu');
            $table->string('file_pdf');
            $table->text('deskripsi')->nullable();
            $table->string('tahun')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppm_dokumens');
    }
};
