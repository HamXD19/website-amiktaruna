@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
    /* Welcome Banner */
    .dashboard-hero-banner {
        background: linear-gradient(135deg, #022c22 0%, #064e3b 50%, #065f46 100%);
        border: 1px solid rgba(16, 185, 129, 0.25);
        border-radius: 24px;
        padding: 28px 32px;
        color: #ffffff;
        box-shadow: 0 10px 25px -5px rgba(2, 44, 34, 0.3);
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }

    .dashboard-hero-banner::after {
        content: '';
        position: absolute;
        right: -30px;
        bottom: -40px;
        width: 220px;
        height: 220px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
        pointer-events: none;
    }

    /* Metric Cards */
    .metric-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 22px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        transition: all 0.25s ease;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .metric-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 22px -4px rgba(15, 23, 42, 0.08);
        border-color: #cbd5e1;
    }

    .metric-icon-box {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }

    /* Action Grid Card */
    .admin-module-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 20px 18px;
        text-decoration: none;
        color: inherit;
        display: block;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        height: 100%;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    }

    .admin-module-card:hover {
        transform: translateY(-4px);
        border-color: #10b981;
        box-shadow: 0 12px 24px -6px rgba(16, 185, 129, 0.15);
        color: inherit;
    }

    .admin-module-card .icon-wrap {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-bottom: 14px;
        transition: transform 0.25s ease;
    }

    .admin-module-card:hover .icon-wrap {
        transform: scale(1.1) rotate(4deg);
    }

    .admin-module-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .admin-module-desc {
        font-size: 0.76rem;
        color: #64748b;
        line-height: 1.45;
        margin-bottom: 0;
    }

    /* Section Subheaders */
    .section-subheader-badge {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        color: #047857;
        background: #d1fae5;
        padding: 4px 10px;
        border-radius: 6px;
        display: inline-block;
        margin-bottom: 6px;
    }

    /* Table styling */
    .dashboard-table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }
</style>

