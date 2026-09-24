<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('dosens', function (Blueprint $table) {

        $table->text('bio')->nullable();

        $table->string('nidn')->nullable();

        $table->string('email')->nullable();

        $table->string('pendidikan')->nullable();

        $table->string('bidang_keahlian')->nullable();

        $table->string('linkedin')->nullable();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dosens', function (Blueprint $table) {
            //
        });
    }
};
