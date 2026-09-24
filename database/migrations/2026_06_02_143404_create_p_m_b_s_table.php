
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pmbs', function (Blueprint $table) {

            $table->id();

            $table->string('judul');

            $table->longText('deskripsi');

            $table->string('link_portal')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pmbs');
    }
};
