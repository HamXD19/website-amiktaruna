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
        Schema::table('visitor_logs', function (Blueprint $table) {
            $table->string('country', 100)->nullable()->after('browser');
            $table->string('country_code', 5)->nullable()->after('country');
            $table->string('city', 100)->nullable()->after('country_code');

            $table->index('country_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitor_logs', function (Blueprint $table) {
            $table->dropIndex(['country_code']);
            $table->dropColumn(['country', 'country_code', 'city']);
        });
    }
};
