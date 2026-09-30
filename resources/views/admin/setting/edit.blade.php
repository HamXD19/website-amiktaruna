@extends('layouts.app')

@section('title', 'Pusat Pengaturan Website & Konten Dinamis')

@php
    $setting = $setting ?? new \App\Models\Setting();
    $headers = $setting->page_headers ?? [];
    $facts = $setting->home_facts ?? [];
    $pillars = $setting->home_pillars ?? [];
    $homeCta = $setting->home_cta ?? [];
    $mobileBanners = $setting->mobile_banners ?? [];
    $homeDosenIds = $setting->home_dosen_ids ?? [];
    if (!is_array($homeDosenIds)) {
        $homeDosenIds = json_decode($homeDosenIds, true) ?? [];
    }
    $allDosen = $allDosen ?? \App\Models\Dosen::orderBy('level_organigram')->orderBy('nama')->get();
    $tentangPillars = $setting->tentang_pillars ?? [];
    $akademikValues = $setting->akademik_values ?? [];
    $alumniPillars = $setting->alumni_pillars ?? [];
    $pmbPillars = $setting->pmb_pillars ?? [];
@endphp

@section('content')

<style>
    .cms-tab-nav {
        background: #ffffff;
        border-radius: 16px;
        padding: 8px;
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .cms-tab-btn {
        border: none;
        background: transparent;
        color: #64748b;
        font-weight: 600;
        font-size: 0.86rem;
        padding: 10px 18px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .cms-tab-btn:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .cms-tab-btn.active {
        background: #047857;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(4, 120, 87, 0.25);
    }

    .card-setting-pane {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        padding: 28px 32px;
        margin-top: 20px;
    }

    .section-divider {
        padding-bottom: 12px;
        margin-bottom: 22px;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .section-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .section-title i {
        color: #10b981;
    }

    .form-label {
        font-weight: 700;
        font-size: 0.82rem;
        color: #334155;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        font-size: 0.9rem;
        color: #0f172a;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
    }

    .form-hint {
        font-size: 0.76rem;
        color: #64748b;
        margin-top: 4px;
    }

    .sub-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .preview-box {
        border: 1px dashed #cbd5e1;
        border-radius: 14px;
        padding: 10px;
        background: #f8fafc;
        text-align: center;
        max-width: 200px;
        margin-top: 8px;
    }

    .preview-box img {
        max-width: 100%;
        max-height: 120px;
        object-fit: contain;
        border-radius: 8px;
    }

    .btn-save-sticky {
        position: sticky;
        bottom: 20px;
        z-index: 100;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 14px 24px;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 25px;
    }
</style>

<div class="container-fluid p-0">

    <!-- Top Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold mb-2">
                <i class="fas fa-sliders text-emerald-600"></i>
                <span>Pusat Konten &amp; Konfigurasi Dinamis</span>
            </div>
            <h3 class="fw-extrabold text-slate-900 mb-1" style="letter-spacing: -0.5px;">
                Pengaturan Tampilan &amp; Konten Website
            </h3>
            <p class="text-slate-500 small mb-0">
                Ubah teks, pilar keunggulan, header halaman, spesifikasi, dan banner secara langsung tanpa menyentuh kode program.
            </p>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-bold">
            <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border border-emerald-400 bg-emerald-50 text-emerald-800 rounded-3 mb-4 p-3 d-flex align-items-center gap-2">
            <i class="fas fa-check-circle fs-5 text-emerald-600"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <form action="{{ url('/admin/setting/update') }}" method="POST" enctype="multipart/form-data" id="settingForm">
        @csrf
        @method('PUT')

        <!-- TAB NAVIGATION (5 TABS) -->
        <div class="cms-tab-nav" id="cmsTabs" role="tablist">
            <button class="cms-tab-btn active" id="tab-btn-identitas" data-bs-toggle="pill" data-bs-target="#tab-identitas" type="button" role="tab">
                <i class="fas fa-landmark"></i>
                <span>1. Identitas &amp; Logo</span>
            </button>
            <button class="cms-tab-btn" id="tab-btn-beranda" data-bs-toggle="pill" data-bs-target="#tab-beranda" type="button" role="tab">
                <i class="fas fa-home"></i>
                <span>2. Konten Beranda</span>
            </button>
            <button class="cms-tab-btn" id="tab-btn-headers" data-bs-toggle="pill" data-bs-target="#tab-headers" type="button" role="tab">
                <i class="fas fa-heading"></i>
                <span>3. Header Tiap Halaman</span>
            </button>
            <button class="cms-tab-btn" id="tab-btn-subhalaman" data-bs-toggle="pill" data-bs-target="#tab-subhalaman" type="button" role="tab">
                <i class="fas fa-layer-group"></i>
                <span>4. Nilai &amp; Pilar Sub-Halaman</span>
            </button>
            <button class="cms-tab-btn" id="tab-btn-kontak" data-bs-toggle="pill" data-bs-target="#tab-kontak" type="button" role="tab">
                <i class="fas fa-map-location-dot"></i>
                <span>5. Kontak, Peta &amp; Footer</span>
            </button>
            <button class="cms-tab-btn" id="tab-btn-navmenu" data-bs-toggle="pill" data-bs-target="#tab-navmenu" type="button" role="tab">
                <i class="fas fa-bars-staggered"></i>
                <span>6. Kelola Menu &amp; Sub-Menu</span>
            </button>
        </div>

        <!-- TAB PANES -->
        <div class="tab-content" id="cmsTabContent">

            <!-- =====================================================
                 TAB 1: IDENTITAS & LOGO
            ===================================================== -->
            <div class="tab-pane fade show active" id="tab-identitas" role="tabpanel">
                <div class="card-setting-pane">
                    <div class="section-divider">
                        <h4 class="section-title">
                            <i class="fas fa-id-card"></i>
                            <span>Identitas Institusi &amp; Branding</span>
                        </h4>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Nama Website / Institusi</label>
                            <input type="text" name="nama_website" class="form-control" value="{{ $setting->nama_website }}" placeholder="Contoh: AMIK Taruna Probolinggo" required>
                            <div class="form-hint">Ditampilkan pada navbar, judul tab browser, dan copyright footer.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Badge Akreditasi Singkat</label>
                            <input type="text" name="badge_akreditasi" class="form-control" value="{{ $setting->badge_akreditasi ?? 'Terakreditasi B' }}" placeholder="Contoh: Terakreditasi B">
                            <div class="form-hint">Ditampilkan di samping logo kampus pada tampilan mobile smartphone.</div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Tagline Institusi</label>
                            <input type="text" name="tagline" class="form-control" value="{{ $setting->tagline }}" placeholder="Contoh: Menyiapkan Generasi Unggul dan Mandiri di Bidang Teknologi Informasi">
                            <div class="form-hint">Slogan resmi yang menggambarkan visi misi kampus.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Logo Resmi Institusi</label>
                            <input type="file" name="logo" class="form-control" accept="image/*">
                            <div class="form-hint">Format: PNG, JPG, WEBP transparan disarankan (Maks 2MB).</div>
                            @if($setting->logo)
                                <div class="preview-box">
                                    <img src="{{ asset('uploads/' . $setting->logo) }}" alt="Logo Saat Ini">
                                    <div class="text-xs text-muted mt-1">Logo Aktif</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- =====================================================
                 TAB 2: KONTEN BERANDA (HERO, FACTS, PILLARS, CTA, MOBILE)
            ===================================================== -->
            <div class="tab-pane fade" id="tab-beranda" role="tabpanel">
                <div class="card-setting-pane">
                    
                    <!-- 2.1 Hero Section -->
                    <div class="section-divider">
                        <h4 class="section-title">
                            <i class="fas fa-image"></i>
                            <span>Hero Section Beranda (Editorial Headline)</span>
                        </h4>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label class="form-label">Hero Judul Utama (Baris 1)</label>
                            <input type="text" name="hero_judul" class="form-control" value="{{ $setting->hero_judul ?? 'Pendidikan Vokasi Teknologi' }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Hero Highlight Teks (Baris 2 Warna Hijau)</label>
                            <input type="text" name="hero_highlight" class="form-control" value="{{ $setting->hero_highlight ?? 'Kesiapan Nyata di Dunia Kerja' }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Hero Subjudul / Paragraf Pengantar</label>
                            <textarea name="hero_subjudul" rows="3" class="form-control">{{ $setting->hero_subjudul ?? 'AMIK Taruna membekali mahasiswa dengan keahlian praktis manajemen informatika, kurikulum terapan yang relevan dengan kebutuhan industri, serta integritas kepemimpinan profesional.' }}</textarea>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tombol 1 Teks</label>
                            <input type="text" name="hero_button_1_text" class="form-control" value="{{ $setting->hero_button_1_text ?? 'Pendaftaran Mahasiswa Baru' }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tombol 1 Link</label>
                            <input type="text" name="hero_button_1_link" class="form-control" value="{{ $setting->hero_button_1_link ?? '/pmb' }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tombol 2 Teks</label>
                            <input type="text" name="hero_button_2_text" class="form-control" value="{{ $setting->hero_button_2_text ?? 'Pelajari Program Studi' }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tombol 2 Link</label>
                            <input type="text" name="hero_button_2_link" class="form-control" value="{{ $setting->hero_button_2_link ?? '/akademik' }}">
                        </div>

                        <!-- 3 Slide Gambar Hero -->
                        <div class="col-md-4">
                            <label class="form-label">Slide Foto 1 (Hero)</label>
                            <input type="file" name="hero_slide_1" class="form-control" accept="image/*">
                            @if($setting->hero_slide_1)
                                <div class="preview-box"><img src="{{ asset('uploads/' . $setting->hero_slide_1) }}"></div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Slide Foto 2 (Hero)</label>
                            <input type="file" name="hero_slide_2" class="form-control" accept="image/*">
                            @if($setting->hero_slide_2)
                                <div class="preview-box"><img src="{{ asset('uploads/' . $setting->hero_slide_2) }}"></div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Slide Foto 3 (Hero)</label>
                            <input type="file" name="hero_slide_3" class="form-control" accept="image/*">
                            @if($setting->hero_slide_3)
                                <div class="preview-box"><img src="{{ asset('uploads/' . $setting->hero_slide_3) }}"></div>
                            @endif
                        </div>
                    </div>

                    <!-- 2.2 Bar Fakta 3 Kolom & Promo Caption -->
                    <div class="section-divider">
                        <h4 class="section-title">
                            <i class="fas fa-chart-simple"></i>
                            <span>Bar Fakta 3 Kolom &amp; Caption Promo Hero</span>
                        </h4>
                    </div>

                    <div class="row g-3 mb-5">
                        <div class="col-md-4">
                            <div class="sub-card">
                                <span class="badge bg-emerald-600 mb-2">Fakta Kolom 1</span>
                                <div class="mb-2">
                                    <label class="form-label">Judul Baris Atas</label>
                                    <input type="text" name="home_facts[fact_1_title]" class="form-control" value="{{ $facts['fact_1_title'] ?? 'Status Resmi' }}">
                                </div>
                                <div>
                                    <label class="form-label">Nilai / Status</label>
                                    <input type="text" name="home_facts[fact_1_val]" class="form-control" value="{{ $facts['fact_1_val'] ?? 'Terakreditasi BAN-PT' }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="sub-card">
                                <span class="badge bg-emerald-600 mb-2">Fakta Kolom 2</span>
                                <div class="mb-2">
                                    <label class="form-label">Judul Baris Atas</label>
                                    <input type="text" name="home_facts[fact_2_title]" class="form-control" value="{{ $facts['fact_2_title'] ?? 'Orientasi' }}">
                                </div>
                                <div>
                                    <label class="form-label">Nilai / Status</label>
                                    <input type="text" name="home_facts[fact_2_val]" class="form-control" value="{{ $facts['fact_2_val'] ?? 'Vokasi Siap Kerja' }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="sub-card">
                                <span class="badge bg-emerald-600 mb-2">Fakta Kolom 3</span>
                                <div class="mb-2">
                                    <label class="form-label">Judul Baris Atas</label>
                                    <input type="text" name="home_facts[fact_3_title]" class="form-control" value="{{ $facts['fact_3_title'] ?? 'Infrastruktur' }}">
                                </div>
                                <div>
                                    <label class="form-label">Nilai / Status</label>
                                    <input type="text" name="home_facts[fact_3_val]" class="form-control" value="{{ $facts['fact_3_val'] ?? 'Lab Informatika Modern' }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Teks Bar Promo (Di Bawah Foto Kampus)</label>
                            <input type="text" name="home_facts[promo_text]" class="form-control" value="{{ $facts['promo_text'] ?? 'Penerimaan Mahasiswa Baru Gelombang 2026/2027 Dibuka' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Teks &amp; Link Tombol Promo</label>
                            <div class="input-group">
                                <input type="text" name="home_facts[promo_btn]" class="form-control" value="{{ $facts['promo_btn'] ?? 'Info PMB →' }}">
                                <input type="text" name="home_facts[promo_link]" class="form-control" value="{{ $facts['promo_link'] ?? '/pmb' }}">
                            </div>
                        </div>
                    </div>

                    <!-- 2.3 4 Pilar Trust Metrics (Mengapa Memilih AMIK Taruna) -->
                    <div class="section-divider">
                        <h4 class="section-title">
                            <i class="fas fa-award"></i>
                            <span>4 Pilar Keunggulan Beranda (Trust Metrics)</span>
                        </h4>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Eyebrow Header</label>
                            <input type="text" name="home_pillars[eyebrow]" class="form-control" value="{{ $pillars['eyebrow'] ?? 'Komitmen Mutu & Keunggulan' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Judul Section</label>
                            <input type="text" name="home_pillars[title]" class="form-control" value="{{ $pillars['title'] ?? 'Mengapa Memilih AMIK Taruna?' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Subjudul Pengantar</label>
                            <input type="text" name="home_pillars[subtitle]" class="form-control" value="{{ $pillars['subtitle'] ?? 'Mempersiapkan generasi masa depan dengan kompetensi teknologi informasi, kemampuan manajerial, dan etika profesional.' }}">
                        </div>
                    </div>

                    <div class="row g-3 mb-5">
                        @php
                            $defaultPillars = [
                                ['icon' => 'badge-check', 'title' => 'Terakreditasi Resmi', 'badge' => 'Legal & Kredibel', 'desc' => 'Memiliki legalitas dan pengakuan resmi dari BAN-PT sebagai institusi pendidikan tinggi vokasi yang terpercaya.'],
                                ['icon' => 'code-laptop', 'title' => 'Kurikulum Terapan', 'badge' => '70% Praktik', 'desc' => 'Proporsi praktik komputasi dan teknologi informasi yang dominan guna memastikan kesiapan kerja lulusan.'],
                                ['icon' => 'users-academic', 'title' => 'Dosen Berpengalaman', 'badge' => 'Kompeten', 'desc' => 'Dibimbing oleh para akademisi dan praktisi profesional di bidang manajemen informatika dan teknologi.'],
                                ['icon' => 'career-growth', 'title' => 'Peluang Karier Luas', 'badge' => 'Siap Kerja', 'desc' => 'Keahlian digital yang dicari di berbagai sektor: instansi pemerintah, BUMN, perbankan, industri kreatif, dan startup.']
                            ];
                            $activePillars = !empty($pillars['items']) ? $pillars['items'] : $defaultPillars;
                        @endphp

                        @for($i = 0; $i < 4; $i++)
                            @php $p = $activePillars[$i] ?? $defaultPillars[$i]; @endphp
                            <div class="col-md-6 col-lg-3">
                                <div class="sub-card h-100">
                                    <span class="badge bg-secondary mb-2">Pilar {{ $i+1 }}</span>
                                    <div class="mb-2">
                                        <label class="form-label">Judul Pilar</label>
                                        <input type="text" name="home_pillars[items][{{ $i }}][title]" class="form-control" value="{{ $p['title'] }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Badge Sudut</label>
                                        <input type="text" name="home_pillars[items][{{ $i }}][badge]" class="form-control" value="{{ $p['badge'] }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Jenis Ikon</label>
                                        <select name="home_pillars[items][{{ $i }}][icon]" class="form-select">
                                            <option value="badge-check" {{ ($p['icon'] ?? '') == 'badge-check' ? 'selected' : '' }}>badge-check (Centang/Perisai)</option>
                                            <option value="code-laptop" {{ ($p['icon'] ?? '') == 'code-laptop' ? 'selected' : '' }}>code-laptop (Laptop/Kode)</option>
                                            <option value="users-academic" {{ ($p['icon'] ?? '') == 'users-academic' ? 'selected' : '' }}>users-academic (Dosen/Siswa)</option>
                                            <option value="career-growth" {{ ($p['icon'] ?? '') == 'career-growth' ? 'selected' : '' }}>career-growth (Grafik/Karier)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="home_pillars[items][{{ $i }}][desc]" rows="3" class="form-control">{{ $p['desc'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>

                    <!-- 2.4 Section Penutup Beranda (CTA Pendaftaran PMB) -->
                    <div class="section-divider">
                        <h4 class="section-title">
                            <i class="fas fa-bullhorn"></i>
                            <span>Section Penutup Beranda (Call To Action PMB)</span>
                        </h4>
                    </div>

                    <div class="row g-3 mb-5">
                        <div class="col-md-4">
                            <label class="form-label">Badge Pill Atas</label>
                            <input type="text" name="home_cta[badge]" class="form-control" value="{{ $homeCta['badge'] ?? 'Penerimaan Mahasiswa Baru 2026/2027' }}">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Headline CTA</label>
                            <input type="text" name="home_cta[headline]" class="form-control" value="{{ $homeCta['headline'] ?? 'Mulai langkah nyatamu di dunia teknologi & digital.' }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Paragraf Persuasi</label>
                            <textarea name="home_cta[subheadline]" rows="2" class="form-control">{{ $homeCta['subheadline'] ?? 'Daftarkan dirimu di AMIK Taruna. Dapatkan pembekalan komputasi terapan, bimbingan dosen berpengalaman, dan sertifikasi keahlian siap industri.' }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">4 Poin Kepercayaan (Pisahkan dengan Tanda Titik Koma ';')</label>
                            <input type="text" name="home_cta[points_str]" class="form-control" value="{{ $homeCta['points_str'] ?? 'Akreditasi BAN-PT Resmi; Biaya Kuliah Terjangkau; Beasiswa Prestasi & KIP-K; Konsultasi Program Studi Bebas Biaya' }}">
                            <div class="form-hint">Format: Poin 1; Poin 2; Poin 3; Poin 4 (Otomatis diberi tanda centang hijau ✓)</div>
                        </div>
                    </div>

                    <!-- 2.5 Pimpinan Utama di Beranda (Direktur & 3 Wakil Direktur) -->
                    <div class="section-divider">
                        <h4 class="section-title">
                            <i class="fas fa-users-line"></i>
                            <span>Pimpinan Utama di Beranda (Direktur &amp; 3 Wakil Direktur)</span>
                        </h4>
                    </div>

                    <div class="alert alert-info border-0 rounded-3 mb-4 shadow-sm" style="background-color: #f0fdf4; border-left: 4px solid #059669 !important;">
                        <div class="d-flex gap-3 align-items-center">
                            <i class="fas fa-circle-check fa-2x text-emerald-600"></i>
                            <div>
                                <strong class="text-slate-800">Konfigurasi 4 Pimpinan Beranda:</strong>
                                <p class="mb-0 text-muted small">Sesuai hierarki institusi, beranda menampilkan 4 pimpinan utama: <strong>Direktur</strong> dan <strong>3 Wakil Direktur (Wadir I, II, III)</strong>. Anda dapat memilih dosen/pejabat yang ditampilkan pada masing-masing slot kartu di bawah ini:</p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-5">
                        @php
                            $slotLabels = [
                                0 => ['title' => 'Slot 1 (Direktur)', 'badge' => 'Direktur Utama', 'default_id' => 6],
                                1 => ['title' => 'Slot 2 (Wadir I)', 'badge' => 'Wadir I - Akademik', 'default_id' => 10],
                                2 => ['title' => 'Slot 3 (Wadir II)', 'badge' => 'Wadir II - Keuangan & Adm', 'default_id' => 12],
                                3 => ['title' => 'Slot 4 (Wadir III)', 'badge' => 'Wadir III - Kemahasiswaan', 'default_id' => 13],
                            ];
                        @endphp

                        @for($s = 0; $s < 4; $s++)
                            @php
                                $selectedId = $homeDosenIds[$s] ?? $slotLabels[$s]['default_id'];
                            @endphp
                            <div class="col-md-6 col-lg-3">
                                <div class="sub-card h-100">
                                    <span class="badge bg-emerald-600 mb-2">{{ $slotLabels[$s]['badge'] }}</span>
                                    <div class="mb-2">
                                        <label class="form-label fw-bold">{{ $slotLabels[$s]['title'] }}</label>
                                        <select name="home_dosen_ids[{{ $s }}]" class="form-select">
                                            <option value="">-- Pilih Pimpinan --</option>
                                            @foreach($allDosen as $dosen)
                                                <option value="{{ $dosen->id }}" {{ (string)$selectedId === (string)$dosen->id ? 'selected' : '' }}>
                                                    {{ $dosen->nama }} ({{ \Illuminate\Support\Str::limit($dosen->jabatan ?? 'Dosen', 28) }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-hint small text-muted">
                                        Kartu ke-{{ $s + 1 }} yang muncul di halaman depan beranda.
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>

                    <!-- 2.6 Slider Banner Tampilan Mobile -->
                    <div class="section-divider">
                        <h4 class="section-title">
                            <i class="fas fa-mobile-screen"></i>
                            <span>Slider Banner Tampilan HP / Smartphone</span>
                        </h4>
                    </div>

                    <div class="row g-3">
                        @php
                            $defaultBanners = [
                                ['title' => 'Penerimaan Mahasiswa Baru', 'highlight' => 'TA 2026/2027', 'desc' => 'Jalur Beasiswa KIP & Prestasi Akademik. Siapkan karir digital Anda!', 'badge' => 'PMB DIBUKA', 'link' => '/pmb', 'btnText' => 'Daftar Sekarang'],
                                ['title' => 'Program Studi Vokasi D3', 'highlight' => 'Gelar Resmi A.Md.', 'desc' => 'Kurikulum praktis berbasis industri IT dengan sertifikasi kompetensi BNSP.', 'badge' => 'AKREDITASI BAIK', 'link' => '/akademik', 'btnText' => 'Lihat Program Studi'],
                                ['title' => 'Pusat Dokumen Resmi', 'highlight' => 'Transparansi Akademik', 'desc' => 'Unduh kurikulum, pedoman akademik, modul, dan RPS per program studi.', 'badge' => 'DOWNLOAD DOKUMEN', 'link' => '/akademik', 'btnText' => 'Buka Dokumen']
                            ];
                            $activeBanners = !empty($mobileBanners) ? $mobileBanners : $defaultBanners;
                        @endphp

                        @for($b = 0; $b < 3; $b++)
                            @php $ban = $activeBanners[$b] ?? $defaultBanners[$b]; @endphp
                            <div class="col-md-4">
                                <div class="sub-card">
                                    <span class="badge bg-primary mb-2">Banner Mobile {{ $b+1 }}</span>
                                    <div class="mb-2">
                                        <label class="form-label">Judul Banner</label>
                                        <input type="text" name="mobile_banners[{{ $b }}][title]" class="form-control" value="{{ $ban['title'] }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Teks Sorotan / Highlight</label>
                                        <input type="text" name="mobile_banners[{{ $b }}][highlight]" class="form-control" value="{{ $ban['highlight'] }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Badge Label</label>
                                        <input type="text" name="mobile_banners[{{ $b }}][badge]" class="form-control" value="{{ $ban['badge'] }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Deskripsi Singkat</label>
                                        <textarea name="mobile_banners[{{ $b }}][desc]" rows="2" class="form-control">{{ $ban['desc'] }}</textarea>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <label class="form-label">Teks Tombol</label>
                                            <input type="text" name="mobile_banners[{{ $b }}][btnText]" class="form-control" value="{{ $ban['btnText'] }}">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Link Tujuan</label>
                                            <input type="text" name="mobile_banners[{{ $b }}][link]" class="form-control" value="{{ $ban['link'] }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>

                </div>
            </div>

            <!-- =====================================================
                 TAB 3: HEADER TIAP HALAMAN PUBLIK
            ===================================================== -->
            <div class="tab-pane fade" id="tab-headers" role="tabpanel">
                <div class="card-setting-pane">
                    <div class="section-divider">
                        <h4 class="section-title">
                            <i class="fas fa-heading"></i>
                            <span>Header Judul &amp; Pengantar Halaman Publik</span>
                        </h4>
                    </div>
                    <p class="text-slate-500 small mb-4">
                        Atur teks pembuka, lencana kecil (*eyebrow*), judul utama, dan narasi pengantar yang tampil di bagian atas setiap halaman website.
                    </p>

                    @php
                        $pageConfigs = [
                            'tentang' => [
                                'nama' => 'Halaman Tentang Kampus (/tentang)',
                                'default_eyebrow' => 'Profil & Identitas Institusi',
                                'default_title' => 'Tentang AMIK Taruna',
                                'default_sub' => 'Mengenal institusi, perjalanan pendidikan vokasi teknologi terapan, dan komitmen mutu civitas akademika AMIK Taruna Probolinggo.'
                            ],
                            'akademik' => [
                                'nama' => 'Halaman Program Studi (/akademik)',
                                'default_eyebrow' => 'Pendidikan Vokasi Terapan',
                                'default_title' => 'Program Studi Akademik',
                                'default_sub' => 'Pilihan program studi vokasi jenjang Diploma III yang dirancang untuk membekali mahasiswa dengan keahlian teknis komputasi, logika terapan, dan kesiapan berkarier di era industri digital.'
                            ],
                            'mahasiswa' => [
                                'nama' => 'Halaman Layanan Mahasiswa (/mahasiswa)',
                                'default_eyebrow' => 'Sivitas Akademika',
                                'default_title' => 'Pelayanan Akademik',
                                'default_sub' => 'Akses cepat ke berbagai portal dan layanan digital mahasiswa AMIK Taruna'
                            ],
                            'alumni' => [
                                'nama' => 'Halaman Tracer Study Alumni (/alumni)',
                                'default_eyebrow' => 'Jejaring & Rekam Jejak',
                                'default_title' => 'Portal Alumni & Tracer Study',
                                'default_sub' => 'Wadah sinergi almamater dengan alumni AMIK Taruna untuk penelusuran karier, survei mutu kurikulum vokasi, dan kontribusi pengembangan institusi.'
                            ],
                            'lppm' => [
                                'nama' => 'Halaman Riset & Lembaga LPPM (/lppm)',
                                'default_eyebrow' => 'Lembaga Penelitian & Pengabdian Masyarakat',
                                'default_title' => 'Portal & Layanan LPPM',
                                'default_sub' => 'Pusat layanan riset, jurnal publikasi ilmiah, dan pengabdian masyarakat Sivitas Akademika AMIK Taruna Probolinggo'
                            ],
                            'ppm' => [
                                'nama' => 'Halaman Penjaminan Mutu PPM (/ppm)',
                                'default_eyebrow' => 'Lembaga Mutu Internal',
                                'default_title' => 'Pusat Penjaminan Mutu (PPM)',
                                'default_sub' => 'Sistem Penjaminan Mutu Internal (SPMI) AMIK Taruna Probolinggo untuk menjaga, mengendalikan, dan meningkatkan standar mutu pendidikan tinggi secara berkelanjutan.'
                            ],
                            'berita' => [
                                'nama' => 'Halaman Berita & Warta (/berita)',
                                'default_eyebrow' => 'Portal Publikasi & Warta',
                                'default_title' => 'Warta & Kabar Kampus',
                                'default_sub' => 'Informasi resmi, agenda kegiatan, pengumuman akademik, dan publikasi Tridharma Perguruan Tinggi AMIK Taruna Probolinggo.'
                            ],
                            'ppks' => [
                                'nama' => 'Halaman Satgas PPKS (/ppks)',
                                'default_eyebrow' => 'Satgas PPKS AMIK Taruna',
                                'default_title' => 'Layanan Pencegahan & Penanganan Kekerasan Seksual',
                                'default_sub' => 'Kanal pelaporan resmi, terenkripsi, dan rahasia sesuai Permendikbudristek No. 30 Tahun 2021. Kami menjamin perlindungan privasi, keamanan identitas, serta pendampingan psikologis korban.'
                            ],
                            'kritiksaran' => [
                                'nama' => 'Halaman Kritik & Saran (/kritik-saran)',
                                'default_eyebrow' => 'Suara Sivitas & Publik',
                                'default_title' => 'Kritik & Saran',
                                'default_sub' => 'Berikan masukan, kritik konstruktif, dan saran untuk kemajuan tata kelola dan layanan digital AMIK Taruna'
                            ],
                        ];
                    @endphp

                    <div class="row g-4">
                        @foreach($pageConfigs as $key => $conf)
                            @php
                                $valEye = $headers[$key]['eyebrow'] ?? $conf['default_eyebrow'];
                                $valTitle = $headers[$key]['title'] ?? $conf['default_title'];
                                $valSub = $headers[$key]['subtitle'] ?? $conf['default_sub'];
                            @endphp
                            <div class="col-md-6">
                                <div class="sub-card h-100">
                                    <h5 class="fw-bold text-slate-800 fs-6 mb-3 d-flex align-items-center gap-2">
                                        <i class="fas fa-file-lines text-emerald-600"></i>
                                        <span>{{ $conf['nama'] }}</span>
                                    </h5>
                                    <div class="mb-2">
                                        <label class="form-label">Lencana / Eyebrow</label>
                                        <input type="text" name="page_headers[{{ $key }}][eyebrow]" class="form-control" value="{{ $valEye }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Judul Utama</label>
                                        <input type="text" name="page_headers[{{ $key }}][title]" class="form-control" value="{{ $valTitle }}">
                                    </div>
                                    <div>
                                        <label class="form-label">Paragraf Subjudul</label>
                                        <textarea name="page_headers[{{ $key }}][subtitle]" rows="2" class="form-control">{{ $valSub }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

            <!-- =====================================================
                 TAB 4: NILAI & PILAR SUB-HALAMAN
            ===================================================== -->
            <div class="tab-pane fade" id="tab-subhalaman" role="tabpanel">
                <div class="card-setting-pane">

                    <!-- 4.1 3 Pilar Profil Kampus (/tentang) -->
                    <div class="section-divider">
                        <h4 class="section-title">
                            <i class="fas fa-university"></i>
                            <span>3 Pilar Sekilas Profil Kampus (Halaman /tentang)</span>
                        </h4>
                    </div>

                    @php
                        $defaultTentangPillars = [
                            ['title' => 'Pendidikan Terapan', 'desc' => 'Kurikulum terstruktur berbasis praktik & kesiapan kerja industri.'],
                            ['title' => 'Praktisi Berpengalaman', 'desc' => 'Dosen dan praktisi kompeten di bidang rekayasa TI & sistem bisnis.'],
                            ['title' => 'Kelanjutan Studi', 'desc' => 'Kemudahan transfer SKS ke jenjang sarjana di PTN maupun Swasta.']
                        ];
                        $activeTP = !empty($tentangPillars['items']) ? $tentangPillars['items'] : $defaultTentangPillars;
                    @endphp

                    <div class="row g-3 mb-5">
                        <div class="col-12">
                            <label class="form-label">Judul Headline Profil Institusi</label>
                            <input type="text" name="tentang_pillars[headline]" class="form-control" value="{{ $tentangPillars['headline'] ?? 'Menumbuhkan keahlian nyata di bidang teknologi komputasi & digital.' }}">
                        </div>

                        @for($t = 0; $t < 3; $t++)
                            @php $itemTP = $activeTP[$t] ?? $defaultTentangPillars[$t]; @endphp
                            <div class="col-md-4">
                                <div class="sub-card">
                                    <span class="badge bg-emerald-600 mb-2">Pilar Profil {{ $t+1 }}</span>
                                    <div class="mb-2">
                                        <label class="form-label">Judul</label>
                                        <input type="text" name="tentang_pillars[items][{{ $t }}][title]" class="form-control" value="{{ $itemTP['title'] }}">
                                    </div>
                                    <div>
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="tentang_pillars[items][{{ $t }}][desc]" rows="2" class="form-control">{{ $itemTP['desc'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>

                    <!-- 4.2 3 Nilai Vokasi Akademik (/akademik) -->
                    <div class="section-divider">
                        <h4 class="section-title">
                            <i class="fas fa-graduation-cap"></i>
                            <span>3 Nilai Keunggulan Vokasi (Halaman /akademik)</span>
                        </h4>
                    </div>

                    @php
                        $defaultAkademikValues = [
                            ['icon' => 'fas fa-laptop-code', 'title' => '60% Kurikulum Praktik', 'desc' => 'Fokus pada penguasaan studi kasus nyata, perancangan aplikasi, dan pemecahan masalah komputasi industri.'],
                            ['icon' => 'fas fa-chalkboard-teacher', 'title' => 'Dosen Praktisi Industri', 'desc' => 'Pengajar berpengalaman mendampingi mahasiswa dari pemahaman konseptual hingga penerapan praktis.'],
                            ['icon' => 'fas fa-share-alt', 'title' => 'Transfer SKS Lanjutan', 'desc' => 'Lulusan dapat dengan mudah melanjutkan studi ke jenjang sarjana di PTN maupun Swasta dengan penyesuaian SKS.']
                        ];
                        $activeAV = !empty($akademikValues) ? $akademikValues : $defaultAkademikValues;
                    @endphp

                    <div class="row g-3 mb-5">
                        @for($a = 0; $a < 3; $a++)
                            @php $itemAV = $activeAV[$a] ?? $defaultAkademikValues[$a]; @endphp
                            <div class="col-md-4">
                                <div class="sub-card">
                                    <span class="badge bg-info text-dark mb-2">Nilai Vokasi {{ $a+1 }}</span>
                                    <div class="mb-2">
                                        <label class="form-label">Judul Nilai</label>
                                        <input type="text" name="akademik_values[{{ $a }}][title]" class="form-control" value="{{ $itemAV['title'] }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Ikon FontAwesome</label>
                                        <input type="text" name="akademik_values[{{ $a }}][icon]" class="form-control" value="{{ $itemAV['icon'] }}">
                                    </div>
                                    <div>
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="akademik_values[{{ $a }}][desc]" rows="3" class="form-control">{{ $itemAV['desc'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>

                    <!-- 4.3 3 Pilar Sinergi Alumni (/alumni) -->
                    <div class="section-divider">
                        <h4 class="section-title">
                            <i class="fas fa-users-rays"></i>
                            <span>3 Pilar Sinergi Alumni (Halaman /alumni)</span>
                        </h4>
                    </div>

                    @php
                        $defaultAlumniPillars = [
                            ['icon' => 'fas fa-chart-line', 'badge' => 'Pilar Pengembangan', 'title' => 'Relevansi Kurikulum', 'desc' => 'Tracer study memetakan kesesuaian keahlian lulusan dengan kebutuhan nyata industri teknologi masa kini.'],
                            ['icon' => 'fas fa-network-wired', 'badge' => 'Pilar Kolaborasi', 'title' => 'Jejaring Profesional', 'desc' => 'Menghubungkan lulusan lintas angkatan yang berkarier di institusi pemerintah, BUMN, dan industri kreatif.'],
                            ['icon' => 'fas fa-hand-holding-heart', 'badge' => 'Pilar Solidaritas', 'title' => 'Dukungan Fasilitas', 'desc' => 'Sinergi dana abadi membantu penyediaan fasilitas laboratorium serta beasiswa bagi mahasiswa berprestasi.']
                        ];
                        $activeAlum = !empty($alumniPillars) ? $alumniPillars : $defaultAlumniPillars;
                    @endphp

                    <div class="row g-3">
                        @for($al = 0; $al < 3; $al++)
                            @php $itemAl = $activeAlum[$al] ?? $defaultAlumniPillars[$al]; @endphp
                            <div class="col-md-4">
                                <div class="sub-card">
                                    <span class="badge bg-teal text-white mb-2" style="background:#0d9488;">Pilar Alumni {{ $al+1 }}</span>
                                    <div class="mb-2">
                                        <label class="form-label">Judul Pilar</label>
                                        <input type="text" name="alumni_pillars[{{ $al }}][title]" class="form-control" value="{{ $itemAl['title'] }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Lencana Bawah</label>
                                        <input type="text" name="alumni_pillars[{{ $al }}][badge]" class="form-control" value="{{ $itemAl['badge'] }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Ikon FontAwesome</label>
                                        <input type="text" name="alumni_pillars[{{ $al }}][icon]" class="form-control" value="{{ $itemAl['icon'] }}">
                                    </div>
                                    <div>
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="alumni_pillars[{{ $al }}][desc]" rows="3" class="form-control">{{ $itemAl['desc'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>

                </div>
            </div>

            <!-- =====================================================
                 TAB 5: KONTAK, PETA & FOOTER
            ===================================================== -->
            <div class="tab-pane fade" id="tab-kontak" role="tabpanel">
                <div class="card-setting-pane">
                    <div class="section-divider">
                        <h4 class="section-title">
                            <i class="fas fa-location-dot"></i>
                            <span>Informasi Alamat, Kontak &amp; Peta Lokasi</span>
                        </h4>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label class="form-label">Alamat Lengkap Kampus</label>
                            <textarea name="alamat" rows="3" class="form-control" placeholder="Contoh: Jl. Hayam Wuruk No. 123, Kraksaan, Probolinggo">{{ $setting->alamat }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">URL Sematan Google Maps (Iframe Embed URL)</label>
                            <textarea name="maps_embed_url" rows="3" class="form-control" placeholder="Contoh: https://www.google.com/maps?q=AMIK%20Taruna%20Probolinggo&output=embed">{{ $setting->maps_embed_url ?? 'https://www.google.com/maps?q=AMIK%20Taruna%20Probolinggo&output=embed' }}</textarea>
                            <div class="form-hint">Dapat diisi URL embed Google Maps resmi kampus.</div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Nomor Telepon Kantor</label>
                            <input type="text" name="telepon" class="form-control" value="{{ $setting->telepon }}" placeholder="Contoh: (0335) 420123 / 081234567890">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Alamat Email Resmi</label>
                            <input type="email" name="email" class="form-control" value="{{ $setting->email }}" placeholder="info@amiktaruna.ac.id">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Jam Operasional Layanan</label>
                            <input type="text" name="jam_operasional" class="form-control" value="{{ $setting->jam_operasional }}" placeholder="Senin - Sabtu: 08.00 - 16.00 WIB">
                        </div>
                    </div>

                    <!-- Footer & Media Sosial -->
                    <div class="section-divider">
                        <h4 class="section-title">
                            <i class="fas fa-share-nodes"></i>
                            <span>Tautan Media Sosial &amp; Deskripsi Footer</span>
                        </h4>
                    </div>

                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label">Deskripsi Singkat Footer</label>
                            <textarea name="footer_deskripsi" rows="2" class="form-control">{{ $setting->footer_deskripsi ?? 'Perguruan tinggi vokasi teknologi informasi yang berdedikasi melahirkan praktisi dan profesional digital siap kerja.' }}</textarea>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label"><i class="fab fa-instagram text-danger me-1"></i> Instagram</label>
                            <input type="url" name="instagram" class="form-control" value="{{ $setting->instagram }}" placeholder="https://instagram.com/...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><i class="fab fa-facebook text-primary me-1"></i> Facebook</label>
                            <input type="url" name="facebook" class="form-control" value="{{ $setting->facebook }}" placeholder="https://facebook.com/...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><i class="fab fa-youtube text-danger me-1"></i> YouTube</label>
                            <input type="url" name="youtube" class="form-control" value="{{ $setting->youtube }}" placeholder="https://youtube.com/...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><i class="fab fa-tiktok text-dark me-1"></i> TikTok</label>
                            <input type="url" name="tiktok" class="form-control" value="{{ $setting->tiktok }}" placeholder="https://tiktok.com/...">
                        </div>
                    </div>

                </div>
            </div>

            <!-- ============================================================ -->
            <!-- TAB 6: KELOLA MENU & SUB-MENU (REFERENSI KRAKSAAN WETAN)     -->
            <!-- ============================================================ -->
            @php
                $navData = $navMenus ?? ($setting->nav_menus ?? \App\Http\Controllers\SettingController::getDefaultNavMenus());
                $berandaNav = $navData['beranda'] ?? ['label' => 'Beranda', 'href' => '/'];
                $navGroupsList = $navData['groups'] ?? [];
            @endphp
            <div class="tab-pane fade" id="tab-navmenu" role="tabpanel">
                <div class="card-setting-pane">

                    <div class="section-divider">
                        <div>
                            <h4 class="section-title">
                                <i class="fas fa-bars-staggered"></i>
                                <span>Pengaturan Nama Menu, Sub-Menu &amp; Tambah Sub-Menu</span>
                            </h4>
                            <p class="text-slate-500 small mb-0 mt-1">
                                Anda dapat mengganti label nama setiap menu utama, mengubah tautan dan nama sub-menu, serta menambah sub-menu baru dengan opsi mengisi halaman konten lengkap (seperti di project Kraksaan Wetan).
                            </p>
                        </div>
                    </div>

                    <!-- FITUR SEPERTI KRAKSAAN WETAN: KELOLA HALAMAN KONTEN SUB-MENU -->
                    <div class="sub-card mb-4" style="background: linear-gradient(135deg, #f0fdf4, #ecfdf5); border: 1.5px solid #a7f3d0;">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                            <div>
                                <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-0.5 rounded-pill small fw-bold mb-1" style="background: #dcfce7; color: #166534; font-size: 0.75rem;">
                                    <i class="fas fa-file-circle-plus"></i> Fitur Seperti Kraksaan Wetan
                                </div>
                                <h5 class="fw-bold text-slate-900 mb-0">Halaman Konten Dinamis untuk Sub-Menu</h5>
                                <p class="text-slate-500 small mb-0 mt-0.5">
                                    Tambahkan sub-menu baru lengkap dengan opsi mengisi konten artikel, ringkasan, dan foto cover yang otomatis dibuatkan halaman publiknya (<code class="text-emerald-800">/halaman/{slug}</code>).
                                </p>
                            </div>

                            <button type="button" class="btn btn-success rounded-pill px-4 py-2.5 fw-bold shadow-xs d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalTambahHalaman">
                                <i class="fas fa-plus-circle"></i>
                                <span>+ Tambah Sub-Menu &amp; Tulis Halaman Baru</span>
                            </button>
                        </div>

                        <!-- DAFTAR HALAMAN KUSTOM YANG SUDAH DIBUAT -->
                        @if(isset($halamanList) && $halamanList->count() > 0)
                            <div class="table-responsive rounded-3 border bg-white mt-3">
                                <table class="table table-sm align-middle mb-0">
                                    <thead class="table-light">
                                        <tr class="small text-slate-600">
                                            <th width="45" class="text-center">No</th>
                                            <th width="60" class="text-center">Cover</th>
                                            <th>Judul Sub-Menu &amp; Slug URL</th>
                                            <th width="160">Menu Dropdown</th>
                                            <th width="90" class="text-center">Status</th>
                                            <th width="160" class="text-center">Aksi Halaman</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($halamanList as $hIdx => $hal)
                                            <tr>
                                                <td class="text-center small text-slate-400 fw-bold">{{ $hIdx + 1 }}</td>
                                                <td class="text-center">
                                                    @if($hal->gambar)
                                                        <img src="{{ $hal->gambar_url }}" alt="Cover" class="rounded-2" style="width: 44px; height: 32px; object-fit: cover;">
                                                    @else
                                                        <span class="badge bg-light text-muted border" style="font-size: 0.65rem;">No Img</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="fw-bold text-slate-900">{{ $hal->judul }}</div>
                                                    <div class="text-emerald-700 font-monospace small">/halaman/{{ $hal->slug }}</div>
                                                    @if($hal->ringkasan)
                                                        <div class="text-slate-500 small text-truncate" style="max-width: 320px;">{{ $hal->ringkasan }}</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($hal->kategori == 'profil')
                                                        <span class="badge rounded-pill px-2.5 py-1" style="background-color: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe;">Profil</span>
                                                    @elseif($hal->kategori == 'akademik')
                                                        <span class="badge rounded-pill px-2.5 py-1" style="background-color: #f3e8ff; color: #7e22ce; border: 1px solid #d8b4fe;">Akademik</span>
                                                    @elseif($hal->kategori == 'riset')
                                                        <span class="badge rounded-pill px-2.5 py-1" style="background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">Riset &amp; Lembaga</span>
                                                    @else
                                                        <span class="badge rounded-pill px-2.5 py-1" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #6ee7b7;">Informasi</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($hal->aktif)
                                                        <span class="badge bg-success rounded-pill px-2.5 py-1 small">Aktif</span>
                                                    @else
                                                        <span class="badge bg-secondary rounded-pill px-2 py-0.5 small">Draft</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <a href="{{ url('/halaman/' . $hal->slug) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill p-1 px-2" title="Lihat Halaman Publik">
                                                            <i class="fas fa-external-link-alt fa-xs"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-outline-warning btn-sm rounded-pill p-1 px-2 text-dark" onclick="openEditHalamanModal({{ json_encode($hal) }})" title="Edit Isi Halaman Ini">
                                                            <i class="fas fa-edit fa-xs"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill p-1 px-2" onclick="confirmDeleteHalaman({{ $hal->id }}, '{{ addslashes($hal->judul) }}')" title="Hapus Halaman &amp; Sub-Menu">
                                                            <i class="fas fa-trash-can fa-xs"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4 bg-white rounded-3 border">
                                <i class="fas fa-file-lines fa-2x text-emerald-400 opacity-60 mb-2"></i>
                                <div class="fw-bold text-slate-700 small">Belum ada Halaman Konten Kustom</div>
                                <div class="text-slate-400 small">Klik tombol <strong>"+ Tambah Sub-Menu &amp; Tulis Halaman Baru"</strong> untuk menambahkan sub-menu baru lengkap dengan halaman artikelnya.</div>
                            </div>
                        @endif
                    </div>

                    <!-- 1. Menu Single: Beranda -->
                    <div class="sub-card mb-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="fw-bold text-slate-800 mb-0 d-flex align-items-center gap-2">
                                <i class="fas fa-home text-emerald-600"></i>
                                <span>Menu Utama Beranda</span>
                            </h5>
                            <span class="badge bg-emerald-100 text-emerald-800 rounded-pill px-3 py-1 small">Single Link</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Label Nama Menu Beranda</label>
                                <input type="text" name="nav_menus[beranda][label]" class="form-control" value="{{ $berandaNav['label'] ?? 'Beranda' }}" placeholder="Beranda" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tautan / URL</label>
                                <input type="text" name="nav_menus[beranda][href]" class="form-control" value="{{ $berandaNav['href'] ?? '/' }}" placeholder="/">
                            </div>
                        </div>
                    </div>

                    <!-- 2. Dropdown Group Menus -->
                    @foreach($navGroupsList as $gIdx => $group)
                        <div class="sub-card mb-4" id="group-card-{{ $group['id'] }}">
                            <input type="hidden" name="nav_menus[groups][{{ $gIdx }}][id]" value="{{ $group['id'] }}">
                            <input type="hidden" name="nav_menus[groups][{{ $gIdx }}][icon]" value="{{ $group['icon'] ?? 'fas fa-bars' }}">

                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3 pb-2 border-bottom">
                                <div class="d-flex align-items-center gap-2 flex-grow-1" style="max-width: 450px;">
                                    <div class="rounded-3 bg-emerald-100 text-emerald-700 d-flex align-items-center justify-center fs-5 flex-shrink-0" style="width: 38px; height: 38px;">
                                        <i class="{{ $group['icon'] ?? 'fas fa-bars' }}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-label mb-1">Nama Grup Menu</label>
                                        <input type="text" name="nav_menus[groups][{{ $gIdx }}][label]" class="form-control fw-bold" value="{{ $group['label'] }}" placeholder="Nama Menu..." required>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-slate-200 text-slate-700 rounded-pill px-3 py-1 font-monospace small">ID: {{ $group['id'] }}</span>
                                    <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold" onclick="openTambahHalamanWithCategory('{{ $group['id'] }}')">
                                        <i class="fas fa-file-circle-plus me-1"></i>+ Tulis Halaman di {{ $group['label'] }}
                                    </button>
                                </div>
                            </div>

                            <!-- Tabel Sub Menu -->
                            <div class="table-responsive mb-2">
                                <table class="table table-sm align-middle mb-0" id="table-sub-{{ $group['id'] }}">
                                    <thead class="table-light">
                                        <tr class="small text-slate-600">
                                            <th width="35" class="text-center">#</th>
                                            <th width="240">Nama Sub-Menu <span class="text-danger">*</span></th>
                                            <th width="240">Tautan / URL <span class="text-danger">*</span></th>
                                            <th>Keterangan Singkat</th>
                                            <th width="160">Target</th>
                                            <th width="90" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="sub-items-body" data-group-index="{{ $gIdx }}" data-group-id="{{ $group['id'] }}">
                                        @foreach($group['items'] ?? [] as $iIdx => $item)
                                            @php
                                                $isHalamanUrl = str_starts_with($item['href'] ?? '', '/halaman/');
                                                $matchedHalaman = null;
                                                if ($isHalamanUrl && isset($halamanList)) {
                                                    $itemSlug = str_replace('/halaman/', '', $item['href']);
                                                    $matchedHalaman = $halamanList->firstWhere('slug', $itemSlug);
                                                }
                                            @endphp
                                            <tr class="sub-item-row">
                                                <td class="text-center text-slate-400 small fw-bold row-num">{{ $iIdx + 1 }}</td>
                                                <td>
                                                    <input type="text" name="nav_menus[groups][{{ $gIdx }}][items][{{ $iIdx }}][label]" class="form-control form-control-sm rounded-3" value="{{ $item['label'] }}" placeholder="Label sub menu..." required>
                                                    @if($isHalamanUrl)
                                                        <div class="mt-1">
                                                            <span class="badge rounded-pill" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 0.68rem;">
                                                                <i class="fas fa-file-lines me-1"></i>Halaman Konten
                                                            </span>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="text" name="nav_menus[groups][{{ $gIdx }}][items][{{ $iIdx }}][href]" class="form-control form-control-sm rounded-3 font-monospace" value="{{ $item['href'] }}" placeholder="/halaman atau https://..." required>
                                                </td>
                                                <td>
                                                    <input type="text" name="nav_menus[groups][{{ $gIdx }}][items][{{ $iIdx }}][desc]" class="form-control form-control-sm rounded-3" value="{{ $item['desc'] ?? '' }}" placeholder="Keterangan singkat...">
                                                </td>
                                                <td>
                                                    <select name="nav_menus[groups][{{ $gIdx }}][items][{{ $iIdx }}][target]" class="form-select form-select-sm rounded-3">
                                                        <option value="_self" {{ ($item['target'] ?? '_self') === '_self' ? 'selected' : '' }}>Tab Sama (_self)</option>
                                                        <option value="_blank" {{ ($item['target'] ?? '_self') === '_blank' ? 'selected' : '' }}>Tab Baru (_blank)</option>
                                                    </select>
                                                    <input type="hidden" name="nav_menus[groups][{{ $gIdx }}][items][{{ $iIdx }}][icon]" value="{{ $item['icon'] ?? 'fas fa-angle-right' }}">
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                                        @if($matchedHalaman)
                                                            <button type="button" class="btn btn-outline-success btn-sm rounded-pill p-1 px-2" onclick="openEditHalamanModal({{ json_encode($matchedHalaman) }})" title="Edit Isi Halaman Ini">
                                                                <i class="fas fa-pen-to-square fa-xs"></i>
                                                            </button>
                                                        @endif
                                                        @if($isHalamanUrl)
                                                            <a href="{{ url($item['href']) }}" target="_blank" class="btn btn-outline-info btn-sm rounded-pill p-1 px-2" title="Buka Halaman Publik">
                                                                <i class="fas fa-external-link-alt fa-xs"></i>
                                                            </a>
                                                        @endif
                                                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill p-1 px-2 btn-del-submenu" title="Hapus sub-menu ini">
                                                            <i class="fas fa-trash-can fa-xs"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Tombol Tambah Sub-Menu -->
                            <div class="pt-2 d-flex flex-wrap align-items-center gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-bold btn-add-submenu" data-group-index="{{ $gIdx }}" data-group-id="{{ $group['id'] }}">
                                    <i class="fas fa-link me-1"></i>+ Tambah Tautan Biasa
                                </button>
                                <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold" onclick="openTambahHalamanWithCategory('{{ $group['id'] }}')">
                                    <i class="fas fa-file-circle-plus me-1"></i>+ Tulis Halaman di {{ $group['label'] }}
                                </button>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>

        <!-- STICKY BOTTOM SAVE ACTION BAR -->
        <div class="btn-save-sticky">
            <div class="d-flex align-items-center gap-2 text-slate-600 small">
                <i class="fas fa-circle-info text-emerald-600"></i>
                <span>Perubahan akan langsung diterapkan ke seluruh halaman website publik.</span>
            </div>

            <button type="submit" class="btn btn-success rounded-pill px-5 py-2.5 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
                <i class="fas fa-floppy-disk"></i>
                <span>Simpan Semua Pengaturan</span>
            </button>
        </div>

    </form>

</div>

<!-- ========================================================
     MODAL TAMBAH SUB-MENU & BUAT HALAMAN BARU (KRAKSAAN WETAN STYLE)
======================================================== -->
<div class="modal fade" id="modalTambahHalaman" tabindex="-1" aria-labelledby="modalTambahHalamanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <form action="{{ route('admin.halaman.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header bg-emerald-50 border-bottom border-emerald-200 py-3 px-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-3 bg-emerald-600 text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="fas fa-file-circle-plus"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-slate-900 mb-0" id="modalTambahHalamanLabel">
                                Tambah Sub-Menu &amp; Tulis Halaman Baru
                            </h5>
                            <span class="text-slate-500 small">Konfigurasi sub-menu navigasi sekaligus isi konten halamannya</span>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 space-y-4">
                    
                    <!-- 1. Letak Menu Dropdown Navbar -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-slate-700">Letak Menu Dropdown Navbar <span class="text-danger">*</span></label>
                        <div class="row g-2" id="tambahKategoriOptions">
                            <div class="col-sm-6 col-md-3">
                                <label class="d-block p-2.5 rounded-3 border cursor-pointer text-center kat-choice-card" style="background: #f8fafc;">
                                    <input type="radio" name="kategori" value="profil" class="form-check-input me-1" checked>
                                    <span class="small fw-bold text-slate-800">Profil</span>
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <label class="d-block p-2.5 rounded-3 border cursor-pointer text-center kat-choice-card" style="background: #f8fafc;">
                                    <input type="radio" name="kategori" value="akademik" class="form-check-input me-1">
                                    <span class="small fw-bold text-slate-800">Akademik</span>
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <label class="d-block p-2.5 rounded-3 border cursor-pointer text-center kat-choice-card" style="background: #f8fafc;">
                                    <input type="radio" name="kategori" value="riset" class="form-check-input me-1">
                                    <span class="small fw-bold text-slate-800">Riset &amp; Lembaga</span>
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <label class="d-block p-2.5 rounded-3 border cursor-pointer text-center kat-choice-card" style="background: #f8fafc;">
                                    <input type="radio" name="kategori" value="informasi" class="form-check-input me-1">
                                    <span class="small fw-bold text-slate-800">Informasi</span>
                                </label>
                            </div>
                        </div>
                        <small class="text-muted d-block mt-1">Pilih dropdown tempat sub-menu ini akan muncul pada navigasi navbar.</small>
                    </div>

                    <!-- 2. Nama Sub-Menu & Slug URL -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="form-label small fw-bold text-slate-700">Nama Sub-Menu / Judul Halaman <span class="text-danger">*</span></label>
                            <input type="text" name="judul" id="tambah_judul" class="form-control rounded-3" placeholder="Contoh: Prestasi Mahasiswa / Mars Kampus" required oninput="generateSlugFromJudul(this.value, 'tambah_slug')">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-bold text-slate-700">Slug URL (/halaman/:slug) <span class="text-danger">*</span></label>
                            <input type="text" name="slug" id="tambah_slug" class="form-control rounded-3 font-monospace text-emerald-800" placeholder="prestasi-mahasiswa" required>
                        </div>
                    </div>

                    <!-- 3. Ringkasan Singkat -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-slate-700">Ringkasan Singkat (Opsional)</label>
                        <input type="text" name="ringkasan" class="form-control rounded-3" placeholder="Ringkasan 1-2 kalimat pengantar untuk pembaca...">
                        <small class="text-muted d-block mt-1">Ditampilkan sebagai kutipan pengantar beraksen di bagian atas artikel.</small>
                    </div>

                    <!-- 4. Foto Cover / Gambar Utama -->
                    <div class="mb-3 p-3 rounded-3 bg-light border">
                        <label class="form-label small fw-bold text-slate-700 mb-2">Foto Cover / Gambar Utama Halaman</label>
                        <div class="d-flex flex-column flex-sm-row align-items-center gap-3">
                            <div id="previewCoverTambah" class="rounded-3 border bg-white d-flex align-items-center justify-content-center overflow-hidden flex-shrink-0" style="width: 110px; height: 75px;">
                                <span class="text-muted small">Tanpa Foto</span>
                            </div>
                            <div class="flex-grow-1 w-100">
                                <input type="file" name="gambar" class="form-control form-control-sm rounded-3" accept="image/png, image/jpeg, image/jpg, image/webp" onchange="previewImage(this, 'previewCoverTambah')">
                                <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP (Maks 10MB). Ditampilkan di atas konten halaman.</small>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Konten Paragraf & Isi Halaman -->
                    <div class="mb-3">
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-1">
                            <label class="form-label small fw-bold text-slate-700 mb-0">Konten Paragraf &amp; Isi Halaman <span class="text-danger">*</span></label>
                            <span class="text-emerald-700 small" style="font-size: 0.76rem;">Gunakan tombol toolbar di bawah untuk format teks</span>
                        </div>

                        <!-- Formatting Toolbar -->
                        <div class="d-flex flex-wrap align-items-center gap-1 mb-2 p-1.5 bg-light rounded-3 border">
                            <button type="button" class="btn btn-sm btn-white border px-2 py-1 fw-bold" onclick="insertFormat('b', 'tambah_konten')" title="Tebal (Bold)"><b>B</b></button>
                            <button type="button" class="btn btn-sm btn-white border px-2 py-1 fst-italic" onclick="insertFormat('i', 'tambah_konten')" title="Miring (Italic)"><i>I</i></button>
                            <button type="button" class="btn btn-sm btn-white border px-2 py-1 fw-bold" onclick="insertFormat('h2', 'tambah_konten')" title="Sub-Judul (H2)">H2</button>
                            <button type="button" class="btn btn-sm btn-white border px-2 py-1 fw-bold" onclick="insertFormat('h3', 'tambah_konten')" title="Poin Judul (H3)">H3</button>
                            <button type="button" class="btn btn-sm btn-white border px-2 py-1" onclick="insertFormat('ul', 'tambah_konten')" title="Daftar Poin (List Bullet)"><i class="fas fa-list-ul"></i></button>
                            <button type="button" class="btn btn-sm btn-white border px-2 py-1" onclick="insertFormat('ol', 'tambah_konten')" title="Daftar Nomor (List Number)"><i class="fas fa-list-ol"></i></button>
                            <button type="button" class="btn btn-sm btn-white border px-2 py-1" onclick="insertFormat('quote', 'tambah_konten')" title="Kutipan (Blockquote)"><i class="fas fa-quote-left"></i></button>
                            <button type="button" class="btn btn-sm btn-white border px-2 py-1" onclick="insertFormat('table', 'tambah_konten')" title="Tabel Konten"><i class="fas fa-table"></i></button>
                            <button type="button" class="btn btn-sm btn-white border px-2 py-1" onclick="insertFormat('link', 'tambah_konten')" title="Tautan Link"><i class="fas fa-link"></i></button>
                        </div>

                        <textarea name="konten" id="tambah_konten" rows="8" class="form-control rounded-3" placeholder="Tuliskan isi informasi lengkap untuk halaman ini (paragraf, poin penting, tabel atau deskripsi)..." style="font-size: 0.9rem; line-height: 1.6;"></textarea>
                    </div>

                    <!-- 6. Opsi Status & Urutan -->
                    <div class="row g-3 align-items-center pt-2 border-top">
                        <div class="col-md-7">
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="tambah_ke_navbar" id="tambahNavbarSwitch" value="1" checked style="cursor: pointer;">
                                <label class="form-check-label small fw-bold text-slate-800" for="tambahNavbarSwitch">
                                    Otomatis Pasang di Menu Navigasi Navbar
                                </label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="aktif" id="tambahAktifSwitch" value="1" checked style="cursor: pointer;">
                                <label class="form-check-label small fw-bold text-slate-800" for="tambahAktifSwitch">
                                    Publikasikan Halaman Ini (Status Aktif)
                                </label>
                            </div>
                        </div>
                        <div class="col-md-5 d-flex align-items-center justify-content-md-end gap-2">
                            <span class="small fw-bold text-slate-700">Urutan Tampil:</span>
                            <input type="number" name="urutan" class="form-control form-control-sm text-center rounded-3" style="width: 80px;" value="{{ (isset($halamanList) ? $halamanList->count() : 0) + 1 }}" min="0">
                        </div>
                    </div>

                </div>

                <div class="modal-footer bg-light border-top py-3 px-4 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold rounded-pill px-5 shadow-xs d-inline-flex align-items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        <span>Terbitkan Halaman &amp; Pasang di Menu</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- ========================================================
     MODAL EDIT HALAMAN KUSTOM
======================================================== -->
<div class="modal fade" id="modalEditHalaman" tabindex="-1" aria-labelledby="modalEditHalamanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <form id="formEditHalaman" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header bg-emerald-50 border-bottom border-emerald-200 py-3 px-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-3 bg-emerald-600 text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-slate-900 mb-0" id="modalEditHalamanLabel">
                                Edit Isi Sub-Menu &amp; Halaman Konten
                            </h5>
                            <span class="text-slate-500 small">Perbarui judul, tata letak menu dropdown, atau isi konten artikel</span>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 space-y-4">
                    
                    <!-- 1. Letak Menu Dropdown Navbar -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-slate-700">Letak Menu Dropdown Navbar <span class="text-danger">*</span></label>
                        <select name="kategori" id="edit_kategori" class="form-select rounded-3" required>
                            <option value="profil">Dropdown Profil</option>
                            <option value="akademik">Dropdown Akademik</option>
                            <option value="riset">Dropdown Riset &amp; Lembaga</option>
                            <option value="informasi">Dropdown Informasi</option>
                        </select>
                    </div>

                    <!-- 2. Nama Sub-Menu & Slug URL -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="form-label small fw-bold text-slate-700">Nama Sub-Menu / Judul Halaman <span class="text-danger">*</span></label>
                            <input type="text" name="judul" id="edit_judul" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-bold text-slate-700">Slug URL (/halaman/:slug) <span class="text-danger">*</span></label>
                            <input type="text" name="slug" id="edit_slug" class="form-control rounded-3 font-monospace text-emerald-800" required>
                        </div>
                    </div>

                    <!-- 3. Ringkasan Singkat -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-slate-700">Ringkasan Singkat (Opsional)</label>
                        <input type="text" name="ringkasan" id="edit_ringkasan" class="form-control rounded-3">
                    </div>

                    <!-- 4. Foto Cover / Gambar Utama -->
                    <div class="mb-3 p-3 rounded-3 bg-light border">
                        <label class="form-label small fw-bold text-slate-700 mb-2">Foto Cover / Gambar Utama Halaman</label>
                        <div class="d-flex flex-column flex-sm-row align-items-center gap-3">
                            <div id="previewCoverEdit" class="rounded-3 border bg-white d-flex align-items-center justify-content-center overflow-hidden flex-shrink-0" style="width: 110px; height: 75px;">
                                <span class="text-muted small">Tanpa Foto</span>
                            </div>
                            <div class="flex-grow-1 w-100">
                                <input type="file" name="gambar" class="form-control form-control-sm rounded-3 mb-2" accept="image/png, image/jpeg, image/jpg, image/webp" onchange="previewImage(this, 'previewCoverEdit')">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="hapus_gambar" id="hapusGambarCheckbox" value="1">
                                    <label class="form-check-label small text-danger" for="hapusGambarCheckbox">
                                        Hapus gambar cover yang ada
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Konten Paragraf & Isi Halaman -->
                    <div class="mb-3">
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-1">
                            <label class="form-label small fw-bold text-slate-700 mb-0">Konten Paragraf &amp; Isi Halaman</label>
                            <span class="text-emerald-700 small" style="font-size: 0.76rem;">Gunakan tombol toolbar di bawah untuk format teks</span>
                        </div>

                        <!-- Formatting Toolbar -->
                        <div class="d-flex flex-wrap align-items-center gap-1 mb-2 p-1.5 bg-light rounded-3 border">
                            <button type="button" class="btn btn-sm btn-white border px-2 py-1 fw-bold" onclick="insertFormat('b', 'edit_konten')" title="Tebal (Bold)"><b>B</b></button>
                            <button type="button" class="btn btn-sm btn-white border px-2 py-1 fst-italic" onclick="insertFormat('i', 'edit_konten')" title="Miring (Italic)"><i>I</i></button>
                            <button type="button" class="btn btn-sm btn-white border px-2 py-1 fw-bold" onclick="insertFormat('h2', 'edit_konten')" title="Sub-Judul (H2)">H2</button>
                            <button type="button" class="btn btn-sm btn-white border px-2 py-1 fw-bold" onclick="insertFormat('h3', 'edit_konten')" title="Poin Judul (H3)">H3</button>
                            <button type="button" class="btn btn-sm btn-white border px-2 py-1" onclick="insertFormat('ul', 'edit_konten')" title="Daftar Poin (List Bullet)"><i class="fas fa-list-ul"></i></button>
                            <button type="button" class="btn btn-sm btn-white border px-2 py-1" onclick="insertFormat('ol', 'edit_konten')" title="Daftar Nomor (List Number)"><i class="fas fa-list-ol"></i></button>
                            <button type="button" class="btn btn-sm btn-white border px-2 py-1" onclick="insertFormat('quote', 'edit_konten')" title="Kutipan (Blockquote)"><i class="fas fa-quote-left"></i></button>
                            <button type="button" class="btn btn-sm btn-white border px-2 py-1" onclick="insertFormat('table', 'edit_konten')" title="Tabel Konten"><i class="fas fa-table"></i></button>
                            <button type="button" class="btn btn-sm btn-white border px-2 py-1" onclick="insertFormat('link', 'edit_konten')" title="Tautan Link"><i class="fas fa-link"></i></button>
                        </div>

                        <textarea name="konten" id="edit_konten" rows="8" class="form-control rounded-3" style="font-size: 0.9rem; line-height: 1.6;"></textarea>
                    </div>

                    <!-- 6. Opsi Status & Urutan -->
                    <div class="row g-3 align-items-center pt-2 border-top">
                        <div class="col-md-7">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="aktif" id="edit_aktif" value="1" style="cursor: pointer;">
                                <label class="form-check-label small fw-bold text-slate-800" for="edit_aktif">
                                    Publikasikan Halaman Ini (Status Aktif)
                                </label>
                            </div>
                        </div>
                        <div class="col-md-5 d-flex align-items-center justify-content-md-end gap-2">
                            <span class="small fw-bold text-slate-700">Urutan Tampil:</span>
                            <input type="number" name="urutan" id="edit_urutan" class="form-control form-control-sm text-center rounded-3" style="width: 80px;" min="0">
                        </div>
                    </div>

                </div>

                <div class="modal-footer bg-light border-top py-3 px-4 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-dark fw-bold rounded-pill px-5 shadow-xs d-inline-flex align-items-center gap-2">
                        <i class="fas fa-save"></i>
                        <span>Simpan Perubahan Halaman</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Form Tersembunyi Hapus Halaman -->
<form id="formDeleteHalaman" action="" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Otomatis aktifkan tab menu jika URL hash adalah #tab-navmenu
    if (window.location.hash === '#tab-navmenu') {
        const tabBtn = document.getElementById('tab-btn-navmenu');
        if (tabBtn) {
            const trigger = new bootstrap.Tab(tabBtn);
            trigger.show();
            setTimeout(() => {
                tabBtn.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }, 200);
        }
    }

    // Tambah baris sub-menu baru secara dinamis
    document.querySelectorAll('.btn-add-submenu').forEach(btn => {
        btn.addEventListener('click', function () {
            const gIdx = this.getAttribute('data-group-index');
            const gId = this.getAttribute('data-group-id');
            const tbody = document.querySelector(`.sub-items-body[data-group-id="${gId}"]`);
            if (!tbody) return;

            const currentCount = tbody.querySelectorAll('.sub-item-row').length;
            const newIndex = currentCount;

            const tr = document.createElement('tr');
            tr.className = 'sub-item-row';
            tr.innerHTML = `
                <td class="text-center text-slate-400 small fw-bold row-num">${newIndex + 1}</td>
                <td>
                    <input type="text" name="nav_menus[groups][${gIdx}][items][${newIndex}][label]" class="form-control form-control-sm rounded-3" placeholder="Nama sub-menu baru..." required>
                </td>
                <td>
                    <input type="text" name="nav_menus[groups][${gIdx}][items][${newIndex}][href]" class="form-control form-control-sm rounded-3 font-monospace" placeholder="/contoh atau https://..." required>
                </td>
                <td>
                    <input type="text" name="nav_menus[groups][${gIdx}][items][${newIndex}][desc]" class="form-control form-control-sm rounded-3" placeholder="Keterangan singkat...">
                </td>
                <td>
                    <select name="nav_menus[groups][${gIdx}][items][${newIndex}][target]" class="form-select form-select-sm rounded-3">
                        <option value="_self" selected>Tab Sama (_self)</option>
                        <option value="_blank">Tab Baru (_blank)</option>
                    </select>
                    <input type="hidden" name="nav_menus[groups][${gIdx}][items][${newIndex}][icon]" value="fas fa-angle-right">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm rounded-pill p-1 px-2 btn-del-submenu" title="Hapus sub-menu ini">
                        <i class="fas fa-trash-can fa-xs"></i>
                    </button>
                </td>
            `;

            tbody.appendChild(tr);

            tr.querySelector('.btn-del-submenu').addEventListener('click', function () {
                tr.remove();
                renumberRows(tbody);
            });
        });
    });

    // Event listener hapus baris sub-menu awal
    document.querySelectorAll('.btn-del-submenu').forEach(btn => {
        btn.addEventListener('click', function () {
            const tr = this.closest('.sub-item-row');
            const tbody = tr.closest('.sub-items-body');
            tr.remove();
            renumberRows(tbody);
        });
    });

    function renumberRows(tbody) {
        if (!tbody) return;
        tbody.querySelectorAll('.sub-item-row').forEach((row, idx) => {
            const numEl = row.querySelector('.row-num');
            if (numEl) numEl.innerText = idx + 1;
        });
    }
});

// Helper: Auto generate slug dari judul
function generateSlugFromJudul(text, targetId) {
    const slug = text.toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');
    const target = document.getElementById(targetId);
    if (target) {
        target.value = slug;
    }
}

// Helper: Live preview foto cover
function previewImage(input, previewContainerId) {
    const container = document.getElementById(previewContainerId);
    if (!container) return;

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            container.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">`;
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        container.innerHTML = `<span class="text-muted small">Tanpa Foto</span>`;
    }
}

// Helper: Insert formatted markup to textarea
function insertFormat(type, textareaId) {
    const textarea = document.getElementById(textareaId);
    if (!textarea) return;

    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const text = textarea.value;
    const selected = text.substring(start, end);

    let replacement = '';
    switch (type) {
        case 'b':
            replacement = selected ? `<strong>${selected}</strong>` : '<strong>Teks Tebal</strong>';
            break;
        case 'i':
            replacement = selected ? `<em>${selected}</em>` : '<em>Teks Miring</em>';
            break;
        case 'h2':
            replacement = selected ? `<h2>${selected}</h2>\n` : '<h2>Sub Judul Halaman</h2>\n';
            break;
        case 'h3':
            replacement = selected ? `<h3>${selected}</h3>\n` : '<h3>Poin Penting</h3>\n';
            break;
        case 'ul':
            replacement = `<ul>\n  <li>Poin pertama</li>\n  <li>Poin kedua</li>\n</ul>\n`;
            break;
        case 'ol':
            replacement = `<ol>\n  <li>Langkah pertama</li>\n  <li>Langkah kedua</li>\n</ol>\n`;
            break;
        case 'quote':
            replacement = `<blockquote>"${selected || 'Kutipan penting institusi...'}"</blockquote>\n`;
            break;
        case 'table':
            replacement = `<table class="table table-bordered">\n  <thead>\n    <tr><th>Kolom 1</th><th>Kolom 2</th></tr>\n  </thead>\n  <tbody>\n    <tr><td>Data A</td><td>Data B</td></tr>\n  </tbody>\n</table>\n`;
            break;
        case 'link':
            replacement = `<a href="https://..." target="_blank">${selected || 'Klik di sini'}</a>`;
            break;
        default:
            replacement = selected;
    }

    textarea.value = text.substring(0, start) + replacement + text.substring(end);
    textarea.focus();
    textarea.setSelectionRange(start + replacement.length, start + replacement.length);
}

// Buka modal tambah dengan pre-selected category
function openTambahHalamanWithCategory(catId) {
    const radio = document.querySelector(`input[name="kategori"][value="${catId}"]`);
    if (radio) radio.checked = true;

    const modalEl = document.getElementById('modalTambahHalaman');
    if (modalEl) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
}

// Buka modal edit halaman
function openEditHalamanModal(hal) {
    const form = document.getElementById('formEditHalaman');
    if (!form || !hal) return;

    form.action = `/admin/halaman-kustom/${hal.id}`;
    document.getElementById('edit_judul').value = hal.judul || '';
    document.getElementById('edit_slug').value = hal.slug || '';
    document.getElementById('edit_kategori').value = hal.kategori || 'profil';
    document.getElementById('edit_ringkasan').value = hal.ringkasan || '';
    document.getElementById('edit_konten').value = hal.konten || '';
    document.getElementById('edit_urutan').value = hal.urutan || 0;
    document.getElementById('edit_aktif').checked = Boolean(hal.aktif);

    const prevContainer = document.getElementById('previewCoverEdit');
    if (prevContainer) {
        if (hal.gambar) {
            const imgUrl = (hal.gambar.startsWith('http')) ? hal.gambar : `/uploads/${hal.gambar}`;
            prevContainer.innerHTML = `<img src="${imgUrl}" alt="Cover" style="width: 100%; height: 100%; object-fit: cover;">`;
        } else {
            prevContainer.innerHTML = `<span class="text-muted small">Tanpa Foto</span>`;
        }
    }

    const hapusBox = document.getElementById('hapusGambarCheckbox');
    if (hapusBox) hapusBox.checked = false;

    const modalEl = document.getElementById('modalEditHalaman');
    if (modalEl) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
}

// Konfirmasi hapus halaman kustom
function confirmDeleteHalaman(id, title) {
    Swal.fire({
        title: 'Hapus Halaman & Sub-Menu?',
        html: `Apakah Anda yakin ingin menghapus halaman <strong>"${title}"</strong>?<br><span class="text-muted small">Tautan ke halaman ini juga akan otomatis dilepas dari navigasi navbar.</span>`,
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
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('formDeleteHalaman');
            if (form) {
                form.action = `/admin/halaman-kustom/${id}`;
                form.submit();
            }
        }
    });
}
</script>
@endpush

@endsection
