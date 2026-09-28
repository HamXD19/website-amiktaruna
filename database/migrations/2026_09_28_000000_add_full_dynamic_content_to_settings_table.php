<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('badge_akreditasi')->nullable()->after('tagline');
            $table->text('maps_embed_url')->nullable()->after('alamat');
            $table->json('page_headers')->nullable();
            $table->json('home_facts')->nullable();
            $table->json('home_pillars')->nullable();
            $table->json('home_cta')->nullable();
            $table->json('mobile_banners')->nullable();
            $table->json('tentang_pillars')->nullable();
            $table->json('akademik_values')->nullable();
            $table->json('alumni_pillars')->nullable();
            $table->json('pmb_pillars')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'badge_akreditasi',
                'maps_embed_url',
                'page_headers',
                'home_facts',
                'home_pillars',
                'home_cta',
                'mobile_banners',
                'tentang_pillars',
                'akademik_values',
                'alumni_pillars',
                'pmb_pillars',
            ]);
        });
    }
};
