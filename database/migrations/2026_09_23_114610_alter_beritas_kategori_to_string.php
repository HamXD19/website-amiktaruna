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
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE beritas MODIFY COLUMN kategori VARCHAR(100) DEFAULT 'pengumuman'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE beritas MODIFY COLUMN kategori ENUM('pengumuman', 'pengabdian', 'penelitian', 'kegiatan_kampus') DEFAULT 'pengumuman'");
    }
};
