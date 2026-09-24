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
        Schema::create('prodi_dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_studi_id')->constrained('program_studis')->onDelete('cascade');
            $table->string('nama_dokumen');
            $table->string('kategori')->default('kurikulum');
            $table->string('file_dokumen');
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
        Schema::dropIfExists('prodi_dokumens');
    }
};
