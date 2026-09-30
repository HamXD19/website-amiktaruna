<?php

namespace App\Http\Controllers;

use App\Models\HalamanKustom;
use App\Models\Setting;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class HalamanKustomController extends Controller
{
    /**
     * Tampilan Publik untuk Halaman Kustom
     */
    public function showPublic($slug)
    {
        $halaman = HalamanKustom::where('slug', $slug)->first();

        if (!$halaman) {
            abort(404, 'Halaman yang Anda tuju tidak ditemukan.');
        }

        if (!$halaman->aktif && !auth()->check()) {
            abort(404, 'Halaman ini sedang dalam status draft atau dinonaktifkan.');
        }

        $setting = Setting::first();

        // Kategori label pemetaan
        $categoryLabels = [
            'profil' => 'Profil Kampus',
            'akademik' => 'Akademik',
            'riset' => 'Riset & Lembaga',
            'informasi' => 'Informasi Publik',
        ];
        $parentLabel = $categoryLabels[$halaman->kategori] ?? 'Informasi';

        // Halaman terkait lainnya dalam kategori yang sama
        $relatedPages = HalamanKustom::where('kategori', $halaman->kategori)
            ->where('id', '!=', $halaman->id)
            ->where('aktif', true)
            ->orderBy('urutan')
            ->take(5)
            ->get();

        return view('halaman.show', compact('halaman', 'setting', 'parentLabel', 'relatedPages'));
    }

    /**
     * Simpan Halaman Kustom Baru dari Admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'slug'      => 'nullable|string|max:255',
            'kategori'  => 'required|string|in:profil,akademik,riset,informasi',
            'ringkasan' => 'nullable|string|max:1000',
            'konten'    => 'nullable|string',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'urutan'    => 'nullable|integer',
        ], [
            'judul.required' => 'Nama sub-menu / judul halaman wajib diisi.',
            'kategori.required' => 'Pilih penempatan menu dropdown target.',
            'gambar.image' => 'File cover harus berupa gambar (JPG, JPEG, PNG, WEBP).',
            'gambar.max' => 'Ukuran gambar cover maksimal 10MB.',
        ]);

        $slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->judul);
        if (empty($slug)) {
            $slug = 'halaman-' . time();
        }

        // Pastikan slug unik
        $baseSlug = $slug;
        $counter = 1;
        while (HalamanKustom::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $namaGambar = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaGambar = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/halaman'), $namaGambar);
            $namaGambar = 'halaman/' . $namaGambar;
        }

        $halaman = HalamanKustom::create([
            'judul'     => $request->judul,
            'slug'      => $slug,
            'kategori'  => $request->kategori,
            'ringkasan' => $request->ringkasan,
            'gambar'    => $namaGambar,
            'konten'    => $request->konten,
            'aktif'     => $request->has('aktif') ? (bool) $request->aktif : true,
            'urutan'    => $request->urutan ?: 0,
        ]);

        // Otomatis masukkan ke navigasi navbar jika dipilih
        if ($request->boolean('tambah_ke_navbar', true)) {
            $this->attachToNavbar($halaman);
        }

        ActivityLogger::log('CREATE', 'Halaman Kustom', "Menambahkan sub-menu dan halaman baru: {$halaman->judul}");

        return redirect()->to(url('/admin/setting/edit#tab-navmenu'))
            ->with('success', "Sub-menu & halaman '{$halaman->judul}' berhasil dibuat dan terpasang di navigasi!");
    }

    /**
     * Update Halaman Kustom
     */
    public function update(Request $request, $id)
    {
        $halaman = HalamanKustom::findOrFail($id);

        $request->validate([
            'judul'     => 'required|string|max:255',
            'slug'      => 'nullable|string|max:255',
            'kategori'  => 'required|string|in:profil,akademik,riset,informasi',
            'ringkasan' => 'nullable|string|max:1000',
            'konten'    => 'nullable|string',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'urutan'    => 'nullable|integer',
        ]);

        $oldSlug = $halaman->slug;
        $slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->judul);
        if (empty($slug)) {
            $slug = 'halaman-' . time();
        }

        $baseSlug = $slug;
        $counter = 1;
        while (HalamanKustom::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $namaGambar = $halaman->gambar;
        if ($request->hasFile('gambar')) {
            // Hapus file lama jika ada
            if ($namaGambar && !str_starts_with($namaGambar, 'http') && File::exists(public_path('uploads/' . $namaGambar))) {
                File::delete(public_path('uploads/' . $namaGambar));
            }

            $file = $request->file('gambar');
            $uploadedName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/halaman'), $uploadedName);
            $namaGambar = 'halaman/' . $uploadedName;
        } elseif ($request->boolean('hapus_gambar')) {
            if ($namaGambar && !str_starts_with($namaGambar, 'http') && File::exists(public_path('uploads/' . $namaGambar))) {
                File::delete(public_path('uploads/' . $namaGambar));
            }
            $namaGambar = null;
        }

        $halaman->update([
            'judul'     => $request->judul,
            'slug'      => $slug,
            'kategori'  => $request->kategori,
            'ringkasan' => $request->ringkasan,
            'gambar'    => $namaGambar,
            'konten'    => $request->konten,
            'aktif'     => $request->has('aktif') ? (bool) $request->aktif : false,
            'urutan'    => $request->urutan ?: 0,
        ]);

        // Sinkronkan perubahan judul / slug / kategori di navbar
        $this->syncNavbarItem($halaman, $oldSlug);

        ActivityLogger::log('UPDATE', 'Halaman Kustom', "Memperbarui isi halaman kustom: {$halaman->judul}");

        return redirect()->to(url('/admin/setting/edit#tab-navmenu'))
            ->with('success', "Isi halaman '{$halaman->judul}' berhasil diperbarui!");
    }

    /**
     * Hapus Halaman Kustom & hapus tautannya dari Navbar
     */
    public function destroy($id)
    {
        $halaman = HalamanKustom::findOrFail($id);
        $judul = $halaman->judul;
        $slug = $halaman->slug;

        $halaman->delete();

        // Hapus tautan /halaman/{slug} dari navigasi navbar
        $this->removeFromNavbar($slug);

        ActivityLogger::log('DELETE', 'Halaman Kustom', "Menghapus halaman kustom & sub-menu: {$judul}");

        return redirect()->to(url('/admin/setting/edit#tab-navmenu'))
            ->with('success', "Halaman '{$judul}' dan tautan sub-menu berhasil dihapus.");
    }

    /**
     * Helper: Tambahkan sub-menu ke navbar Setting
     */
    private function attachToNavbar(HalamanKustom $halaman)
    {
        $setting = Setting::first();
        if (!$setting) return;

        $navMenus = $setting->nav_menus ?? SettingController::getDefaultNavMenus();
        $targetUrl = "/halaman/{$halaman->slug}";

        if (!isset($navMenus['groups']) || !is_array($navMenus['groups'])) {
            $navMenus = SettingController::getDefaultNavMenus();
        }

        // Cari grup yang cocok
        $found = false;
        foreach ($navMenus['groups'] as &$group) {
            if (($group['id'] ?? '') === $halaman->kategori) {
                if (!isset($group['items']) || !is_array($group['items'])) {
                    $group['items'] = [];
                }

                // Cek apakah sudah ada
                $alreadyExists = false;
                foreach ($group['items'] as $item) {
                    if (($item['href'] ?? '') === $targetUrl) {
                        $alreadyExists = true;
                        break;
                    }
                }

                if (!$alreadyExists) {
                    $group['items'][] = [
                        'label'  => $halaman->judul,
                        'href'   => $targetUrl,
                        'desc'   => $halaman->ringkasan ?: 'Halaman informasi resmi kampus',
                        'icon'   => 'fas fa-file-lines',
                        'target' => '_self',
                    ];
                }
                $found = true;
                break;
            }
        }

        $setting->nav_menus = $navMenus;
        $setting->save();
    }

    /**
     * Helper: Sinkronkan item navbar jika slug/label/kategori berubah
     */
    private function syncNavbarItem(HalamanKustom $halaman, string $oldSlug)
    {
        $setting = Setting::first();
        if (!$setting || !isset($setting->nav_menus['groups'])) return;

        $navMenus = $setting->nav_menus;
        $oldUrl = "/halaman/{$oldSlug}";
        $newUrl = "/halaman/{$halaman->slug}";

        // Cari di grup lama atau pindahkan ke grup baru
        $itemFound = null;

        foreach ($navMenus['groups'] as &$group) {
            if (isset($group['items']) && is_array($group['items'])) {
                foreach ($group['items'] as $idx => $it) {
                    if (($it['href'] ?? '') === $oldUrl || ($it['href'] ?? '') === $newUrl) {
                        $itemFound = $it;
                        // Jika grup berbeda dengan kategori baru, hapus dari grup lama
                        if (($group['id'] ?? '') !== $halaman->kategori) {
                            array_splice($group['items'], $idx, 1);
                        } else {
                            // Update data di grup yang sama
                            $group['items'][$idx]['label'] = $halaman->judul;
                            $group['items'][$idx]['href'] = $newUrl;
                            $group['items'][$idx]['desc'] = $halaman->ringkasan ?: 'Halaman informasi resmi kampus';
                        }
                        break;
                    }
                }
            }
        }

        // Jika dipindahkan ke grup lain, masukkan ke grup baru
        if ($itemFound) {
            foreach ($navMenus['groups'] as &$group) {
                if (($group['id'] ?? '') === $halaman->kategori) {
                    $existsInTarget = false;
                    foreach ($group['items'] ?? [] as $it) {
                        if (($it['href'] ?? '') === $newUrl) {
                            $existsInTarget = true;
                            break;
                        }
                    }
                    if (!$existsInTarget) {
                        $group['items'][] = [
                            'label'  => $halaman->judul,
                            'href'   => $newUrl,
                            'desc'   => $halaman->ringkasan ?: 'Halaman informasi resmi kampus',
                            'icon'   => 'fas fa-file-lines',
                            'target' => '_self',
                        ];
                    }
                    break;
                }
            }
        }

        $setting->nav_menus = $navMenus;
        $setting->save();
    }

    /**
     * Helper: Hapus item dari navbar
     */
    private function removeFromNavbar(string $slug)
    {
        $setting = Setting::first();
        if (!$setting || !isset($setting->nav_menus['groups'])) return;

        $navMenus = $setting->nav_menus;
        $targetUrl = "/halaman/{$slug}";

        foreach ($navMenus['groups'] as &$group) {
            if (isset($group['items']) && is_array($group['items'])) {
                $group['items'] = array_values(array_filter($group['items'], function ($item) use ($targetUrl) {
                    return ($item['href'] ?? '') !== $targetUrl;
                }));
            }
        }

        $setting->nav_menus = $navMenus;
        $setting->save();
    }
}
