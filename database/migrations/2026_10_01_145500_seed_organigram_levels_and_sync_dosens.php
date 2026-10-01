<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Kategori;
use App\Models\Dosen;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Kategori::seedOrganigramDefaults();

        foreach (Dosen::all() as $d) {
            $j = $d->jabatan ?? '';
            $lvl = 7;
            if (str_contains($j, 'Direktur') && !str_contains($j, 'Wakil Direktur')) {
                $lvl = 1;
            } elseif (str_contains($j, 'Wakil Direktur')) {
                $lvl = 2;
            } elseif (str_contains($j, 'Program Studi') || str_contains($j, 'Kaprodi')) {
                $lvl = 4;
            } elseif ((str_contains($j, 'Staf') || str_contains($j, 'Staff') || str_contains($j, 'Tendik')) && !str_contains($j, 'Ketua') && !str_contains($j, 'Kepala')) {
                $lvl = 6;
            } elseif (str_contains($j, 'Kepala Bagian') || str_contains($j, 'Kabag')) {
                $lvl = 5;
            } elseif (str_contains($j, 'Penjaminan Mutu') || str_contains($j, 'PPM') || str_contains($j, 'LPPM') || str_contains($j, 'Lembaga') || str_contains($j, 'Perpustakaan') || str_contains($j, 'Kerjasama')) {
                $lvl = 3;
            } else {
                $lvl = 7;
            }
            $d->update(['level_organigram' => $lvl]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Kategori::where('modul', 'organigram')->delete();
    }
};
