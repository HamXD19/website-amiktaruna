<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\LayananController;
use App\Models\Layanan;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AlumniSectionController;
use App\Http\Controllers\AkreditasiController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\ProfilLulusanController; 
use App\Http\Controllers\FasilitasProdiController; 
use App\Http\Controllers\FaqProdiController;
use App\Http\Controllers\PMBController; 
use App\Http\Controllers\BeritaPMBController;
use App\Http\Controllers\PPMController;
use App\Http\Controllers\LPPMController;
use App\Http\Controllers\KritikSaranController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdiDokumenController;
use App\Http\Controllers\PPKSController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\ActivityLogController;
/*
|--------------------------------------------------------------------------
| FRONTEND
|--------------------------------------------------------------------------
*/

Route::get('/', [BeritaController::class, 'home']);

Route::get('/berita', [BeritaController::class, 'indexPublic']);
Route::get('/berita/{slug}', [BeritaController::class, 'showPublic']);

Route::get('/alumni', [AlumniSectionController::class, 'alumni'])
    ->name('alumni');

Route::get('/tentang', [TentangController::class, 'index'])
    ->name('tentang');

Route::get('/mahasiswa', function () {$layanans = Layanan::all(); return view('mahasiswa', compact('layanans'));});

Route::get('/dosen/{id}', [DosenController::class,'show'])
->name('dosen.show');   

Route::get('/akademik',
    [ProgramStudiController::class,'frontend'])
->name('akademik');

Route::get('/akademik/{slug}',[ProgramStudiController::class,'show'])->name('akademik.show');

Route::get( '/pmb', [PMBController::class,'frontend'] )->name('pmb.frontend');


Route::get( '/pmb/berita/{slug}',[BeritaPMBController::class,'show'])->name('beritapmb.show');

Route::get('/ppm',[PPMController::class,'index'])
->name('ppm');

Route::get('/lppm',[LPPMController::class,'index'])
->name('lppm');

Route::get(
    '/kritik-saran',
    [KritikSaranController::class,'create']
)->name('kritiksaran.form');

Route::post(
    '/kritik-saran',
    [KritikSaranController::class,'store']
)->name('kritiksaran.store');

/*
|--------------------------------------------------------------------------
| LAYANAN PPKS (PENCEGAHAN & PENANGANAN KEKERASAN SEKSUAL)
|--------------------------------------------------------------------------
*/
Route::get('/ppks', [PPKSController::class, 'index'])->name('ppks.index');
Route::post('/ppks/lapor', [PPKSController::class, 'storeLaporan'])->name('ppks.lapor.store');

