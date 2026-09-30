<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\BeritaPMB;
use App\Models\Dosen;
use App\Models\Kategori;
use App\Models\ProdiDokumen;
use App\Models\PPMDokumen;
use App\Models\LPPMDokumen;
use App\Models\DokumenKampus;
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

        // Pastikan kategori Dokumen Riset & Pengabdian LPPM tersedia
        if (Kategori::where('modul', 'lppm_dokumen')->count() === 0) {
            $lppmDefaults = [
                [
                    'nama' => 'Panduan Penelitian',
                    'slug' => 'panduan-penelitian',
                    'modul' => 'lppm_dokumen',
                    'warna' => 'primary',
                    'ikon' => '🔬',
                    'keterangan' => 'Buku panduan hibah riset dan penelitian dosen/mahasiswa',
                    'urutan' => 1,
                    'is_active' => true,
                ],
                [
                    'nama' => 'Pedoman Pengabdian',
                    'slug' => 'pedoman-pengabdian',
                    'modul' => 'lppm_dokumen',
                    'warna' => 'success',
                    'ikon' => '🤝',
                    'keterangan' => 'Pedoman pelaksanaan program pengabdian kepada masyarakat (PkM)',
                    'urutan' => 2,
                    'is_active' => true,
                ],
                [
                    'nama' => 'Template Proposal & Laporan',
                    'slug' => 'template-lppm',
                    'modul' => 'lppm_dokumen',
                    'warna' => 'warning',
                    'ikon' => '📋',
                    'keterangan' => 'Format template proposal dan laporan kemajuan/akhir riset',
                    'urutan' => 3,
                    'is_active' => true,
                ],
                [
                    'nama' => 'Publikasi & Jurnal Ilmiah',
                    'slug' => 'jurnal-lppm',
                    'modul' => 'lppm_dokumen',
                    'warna' => 'info',
                    'ikon' => '📚',
                    'keterangan' => 'Panduan penulisan jurnal, prosiding, dan luaran publikasi',
                    'urutan' => 4,
                    'is_active' => true,
                ],
            ];

            foreach ($lppmDefaults as $ld) {
                if (!Kategori::where('slug', $ld['slug'])->exists()) {
                    Kategori::create($ld);
                }
            }
        }

        // Pastikan kategori Dokumen Kampus (Statuta, Renstra, SK Direktur, Pedoman, Laporan Tahunan) tersedia
        if (Kategori::where('modul', 'dokumen_kampus')->count() === 0) {
            $kampusDefaults = [
                [
                    'nama' => 'Statuta & Renstra Kampus',
                    'slug' => 'statuta-renstra',
                    'modul' => 'dokumen_kampus',
                    'warna' => 'primary',
                    'ikon' => '📜',
                    'keterangan' => 'Statuta institusi, rencana strategis, dan rencana operasional kampus',
                    'urutan' => 1,
                    'is_active' => true,
                ],
                [
                    'nama' => 'SK & Kebijakan Direktur',
                    'slug' => 'sk-direktur',
                    'modul' => 'dokumen_kampus',
                    'warna' => 'danger',
                    'ikon' => '⚖️',
                    'keterangan' => 'Surat keputusan direktur dan ketetapan pimpinan perguruan tinggi',
                    'urutan' => 2,
                    'is_active' => true,
                ],
                [
                    'nama' => 'Pedoman & Standar Pelayanan',
                    'slug' => 'pedoman-standar',
                    'modul' => 'dokumen_kampus',
                    'warna' => 'warning',
                    'ikon' => '📋',
                    'keterangan' => 'Buku pedoman tata pamong, kode etik, dan standar pelayanan umum',
                    'urutan' => 3,
                    'is_active' => true,
                ],
                [
                    'nama' => 'Laporan Tahunan & Kinerja',
                    'slug' => 'laporan-tahunan',
                    'modul' => 'dokumen_kampus',
                    'warna' => 'success',
                    'ikon' => '📊',
                    'keterangan' => 'Laporan akuntabilitas tahunan dan capaian kinerja institusi',
                    'urutan' => 4,
                    'is_active' => true,
                ],
            ];

            foreach ($kampusDefaults as $kd) {
                if (!Kategori::where('slug', $kd['slug'])->exists()) {
                    Kategori::create($kd);
                }
            }
        }

        // Pastikan kategori Jabatan Dosen & Tendik tersedia
        static::seedJabatanDefaults();
    }

    public static function seedJabatanDefaults()
    {
        $jabatanDefaults = [
            ['nama' => 'Direktur AMIK Taruna', 'slug' => 'direktur-amik-taruna', 'modul' => 'jabatan', 'level_organigram' => 1, 'warna' => 'success', 'ikon' => '👔', 'keterangan' => 'Pimpinan Utama AMIK Taruna', 'urutan' => 1, 'is_active' => true],
            ['nama' => 'Wakil Direktur I Bidang Akademik', 'slug' => 'wakil-direktur-i', 'modul' => 'jabatan', 'level_organigram' => 2, 'warna' => 'primary', 'ikon' => '🎓', 'keterangan' => 'Pimpinan Bidang Kurikulum & Akademik', 'urutan' => 2, 'is_active' => true],
            ['nama' => 'Wakil Direktur II Bidang Administrasi & Keuangan', 'slug' => 'wakil-direktur-ii', 'modul' => 'jabatan', 'level_organigram' => 2, 'warna' => 'primary', 'ikon' => '💼', 'keterangan' => 'Pimpinan Bidang Keuangan & SDM', 'urutan' => 3, 'is_active' => true],
            ['nama' => 'Wakil Direktur III Bidang Kemahasiswaan & Alumni', 'slug' => 'wakil-direktur-iii', 'modul' => 'jabatan', 'level_organigram' => 2, 'warna' => 'primary', 'ikon' => '🤝', 'keterangan' => 'Pimpinan Bidang Kemahasiswaan & Kerjasama', 'urutan' => 4, 'is_active' => true],
            ['nama' => 'Ketua Lembaga Penelitian & Pengabdian Masyarakat', 'slug' => 'ketua-lppm', 'modul' => 'jabatan', 'level_organigram' => 3, 'warna' => 'info', 'ikon' => '🔬', 'keterangan' => 'Kepala LPPM Kampus', 'urutan' => 5, 'is_active' => true],
            ['nama' => 'Ketua Pusat Penjaminan Mutu', 'slug' => 'ketua-ppm', 'modul' => 'jabatan', 'level_organigram' => 3, 'warna' => 'warning', 'ikon' => '🛡️', 'keterangan' => 'Kepala Penjaminan Mutu Internal (PPM)', 'urutan' => 6, 'is_active' => true],
            ['nama' => 'Ketua UPT Perpustakaan & Kearsipan', 'slug' => 'ketua-perpustakaan', 'modul' => 'jabatan', 'level_organigram' => 3, 'warna' => 'info', 'ikon' => '📚', 'keterangan' => 'Kepala Unit Perpustakaan', 'urutan' => 7, 'is_active' => true],
            ['nama' => 'Ketua Unit Kerjasama & Pengembangan Institusi', 'slug' => 'ketua-kerjasama', 'modul' => 'jabatan', 'level_organigram' => 3, 'warna' => 'info', 'ikon' => '🌐', 'keterangan' => 'Kepala Hubungan Kerjasama Institusi', 'urutan' => 8, 'is_active' => true],
            ['nama' => 'Ketua Program Studi Teknologi Informasi', 'slug' => 'kaprodi-ti', 'modul' => 'jabatan', 'level_organigram' => 4, 'warna' => 'success', 'ikon' => '💻', 'keterangan' => 'Kaprodi D3 Teknologi Informasi', 'urutan' => 9, 'is_active' => true],
            ['nama' => 'Ketua Program Studi Sistem Informasi Akuntansi', 'slug' => 'kaprodi-sia', 'modul' => 'jabatan', 'level_organigram' => 4, 'warna' => 'success', 'ikon' => '📊', 'keterangan' => 'Kaprodi D3 Sistem Informasi Akuntansi', 'urutan' => 10, 'is_active' => true],
            ['nama' => 'Ketua Program Studi Sistem Informasi', 'slug' => 'kaprodi-si', 'modul' => 'jabatan', 'level_organigram' => 4, 'warna' => 'success', 'ikon' => '🖥️', 'keterangan' => 'Kaprodi D3 Sistem Informasi', 'urutan' => 11, 'is_active' => true],
            ['nama' => 'Kepala Bagian Administrasi Umum & Keuangan', 'slug' => 'kabag-keuangan', 'modul' => 'jabatan', 'level_organigram' => 5, 'warna' => 'secondary', 'ikon' => '🏢', 'keterangan' => 'Kabag Administrasi Umum & Keuangan', 'urutan' => 12, 'is_active' => true],
            ['nama' => 'Kepala Bagian Administrasi Akademik', 'slug' => 'kabag-akademik', 'modul' => 'jabatan', 'level_organigram' => 5, 'warna' => 'secondary', 'ikon' => '📋', 'keterangan' => 'Kabag Administrasi Akademik (BAAK)', 'urutan' => 13, 'is_active' => true],
            ['nama' => 'Staff Pusat Penjaminan Mutu', 'slug' => 'staf-ppm', 'modul' => 'jabatan', 'level_organigram' => 6, 'warna' => 'secondary', 'ikon' => '👤', 'keterangan' => 'Staf Pelaksana PPM', 'urutan' => 14, 'is_active' => true],
            ['nama' => 'Staf Administrasi Umum & Keuangan', 'slug' => 'staf-keuangan', 'modul' => 'jabatan', 'level_organigram' => 6, 'warna' => 'secondary', 'ikon' => '👤', 'keterangan' => 'Staf Keuangan & Umum', 'urutan' => 15, 'is_active' => true],
            ['nama' => 'Staf Administrasi Akademik', 'slug' => 'staf-akademik', 'modul' => 'jabatan', 'level_organigram' => 6, 'warna' => 'secondary', 'ikon' => '👤', 'keterangan' => 'Staf Akademik Kampus', 'urutan' => 16, 'is_active' => true],
            ['nama' => 'Staf SI, Humas & Layanan', 'slug' => 'staf-humas', 'modul' => 'jabatan', 'level_organigram' => 6, 'warna' => 'secondary', 'ikon' => '👤', 'keterangan' => 'Staf Humas & IT Layanan', 'urutan' => 17, 'is_active' => true],
            ['nama' => 'Staf Alumni & Pusat Karir', 'slug' => 'staf-alumni', 'modul' => 'jabatan', 'level_organigram' => 6, 'warna' => 'secondary', 'ikon' => '👤', 'keterangan' => 'Staf CDC & Alumni', 'urutan' => 18, 'is_active' => true],
            ['nama' => 'Staf Perpustakaan & Kearsipan', 'slug' => 'staf-perpustakaan', 'modul' => 'jabatan', 'level_organigram' => 6, 'warna' => 'secondary', 'ikon' => '👤', 'keterangan' => 'Staf Perpustakaan Kampus', 'urutan' => 19, 'is_active' => true],
            ['nama' => 'Dosen', 'slug' => 'dosen', 'modul' => 'jabatan', 'level_organigram' => 7, 'warna' => 'secondary', 'ikon' => '👨‍🏫', 'keterangan' => 'Dosen / Tenaga Pendidik', 'urutan' => 20, 'is_active' => true],
        ];

        foreach ($jabatanDefaults as $jd) {
            $existing = Kategori::where('slug', $jd['slug'])->where('modul', 'jabatan')->first();
            if (!$existing) {
                Kategori::create($jd);
            } elseif ($existing->level_organigram === null && isset($jd['level_organigram'])) {
                $existing->update(['level_organigram' => $jd['level_organigram']]);
            }
        }

        // Sinkronisasi otomatis level_organigram untuk jabatan lain berdasarkan pola nama jika masih null
        $levelMap = [
            'direktur' => 1,
            'wakil direktur' => 2,
            'wadir' => 2,
            'lembaga' => 3,
            'lppm' => 3,
            'ppm' => 3,
            'perpustakaan' => 3,
            'kerjasama' => 3,
            'kaprodi' => 4,
            'program studi' => 4,
            'kabag' => 5,
            'kepala bagian' => 5,
            'staff' => 6,
            'staf' => 6,
            'dosen' => 7,
        ];

        foreach (Kategori::where('modul', 'jabatan')->whereNull('level_organigram')->get() as $k) {
            $lower = strtolower($k->nama . ' ' . $k->slug);
            foreach ($levelMap as $key => $lvl) {
                if (str_contains($lower, $key)) {
                    $k->update(['level_organigram' => $lvl]);
                    break;
                }
            }
        }
    }

    public function index(Request $request)
    {
        $this->autoSeedDefaults();

        $query = Kategori::withCount(['beritas', 'prodiDokumens', 'ppmDokumens', 'lppmDokumens', 'dokumenKampuses', 'beritaPmbs'])->orderBy('urutan', 'asc')->latest();

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

        // Calculate accurate total_used count for each kategori
        $kategoris->getCollection()->transform(function ($kat) {
            $used = 0;
            if ($kat->modul === 'jabatan') {
                $used = Dosen::where('jabatan', 'LIKE', "%{$kat->nama}%")->count();
            } else {
                $used = ($kat->beritas_count ?? 0)
                      + ($kat->prodi_dokumens_count ?? 0)
                      + ($kat->ppm_dokumens_count ?? 0)
                      + ($kat->lppm_dokumens_count ?? 0)
                      + ($kat->dokumen_kampuses_count ?? 0)
                      + ($kat->berita_pmbs_count ?? 0);
            }
            $kat->total_used = $used;
            return $kat;
        });

        // Hitung statistik kategori
        $stats = [
            'total' => Kategori::count(),
            'berita' => Kategori::where('modul', 'berita')->count(),
            'pmb' => Kategori::where('modul', 'pmb')->count(),
            'dokumen' => Kategori::where('modul', 'dokumen')->count(),
            'dokumen_kampus' => Kategori::where('modul', 'dokumen_kampus')->count(),
            'lppm_dokumen' => Kategori::where('modul', 'lppm_dokumen')->count(),
            'prodi_dokumen' => Kategori::where('modul', 'prodi_dokumen')->count(),
            'layanan' => Kategori::where('modul', 'layanan')->count(),
            'jabatan' => Kategori::where('modul', 'jabatan')->count(),
            'umum' => Kategori::where('modul', 'umum')->count(),
        ];

        return view('admin.kategori.index', compact('kategoris', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'modul' => 'required|string|in:berita,pmb,dokumen,prodi_dokumen,layanan,umum,jabatan,lppm_dokumen,dokumen_kampus',
            'level_organigram' => 'nullable|integer|min:1|max:7',
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
            'level_organigram' => $request->filled('level_organigram') ? (int) $request->level_organigram : null,
            'warna' => $request->warna ?: 'success',
            'ikon' => $request->ikon ?: '📌',
            'keterangan' => $request->keterangan,
            'urutan' => $request->urutan ?: 0,
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : true,
        ]);

        return redirect()->route('admin.kategori.index', ['modul' => $request->modul])
            ->with('success', "Kategori '{$request->nama}' berhasil ditambahkan.");
    }

    public function storeAjax(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'level_organigram' => 'nullable|integer|min:1|max:7',
        ]);

        $nama = trim($request->nama);
        $slug = Str::slug($nama);

        $kategori = Kategori::where('nama', $nama)
            ->where('modul', 'jabatan')
            ->first();

        if (!$kategori) {
            $maxUrutan = Kategori::where('modul', 'jabatan')->max('urutan') ?? 20;
            $kategori = Kategori::create([
                'nama' => $nama,
                'slug' => $slug ?: 'jabatan-' . time(),
                'modul' => 'jabatan',
                'level_organigram' => $request->filled('level_organigram') ? (int) $request->level_organigram : 6,
                'warna' => 'primary',
                'ikon' => '👔',
                'keterangan' => 'Jabatan Dosen & Sivitas Akademika',
                'urutan' => $maxUrutan + 1,
                'is_active' => true,
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $kategori->id,
                'nama' => $kategori->nama,
                'slug' => $kategori->slug,
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'modul' => 'required|string|in:berita,pmb,dokumen,prodi_dokumen,layanan,umum,jabatan,lppm_dokumen,dokumen_kampus',
            'level_organigram' => 'nullable|integer|min:1|max:7',
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
            DokumenKampus::where('kategori', $oldSlug)->update(['kategori' => $newSlug]);
        }

        // Jika nama jabatan dosen berubah, update di data dosen
        if ($kategori->modul === 'jabatan' && $kategori->nama !== $request->nama) {
            $dosens = \App\Models\Dosen::where('jabatan', 'LIKE', "%{$kategori->nama}%")->get();
            foreach ($dosens as $d) {
                $parts = explode('|', $d->jabatan);
                $updatedParts = array_map(function($p) use ($kategori, $request) {
                    return trim($p) === trim($kategori->nama) ? trim($request->nama) : trim($p);
                }, $parts);
                $d->jabatan = implode('|', $updatedParts);
                $d->save();
            }
        }

        $kategori->update([
            'nama' => $request->nama,
            'slug' => $newSlug,
            'modul' => $request->modul,
            'level_organigram' => $request->filled('level_organigram') ? (int) $request->level_organigram : null,
            'warna' => $request->warna ?: 'success',
            'ikon' => $request->ikon ?: '📌',
            'keterangan' => $request->keterangan,
            'urutan' => $request->urutan ?: 0,
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : false,
        ]);

        return redirect()->route('admin.kategori.index', ['modul' => $request->modul])
            ->with('success', "Kategori '{$kategori->nama}' berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        // Cek apakah kategori digunakan oleh berita, dokumen, PMB, atau dosen
        $usedInBerita = Berita::where('kategori', $kategori->slug)->count();
        $usedInPMB = BeritaPMB::where('kategori', $kategori->slug)->count();
        $usedInProdiDok = ProdiDokumen::where('kategori', $kategori->slug)->count();
        $usedInPPMDok = PPMDokumen::where('kategori', $kategori->slug)->count();
        $usedInLPPMDok = LPPMDokumen::where('kategori', $kategori->slug)->count();
        $usedInDokumenKampus = DokumenKampus::where('kategori', $kategori->slug)->count();
        $usedInDosen = 0;
        if ($kategori->modul === 'jabatan') {
            $usedInDosen = Dosen::where('jabatan', 'LIKE', "%{$kategori->nama}%")->count();
        }

        $totalUsed = $usedInBerita + $usedInPMB + $usedInProdiDok + $usedInPPMDok + $usedInLPPMDok + $usedInDokumenKampus + $usedInDosen;

        if ($totalUsed > 0) {
            return redirect()->route('admin.kategori.index', ['modul' => $kategori->modul])
                ->with('error', "Kategori '{$kategori->nama}' tidak dapat dihapus karena masih digunakan oleh {$totalUsed} data/konten/dosen aktif. Silakan ubah atau hapus data terkait terlebih dahulu, atau nonaktifkan kategori ini.");
        }

        $nama = $kategori->nama;
        $modul = $kategori->modul;
        $kategori->delete();

        return redirect()->route('admin.kategori.index', ['modul' => $modul])
            ->with('success', "Kategori '{$nama}' berhasil dihapus.");
    }
}
