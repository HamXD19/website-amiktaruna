<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Dosen;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public static function getDefaultNavMenus()
    {
        return [
            'beranda' => ['label' => 'Beranda', 'href' => '/'],
            'groups' => [
                [
                    'id' => 'profil',
                    'label' => 'Profil',
                    'icon' => 'fas fa-university',
                    'items' => [
                        ['label' => 'Tentang AMIK Taruna', 'href' => '/tentang', 'desc' => 'Sejarah, legalitas, dan komitmen mutu', 'icon' => 'fas fa-info-circle', 'target' => '_self'],
                        ['label' => 'Visi & Misi', 'href' => '/tentang#visi-misi', 'desc' => 'Arah haluan dan target capaian kampus', 'icon' => 'fas fa-bullseye', 'target' => '_self'],
                        ['label' => 'Pimpinan & Dosen', 'href' => '/tentang#struktur', 'desc' => 'Tenaga pendidik profesional dan pimpinan', 'icon' => 'fas fa-chalkboard-teacher', 'target' => '_self'],
                        ['label' => 'Akreditasi Kampus', 'href' => '/tentang#akreditasi', 'desc' => 'Status akreditasi resmi institusi', 'icon' => 'fas fa-award', 'target' => '_self'],
                        ['label' => 'Dokumen Kampus', 'href' => '/dokumen-kampus', 'desc' => 'Statuta, renstra, dan regulasi resmi institusi', 'icon' => 'fas fa-file-contract', 'target' => '_self'],
                    ]
                ],
                [
                    'id' => 'akademik',
                    'label' => 'Akademik',
                    'icon' => 'fas fa-graduation-cap',
                    'items' => [
                        ['label' => 'Program Studi', 'href' => '/akademik', 'desc' => 'Pilihan prodi vokasi teknologi informasi', 'icon' => 'fas fa-laptop-code', 'target' => '_self'],
                        ['label' => 'Layanan Mahasiswa', 'href' => '/mahasiswa', 'desc' => 'Fasilitas dan administrasi sivitas', 'icon' => 'fas fa-user-graduate', 'target' => '_self'],
                        ['label' => 'Tracer Study Alumni', 'href' => '/alumni', 'desc' => 'Jaringan dan rekam jejak lulusan', 'icon' => 'fas fa-user-check', 'target' => '_self'],
                    ]
                ],
                [
                    'id' => 'riset',
                    'label' => 'Riset & Lembaga',
                    'icon' => 'fas fa-flask',
                    'items' => [
                        ['label' => 'LPPM', 'href' => '/lppm', 'desc' => 'Lembaga Penelitian & Pengabdian Masyarakat', 'icon' => 'fas fa-microscope', 'target' => '_self'],
                        ['label' => 'PPM', 'href' => '/ppm', 'desc' => 'Pusat Penjaminan Mutu Internal', 'icon' => 'fas fa-shield-alt', 'target' => '_self'],
                    ]
                ],
                [
                    'id' => 'informasi',
                    'label' => 'Informasi',
                    'icon' => 'fas fa-newspaper',
                    'items' => [
                        ['label' => 'Penerimaan Mahasiswa Baru (PMB)', 'href' => '/pmb', 'desc' => 'Informasi jalur seleksi & pendaftaran mahasiswa baru', 'icon' => 'fas fa-user-plus', 'target' => '_self'],
                        ['label' => 'Berita & Agenda', 'href' => '/berita', 'desc' => 'Kabar kegiatan dan pengumuman resmi', 'icon' => 'far fa-newspaper', 'target' => '_self'],
                        ['label' => 'Layanan PPKS (Kekerasan Seksual)', 'href' => '/ppks', 'desc' => 'Form pelaporan rahasia & warta edukasi PPKS', 'icon' => 'fas fa-shield-alt', 'target' => '_self'],
                        ['label' => 'Kritik & Saran', 'href' => '/kritik-saran', 'desc' => 'Kanal aspirasi perbaikan layanan', 'icon' => 'fas fa-comment-dots', 'target' => '_self'],
                    ]
                ]
            ]
        ];
    }

    public function edit()
    {
        $setting = Setting::first();
        if (!$setting->nav_menus) {
            $setting->nav_menus = self::getDefaultNavMenus();
            $setting->save();
        }
        $navMenus = $setting->nav_menus;
        $allDosen = Dosen::orderBy('level_organigram')->orderBy('nama')->get();
        $halamanList = \App\Models\HalamanKustom::orderBy('urutan')->orderByDesc('id')->get();
        return view('admin.setting.edit', compact('setting', 'allDosen', 'navMenus', 'halamanList'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first();

        $data = $request->all();

        // Handle nav_menus JSON parsing if passed as string or structured array
        if ($request->has('nav_menus')) {
            $navInput = $request->input('nav_menus');
            if (is_string($navInput)) {
                $decoded = json_decode($navInput, true);
                if (is_array($decoded)) {
                    $data['nav_menus'] = $decoded;
                }
            } elseif (is_array($navInput)) {
                $data['nav_menus'] = $navInput;
            }
        }

        if ($request->has('home_dosen_ids')) {
            $data['home_dosen_ids'] = array_values(array_filter($request->input('home_dosen_ids', [])));
        }

        /*
        |------------------------------------------
        | UPLOAD LOGO (HOSTING SAFE)
        |------------------------------------------
        */
        if ($request->hasFile('logo')) {

            $file = $request->file('logo');
            $namaFile = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $namaFile);

            $data['logo'] = $namaFile;
        }

        /*
        |------------------------------------------
        | HERO SLIDE 1
        |------------------------------------------
        */
        if ($request->hasFile('hero_slide_1')) {

            $file = $request->file('hero_slide_1');
            $namaFile = time().'_slide1_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $namaFile);

            $data['hero_slide_1'] = $namaFile;
        }

        /*
        |------------------------------------------
        | HERO SLIDE 2
        |------------------------------------------
        */
        if ($request->hasFile('hero_slide_2')) {

            $file = $request->file('hero_slide_2');
            $namaFile = time().'_slide2_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $namaFile);

            $data['hero_slide_2'] = $namaFile;
        }

        /*
        |------------------------------------------
        | HERO SLIDE 3
        |------------------------------------------
        */
        if ($request->hasFile('hero_slide_3')) {

            $file = $request->file('hero_slide_3');
            $namaFile = time().'_slide3_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $namaFile);

            $data['hero_slide_3'] = $namaFile;
        }

        if (isset($data['home_cta']['points_str'])) {
            $data['home_cta']['points'] = array_values(array_filter(array_map('trim', explode(';', $data['home_cta']['points_str']))));
        }

        $setting->update($data);

        ActivityLogger::log('UPDATE', 'Setting Website', 'Memperbarui konfigurasi identitas dan tampilan website');

        return back()->with('success', 'Pengaturan tampilan & konten website berhasil disimpan!');
    }
}