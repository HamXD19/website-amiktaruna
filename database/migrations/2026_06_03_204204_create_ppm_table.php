<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppm', function (Blueprint $table) {

            $table->id();

            $table->longText('deskripsi')->nullable();

            $table->string('nama_portal')->nullable();

            $table->string('link_portal')->nullable();

            $table->string('gambar')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppm');
    }
};