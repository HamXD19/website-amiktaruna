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
    Schema::create('layanans', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('link');
        $table->string('icon'); // contoh: laptop, mail, dll (Lucide)
        $table->string('warna')->nullable(); // success, primary, dll
        $table->text('deskripsi')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
