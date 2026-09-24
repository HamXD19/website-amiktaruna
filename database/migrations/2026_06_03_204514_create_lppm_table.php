<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lppm', function (Blueprint $table) {

            $table->id();

            $table->longText('deskripsi')->nullable();

            $table->string('jesica_link')->nullable();

            $table->string('jesica_image')->nullable();

            $table->string('penelitian_link')->nullable();

            $table->string('penelitian_image')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lppm');
    }
};