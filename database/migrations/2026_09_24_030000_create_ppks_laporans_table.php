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
        Schema::create('ppks_laporans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tiket')->unique();
            $table->boolean('is_anonim')->default(false);
            $table->string('nama_pelapor')->nullable();
            $table->string('status_pelapor')->default('Mahasiswa'); // Mahasiswa, Dosen, Tenaga Kependidikan, Alumni, Masyarakat
            $table->string('no_telp')->nullable();
            $table->string('email')->nullable();
            $table->string('kategori_kekerasan'); // Pelecehan Verbal, Fisik, Daring/Cyber, Intimidasi, Diskriminasi Seksual, Lainnya
            $table->date('tanggal_kejadian')->nullable();
            $table->string('lokasi_kejadian')->nullable();
            $table->string('nama_terlapor')->nullable();
            $table->text('kronologi');
            $table->string('dokumen_bukti')->nullable(); // PDF, DOC, DOCX, JPG, PNG
            $table->string('kebutuhan_pendampingan')->nullable(); // Konseling, Mediasi, Hukum, Perlindungan
            $table->enum('status', ['baru', 'ditinjau', 'investigasi', 'selesai'])->default('baru');
            $table->text('catatan_petugas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppks_laporans');
    }
};
