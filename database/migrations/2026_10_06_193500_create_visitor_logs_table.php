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
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->nullable()->index();
            $table->string('url', 500);
            $table->string('page_name', 150)->nullable();
            $table->string('method', 10)->default('GET');
            $table->string('referrer', 500)->nullable();
            $table->string('referrer_host', 100)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device', 20)->default('desktop')->index();
            $table->string('platform', 50)->nullable();
            $table->string('browser', 50)->nullable();
            $table->string('session_id', 100)->nullable()->index();
            $table->boolean('is_bot')->default(false)->index();
            $table->timestamps();

            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