/*
|--------------------------------------------------------------------------
| USER DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return redirect('/admin/dashboard');
})->middleware(['auth'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| ADMIN AREA (BERSIH TOTAL)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN EKSKLUSIF: MANAJEMEN PENGGUNA & LOG AKTIVITAS
    |--------------------------------------------------------------------------
    */
    Route::middleware(['super_admin'])->group(function () {
        Route::resource('users', UserManagementController::class)->names('admin.users');
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('admin.activity-logs.index');
        Route::post('/activity-logs/clear', [ActivityLogController::class, 'clear'])->name('admin.activity-logs.clear');
    });

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware(['menu.permission:dashboard'])->group(function () {
        Route::get('/dashboard', function () {
            $counts = [
                'berita' => \App\Models\Berita::count(),
                'dosen' => \App\Models\Dosen::count(),
                'prodi' => \App\Models\ProgramStudi::count(),
                'layanan' => \App\Models\Layanan::count(),
                'akreditasi' => \App\Models\Akreditasi::count(),
                'kritiksaran' => class_exists(\App\Models\KritikSaran::class) ? \App\Models\KritikSaran::count() : 0,
                'ppm' => class_exists(\App\Models\PPM::class) ? \App\Models\PPM::count() : 0,
                'lppm' => class_exists(\App\Models\LPPM::class) ? \App\Models\LPPM::count() : 0,
                'alumni' => class_exists(\App\Models\AlumniSection::class) ? \App\Models\AlumniSection::count() : 0,
            ];
            $recent_berita = \App\Models\Berita::latest()->take(5)->get();
            return view('admin.dashboard', compact('counts', 'recent_berita'));
        })->name('admin.dashboard');
    });

    /*
    |--------------------------------------------------------------------------
    | BERITA
    |--------------------------------------------------------------------------
    */
    Route::middleware(['menu.permission:berita'])->group(function () {
        Route::resource('berita', BeritaController::class)
            ->parameters(['berita' => 'berita']);
    });

    /*
    |--------------------------------------------------------------------------
    | BERITA PMB
    |--------------------------------------------------------------------------
    */
    Route::middleware(['menu.permission:beritapmb'])->group(function () {
        Route::resource('beritapmb', BeritaPMBController::class)->except(['show']);
    });

    /*
    |--------------------------------------------------------------------------
    | DOSEN & PROFIL DOSEN
    |--------------------------------------------------------------------------
    */
    Route::middleware(['menu.permission:dosen'])->group(function () {
        Route::get('/profil-dosen', [DosenController::class,'profilIndex'])
            ->name('admin.profil.dosen');

        Route::get('/profil-dosen/edit/{id}', [DosenController::class,'profilEdit'])
            ->name('admin.profil.dosen.edit');

        Route::post('/profil-dosen/update/{id}', [DosenController::class,'profilUpdate'])
            ->name('admin.profil.dosen.update');

        Route::get('/dosen', [DosenController::class, 'index'])
            ->name('admin.dosen');

        Route::post('/dosen', [DosenController::class, 'store']);

        Route::delete('/dosen/{dosen}', [DosenController::class, 'destroy']);

        Route::get('/dosen/edit/{id}', [DosenController::class, 'edit'])
            ->name('admin.dosen.edit');

        Route::post('/dosen/update/{id}', [DosenController::class, 'update']) 
            ->name('admin.dosen.update');
    });

    /*
    |--------------------------------------------------------------------------
    | VISI MISI
    |--------------------------------------------------------------------------
    */
    Route::middleware(['menu.permission:visimisi'])->group(function () {
        Route::get('/visimisi', [VisiMisiController::class, 'index'])
            ->name('admin.visimisi');

        Route::post('/visimisi', [VisiMisiController::class, 'store']);

        Route::get('/visimisi/edit', [VisiMisiController::class, 'edit'])
            ->name('admin.visimisi.edit');

        Route::post('/visimisi/update', [VisiMisiController::class, 'update'])
            ->name('admin.visimisi.update');
    });

    /*
    |--------------------------------------------------------------------------
    | LAYANAN
    |--------------------------------------------------------------------------
    */
    Route::middleware(['menu.permission:layanan'])->group(function () {
        Route::get('/layanan', [LayananController::class, 'index'])
            ->name('admin.layanan');
        
        Route::post('/layanan', [LayananController::class, 'store']);

        Route::delete('/layanan/{layanan}', [LayananController::class, 'destroy']);

        Route::get('/layanan/edit/{id}', [LayananController::class, 'edit'])
            ->name('admin.layanan.edit');

        Route::post('/layanan/update/{id}', [LayananController::class, 'update'])
            ->name('admin.layanan.update');
    });

    /*
    |--------------------------------------------------------------------------
    | SETTING WEBSITE
    |--------------------------------------------------------------------------
    */
    Route::middleware(['menu.permission:setting'])->group(function () {
        Route::get('/setting', [SettingController::class, 'edit'])
            ->name('setting.edit');

        Route::put('/setting/update', [SettingController::class, 'update'])
            ->name('setting.update');
    });

    /*
    |--------------------------------------------------------------------------
    | ALUMNI SECTION
    |--------------------------------------------------------------------------
    */
    Route::middleware(['menu.permission:alumni'])->group(function () {
        Route::get('/alumni-section', [AlumniSectionController::class, 'index'])
            ->name('alumni_section.index');

        Route::post('/alumni-section', [AlumniSectionController::class, 'store'])
            ->name('alumni_section.store');

        Route::get('/alumni-section/{id}/edit', [AlumniSectionController::class, 'edit'])
            ->name('alumni_section.edit');

        Route::put('/alumni-section/{id}', [AlumniSectionController::class, 'update'])
            ->name('alumni_section.update');

        Route::delete('/alumni-section/{id}', [AlumniSectionController::class, 'destroy'])
            ->name('alumni_section.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | AKREDITASI
    |--------------------------------------------------------------------------
    */
    Route::middleware(['menu.permission:akreditasi'])->group(function () {
        Route::get('/akreditasi', [AkreditasiController::class, 'index'])
            ->name('akreditasi.index');

        Route::post('/akreditasi', [AkreditasiController::class, 'store'])
            ->name('akreditasi.store');

        Route::get('/akreditasi/edit/{id}', [AkreditasiController::class, 'edit'])
            ->name('akreditasi.edit');

        Route::put('/akreditasi/{id}', [AkreditasiController::class, 'update'])
            ->name('akreditasi.update');

        Route::delete('/akreditasi/{id}', [AkreditasiController::class, 'destroy'])
            ->name('akreditasi.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | PROGRAM STUDI, FASILITAS, FAQ & DOKUMEN PRODI
    |--------------------------------------------------------------------------
    */
    Route::middleware(['menu.permission:program_studi'])->group(function () {
        Route::resource('program-studi', ProgramStudiController::class);

        Route::get(
            '/program-studi/{id}/profil-lulusan',
            [ProgramStudiController::class,'profilIndex']
        )->name('profil.index');

        Route::get(
            '/program-studi/{id}/fasilitas',
            [ProgramStudiController::class,'fasilitasIndex']
        )->name('fasilitas.index');

        Route::get(
            '/program-studi/{id}/faq',
            [ProgramStudiController::class,'faqIndex']
        )->name('faq.index');

        Route::post('/fasilitas/store', [FasilitasProdiController::class,'store'])->name('fasilitas.store');
        Route::post('/fasilitas/update/{id}', [FasilitasProdiController::class,'update'])->name('fasilitas.update');
        Route::delete('/fasilitas/delete/{id}', [FasilitasProdiController::class,'destroy'])->name('fasilitas.destroy');

        Route::post('/faq/store', [FaqProdiController::class,'store'])->name('faq.store');
        Route::post('/faq/update/{id}', [FaqProdiController::class,'update'])->name('faq.update');
        Route::delete('/faq/delete/{id}', [FaqProdiController::class,'destroy'])->name('faq.destroy');

        Route::get(
            '/program-studi/{program_studi_id}/dokumen',
            [ProdiDokumenController::class, 'index']
        )->name('program-studi.dokumen.index');

        Route::post(
            '/program-studi/{program_studi_id}/dokumen',
            [ProdiDokumenController::class, 'store']
        )->name('program-studi.dokumen.store');

        Route::put(
            '/program-studi/dokumen/{id}',
            [ProdiDokumenController::class, 'update']
        )->name('program-studi.dokumen.update');

        Route::delete(
            '/program-studi/dokumen/{id}',
            [ProdiDokumenController::class, 'destroy']
        )->name('program-studi.dokumen.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | PROFIL LULUSAN
    |--------------------------------------------------------------------------
    */
    Route::middleware(['menu.permission:profil_lulusan'])->group(function () {
        Route::resource('profil-lulusan', ProfilLulusanController::class);
        Route::post('/profil/store', [ProfilLulusanController::class,'store'])->name('profil.store');
        Route::post('/profil/update/{id}', [ProfilLulusanController::class,'update'])->name('profil.update');
        Route::delete('/profil/delete/{id}', [ProfilLulusanController::class,'destroy'])->name('profil.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | PMB
    |--------------------------------------------------------------------------
    */
    Route::middleware(['menu.permission:pmb'])->group(function () {
        Route::get('/pmb', [PMBController::class,'index'])->name('pmb.index');
        Route::post('/pmb/store', [PMBController::class,'store'])->name('pmb.store');
    });

    /*
    |--------------------------------------------------------------------------
    | PPM & LPPM
    |--------------------------------------------------------------------------
    */
    Route::middleware(['menu.permission:ppm'])->group(function () {
        Route::get('/ppm', [PPMController::class, 'admin'])->name('admin.ppm');
        Route::post('/ppm/store', [PPMController::class, 'store'])->name('ppm.store');
        Route::post('/ppm/dokumen', [PPMController::class, 'storeDokumen'])->name('admin.ppm.dokumen.store');
        Route::post('/ppm/dokumen/{id}', [PPMController::class, 'updateDokumen'])->name('admin.ppm.dokumen.update');
        Route::delete('/ppm/dokumen/{id}', [PPMController::class, 'destroyDokumen'])->name('admin.ppm.dokumen.destroy');
    });

    Route::middleware(['menu.permission:lppm'])->group(function () {
        Route::get('/lppm', [LPPMController::class, 'admin'])->name('admin.lppm');
        Route::post('/lppm/store', [LPPMController::class, 'store'])->name('lppm.store');
        Route::post('/lppm/portal', [LPPMController::class, 'storePortal'])->name('admin.lppm.portal.store');
        Route::post('/lppm/portal/{id}', [LPPMController::class, 'updatePortal'])->name('admin.lppm.portal.update');
        Route::delete('/lppm/portal/{id}', [LPPMController::class, 'destroyPortal'])->name('admin.lppm.portal.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | MASTER KATEGORI
    |--------------------------------------------------------------------------
    */
    Route::middleware(['menu.permission:kategori'])->group(function () {
        Route::get('/kategori', [KategoriController::class, 'index'])->name('admin.kategori.index');
        Route::post('/kategori', [KategoriController::class, 'store'])->name('admin.kategori.store');
        Route::post('/kategori/{id}', [KategoriController::class, 'update'])->name('admin.kategori.update');
        Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | LAYANAN PPKS
    |--------------------------------------------------------------------------
    */
    Route::middleware(['menu.permission:ppks'])->group(function () {
        Route::get('/ppks', [PPKSController::class, 'adminIndex'])->name('admin.ppks.index');
        Route::get('/ppks/{id}', [PPKSController::class, 'adminShow'])->name('admin.ppks.show');
        Route::post('/ppks/{id}/status', [PPKSController::class, 'updateStatus'])->name('admin.ppks.status');
        Route::delete('/ppks/{id}', [PPKSController::class, 'adminDestroy'])->name('admin.ppks.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | KRITIK & SARAN
    |--------------------------------------------------------------------------
    */
    Route::middleware(['menu.permission:kritiksaran'])->group(function () {
        Route::get('/kritiksaran', [KritikSaranController::class, 'index'])->name('kritiksaran.index');
        Route::delete('/kritik-saran/{id}', [KritikSaranController::class, 'destroy'])->name('kritiksaran.destroy');
    });

});
/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';