<div class="container-fluid p-0">

    {{-- 1. WELCOME HERO BANNER (KRAKSAAN WETAN STYLE) --}}
    <div class="dashboard-hero-banner">
        <div class="row align-items-center g-4 position-relative" style="z-index: 1;">
            <div class="col-lg-8">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                    <span class="badge px-3 py-1.5 rounded-pill text-white fw-bold" style="background: rgba(4, 120, 87, 0.7); border: 1px solid rgba(52, 211, 153, 0.35); font-size: 0.75rem;">
                        <i class="fas fa-sparkles text-warning me-1"></i>Selamat Datang
                    </span>
                    <span class="badge px-2.5 py-1 rounded-pill fw-bold" style="background: rgba(245, 158, 11, 0.2); color: #fcd34d; border: 1px solid rgba(245, 158, 11, 0.4); font-size: 0.72rem;">
                        <i class="fas fa-shield-alt me-1"></i>Administrator Sistem
                    </span>
                </div>
                <h2 class="fw-extrabold text-white mb-2" style="font-size: 1.85rem; letter-spacing: -0.5px;">
                    Ringkasan Sistem AMIK Taruna
                </h2>
                <p class="text-white-50 mb-0" style="font-size: 0.88rem; max-width: 680px; line-height: 1.6;">
                    Kelola seluruh konten, dosen, program studi, publikasi berita, dan standar mutu kampus secara terpadu dan terhubung langsung ke database MySQL.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('berita.create') }}" class="btn fw-bold px-3.5 py-2 rounded-3 shadow-sm d-inline-flex align-items-center gap-1.5" style="background: #f59e0b; color: #0f172a; font-size: 0.82rem;">
                        <i class="fas fa-pen-to-square"></i>
                        <span>Tulis Berita</span>
                    </a>
                    <a href="{{ route('admin.dosen') }}" class="btn btn-outline-light fw-bold px-3 py-2 rounded-3 d-inline-flex align-items-center gap-1.5" style="font-size: 0.82rem; background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.25);">
                        <i class="fas fa-chalkboard-user"></i>
                        <span>Kelola Dosen</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. METRIC STAT CARDS --}}
    <div class="row g-3 mb-4">
        <!-- Metric: Total Berita -->
        <div class="col-sm-6 col-xl-3">
            <div class="metric-card">
                <div>
                    <span class="text-uppercase fw-bold text-slate-400 small" style="font-size: 0.68rem; letter-spacing: 0.5px;">Total Berita</span>
                    <h3 class="fw-extrabold text-slate-900 mt-1 mb-1">{{ $counts['berita'] ?? 0 }}</h3>
                    <a href="{{ route('berita.index') }}" class="text-decoration-none fw-semibold small text-success" style="font-size: 0.74rem;">
                        Kelola Berita &rarr;
                    </a>
                </div>
                <div class="metric-icon-box" style="background: #ecfdf5; color: #059669;">
                    <i class="fas fa-newspaper"></i>
                </div>
            </div>
        </div>

        <!-- Metric: Total Dosen -->
        <div class="col-sm-6 col-xl-3">
            <div class="metric-card">
                <div>
                    <span class="text-uppercase fw-bold text-slate-400 small" style="font-size: 0.68rem; letter-spacing: 0.5px;">Dosen &amp; Pengajar</span>
                    <h3 class="fw-extrabold text-slate-900 mt-1 mb-1">{{ $counts['dosen'] ?? 0 }}</h3>
                    <a href="{{ route('admin.dosen') }}" class="text-decoration-none fw-semibold small text-primary" style="font-size: 0.74rem;">
                        Data Dosen &rarr;
                    </a>
                </div>
                <div class="metric-icon-box" style="background: #eff6ff; color: #2563eb;">
                    <i class="fas fa-chalkboard-user"></i>
                </div>
            </div>
        </div>

        <!-- Metric: Program Studi -->
        <div class="col-sm-6 col-xl-3">
            <div class="metric-card">
                <div>
                    <span class="text-uppercase fw-bold text-slate-400 small" style="font-size: 0.68rem; letter-spacing: 0.5px;">Program Studi</span>
                    <h3 class="fw-extrabold text-slate-900 mt-1 mb-1">{{ $counts['prodi'] ?? 0 }}</h3>
                    <a href="{{ route('program-studi.index') }}" class="text-decoration-none fw-semibold small text-purple" style="font-size: 0.74rem; color: #7c3aed;">
                        Program Studi &rarr;
                    </a>
                </div>
                <div class="metric-icon-box" style="background: #f5f3ff; color: #7c3aed;">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
        </div>

        <!-- Metric: Layanan Kampus -->
        <div class="col-sm-6 col-xl-3">
            <div class="metric-card">
                <div>
                    <span class="text-uppercase fw-bold text-slate-400 small" style="font-size: 0.68rem; letter-spacing: 0.5px;">Layanan Kampus</span>
                    <h3 class="fw-extrabold text-slate-900 mt-1 mb-1">{{ $counts['layanan'] ?? 0 }}</h3>
                    <a href="{{ route('admin.layanan') }}" class="text-decoration-none fw-semibold small text-amber-600" style="font-size: 0.74rem; color: #d97706;">
                        Kelola Layanan &rarr;
                    </a>
                </div>
                <div class="metric-icon-box" style="background: #fffbeb; color: #d97706;">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. QUICK ACCESS GRID (DIKELOMPOKKAN RAPI ALA KRAKSAAN WETAN) --}}
    <div class="row g-4 mb-5">
        
        <!-- KOLOM 1: KONTEN & PUBLIKASI -->
        <div class="col-lg-4">
            <div class="mb-3">
                <span class="section-subheader-badge">Publikasi &amp; Berita</span>
                <h5 class="fw-bold text-slate-900 mb-0" style="font-size: 1.05rem;">Konten Kampus</h5>
            </div>
            <div class="d-flex flex-column gap-2.5">
                <a href="{{ route('berita.index') }}" class="admin-module-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrap mb-0" style="background: #ecfdf5; color: #059669;">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div>
                            <div class="admin-module-title">Berita &amp; Artikel</div>
                            <p class="admin-module-desc">Kelola publikasi berita, artikel, dan rilis pers kampus</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('beritapmb.index') }}" class="admin-module-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrap mb-0" style="background: #fffbeb; color: #d97706;">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div>
                            <div class="admin-module-title">Berita &amp; Pengumuman PMB</div>
                            <p class="admin-module-desc">Informasi pendaftaran dan alur seleksi mahasiswa baru</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.layanan') }}" class="admin-module-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrap mb-0" style="background: #eff6ff; color: #2563eb;">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <div>
                            <div class="admin-module-title">Layanan Mahasiswa</div>
                            <p class="admin-module-desc">Portal layanan administrasi dan fasilitas akademik</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- KOLOM 2: AKADEMIK & LEMBAGA MUTU -->
        <div class="col-lg-4">
            <div class="mb-3">
                <span class="section-subheader-badge">Akademik &amp; Riset</span>
                <h5 class="fw-bold text-slate-900 mb-0" style="font-size: 1.05rem;">Lembaga &amp; Dosen</h5>
            </div>
            <div class="d-flex flex-column gap-2.5">
                <a href="{{ route('program-studi.index') }}" class="admin-module-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrap mb-0" style="background: #f5f3ff; color: #7c3aed;">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <div class="admin-module-title">Program Studi</div>
                            <p class="admin-module-desc">Kelola kurikulum, fasilitas, dan FAQ per program studi</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.ppm') }}" class="admin-module-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrap mb-0" style="background: #ecfdf5; color: #059669;">
                            <i class="fas fa-shield-halved"></i>
                        </div>
                        <div>
                            <div class="admin-module-title">Penjaminan Mutu (PPM)</div>
                            <p class="admin-module-desc">Portal SPMI, standar mutu, dan unggahan dokumen PDF resmi</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.lppm') }}" class="admin-module-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrap mb-0" style="background: #eff6ff; color: #0284c7;">
                            <i class="fas fa-microscope"></i>
                        </div>
                        <div>
                            <div class="admin-module-title">Riset LPPM</div>
                            <p class="admin-module-desc">Lembaga Penelitian dan Pengabdian kepada Masyarakat</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- KOLOM 3: PROFIL & PENGATURAN -->
        <div class="col-lg-4">
            <div class="mb-3">
                <span class="section-subheader-badge">Institusi &amp; Konfigurasi</span>
                <h5 class="fw-bold text-slate-900 mb-0" style="font-size: 1.05rem;">Profil &amp; Sistem</h5>
            </div>
            <div class="d-flex flex-column gap-2.5">
                <a href="{{ route('admin.visimisi') }}" class="admin-module-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrap mb-0" style="background: #fef2f2; color: #dc2626;">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <div>
                            <div class="admin-module-title">Visi &amp; Misi</div>
                            <p class="admin-module-desc">Kelola rumusan visi, misi, dan tujuan AMIK Taruna</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('alumni_section.index') }}" class="admin-module-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrap mb-0" style="background: #fff7ed; color: #ea580c;">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div>
                            <div class="admin-module-title">Alumni &amp; Karir</div>
                            <p class="admin-module-desc">Testimoni, jejak alumni, dan tracer study lulusan</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('setting.edit') }}" class="admin-module-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrap mb-0" style="background: #f1f5f9; color: #475569;">
                            <i class="fas fa-sliders"></i>
                        </div>
                        <div>
                            <div class="admin-module-title">Pengaturan Website</div>
                            <p class="admin-module-desc">Konfigurasi logo, nama website, kontak, dan footer</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </div>

    {{-- 4. TABEL PUBLIKASI BERITA TERKINI --}}
    <div class="dashboard-table-card">
        <div class="p-4 border-bottom border-slate-200 d-flex flex-wrap align-items-center justify-content-between gap-3 bg-white">
            <div>
                <h5 class="fw-bold text-slate-900 mb-1" style="font-size: 1.05rem;">Publikasi Berita Terkini</h5>
                <p class="text-slate-500 small mb-0">Daftar postingan berita yang aktif di portal publik</p>
            </div>
            <a href="{{ route('berita.index') }}" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold">
                Lihat Semua Berita &rarr;
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                <thead class="bg-light text-slate-600 fw-bold border-bottom">
                    <tr>
                        <th class="ps-4 py-3" style="width: 70px;">Thumbnail</th>
                        <th class="py-3">Judul Berita</th>
                        <th class="py-3">Kategori</th>
                        <th class="py-3">Tanggal Unggah</th>
                        <th class="pe-4 py-3 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_berita ?? [] as $item)
                        <tr>
                            <td class="ps-4 py-3">
                                @if(!empty($item->gambar))
                                    <img src="{{ asset('uploads/berita/' . $item->gambar) }}" alt="Thumb" class="rounded-3" style="width: 48px; height: 38px; object-fit: cover; border: 1px solid #e2e8f0;">
                                @else
                                    <div class="rounded-3 d-flex align-items-center justify-content-center bg-slate-100 text-slate-400" style="width: 48px; height: 38px;">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3">
                                <div class="fw-bold text-slate-900">{{ Str::limit($item->judul, 60) }}</div>
                                <small class="text-slate-400">{{ Str::limit(strip_tags($item->konten ?? ''), 70) }}</small>
                            </td>
                            <td class="py-3">
                                <span class="badge px-2.5 py-1 rounded-pill" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; font-size: 0.72rem;">
                                    {{ $item->kategori->nama ?? ($item->kategori ?? 'Umum') }}
                                </span>
                            </td>
                            <td class="py-3 text-slate-500">
                                <i class="far fa-calendar-alt me-1 text-slate-400"></i>
                                {{ $item->created_at ? $item->created_at->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <a href="{{ route('berita.edit', $item->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size: 0.75rem;">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-slate-400">
                                <i class="fas fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                                Belum ada publikasi berita yang diinput.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection