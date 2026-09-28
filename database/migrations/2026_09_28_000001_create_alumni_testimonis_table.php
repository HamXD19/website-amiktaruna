<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni_testimonis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('program_studi')->nullable();
            $table->string('tahun_lulus', 20)->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('perusahaan')->nullable();
            $table->text('testimoni');
            $table->string('foto')->nullable();
            $table->tinyInteger('rating')->default(5);
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_testimonis');
    }
};
