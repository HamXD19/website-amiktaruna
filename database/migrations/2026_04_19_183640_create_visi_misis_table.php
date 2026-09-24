<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visi_misis', function (Blueprint $table) {
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('visi_misis', function (Blueprint $table) {
            $table->dropColumn(['visi', 'misi']);
        });
    }
};