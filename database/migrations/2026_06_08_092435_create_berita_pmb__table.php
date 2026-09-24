<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_pmbs', function (Blueprint $table) {

            $table->id();

            $table->string('judul');
            $table->string('slug')->unique();

            $table->string('penulis');
            $table->string('editor')->nullable();

            $table->string('kategori')->nullable();

            $table->longText('isi');

            $table->string('gambar')->nullable();
            $table->string('video')->nullable();
            $table->string('file_pdf')->nullable();

            $table->timestamp('publish_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_pmbs');
    }
};

