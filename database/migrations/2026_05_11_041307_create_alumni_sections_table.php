<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni_sections', function (Blueprint $table) {

            $table->id();

            // Judul section
            $table->string('judul');

            // Isi panjang
            $table->longText('deskripsi')->nullable();

            // Gambar
            $table->string('image')->nullable();

            // Penanda section
            $table->enum('type', [
                'tracer_study',
                'dana_abadi'
            ]);

            // Posisi gambar
            $table->enum('layout', [
                'left_image',
                'right_image'
            ])->default('left_image');

            // Status tampil
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_sections');
    }
};