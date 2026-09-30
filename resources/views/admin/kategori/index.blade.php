@extends('layouts.app')

@section('title', 'Master Kategori & Jabatan')

@section('content')

<style>
    /* ========================================================
       MASTER KATEGORI & JABATAN MODERN ADMIN STYLING
    ======================================================== */
    .kat-stat-card {
        border-radius: 16px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 18px 20px;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        overflow: hidden;
    }
    .kat-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px -6px rgba(0, 0, 0, 0.08) !important;
        border-color: #cbd5e1;
    }
    .kat-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
    }

    /* Filter Tabs Scrollable */
    .kat-tabs-container {
        display: flex;
        gap: 6px;
        overflow-x: auto;
        padding-bottom: 4px;
        scrollbar-width: thin;
    }
    .kat-tabs-container::-webkit-scrollbar {
        height: 4px;
    }
    .kat-tabs-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .kat-tab-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.2s ease;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #475569;
    }
    .kat-tab-pill:hover {
        background: #f1f5f9;
        color: #0f172a;
        transform: translateY(-1px);
    }
    .kat-tab-pill.active {
        background: #059669 !important;
        color: #ffffff !important;
        border-color: #059669 !important;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25) !important;
    }
    .kat-tab-pill.active .badge-count {
        background: rgba(255, 255, 255, 0.25) !important;
        color: #ffffff !important;
    }
    .badge-count {
        background: #e2e8f0;
        color: #475569;
        padding: 2px 7px;
        border-radius: 12px;
        font-size: 0.72rem;
        font-weight: 700;
    }

    /* Form Inputs Focus */
    .form-control:focus, .form-select:focus {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15) !important;
    }

    /* Table Styling */
    .table-custom-header th {
        background: #f8fafc;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
        color: #475569;
        padding: 12px 14px;
        border-bottom: 2px solid #e2e8f0;
    }
    .table-custom-body td {
        padding: 14px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    .table-custom-body tr:hover td {
        background-color: #f8fafc;
    }

    /* PAGINATION FIX - PREVENT GIANT SVG ARROWS */
    .pagination {
        margin-bottom: 0;
        gap: 4px;
        align-items: center;
    }
    .pagination svg {
        width: 1rem !important;
        height: 1rem !important;
        max-width: 1rem !important;
        max-height: 1rem !important;
        display: inline-block;
        vertical-align: middle;
    }
    .pagination .page-item .page-link {
        border-radius: 8px !important;
        color: #334155;
        border: 1px solid #e2e8f0;
        font-size: 0.82rem;
        font-weight: 600;
        padding: 6px 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 34px;
        line-height: 1;
        box-shadow: none !important;
        transition: all 0.2s ease;
    }
    .pagination .page-item.active .page-link {
        background: #059669 !important;
        border-color: #059669 !important;
        color: #ffffff !important;
    }
    .pagination .page-item .page-link:hover {
        background: #f1f5f9;
        color: #059669;
    }
    .pagination .page-item.disabled .page-link {
        color: #94a3b8;
        background: #f8fafc;
        border-color: #e2e8f0;
    }
</style>

<div class="container-fluid p-0">

    <!-- Header Page -->
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-emerald-100 text-emerald-800 rounded-pill px-3 py-1 font-semibold small">
                    <i class="fas fa-layer-group me-1"></i>Master Data Kategori
                </span>
            </div>
            <h4 class="fw-bold text-slate-900 mb-1">🏷️ Master Kategori &amp; Jabatan</h4>
            <p class="text-slate-500 small mb-0">Pusat pengaturan kategori dan jabatan dinamis untuk Berita, Dokumen Kampus, PPM, LPPM, Prodi, dan Kepegawaian.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('berita.index') }}" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold">
                <i class="fas fa-newspaper me-1"></i>Kelola Berita
            </a>
            <a href="{{ route('admin.dokumen_kampus') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold">
                <i class="fas fa-file-contract me-1"></i>Dokumen Kampus
            </a>
            <a href="{{ route('admin.ppm') }}" class="btn btn-outline-warning btn-sm rounded-pill px-3 fw-bold text-dark">
                <i class="fas fa-shield-halved me-1"></i>Dokumen PPM
            </a>
            <a href="{{ route('admin.dosen') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3 fw-bold">
                <i class="fas fa-chalkboard-user me-1"></i>Data Dosen &amp; Sivitas
            </a>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-xs mb-4 d-flex align-items-center gap-2" role="alert">
            <i class="fas fa-circle-check fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-xs mb-4 d-flex align-items-center gap-2" role="alert">
            <i class="fas fa-circle-exclamation fs-5"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- STATS CARDS (8 Modul Terdistribusi Rapi) -->
    <div class="row row-cols-2 row-cols-md-4 g-3 mb-4">
        <!-- 1. Total Kategori -->
        <div class="col">
            <div class="kat-stat-card shadow-xs d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-slate-400 small fw-semibold d-block mb-1">Total Kategori</span>
                    <span class="h4 fw-bold text-slate-900 mb-0">{{ $stats['total'] }}</span>
                </div>
                <div class="kat-stat-icon" style="background-color: #f1f5f9; color: #334155;">
                    <i class="fas fa-tags"></i>
                </div>
            </div>
        </div>

        <!-- 2. Berita Kampus -->
        <div class="col">
            <div class="kat-stat-card shadow-xs d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-slate-400 small fw-semibold d-block mb-1">Berita Kampus</span>
                    <span class="h4 fw-bold mb-0" style="color: #059669;">{{ $stats['berita'] }}</span>
                </div>
                <div class="kat-stat-icon" style="background-color: #ecfdf5; color: #059669;">
                    <i class="fas fa-newspaper"></i>
                </div>
            </div>
        </div>

        <!-- 3. Berita PMB -->
        <div class="col">
            <div class="kat-stat-card shadow-xs d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-slate-400 small fw-semibold d-block mb-1">Berita PMB</span>
                    <span class="h4 fw-bold mb-0" style="color: #2563eb;">{{ $stats['pmb'] }}</span>
                </div>
                <div class="kat-stat-icon" style="background-color: #eff6ff; color: #2563eb;">
                    <i class="fas fa-bullhorn"></i>
                </div>
            </div>
        </div>

        <!-- 4. Dokumen Kampus -->
        <div class="col">
            <div class="kat-stat-card shadow-xs d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-slate-400 small fw-semibold d-block mb-1">Dokumen Kampus</span>
                    <span class="h4 fw-bold mb-0" style="color: #4f46e5;">{{ $stats['dokumen_kampus'] ?? 0 }}</span>
                </div>
                <div class="kat-stat-icon" style="background-color: #eef2ff; color: #4f46e5;">
                    <i class="fas fa-file-contract"></i>
                </div>
            </div>
        </div>

        <!-- 5. Dokumen Mutu (PPM) -->
        <div class="col">
            <div class="kat-stat-card shadow-xs d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-slate-400 small fw-semibold d-block mb-1">Dokumen Mutu PPM</span>
                    <span class="h4 fw-bold mb-0" style="color: #d97706;">{{ $stats['dokumen'] }}</span>
                </div>
                <div class="kat-stat-icon" style="background-color: #fffbeb; color: #d97706;">
                    <i class="fas fa-shield-halved"></i>
                </div>
            </div>
        </div>

        <!-- 6. Dokumen LPPM -->
        <div class="col">
            <div class="kat-stat-card shadow-xs d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-slate-400 small fw-semibold d-block mb-1">Dokumen LPPM</span>
                    <span class="h4 fw-bold mb-0" style="color: #0891b2;">{{ $stats['lppm_dokumen'] ?? 0 }}</span>
                </div>
                <div class="kat-stat-icon" style="background-color: #ecfeff; color: #0891b2;">
                    <i class="fas fa-flask"></i>
                </div>
            </div>
        </div>

        <!-- 7. Dokumen Prodi -->
        <div class="col">
            <div class="kat-stat-card shadow-xs d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-slate-400 small fw-semibold d-block mb-1">Dokumen Prodi</span>
                    <span class="h4 fw-bold mb-0" style="color: #7c3aed;">{{ $stats['prodi_dokumen'] }}</span>
                </div>
                <div class="kat-stat-icon" style="background-color: #f5f3ff; color: #7c3aed;">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
        </div>

        <!-- 8. Jabatan Dosen & Sivitas -->
        <div class="col">
            <div class="kat-stat-card shadow-xs d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-slate-400 small fw-semibold d-block mb-1">Jabatan Sivitas</span>
                    <span class="h4 fw-bold mb-0" style="color: #047857;">{{ $stats['jabatan'] ?? 0 }}</span>
                </div>
                <div class="kat-stat-icon" style="background-color: #ecfdf5; color: #047857;">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN SECTION: FORM + TABLE -->
    <div class="row g-4">

        <!-- KOLOM KIRI: FORM TAMBAH KATEGORI (col-lg-4 col-xl-4) -->
        <div class="col-lg-4 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h6 class="fw-bold text-slate-900 mb-0 d-flex align-items-center gap-2">
                        <i class="fas fa-plus-circle text-emerald-600"></i>
                        <span>Tambah Kategori / Jabatan Baru</span>
                    </h6>
                    <span class="text-slate-400 small">Formulir penambahan kategori multi-modul</span>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.kategori.store') }}">
                        @csrf

                        <!-- NAMA KATEGORI -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-slate-700">Nama Kategori / Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control rounded-3" placeholder="Contoh: Sekretaris Jurusan / Prestasi" required>
                        </div>

                        <!-- MODUL / FITUR -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-slate-700">Modul / Fitur Target <span class="text-danger">*</span></label>
                            <select name="modul" class="form-select rounded-3" required>
                                <option value="berita" {{ request('modul') == 'berita' ? 'selected' : '' }}>📰 Berita Kampus</option>
                                <option value="pmb" {{ request('modul') == 'pmb' ? 'selected' : '' }}>📢 Berita &amp; Informasi PMB</option>
                                <option value="dokumen_kampus" {{ request('modul') == 'dokumen_kampus' ? 'selected' : '' }}>📜 Dokumen Kampus (Statuta, SK, Renstra)</option>
                                <option value="dokumen" {{ request('modul') == 'dokumen' ? 'selected' : '' }}>🛡️ Dokumen Mutu (PPM / SPMI)</option>
                                <option value="lppm_dokumen" {{ request('modul') == 'lppm_dokumen' ? 'selected' : '' }}>🔬 Dokumen LPPM (Penelitian &amp; PkM)</option>
                                <option value="prodi_dokumen" {{ request('modul') == 'prodi_dokumen' ? 'selected' : '' }}>🎓 Dokumen Prodi (Profil, RPS, Kurikulum)</option>
                                <option value="layanan" {{ request('modul') == 'layanan' ? 'selected' : '' }}>💼 Layanan Akademik</option>
                                <option value="jabatan" {{ request('modul') == 'jabatan' ? 'selected' : '' }}>👔 Jabatan Dosen &amp; Sivitas</option>
                                <option value="umum" {{ request('modul') == 'umum' ? 'selected' : '' }}>🌐 Umum (Bisa Dipakai di Semua)</option>
                            </select>
                            <small class="text-slate-400 mt-1 d-block">Pilih modul tempat kategori ini akan muncul.</small>
                        </div>

                        <!-- SLUG / IDENTIFIER -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-slate-700">Slug / Kode (Opsional)</label>
                            <input type="text" name="slug" class="form-control rounded-3 font-monospace small" placeholder="Otomatis dibuat jika dikosongkan">
                            <small class="text-slate-400 mt-1 d-block">Gunakan huruf kecil, angka, dan tanda hubung (-).</small>
                        </div>

                        <div class="row g-2 mb-3">
                            <!-- WARNA BADGE -->
                            <div class="col-7">
                                <label class="form-label small fw-bold text-slate-700">Warna Aksen</label>
                                <select name="warna" class="form-select rounded-3">
                                    <option value="success" selected>🟢 Hijau (Success)</option>
                                    <option value="primary">🔵 Biru (Primary)</option>
                                    <option value="warning">🟡 Kuning (Warning)</option>
                                    <option value="danger">🔴 Merah (Danger)</option>
                                    <option value="info">🔷 Cyan (Info)</option>
                                    <option value="dark">⚫ Gelap (Dark)</option>
                                </select>
                            </div>

                            <!-- IKON / EMOJI -->
                            <div class="col-5">
                                <label class="form-label small fw-bold text-slate-700">Ikon / Emoji</label>
                                <input type="text" name="ikon" class="form-control rounded-3 text-center fs-6" value="📌" placeholder="Emoji / Ikon">
                            </div>
                        </div>

                        <!-- URUTAN -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-slate-700">Nomor Urutan Tampil</label>
                            <input type="number" name="urutan" class="form-control rounded-3" value="0" min="0">
                        </div>

                        <!-- KETERANGAN -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-slate-700">Keterangan / Deskripsi Singkat</label>
                            <textarea name="keterangan" rows="2" class="form-control rounded-3" placeholder="Deskripsi peruntukan kategori..."></textarea>
                        </div>

                        <!-- STATUS AKTIF -->
                        <div class="form-check form-switch mb-4 p-2 bg-light rounded-3 d-flex align-items-center justify-content-between">
                            <label class="form-check-label small fw-bold text-slate-700 ms-1 mb-0" for="isActiveSwitch">Aktifkan Kategori Ini</label>
                            <input class="form-check-input float-none ms-0 mb-0" type="checkbox" name="is_active" id="isActiveSwitch" value="1" checked style="cursor: pointer; width: 2.4em; height: 1.25em;">
                        </div>

                        <button type="submit" class="btn btn-success fw-bold w-100 rounded-pill py-2.5 shadow-xs" style="background: linear-gradient(135deg, #059669, #10b981); border: none;">
                            <i class="fas fa-plus me-1.5"></i>Simpan Kategori Baru
                        </button>
                    </form>
                </div>
            </div>

            <!-- BANTUAN ARSITEKTUR -->
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #ecfdf5, #f0fdf4); border: 1px solid #a7f3d0 !important;">
                <div class="card-body p-4 text-center">
                    <div class="w-12 h-12 rounded-circle bg-emerald-100 text-emerald-600 d-inline-flex align-items-center justify-content-center mb-2" style="width: 46px; height: 46px;">
                        <i class="fas fa-shield-halved fs-5"></i>
                    </div>
                    <h6 class="fw-bold text-slate-900 mb-1">Proteksi Integritas Data</h6>
                    <p class="text-slate-500 small mb-0">
                        Kategori yang sedang digunakan oleh Berita, Dokumen, PMB, atau Dosen diproteksi secara otomatis oleh sistem agar tidak terhapus secara tidak sengaja.
                    </p>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: DAFTAR KATEGORI & FILTER (col-lg-8 col-xl-8) -->
        <div class="col-lg-8 col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                <div class="card-body p-4">

                    <!-- FILTER MODUL TABS & SEARCH -->
                    <div class="mb-4">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                            <span class="fw-bold text-slate-800 small text-uppercase tracking-wider">
                                <i class="fas fa-filter text-emerald-600 me-1"></i>Filter Berdasarkan Modul:
                            </span>

                            <!-- SEARCH FORM -->
                            <form method="GET" action="{{ route('admin.kategori.index') }}" class="d-flex gap-2" style="min-width: 250px;">
                                <input type="hidden" name="modul" value="{{ request('modul', 'semua') }}">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control rounded-start-pill ps-3" placeholder="Cari nama / slug..." value="{{ request('search') }}">
                                    <button class="btn btn-outline-secondary rounded-end-pill px-3" type="submit" title="Cari">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                @if(request('search'))
                                    <a href="{{ route('admin.kategori.index', ['modul' => request('modul', 'semua')]) }}" class="btn btn-light btn-sm rounded-pill px-2.5 text-danger" title="Hapus Filter Pencarian">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </form>
                        </div>

                        <!-- SCROLLABLE TAB PILLS -->
                        @php $currentModul = request('modul', 'semua'); @endphp
                        <div class="kat-tabs-container">
                            <a href="{{ route('admin.kategori.index', ['modul' => 'semua', 'search' => request('search')]) }}" 
                               class="kat-tab-pill {{ $currentModul == 'semua' ? 'active' : '' }}">
                                <span>Semua</span>
                                <span class="badge-count">{{ $stats['total'] }}</span>
                            </a>
                            <a href="{{ route('admin.kategori.index', ['modul' => 'berita', 'search' => request('search')]) }}" 
                               class="kat-tab-pill {{ $currentModul == 'berita' ? 'active' : '' }}">
                                <span>Berita</span>
                                <span class="badge-count">{{ $stats['berita'] }}</span>
                            </a>
                            <a href="{{ route('admin.kategori.index', ['modul' => 'pmb', 'search' => request('search')]) }}" 
                               class="kat-tab-pill {{ $currentModul == 'pmb' ? 'active' : '' }}">
                                <span>PMB</span>
                                <span class="badge-count">{{ $stats['pmb'] }}</span>
                            </a>
                            <a href="{{ route('admin.kategori.index', ['modul' => 'dokumen_kampus', 'search' => request('search')]) }}" 
                               class="kat-tab-pill {{ $currentModul == 'dokumen_kampus' ? 'active' : '' }}">
                                <span>Dokumen Kampus</span>
                                <span class="badge-count">{{ $stats['dokumen_kampus'] ?? 0 }}</span>
                            </a>
                            <a href="{{ route('admin.kategori.index', ['modul' => 'dokumen', 'search' => request('search')]) }}" 
                               class="kat-tab-pill {{ $currentModul == 'dokumen' ? 'active' : '' }}">
                                <span>PPM (SPMI)</span>
                                <span class="badge-count">{{ $stats['dokumen'] }}</span>
                            </a>
                            <a href="{{ route('admin.kategori.index', ['modul' => 'lppm_dokumen', 'search' => request('search')]) }}" 
                               class="kat-tab-pill {{ $currentModul == 'lppm_dokumen' ? 'active' : '' }}">
                                <span>LPPM</span>
                                <span class="badge-count">{{ $stats['lppm_dokumen'] ?? 0 }}</span>
                            </a>
                            <a href="{{ route('admin.kategori.index', ['modul' => 'prodi_dokumen', 'search' => request('search')]) }}" 
                               class="kat-tab-pill {{ $currentModul == 'prodi_dokumen' ? 'active' : '' }}">
                                <span>Prodi</span>
                                <span class="badge-count">{{ $stats['prodi_dokumen'] }}</span>
                            </a>
                            <a href="{{ route('admin.kategori.index', ['modul' => 'jabatan', 'search' => request('search')]) }}" 
                               class="kat-tab-pill {{ $currentModul == 'jabatan' ? 'active' : '' }}">
                                <span>Jabatan</span>
                                <span class="badge-count">{{ $stats['jabatan'] ?? 0 }}</span>
                            </a>
                            <a href="{{ route('admin.kategori.index', ['modul' => 'layanan', 'search' => request('search')]) }}" 
                               class="kat-tab-pill {{ $currentModul == 'layanan' ? 'active' : '' }}">
                                <span>Layanan</span>
                                <span class="badge-count">{{ $stats['layanan'] }}</span>
                            </a>
                            <a href="{{ route('admin.kategori.index', ['modul' => 'umum', 'search' => request('search')]) }}" 
                               class="kat-tab-pill {{ $currentModul == 'umum' ? 'active' : '' }}">
                                <span>Umum</span>
                                <span class="badge-count">{{ $stats['umum'] }}</span>
                            </a>
                        </div>
                    </div>

                    <!-- TABEL KATEGORI -->
                    <div class="table-responsive rounded-3 border">
                        <table class="table align-middle mb-0">
                            <thead class="table-custom-header">
                                <tr>
                                    <th width="45" class="text-center">No</th>
                                    <th width="45" class="text-center">Ikon</th>
                                    <th>Kategori &amp; Keterangan</th>
                                    <th width="145">Modul</th>
                                    <th width="100" class="text-center">Terpakai</th>
                                    <th width="85" class="text-center">Status</th>
                                    <th width="95" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-custom-body">
                                @forelse($kategoris as $index => $kat)
                                @php
                                    $usageCount = $kat->total_used ?? 0;
                                @endphp
                                <tr>
                                    <!-- NO / URUTAN -->
                                    <td class="text-center fw-semibold text-slate-400 small">
                                        {{ $kat->urutan ?: ($kategoris->firstItem() + $index) }}
                                    </td>

                                    <!-- IKON -->
                                    <td class="text-center fs-5">
                                        {{ $kat->ikon ?: '📌' }}
                                    </td>

                                    <!-- NAMA & SLUG -->
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fw-bold text-slate-900">{{ $kat->nama }}</span>
                                            <span class="badge bg-{{ $kat->warna ?: 'secondary' }}-subtle text-{{ $kat->warna ?: 'secondary' }} border border-{{ $kat->warna ?: 'secondary' }}-subtle rounded-pill small py-0.5 px-2">
                                                {{ $kat->warna ?: 'default' }}
                                            </span>
                                        </div>
                                        <div class="text-slate-400 font-monospace small">
                                            slug: {{ $kat->slug }}
                                        </div>
                                        @if($kat->keterangan)
                                            <div class="text-slate-500 small text-truncate mt-0.5" style="max-width: 280px;" title="{{ $kat->keterangan }}">
                                                {{ $kat->keterangan }}
                                            </div>
                                        @endif
                                    </td>

                                    <!-- MODUL BADGE -->
                                    <td>
                                        @if($kat->modul == 'berita')
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle rounded-pill px-2.5 py-1">
                                                <i class="fas fa-newspaper me-1"></i>Berita
                                            </span>
                                        @elseif($kat->modul == 'pmb')
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle rounded-pill px-2.5 py-1">
                                                <i class="fas fa-bullhorn me-1"></i>PMB
                                            </span>
                                        @elseif($kat->modul == 'dokumen_kampus')
                                            <span class="badge rounded-pill px-2.5 py-1" style="background-color: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe;">
                                                <i class="fas fa-file-contract me-1"></i>Dok. Kampus
                                            </span>
                                        @elseif($kat->modul == 'dokumen')
                                            <span class="badge rounded-pill px-2.5 py-1" style="background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a;">
                                                <i class="fas fa-shield-halved me-1"></i>Dok. Mutu
                                            </span>
                                        @elseif($kat->modul == 'lppm_dokumen')
                                            <span class="badge rounded-pill px-2.5 py-1" style="background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">
                                                <i class="fas fa-flask me-1"></i>LPPM
                                            </span>
                                        @elseif($kat->modul == 'prodi_dokumen')
                                            <span class="badge rounded-pill px-2.5 py-1" style="background-color: #f3e8ff; color: #7e22ce; border: 1px solid #d8b4fe;">
                                                <i class="fas fa-graduation-cap me-1"></i>Prodi
                                            </span>
                                        @elseif($kat->modul == 'layanan')
                                            <span class="badge rounded-pill px-2.5 py-1" style="background-color: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0;">
                                                <i class="fas fa-user-graduate me-1"></i>Layanan
                                            </span>
                                        @elseif($kat->modul == 'jabatan')
                                            <span class="badge rounded-pill px-2.5 py-1" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #6ee7b7;">
                                                <i class="fas fa-user-tie me-1"></i>Jabatan
                                            </span>
                                        @else
                                            <span class="badge rounded-pill px-2.5 py-1" style="background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">
                                                Umum
                                            </span>
                                        @endif
                                    </td>

                                    <!-- JUMLAH PEMAKAIAN -->
                                    <td class="text-center">
                                        @if($usageCount > 0)
                                            <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-pill px-2.5 py-1 fw-bold" title="Digunakan oleh {{ $usageCount }} data aktif">
                                                <i class="fas fa-check-circle me-1 text-emerald-600"></i>{{ $usageCount }}
                                            </span>
                                        @else
                                            <span class="badge bg-light text-slate-400 border rounded-pill px-2.5 py-1" title="Belum ada data">
                                                0
                                            </span>
                                        @endif
                                    </td>

                                    <!-- STATUS -->
                                    <td class="text-center">
                                        @if($kat->is_active)
                                            <span class="badge bg-success rounded-pill px-2.5 py-1 small">
                                                <i class="fas fa-check me-0.5"></i> Aktif
                                            </span>
                                        @else
                                            <span class="badge bg-slate-300 text-slate-700 rounded-pill px-2 py-1 small">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <!-- AKSI -->
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1.5">
                                            <!-- EDIT BUTTON -->
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-warning rounded-pill px-2.5 py-1" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalEditKategori{{ $kat->id }}"
                                                    title="Edit Kategori">
                                                <i class="fas fa-pen-to-square"></i>
                                            </button>

                                            <!-- DELETE BUTTON DENGAN VALIDASI & POPUP ANIMATIF -->
                                            @if($usageCount > 0)
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-1" 
                                                        onclick="alertCantDelete('{{ addslashes($kat->nama) }}', {{ $usageCount }})"
                                                        title="Kategori ini tidak dapat dihapus karena masih digunakan">
                                                    <i class="fas fa-lock text-muted"></i>
                                                </button>
                                            @else
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-1" 
                                                        onclick="confirmDeleteKategori({{ $kat->id }}, '{{ addslashes($kat->nama) }}')"
                                                        title="Hapus Kategori">
                                                    <i class="fas fa-trash-can"></i>
                                                </button>
                                                <form id="deleteKategoriForm{{ $kat->id }}" method="POST" action="{{ route('admin.kategori.destroy', $kat->id) }}" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-folder-open d-block fa-3x mb-3 text-slate-300"></i>
                                        <h6 class="fw-bold text-slate-700">Belum ada kategori yang sesuai</h6>
                                        <p class="small text-slate-400 mb-0">Gunakan formulir di sebelah kiri untuk menambahkan kategori baru.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- PAGINATION (CLEAN BOOTSTRAP 5 CONTROLS, NO GIANT SVG) -->
                    @if($kategoris->hasPages())
                        <div class="mt-4 d-flex flex-wrap align-items-center justify-content-between gap-3 pt-3 border-top">
                            <div class="small text-slate-500">
                                Menampilkan <span class="fw-bold text-slate-800">{{ $kategoris->firstItem() ?? 0 }}</span> - <span class="fw-bold text-slate-800">{{ $kategoris->lastItem() ?? 0 }}</span> dari <span class="fw-bold text-slate-800">{{ $kategoris->total() }}</span> kategori
                            </div>
                            <div>
                                {{ $kategoris->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>

</div>

<!-- MODAL EDIT KATEGORI (DI LUAR TABEL) -->
@foreach($kategoris as $kat)
@php
    $modalUsageCount = $kat->total_used ?? 0;
@endphp
<div class="modal fade" id="modalEditKategori{{ $kat->id }}" tabindex="-1" aria-labelledby="modalEditKategoriLabel{{ $kat->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form method="POST" action="{{ route('admin.kategori.update', $kat->id) }}">
                @csrf

                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold text-slate-900" id="modalEditKategoriLabel{{ $kat->id }}">
                        <i class="fas fa-edit text-warning me-2"></i>Edit Kategori / Jabatan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold text-slate-700">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control rounded-3" value="{{ $kat->nama }}" required>
                        </div>

                        <div class="col-md-7">
                            <label class="form-label small fw-bold text-slate-700">Slug / Identifier <span class="text-danger">*</span></label>
                            <input type="text" name="slug" class="form-control rounded-3 font-monospace small" value="{{ $kat->slug }}" required>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label small fw-bold text-slate-700">Urutan Tampil</label>
                            <input type="number" name="urutan" class="form-control rounded-3" value="{{ $kat->urutan }}" min="0">
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-slate-700">Modul Target <span class="text-danger">*</span></label>
                            <select name="modul" class="form-select rounded-3" required>
                                <option value="berita" {{ $kat->modul == 'berita' ? 'selected' : '' }}>📰 Berita Kampus</option>
                                <option value="pmb" {{ $kat->modul == 'pmb' ? 'selected' : '' }}>📢 Berita &amp; Informasi PMB</option>
                                <option value="dokumen_kampus" {{ $kat->modul == 'dokumen_kampus' ? 'selected' : '' }}>📜 Dokumen Kampus (Statuta, SK, Renstra)</option>
                                <option value="dokumen" {{ $kat->modul == 'dokumen' ? 'selected' : '' }}>🛡️ Dokumen Mutu (PPM / SPMI)</option>
                                <option value="lppm_dokumen" {{ $kat->modul == 'lppm_dokumen' ? 'selected' : '' }}>🔬 Dokumen LPPM (Penelitian &amp; PkM)</option>
                                <option value="prodi_dokumen" {{ $kat->modul == 'prodi_dokumen' ? 'selected' : '' }}>🎓 Dokumen Prodi</option>
                                <option value="layanan" {{ $kat->modul == 'layanan' ? 'selected' : '' }}>💼 Layanan Akademik</option>
                                <option value="jabatan" {{ $kat->modul == 'jabatan' ? 'selected' : '' }}>👔 Jabatan Dosen &amp; Sivitas</option>
                                <option value="umum" {{ $kat->modul == 'umum' ? 'selected' : '' }}>🌐 Umum (Semua Modul)</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-slate-700">Warna Aksen</label>
                            <select name="warna" class="form-select rounded-3">
                                <option value="success" {{ $kat->warna == 'success' ? 'selected' : '' }}>🟢 Hijau (Success)</option>
                                <option value="primary" {{ $kat->warna == 'primary' ? 'selected' : '' }}>🔵 Biru (Primary)</option>
                                <option value="warning" {{ $kat->warna == 'warning' ? 'selected' : '' }}>🟡 Kuning (Warning)</option>
                                <option value="danger" {{ $kat->warna == 'danger' ? 'selected' : '' }}>🔴 Merah (Danger)</option>
                                <option value="info" {{ $kat->warna == 'info' ? 'selected' : '' }}>🔷 Cyan (Info)</option>
                                <option value="dark" {{ $kat->warna == 'dark' ? 'selected' : '' }}>⚫ Gelap (Dark)</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-slate-700">Ikon / Emoji</label>
                            <input type="text" name="ikon" class="form-control rounded-3 text-center fs-6" value="{{ $kat->ikon ?: '📌' }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-slate-700">Keterangan / Deskripsi Singkat</label>
                            <textarea name="keterangan" rows="2" class="form-control rounded-3">{{ $kat->keterangan }}</textarea>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch p-2 bg-light rounded-3 d-flex align-items-center justify-content-between">
                                <label class="form-check-label small fw-bold text-slate-700 ms-1 mb-0" for="editActiveSwitch{{ $kat->id }}">Status Kategori Aktif</label>
                                <input class="form-check-input float-none ms-0 mb-0" type="checkbox" name="is_active" id="editActiveSwitch{{ $kat->id }}" value="1" {{ $kat->is_active ? 'checked' : '' }} style="cursor: pointer; width: 2.4em; height: 1.25em;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex justify-content-between">
                    @if($modalUsageCount > 0)
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-3" onclick="alertCantDelete('{{ addslashes($kat->nama) }}', {{ $modalUsageCount }})">
                            <i class="fas fa-lock me-1"></i>Terkunci ({{ $modalUsageCount }} Data)
                        </button>
                    @else
                        <button type="button" class="btn btn-outline-danger rounded-pill px-3" onclick="confirmDeleteKategori({{ $kat->id }}, '{{ addslashes($kat->nama) }}')">
                            <i class="fas fa-trash-can me-1"></i>Hapus
                        </button>
                    @endif
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning fw-bold rounded-pill px-4 text-dark shadow-xs">
                            <i class="fas fa-save me-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
<script>
    // Popup animasi jika kategori masih digunakan
    function alertCantDelete(nama, count) {
        Swal.fire({
            icon: 'error',
            title: 'Tidak Dapat Dihapus!',
            html: `Kategori/Jabatan <strong>"${nama}"</strong> saat ini masih digunakan oleh <strong>${count}</strong> data/konten aktif.<br><br><span class="text-muted small">Untuk menghapus kategori ini, ubah atau hapus data terkait terlebih dahulu, atau nonaktifkan status kategori.</span>`,
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'Saya Mengerti',
            customClass: {
                popup: 'rounded-4 shadow-lg border-0',
                confirmButton: 'btn btn-danger rounded-pill px-4'
            },
            showClass: {
                popup: 'animate__animated animate__shakeX'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown animate__faster'
            }
        });
    }

    // Popup konfirmasi hapus animatif
    function confirmDeleteKategori(id, nama) {
        Swal.fire({
            title: 'Hapus Kategori?',
            html: `Apakah Anda yakin ingin menghapus kategori <strong>"${nama}"</strong>? Tindakan ini tidak dapat dibatalkan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fas fa-trash-can me-1"></i> Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-4 shadow-lg border-0',
                confirmButton: 'btn btn-danger rounded-pill px-4 me-2',
                cancelButton: 'btn btn-light rounded-pill px-4'
            },
            showClass: {
                popup: 'animate__animated animate__bounceIn'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById(`deleteKategoriForm${id}`);
                if (form) {
                    form.submit();
                }
            }
        });
    }
</script>
@endpush
