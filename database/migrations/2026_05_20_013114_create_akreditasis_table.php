<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akreditasis', function (Blueprint $table) {

            $table->id();

            $table->string('tahun');

            $table->string('peringkat');

            $table->text('deskripsi')->nullable();

            $table->string('gambar')->nullable();

            $table->boolean('is_active')->default(1);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akreditasis');
    }
};