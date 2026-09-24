<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use App\Models\ProdiDokumen;
use App\Models\PPMDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    private function autoSeedDefaults()
    {
        if (Kategori::count() === 0) {
            $defaults = [
                [
                    'nama' => 'Pengumuman',
                    'slug' => 'pengumuman',
                    'modul' => 'berita',
                    'warna' => 'success',
                    'ikon' => '📢',
                    'keterangan' => 'Informasi dan pemberitahuan resmi kampus',
                    'urutan' => 1,
                    'is_active' => true,
                ],
                [
                    'nama' => 'Pengabdian',
                    'slug' => 'pengabdian',
                    'modul' => 'berita',
                    'warna' => 'primary',
                    'ikon' => '🤝',
                    'keterangan' => 'Kegiatan pengabdian kepada masyarakat',
                    'urutan' => 2,
                    'is_active' => true,
                ],
                [
                    'nama' => 'Penelitian',
                    'slug' => 'penelitian',
                    'modul' => 'berita',
                    'warna' => 'warning',
                    'ikon' => '🔬',
                    'keterangan' => 'Publikasi dan riset ilmiah kampus',
                    'urutan' => 3,
                    'is_active' => true,
                ],
                [
                    'nama' => 'Kegiatan Kampus',
                    'slug' => 'kegiatan_kampus',
                    'modul' => 'berita',
                    'warna' => 'danger',
                    'ikon' => '🎓',
                    'keterangan' => 'Aktivitas dan event kemahasiswaan kampus',
                    'urutan' => 4,
                    'is_active' => true,
                ],
                [
                    'nama' => 'Prestasi Mahasiswa',
                    'slug' => 'prestasi',
                    'modul' => 'berita',
                    'warna' => 'info',
                    'ikon' => '🏆',
                    'keterangan' => 'Penghargaan dan capaian prestasi sivitas akademika',
                    'urutan' => 5,
                    'is_active' => true,
                ],
                [
                    'nama' => 'PMB Reguler',
                    'slug' => 'pmb-reguler',
                    'modul' => 'pmb',
                    'warna' => 'info',
                    'ikon' => '📝',
                    'keterangan' => 'Informasi pendaftaran mahasiswa baru reguler',
                    'urutan' => 6,
                    'is_active' => true,
                ],
                [
                    'nama' => 'PMB Beasiswa',
                    'slug' => 'pmb-beasiswa',
                    'modul' => 'pmb',
                    'warna' => 'success',
                    'ikon' => '🌟',
                    'keterangan' => 'Informasi pendaftaran mahasiswa jalur beasiswa',
                    'urutan' => 7,
                    'is_active' => true,
                ],
                [
                    'nama' => 'Standar Mutu SPMI',
                    'slug' => 'spmi-mutu',
                    'modul' => 'dokumen',
                    'warna' => 'primary',
                    'ikon' => '📜',
                    'keterangan' => 'Dokumen standar mutu dan audit internal',
                    'urutan' => 8,
                    'is_active' => true,
                ],
                [
                    'nama' => 'Layanan Akademik',
                    'slug' => 'layanan-akademik',
                    'modul' => 'layanan',
                    'warna' => 'success',
                    'ikon' => '💻',
                    'keterangan' => 'Portal dan fasilitas akademik kampus',
                    'urutan' => 9,
                    'is_active' => true,
                ],
            ];

            foreach ($defaults as $d) {
                Kategori::create($d);
            }
        }

        // Pastikan kategori Dokumen Prodi (Profil Lulusan, Pedoman Akademik, Kurikulum, RPS) tersedia
        if (Kategori::where('modul', 'prodi_dokumen')->count() === 0) {
            $prodiDefaults = [
                [
                    'nama' => 'Profil Lulusan',
                    'slug' => 'profil-lulusan',
                    'modul' => 'prodi_dokumen',
                    'warna' => 'success',
                    'ikon' => '🎓',
                    'keterangan' => 'Dokumen profil kelulusan dan capaian kompetensi prodi',
                    'urutan' => 1,
                    'is_active' => true,
                ],
                [
                    'nama' => 'Pedoman Akademik',
                    'slug' => 'pedoman-akademik',
                    'modul' => 'prodi_dokumen',
                    'warna' => 'primary',
                    'ikon' => '📖',
                    'keterangan' => 'Buku pedoman dan panduan perkuliahan akademik program studi',
                    'urutan' => 2,
                    'is_active' => true,
                ],
                [
                    'nama' => 'Kurikulum',
                    'slug' => 'kurikulum',
                    'modul' => 'prodi_dokumen',
                    'warna' => 'warning',
                    'ikon' => '📚',
                    'keterangan' => 'Struktur sebaran mata kuliah dan silabus kurikulum',
                    'urutan' => 3,
                    'is_active' => true,
                ],
                [
                    'nama' => 'RPS',
                    'slug' => 'rps',
                    'modul' => 'prodi_dokumen',
                    'warna' => 'danger',
                    'ikon' => '📝',
                    'keterangan' => 'Rencana Pembelajaran Semester per mata kuliah prodi',
                    'urutan' => 4,
                    'is_active' => true,
                ],
            ];

            foreach ($prodiDefaults as $pd) {
                if (!Kategori::where('slug', $pd['slug'])->exists()) {
                    Kategori::create($pd);
                }
            }
        }
    }

    public function index(Request $request)
    {
        $this->autoSeedDefaults();

        $query = Kategori::withCount(['beritas', 'prodiDokumens'])->orderBy('urutan', 'asc')->latest();

        if ($request->filled('modul') && $request->modul !== 'semua') {
            $query->where('modul', $request->modul);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $kategoris = $query->paginate(15)->withQueryString();

        // Hitung statistik kategori
        $stats = [
            'total' => Kategori::count(),
            'berita' => Kategori::where('modul', 'berita')->count(),
            'pmb' => Kategori::where('modul', 'pmb')->count(),
            'dokumen' => Kategori::where('modul', 'dokumen')->count(),
            'prodi_dokumen' => Kategori::where('modul', 'prodi_dokumen')->count(),
            'layanan' => Kategori::where('modul', 'layanan')->count(),
            'umum' => Kategori::where('modul', 'umum')->count(),
        ];

        return view('admin.kategori.index', compact('kategoris', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'modul' => 'required|string|in:berita,pmb,dokumen,prodi_dokumen,layanan,umum',
            'slug' => 'nullable|string|max:100|unique:kategoris,slug',
            'warna' => 'nullable|string|max:30',
            'ikon' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer',
        ]);

        $slug = $request->filled('slug')
            ? Str::slug($request->slug)
            : Str::slug($request->nama);

        // Pastikan slug unik
        $originalSlug = $slug;
        $counter = 1;
        while (Kategori::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        Kategori::create([
            'nama' => $request->nama,
            'slug' => $slug,
            'modul' => $request->modul,
            'warna' => $request->warna ?: 'success',
            'ikon' => $request->ikon ?: '📌',
            'keterangan' => $request->keterangan,
            'urutan' => $request->urutan ?: 0,
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : true,
        ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', "Kategori '{$request->nama}' berhasil ditambahkan.");
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'modul' => 'required|string|in:berita,pmb,dokumen,prodi_dokumen,layanan,umum',
            'slug' => 'required|string|max:100|unique:kategoris,slug,'.$id,
            'warna' => 'nullable|string|max:30',
            'ikon' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer',
        ]);

        $oldSlug = $kategori->slug;
        $newSlug = Str::slug($request->slug);

        // Jika slug berubah, otomatis update relasi terkait
        if ($oldSlug !== $newSlug) {
            Berita::where('kategori', $oldSlug)->update(['kategori' => $newSlug]);
            ProdiDokumen::where('kategori', $oldSlug)->update(['kategori' => $newSlug]);
            PPMDokumen::where('kategori', $oldSlug)->update(['kategori' => $newSlug]);
        }

        $kategori->update([
            'nama' => $request->nama,
            'slug' => $newSlug,
            'modul' => $request->modul,
            'warna' => $request->warna ?: 'success',
            'ikon' => $request->ikon ?: '📌',
            'keterangan' => $request->keterangan,
            'urutan' => $request->urutan ?: 0,
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : false,
        ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', "Kategori '{$kategori->nama}' berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        // Cek apakah kategori digunakan oleh berita atau dokumen
        $usedInBerita = Berita::where('kategori', $kategori->slug)->count();
        $usedInProdiDok = ProdiDokumen::where('kategori', $kategori->slug)->count();
        $usedInPPMDok = PPMDokumen::where('kategori', $kategori->slug)->count();

        $totalUsed = $usedInBerita + $usedInProdiDok + $usedInPPMDok;

        if ($totalUsed > 0) {
            return redirect()->route('admin.kategori.index')
                ->with('error', "Kategori '{$kategori->nama}' tidak dapat dihapus karena masih digunakan oleh {$totalUsed} data/dokumen aktif. Silakan ubah kategori data tersebut terlebih dahulu atau nonaktifkan kategori ini.");
        }

        $nama = $kategori->nama;
        $kategori->delete();

        return redirect()->route('admin.kategori.index')
            ->with('success', "Kategori '{$nama}' berhasil dihapus.");
    }
}
