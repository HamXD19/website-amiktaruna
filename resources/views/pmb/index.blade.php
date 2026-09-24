@extends('layouts.main')

@section('content')

@php
    $portalUrl = $pmb->link_portal ?? 'https://pmb.amiktaruna.ac.id';
    $rawWa = !empty($pmb->no_whatsapp) ? $pmb->no_whatsapp : ($setting->whatsapp ?? $setting->no_hp ?? '081234567890');
    $cleanWa = preg_replace('/[^0-9]/', '', $rawWa);
    if (str_starts_with($cleanWa, '0')) {
        $cleanWa = '62' . substr($cleanWa, 1);
    }
    $waConsultUrl = "https://wa.me/{$cleanWa}?text=" . rawurlencode("Halo Panitia PMB AMIK Taruna, saya ingin berkonsultasi mengenai pendaftaran mahasiswa baru.");
    
    // Dynamic lists from database
    $jalurList = $pmb->jalur_pendaftaran ?? [];
    $alurList = $pmb->alur_pendaftaran ?? [];
    $jadwalList = $pmb->jadwal_gelombang ?? [];
    $syaratList = $pmb->persyaratan_berkas ?? [];
    $faqList = $pmb->faq_list ?? [];
@endphp

<style>
    /* =========================================================
       PMB PAGE - FULL DINAMIS & EMERALD GLASSMORPHISM
    ========================================================= */

    .pmb-hero-wrapper {
        background: linear-gradient(135deg, rgba(3, 29, 17, 0.95), rgba(6, 44, 27, 0.92));
        border: 1px solid rgba(16, 185, 129, 0.25);
        border-radius: 32px;
        padding: 50px 32px;
        box-shadow: 0 20px 50px -10px rgba(0, 0, 0, 0.5);
        position: relative;
        overflow: hidden;
        margin-bottom: 50px;
    }

    .pmb-hero-wrapper::before {
        content: '';
        position: absolute;
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.18) 0%, transparent 70%);
        top: -120px;
        right: -80px;
        pointer-events: none;
    }

    .pmb-card {
        background: rgba(4, 26, 16, 0.88);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(16, 185, 129, 0.22);
        border-radius: 24px;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.4);
        color: #f1f5f9;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .pmb-card:hover {
        border-color: rgba(52, 211, 153, 0.45);
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5), 0 0 20px rgba(16, 185, 129, 0.15);
    }

    .pmb-badge-gold {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(217, 119, 6, 0.3));
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.4);
    }

    .pmb-badge-emerald {
        background: rgba(16, 185, 129, 0.18);
        color: #6ee7b7;
        border: 1px solid rgba(16, 185, 129, 0.35);
    }

    .btn-pmb-primary {
        background: linear-gradient(135deg, #10b981, #059669);
        color: #ffffff !important;
        font-weight: 700;
        border-radius: 50px;
        padding: 14px 32px;
        border: none;
        transition: all 0.25s ease;
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .btn-pmb-primary:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #059669, #047857);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.5);
    }

    .btn-pmb-secondary {
        background: rgba(2, 20, 12, 0.7);
        color: #6ee7b7 !important;
        font-weight: 600;
        border-radius: 50px;
        padding: 13px 28px;
        border: 1px solid rgba(16, 185, 129, 0.35);
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-pmb-secondary:hover {
        background: rgba(16, 185, 129, 0.15);
        border-color: #34d399;
        color: #ffffff !important;
        transform: translateY(-2px);
    }

    /* Step Timeline Circles */
    .step-number-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #059669, #047857);
        color: #ffffff;
        font-weight: 800;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #34d399;
        box-shadow: 0 0 15px rgba(52, 211, 153, 0.3);
        flex-shrink: 0;
    }

    /* Accordion FAQ Styling */
    .pmb-accordion .accordion-item {
        background: rgba(4, 26, 16, 0.85);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 16px !important;
        margin-bottom: 12px;
        overflow: hidden;
    }

    .pmb-accordion .accordion-button {
        background: rgba(4, 26, 16, 0.85);
        color: #ffffff;
        font-weight: 700;
        font-size: 0.95rem;
        padding: 16px 20px;
        box-shadow: none !important;
    }

    .pmb-accordion .accordion-button:not(.collapsed) {
        background: rgba(6, 44, 27, 0.95);
        color: #34d399;
        border-bottom: 1px solid rgba(16, 185, 129, 0.2);
    }

    .pmb-accordion .accordion-button::after {
        filter: brightness(0) invert(1);
    }

    .pmb-accordion .accordion-body {
        color: #cbd5e1;
        font-size: 0.9rem;
        line-height: 1.7;
        background: rgba(2, 19, 11, 0.8);
        padding: 20px;
    }
</style>

<div class="container py-4 py-lg-5">

    <!-- 1. HERO SECTION PMB (DINAMIS DARI ADMIN) -->
    <section class="pmb-hero-wrapper text-white">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <!-- Status Badge -->
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 mb-3 rounded-pill pmb-badge-emerald fw-bold small">
                    <span class="w-2 h-2 rounded-circle bg-emerald-400 animate-ping"></span>
                    <span>PMB TA {{ date('Y') }}/{{ date('Y') + 1 }} • {{ strtoupper($pmb->status_gelombang ?? 'DIBUKA') }}</span>
                </div>

                <h1 class="fw-bold mb-3" style="font-size: clamp(2rem, 3.8vw, 3rem); line-height: 1.15; letter-spacing: -0.5px;">
                    {{ $pmb->judul ?? 'Penerimaan Mahasiswa Baru AMIK Taruna' }}
                </h1>

                @if(!empty($pmb->subjudul))
                    <p class="text-emerald-300 fw-semibold mb-2" style="font-size: 1.1rem;">
                        {{ $pmb->subjudul }}
                    </p>
                @endif

                <p class="text-slate-200 mb-4" style="font-size: 1.02rem; line-height: 1.7; max-width: 620px;">
                    {{ $pmb->deskripsi ?? 'Wujudkan impian karir di industri digital bersama AMIK Taruna. Kuliah vokasi 3 tahun siap kerja, kurikulum terapan berbasis industri IT, dan gelar resmi A.Md.' }}
                </p>

                <!-- Action CTA Buttons -->
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <a href="{{ $portalUrl }}" target="_blank" class="btn-pmb-primary">
                        <i class="fas fa-paper-plane"></i>
                        <span>Daftar Online Sekarang</span>
                    </a>

                    <a href="{{ $waConsultUrl }}" target="_blank" class="btn-pmb-secondary">
                        <i class="fab fa-whatsapp fs-5 text-success"></i>
                        <span>Konsultasi WhatsApp</span>
                    </a>

                    @if(!empty($pmb->brosur_file))
                        <a href="{{ asset('uploads/pmb/' . $pmb->brosur_file) }}" target="_blank" download class="btn-pmb-secondary">
                            <i class="fas fa-download text-warning"></i>
                            <span>Unduh Brosur PMB</span>
                        </a>
                    @endif
                </div>

                <!-- Verified Pillars -->
                <div class="mt-4 pt-3 border-top border-emerald-500/20 d-flex flex-wrap align-items-center gap-3 gap-md-4 text-slate-300 small">
                    <div class="d-flex align-items-center gap-1.5">
                        <i class="fas fa-check-circle text-emerald-400"></i>
                        <span>Terakreditasi BAN-PT</span>
                    </div>
                    <div class="d-flex align-items-center gap-1.5">
                        <i class="fas fa-award text-amber-400"></i>
                        <span>Beasiswa KIP Kuliah</span>
                    </div>
                    <div class="d-flex align-items-center gap-1.5">
                        <i class="fas fa-certificate text-cyan-400"></i>
                        <span>Sertifikasi BNSP</span>
                    </div>
                </div>
            </div>

            <!-- Hero Right: Live Status Box (Dinamis dari Admin) -->
            <div class="col-lg-5">
                <div class="pmb-card p-4 p-md-5 text-center position-relative">
                    <div class="d-inline-flex p-3 rounded-2xl bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 mb-3 fs-2">
                        <i class="fas fa-user-graduate"></i>
                    </div>

                    <h3 class="fs-4 fw-bold text-white mb-1">
                        {{ $pmb->nama_gelombang ?? 'Gelombang 2' }} Aktif
                    </h3>
                    <p class="text-slate-300 small mb-4">
                        {{ $pmb->kuota_info ?? 'Pendaftaran Jalur Reguler & Beasiswa KIP Kuliah siap diproses.' }}
                    </p>

                    <!-- Quick Highlight Badges -->
                    <div class="p-3 rounded-2xl bg-black/30 border border-emerald-500/20 mb-4 text-start space-y-2">
                        <div class="d-flex align-items-center justify-content-between text-xs py-1 border-bottom border-white/10">
                            <span class="text-slate-400">Periode Seleksi:</span>
                            <span class="text-emerald-300 fw-bold">{{ $pmb->periode_gelombang ?? 'Mei s/d Juli 2026' }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between text-xs py-1 border-bottom border-white/10">
                            <span class="text-slate-400">Jenjang Kuliah:</span>
                            <span class="text-white fw-bold">Diploma 3 (Gelar A.Md.)</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between text-xs py-1">
                            <span class="text-slate-400">Status Gelombang:</span>
                            <span class="text-amber-300 fw-bold">{{ $pmb->status_gelombang ?? 'Sedang Berlangsung' }}</span>
                        </div>
                    </div>

                    <a href="{{ $portalUrl }}" target="_blank" class="btn btn-success w-100 rounded-pill py-2.5 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2">
                        <span>Buka Formulir Pendaftaran</span>
                        <i class="fas fa-arrow-right small"></i>
                    </a>

                    @auth
                        <div class="mt-3">
                            <a href="{{ route('pmb.index') }}" class="btn btn-sm btn-outline-warning rounded-pill px-3 py-1" style="font-size: 11px;">
                                <i class="fas fa-edit me-1"></i> Edit Halaman PMB di Admin
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- 2. JALUR PENDAFTARAN (DINAMIS DARI ADMIN) -->
    @if(count($jalurList) > 0)
        <section class="mb-5">
            <div class="text-center mb-4">
                <span class="d-inline-block pmb-badge-emerald px-3 py-1 rounded-pill small fw-bold mb-2">
                    PILIHAN SELEKSI
                </span>
                <h2 class="fs-2 fw-bold text-white mb-2">
                    Jalur Masuk Mahasiswa Baru
                </h2>
                <p class="text-slate-400 small mx-auto" style="max-width: 580px;">
                    Pilih jalur penerimaan yang paling sesuai dengan profil, prestasi, atau kebutuhan pembiayaan Anda.
                </p>
            </div>

            <div class="row g-4">
                @foreach($jalurList as $j)
                    <div class="col-md-6 col-lg-3">
                        <div class="pmb-card h-100 p-4 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    @if(!empty($j['badge']))
                                        <span class="badge pmb-badge-gold rounded-pill px-2.5 py-1 text-xs">{{ $j['badge'] }}</span>
                                    @else
                                        <span></span>
                                    @endif
                                    <i class="{{ $j['ikon'] ?? 'fas fa-graduation-cap' }} text-emerald-400 fs-4"></i>
                                </div>
                                <h4 class="fs-5 fw-bold text-white mb-2">{{ $j['nama'] }}</h4>
                                <p class="text-slate-300 small leading-relaxed mb-3">
                                    {{ $j['deskripsi'] }}
                                </p>
                            </div>
                            @if(!empty($j['syarat']))
                                <ul class="text-slate-400 small ps-3 mb-0" style="font-size: 11px;">
                                    @foreach(explode(',', $j['syarat']) as $s)
                                        <li>{{ trim($s) }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- 3. PROGRAM STUDI PILIHAN (D3 DENGAN GELAR A.MD.) -->
    <section class="mb-5">
        <div class="text-center mb-4">
            <span class="d-inline-block pmb-badge-emerald px-3 py-1 rounded-pill small fw-bold mb-2">
                PROGRAM VOKASI UNGGULAN
            </span>
            <h2 class="fs-2 fw-bold text-white mb-2">
                Pilihan Program Studi Diploma Tiga (D3)
            </h2>
            <p class="text-slate-400 small mx-auto" style="max-width: 600px;">
                Semua program studi berorientasi keahlian praktis, sertifikasi BNSP, dan lulus dengan gelar resmi <strong>Ahli Madya (A.Md.)</strong>.
            </p>
        </div>

        <div class="row g-4">
            @if(isset($programStudis) && $programStudis->count() > 0)
                @foreach($programStudis as $prodi)
                    <div class="col-md-6 col-lg-4">
                        <div class="pmb-card h-100 p-4 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <!-- GELAR RESMI WAJIB A.Md. SESUAI KETETAPAN -->
                                    <span class="badge pmb-badge-emerald rounded-pill px-2.5 py-1 text-xs fw-bold">
                                        Jenjang D3 • Gelar A.Md.
                                    </span>
                                    <span class="badge bg-black/40 text-emerald-400 border border-emerald-500/25 rounded-pill px-2.5 py-1 text-xs">
                                        Akreditasi {{ $prodi->akreditasi ?? 'Baik' }}
                                    </span>
                                </div>

                                <h3 class="fs-5 fw-bold text-white mt-2 mb-2">
                                    {{ $prodi->nama_prodi }}
                                </h3>

                                <p class="text-slate-300 small leading-relaxed mb-4">
                                    {{ $prodi->deskripsi ?? 'Mempersiapkan tenaga ahli vokasi teknologi informasi dengan kompetensi terapan modern dan siap terserap industri.' }}
                                </p>
                            </div>

                            <div class="pt-3 border-top border-emerald-500/15 d-flex align-items-center justify-content-between">
                                <a href="{{ url('/akademik/' . ($prodi->slug ?: $prodi->id)) }}" class="text-emerald-300 small fw-bold text-decoration-none d-inline-flex align-items-center gap-1">
                                    <span>Kurikulum &amp; Profil</span>
                                    <i class="fas fa-arrow-right fa-xs"></i>
                                </a>

                                <a href="{{ $portalUrl }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3 text-white border-emerald-400/40">
                                    Pilih Prodi Ini
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Fallback 3 prodi default jika kosong -->
                <div class="col-md-4">
                    <div class="pmb-card h-100 p-4 d-flex flex-column justify-content-between">
                        <div>
                            <span class="badge pmb-badge-emerald rounded-pill px-2.5 py-1 text-xs fw-bold mb-2">Jenjang D3 • Gelar A.Md.</span>
                            <h3 class="fs-5 fw-bold text-white mb-2">Sistem Informasi</h3>
                            <p class="text-slate-300 small">Spesialisasi rekayasa proses bisnis, implementasi database, dan sistem informasi manajemen korporasi.</p>
                        </div>
                        <a href="{{ $portalUrl }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3 mt-3 text-white border-emerald-400/40">Daftar Prodi Ini</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pmb-card h-100 p-4 d-flex flex-column justify-content-between">
                        <div>
                            <span class="badge pmb-badge-emerald rounded-pill px-2.5 py-1 text-xs fw-bold mb-2">Jenjang D3 • Gelar A.Md.</span>
                            <h3 class="fs-5 fw-bold text-white mb-2">Teknologi Informasi</h3>
                            <p class="text-slate-300 small">Fokus infrastruktur jaringan komputer, sistem keamanan, komputasi awan, dan perakitan sistem terapan.</p>
                        </div>
                        <a href="{{ $portalUrl }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3 mt-3 text-white border-emerald-400/40">Daftar Prodi Ini</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pmb-card h-100 p-4 d-flex flex-column justify-content-between">
                        <div>
                            <span class="badge pmb-badge-emerald rounded-pill px-2.5 py-1 text-xs fw-bold mb-2">Jenjang D3 • Gelar A.Md.</span>
                            <h3 class="fs-5 fw-bold text-white mb-2">Sistem Informasi Akuntansi</h3>
                            <p class="text-slate-300 small">Kombinasi audit akuntansi dengan otomasi software keuangan digital untuk instansi dan perbankan modern.</p>
                        </div>
                        <a href="{{ $portalUrl }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3 mt-3 text-white border-emerald-400/40">Daftar Prodi Ini</a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- 4. ALUR PENDAFTARAN (DINAMIS DARI ADMIN) -->
    @if(count($alurList) > 0)
        <section class="mb-5">
            <div class="text-center mb-4">
                <span class="d-inline-block pmb-badge-emerald px-3 py-1 rounded-pill small fw-bold mb-2">
                    PANDUAN LANGKAH
                </span>
                <h2 class="fs-2 fw-bold text-white mb-2">
                    Alur Pendaftaran Mahasiswa Baru
                </h2>
                <p class="text-slate-400 small mx-auto" style="max-width: 580px;">
                    Proses registrasi berlangsung sepenuhnya secara digital, cepat, dan transparan.
                </p>
            </div>

            <div class="row g-4">
                @foreach($alurList as $idx => $a)
                    <div class="col-md-6 col-lg-3">
                        <div class="pmb-card h-100 p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="step-number-circle">{{ $a['langkah'] ?? ($idx + 1) }}</div>
                                <span class="text-emerald-400 small fw-bold text-uppercase">Tahap {{ $idx + 1 }}</span>
                            </div>
                            <h4 class="fs-5 fw-bold text-white mb-2">{{ $a['judul'] }}</h4>
                            <p class="text-slate-300 small leading-relaxed mb-0">
                                {{ $a['deskripsi'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- 5. SYARAT BERKAS & TIMELINE GELOMBANG (DINAMIS DARI ADMIN) -->
    <section class="mb-5">
        <div class="row g-4">
            <!-- KOLOM KIRI: PERSYARATAN BERKAS -->
            <div class="col-lg-6">
                <div class="pmb-card h-100 p-4 p-md-5">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="fas fa-clipboard-check text-emerald-400 fs-4"></i>
                        <h3 class="fs-4 fw-bold text-white mb-0">Persyaratan Dokumen</h3>
                    </div>
                    <p class="text-slate-400 small mb-4">
                        Siapkan dokumen berikut dalam format digital (scan/foto jelas) sebelum mengisi formulir:
                    </p>

                    <div class="space-y-3">
                        @forelse($syaratList as $sb)
                            <div class="d-flex align-items-start gap-3 p-3 rounded-2xl bg-black/25 border border-emerald-500/20">
                                <i class="{{ $sb['ikon'] ?? 'fas fa-file-alt' }} text-emerald-400 mt-1"></i>
                                <div>
                                    <span class="fw-bold text-white d-block small">{{ $sb['judul'] }}</span>
                                    <span class="text-slate-400" style="font-size: 11px;">{{ $sb['keterangan'] ?? '' }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-400 small">Tidak ada persyaratan dokumen khusus.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: TIMELINE GELOMBANG -->
            <div class="col-lg-6">
                <div class="pmb-card h-100 p-4 p-md-5">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="far fa-calendar-alt text-amber-400 fs-4"></i>
                        <h3 class="fs-4 fw-bold text-white mb-0">Jadwal &amp; Gelombang</h3>
                    </div>
                    <p class="text-slate-400 small mb-4">
                        Perhatikan jadwal penting agar tidak melewatkan batas waktu pendaftaran:
                    </p>

                    <div class="space-y-3">
                        @forelse($jadwalList as $jd)
                            @php
                                $isAktif = str_contains(strtolower($jd['status'] ?? ''), 'berlangsung') || str_contains(strtolower($jd['status'] ?? ''), 'aktif');
                            @endphp
                            <div class="p-3 rounded-2xl {{ $isAktif ? 'bg-emerald-950/60 border border-emerald-500/40 shadow-sm' : 'bg-black/25 border border-emerald-500/20' }}">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="fw-bold {{ $isAktif ? 'text-emerald-300' : 'text-white' }} small">{{ $jd['nama'] }}</span>
                                    <span class="badge {{ $isAktif ? 'pmb-badge-emerald animate-pulse' : 'bg-secondary rounded-pill' }} text-xs">
                                        {{ $jd['status'] }}
                                    </span>
                                </div>
                                <span class="{{ $isAktif ? 'text-slate-300' : 'text-slate-400' }} d-block" style="font-size: 11px;">{{ $jd['periode'] }}</span>
                                @if(!empty($jd['keterangan']))
                                    <span class="{{ $isAktif ? 'text-emerald-400/90 fw-semibold' : 'text-slate-500' }}" style="font-size: 10px;">{{ $jd['keterangan'] }}</span>
                                @endif
                            </div>
                        @empty
                            <p class="text-slate-400 small">Jadwal gelombang belum ditetapkan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. WARTA & BERITA SEPUTAR PMB (DARI DATABASE BERITA_PMB) -->
    <section class="mb-5">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pb-2 border-bottom border-emerald-500/20">
            <div>
                <span class="d-inline-block pmb-badge-emerald px-3 py-1 rounded-pill small fw-bold mb-1">
                    PUBLIKASI RESMI
                </span>
                <h3 class="fs-2 fw-bold text-white mb-0">
                    Warta &amp; Pengumuman PMB
                </h3>
            </div>
            @auth
                <a href="{{ route('beritapmb.create') }}" class="btn btn-sm btn-success rounded-pill px-3 py-2 fw-bold shadow-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Berita PMB
                </a>
            @endauth
        </div>

        <div class="row g-4">
            @forelse($beritas as $berita)
                <div class="col-md-6 col-lg-4">
                    <div class="pmb-card h-100 overflow-hidden d-flex flex-column justify-content-between">
                        <div>
                            <!-- Gambar Warta PMB -->
                            <div class="position-relative" style="aspect-ratio: 16/9; overflow: hidden; background: #021a0f;">
                                @if($berita->gambar)
                                    <img src="{{ asset('uploads/beritapmb/gambar/'.$berita->gambar) }}" 
                                         class="w-100 h-100 object-fit-cover" 
                                         alt="{{ $berita->judul }}"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                @endif
                                <div class="w-100 h-100 align-items-center justify-content-center text-emerald-400" style="{{ $berita->gambar ? 'display: none;' : 'display: flex;' }}">
                                    <i class="fas fa-newspaper fa-3x opacity-40"></i>
                                </div>

                                <div class="position-absolute top-0 start-0 p-3">
                                    <span class="badge rounded-pill bg-black/75 text-emerald-300 border border-emerald-500/30 px-2.5 py-1 text-xs">
                                        {{ $berita->kategori ?? 'Warta PMB' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Body Warta PMB -->
                            <div class="p-4">
                                <div class="d-flex align-items-center gap-2 text-slate-400 small mb-2" style="font-size: 11px;">
                                    <i class="far fa-calendar-alt text-emerald-400"></i>
                                    <span>{{ $berita->created_at ? $berita->created_at->format('d M Y') : '-' }}</span>
                                    <span>•</span>
                                    <span>{{ $berita->penulis ?? 'Panitia PMB' }}</span>
                                </div>

                                <h4 class="fs-6 fw-bold text-white mb-2 leading-snug">
                                    <a href="{{ route('beritapmb.show', $berita->slug ?? $berita->id) }}" class="text-white text-decoration-none">
                                        {{ $berita->judul }}
                                    </a>
                                </h4>

                                <p class="text-slate-300 small line-clamp-2 mb-0">
                                    {{ Str::limit(strip_tags($berita->isi), 100) }}
                                </p>
                            </div>
                        </div>

                        <!-- Footer Warta PMB -->
                        <div class="p-4 pt-0">
                            <div class="pt-3 border-top border-emerald-500/15 d-flex align-items-center justify-content-between">
                                <a href="{{ route('beritapmb.show', $berita->slug ?? $berita->id) }}" class="text-emerald-300 small fw-bold text-decoration-none d-inline-flex align-items-center gap-1">
                                    <span>Baca Pengumuman</span>
                                    <i class="fas fa-arrow-right fa-xs"></i>
                                </a>

                                @if($berita->file_pdf)
                                    <span class="badge bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 px-2 py-0.5 rounded" style="font-size: 10px;">
                                        <i class="fas fa-file-pdf me-1"></i> Lampiran PDF
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="pmb-card text-center p-5">
                        <i class="far fa-newspaper text-emerald-400 fa-3x mb-3 opacity-40"></i>
                        <h5 class="text-white fw-bold">Belum Ada Berita Tambahan PMB</h5>
                        <p class="text-slate-400 small mb-0">Pengumuman teknis gelombang seleksi akan ditampilkan di area ini.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- 7. TANYA JAWAB (FAQ CALON MAHASISWA - DINAMIS DARI ADMIN) -->
    @if(count($faqList) > 0)
        <section class="mb-5">
            <div class="text-center mb-4">
                <span class="d-inline-block pmb-badge-emerald px-3 py-1 rounded-pill small fw-bold mb-2">
                    PERTANYAAN UMUM
                </span>
                <h2 class="fs-2 fw-bold text-white mb-2">
                    Frequently Asked Questions (FAQ)
                </h2>
                <p class="text-slate-400 small mx-auto" style="max-width: 580px;">
                    Pertanyaan yang paling sering diajukan oleh calon mahasiswa baru dan orang tua.
                </p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="accordion pmb-accordion" id="faqAccordion">
                        @foreach($faqList as $idx => $f)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $idx }}">
                                    <button class="accordion-button {{ $idx > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $idx }}">
                                        {{ $f['tanya'] }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $idx }}" class="accordion-collapse collapse {{ $idx === 0 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        {!! nl2br(e($f['jawab'])) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- 8. BOTTOM CONVERSION CTA BANNER -->
    <section class="mt-5">
        <div class="pmb-hero-wrapper p-4 p-md-5 text-center text-white mb-0">
            <span class="badge pmb-badge-gold px-3 py-1 rounded-pill small fw-bold mb-3">
                KONSULTASI GRATIS 24/7
            </span>
            <h2 class="fs-2 fw-bold text-white mb-3">
                Masih Memiliki Pertanyaan Seputar Pendaftaran?
            </h2>
            <p class="text-slate-200 small mx-auto mb-4" style="max-width: 600px;">
                Tim Panitia Penerimaan Mahasiswa Baru AMIK Taruna siap memandu proses pendaftaran Anda, pemilihan program studi, hingga pengajuan beasiswa.
            </p>

            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="{{ $waConsultUrl }}" target="_blank" class="btn-pmb-primary">
                    <i class="fab fa-whatsapp fs-5 text-success"></i>
                    <span>Hubungi Helpdesk PMB WhatsApp</span>
                </a>
                <a href="{{ $portalUrl }}" target="_blank" class="btn-pmb-secondary">
                    <i class="fas fa-external-link-alt"></i>
                    <span>Buka Portal PMB Online</span>
                </a>
                @if(!empty($pmb->brosur_file))
                    <a href="{{ asset('uploads/pmb/' . $pmb->brosur_file) }}" target="_blank" download class="btn-pmb-secondary">
                        <i class="fas fa-file-download text-warning"></i>
                        <span>Unduh Brosur PMB</span>
                    </a>
                @endif
            </div>
        </div>
    </section>

</div>

@endsection
