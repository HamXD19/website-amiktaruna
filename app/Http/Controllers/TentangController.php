<?php

namespace App\Http\Controllers;

use App\Models\VisiMisi;
use App\Models\Dosen;
use App\Models\Akreditasi;

class TentangController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | VISI MISI
        |--------------------------------------------------------------------------
        */

        $visimisi = VisiMisi::first();

        /*
        |--------------------------------------------------------------------------
        | DOSEN
        |--------------------------------------------------------------------------
        */

$dosen = Dosen::orderByRaw("

CASE

/* PIMPINAN */

WHEN jabatan LIKE '%Direktur AMIK Taruna%' THEN 1

WHEN jabatan LIKE '%Wakil Direktur I Bidang Akademik%' THEN 2

WHEN jabatan LIKE '%Wakil Direktur II Bidang Administrasi & Keuangan%' THEN 3

WHEN jabatan LIKE '%Wakil Direktur III Bidang Kemahasiswaan & Alumni%' THEN 4

/* KETUA */

WHEN jabatan LIKE '%Ketua Lembaga Penelitian & Pengabdian Masyarakat%' THEN 5

WHEN jabatan LIKE '%Ketua Pusat Penjaminan Mutu%' THEN 6

WHEN jabatan LIKE '%Ketua UPT Perpustakaan & Kearsipan%' THEN 7

WHEN jabatan LIKE '%Ketua Unit Kerjasama & Pengembangan Institusi%' THEN 8

/***** KAPRODI (PINDAH KE BAWAH KETUA) *****/

WHEN jabatan LIKE '%Ketua Program Studi Teknologi Informasi%' THEN 9

WHEN jabatan LIKE '%Ketua Program Studi Sistem Informasi Akuntansi%' THEN 10

WHEN jabatan LIKE '%Ketua Program Studi Sistem Informasi%' THEN 11

/* KABAG */

WHEN jabatan LIKE '%Kepala Bagian Administrasi Umum & Keuangan%' THEN 12

WHEN jabatan LIKE '%Kepala Bagian Administrasi Akademik%' THEN 13

/* STAFF */

WHEN jabatan LIKE '%Staf Pusat Penjaminan Mutu%' THEN 14

WHEN jabatan LIKE '%Staf Administrasi Umum & Keuangan%' THEN 15

WHEN jabatan LIKE '%Staf Administrasi Akademik%' THEN 16

WHEN jabatan LIKE '%Staf SI, Humas & Layanan%' THEN 17

WHEN jabatan LIKE '%Staf Alumni & Pusat Karir%' THEN 18

WHEN jabatan LIKE '%Staf Perpustakaan & Kearsipan%' THEN 19

/* DOSEN */

WHEN jabatan LIKE '%Dosen%' THEN 20

ELSE 999

END

")->get();




        /*
        |--------------------------------------------------------------------------
        | AKREDITASI
        |--------------------------------------------------------------------------
        */

        $akreditasi = Akreditasi::where('is_active', 1)
                        ->latest('tahun')
                        ->get();

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view('tentang', compact(
            'visimisi',
            'dosen',
            'akreditasi'
        ));
    }
}