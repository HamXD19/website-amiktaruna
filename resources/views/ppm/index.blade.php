@extends('layouts.main')

@section('content')

<style>
    /* Hero Banner PPM */
    .ppm-hero-header {
        background: rgba(8, 38, 24, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(74, 222, 128, 0.22);
        border-radius: 28px;
        padding: 40px 30px;
        box-shadow: 0 16px 40px -4px rgba(2, 20, 12, 0.5);
    }

    /* Deskripsi Card */
    .ppm-deskripsi-card {
        background: rgba(10, 42, 27, 0.82);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: 24px;
        padding: 32px 36px;
        border: 1px solid rgba(74, 222, 128, 0.20);
        box-shadow: 0 12px 30px rgba(0,0,0,0.3);
    }

    /* Portal Card Utama (Di Tengah / Menonjol) */
    .ppm-portal-featured-card {
        background: rgba(12, 48, 30, 0.88);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: 26px;
        overflow: hidden;
        transition: all 0.35s ease;
        border: 1px solid rgba(74, 222, 128, 0.25);
        box-shadow: 0 14px 35px rgba(0,0,0,0.35);
    }

    .ppm-portal-featured-card:hover {
        transform: translateY(-6px);
        background: rgba(16, 60, 38, 0.96);
        border-color: rgba(74, 222, 128, 0.5);
        box-shadow: 0 20px 45px rgba(74, 222, 128, 0.18), 0 10px 25px rgba(0,0,0,0.5);
    }

    .ppm-portal-featured-card .portal-icon-wrap {
        width: 80px;
        height: 80px;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        background: rgba(74, 222, 128, 0.15);
        color: #4ade80;
        border: 1px solid rgba(74, 222, 128, 0.35);
        transition: transform 0.3s ease;
    }

    .ppm-portal-featured-card:hover .portal-icon-wrap {
        transform: scale(1.08);
        background: rgba(74, 222, 128, 0.25);
    }

    /* Grid Card Portal PPM (Like LPPM) */
    .ppm-grid-card {
        position: relative;
        overflow: hidden;
        border-radius: 28px;
        background: rgba(8, 38, 24, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(74, 222, 128, 0.22);
        box-shadow: 0 16px 40px -4px rgba(2, 20, 12, 0.5);
        transition: all 0.35s ease;
        display: flex;
        flex-direction: column;
    }

    .ppm-grid-card:hover {
        transform: translateY(-8px);
        background: rgba(14, 56, 36, 0.95);
        border-color: rgba(74, 222, 128, 0.5);
        box-shadow: 0 24px 50px -6px rgba(74, 222, 128, 0.2), 0 12px 30px rgba(0,0,0,0.5);
    }

    .ppm-portal-logo {
        width: 86px;
        height: 86px;
        object-fit: contain;
        background: #ffffff;
        border-radius: 22px;
        padding: 8px;
        border: 2px solid rgba(74, 222, 128, 0.4);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
    }

    .ppm-grid-card:hover .ppm-portal-logo {
        transform: scale(1.08) rotate(-2deg);
        border-color: #4ade80;
    }

    .ppm-portal-logo-kosong {
        width: 86px;
        height: 86px;
        border-radius: 22px;
        background: rgba(74, 222, 128, 0.15);
        border: 2px solid rgba(74, 222, 128, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: #4ade80;
        transition: transform 0.3s ease;
    }

    .ppm-grid-card:hover .ppm-portal-logo-kosong {
        transform: scale(1.08);
        background: rgba(74, 222, 128, 0.25);
    }

    /* Section Dokumen di Bawah Portal */
    .ppm-doc-section-card {
        background: rgba(10, 42, 27, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: 26px;
        border: 1px solid rgba(74, 222, 128, 0.22);
        box-shadow: 0 14px 35px rgba(0,0,0,0.35);
        padding: 36px 32px;
    }

    /* List Item Dokumen */
    .ppm-doc-item {
        background: rgba(6, 28, 18, 0.75);
        border: 1px solid rgba(74, 222, 128, 0.18);
        border-radius: 18px;
        padding: 22px 24px;
        transition: all 0.3s ease;
    }

    .ppm-doc-item:hover {
        background: rgba(12, 48, 30, 0.95);
        border-color: rgba(74, 222, 128, 0.4);
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    }

    .ppm-doc-icon {
        width: 54px;
        height: 54px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
        font-size: 1.6rem;
        flex-shrink: 0;
    }

    /* Pillar badges */
    .ppm-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Kategori Filter Tabs (Tanpa Reload / Tanpa Refresh) */
    .ppm-kat-btn {
        transition: all 0.25s ease;
        font-size: 0.82rem;
        border: 1px solid rgba(255, 255, 255, 0.18);
        color: #cbd5e1;
        background: rgba(255, 255, 255, 0.05);
    }
    .ppm-kat-btn:hover {
        background: rgba(74, 222, 128, 0.18);
        border-color: rgba(74, 222, 128, 0.5);
        color: #ffffff;
        transform: translateY(-1px);
    }
    .ppm-kat-btn.active {
        background: #16a34a !important;
        border-color: #22c55e !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(22, 163, 74, 0.4);
    }
</style>

<div class="container py-5">

    {{-- 1. HEADER SECTION --}}
    <div class="ppm-hero-header text-center mb-5 position-relative">
        <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill mb-3" style="background: rgba(74, 222, 128, 0.15); border: 1px solid rgba(74, 222, 128, 0.3);">
            <i class="fas fa-shield-alt text-success"></i>
            <span class="text-success fw-bold small text-uppercase tracking-wider">{{ $setting->page_headers['ppm']['eyebrow'] ?? 'Lembaga Mutu Internal' }}</span>
        </div>
        <h1 class="fw-extrabold text-white mb-3" style="font-size: 2.4rem; letter-spacing: -0.5px;">
            {{ $setting->page_headers['ppm']['title'] ?? 'Pusat Penjaminan Mutu (PPM)' }}
        </h1>
        <p class="text-slate-300 mx-auto mb-0" style="max-width: 720px; font-size: 1.05rem; line-height: 1.7;">
            {{ $setting->page_headers['ppm']['subtitle'] ?? 'Sistem Penjaminan Mutu Internal (SPMI) AMIK Taruna Probolinggo untuk menjaga, mengendalikan, dan meningkatkan standar mutu pendidikan tinggi secara berkelanjutan.' }}
        </p>
    </div>

    {{-- 2. DESKRIPSI & KOMITMEN MUTU --}}
    <div class="ppm-deskripsi-card mb-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-2 col-md-3 text-center">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 86px; height: 86px; background: rgba(74, 222, 128, 0.15); border: 2px solid rgba(74, 222, 128, 0.35);">
                    <i class="fas fa-award text-success fa-2x"></i>
                </div>
            </div>
            <div class="col-lg-10 col-md-9">
                <span class="ppm-badge-pill bg-success bg-opacity-25 text-success mb-2 border border-success border-opacity-25">
                    <i class="fas fa-check-double me-1"></i>Komitmen SPMI
                </span>
                <h4 class="fw-bold text-white mb-2">Penjaminan Mutu Terintegrasi &amp; Berkelanjutan</h4>
                <p class="text-slate-300 mb-0" style="font-size: 0.98rem; line-height: 1.8;">
                    {{ $ppm->deskripsi ?? 'Pusat Penjaminan Mutu (PPM) AMIK Taruna bertugas merencanakan, melaksanakan, mengevaluasi, mengendalikan, dan meningkatkan (PPEPP) standar mutu Tridharma Perguruan Tinggi untuk menghasilkan lulusan yang kompeten, beretika, dan siap bersaing di dunia industri digital.' }}
                </p>
            </div>
        </div>
    </div>

    {{-- 3. PORTAL LAYANAN PENJAMINAN MUTU (DINAMIS SEPERTI LPPM) --}}
    @if(isset($portals) && $portals->count() > 0)
    <div class="row g-4 justify-content-center mb-5" id="portal-layanan-ppm">
        @foreach($portals as $portal)
        <div class="col-md-6 col-lg-4">
            <a href="{{ $portal->link }}"
               target="_blank"
               class="text-decoration-none h-100 d-block">
                <div class="card ppm-grid-card border-0 h-100 text-center p-4">
                    <!-- LOGO -->
                    <div class="d-flex justify-content-center align-items-center mb-3">
                        @if($portal->logo)
                            @php
                                $pLogoPath = file_exists(public_path('uploads/ppm/' . $portal->logo)) 
                                    ? asset('uploads/ppm/' . $portal->logo) 
                                    : (file_exists(public_path('uploads/' . $portal->logo)) ? asset('uploads/' . $portal->logo) : asset('uploads/ppm/' . $portal->logo));
                            @endphp
                            <img src="{{ $pLogoPath }}"
                                 alt="{{ $portal->nama }}"
                                 class="ppm-portal-logo">
                        @else
                            <div class="ppm-portal-logo-kosong">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                        @endif
                    </div>

                    <!-- CONTENT -->
                    <div class="d-flex flex-column flex-grow-1 h-100">
                        <h5 class="fw-bold text-white mb-2" style="font-size: 1.18rem;">
                            {{ $portal->nama }}
                        </h5>
                        <p class="text-slate-300 small mt-1 flex-grow-1" style="line-height: 1.6;">
                            {{ $portal->deskripsi ?: 'Portal layanan Sistem Penjaminan Mutu Internal (SPMI) AMIK Taruna.' }}
                        </p>
                        <div class="mt-auto pt-3">
                            <span class="btn btn-{{ $portal->warna ?: 'success' }} rounded-pill px-4 py-2 fw-bold small shadow-sm">
                                Kunjungi Portal <i class="fas fa-arrow-right ms-1"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @else
    {{-- FALLBACK PORTAL UTAMA (JIKA BELUM ADA PORTAL DINAMIS) --}}
    <div class="row justify-content-center mb-5">
        <div class="col-lg-10">
            <div class="ppm-portal-featured-card p-4 p-md-5">
                <div class="row align-items-center g-4">
                    <div class="col-md-auto text-center">
                        <div class="portal-icon-wrap mx-auto">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-2 justify-content-center justify-content-md-start">
                            <span class="badge bg-success bg-opacity-20 text-success border border-success border-opacity-25 px-3 py-1 rounded-pill small fw-bold">
                                Aplikasi / Portal Utama
                            </span>
                            <span class="text-slate-400 small">
                                <i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i>Akses Terbuka Sivitas
                            </span>
                        </div>
                        <h3 class="fw-bold text-white mb-2" style="font-size: 1.55rem;">
                            {{ $ppm->nama_portal ?? 'Website Penjaminan Mutu' }}
                        </h3>
                        <p class="text-slate-300 mb-0" style="font-size: 0.95rem; line-height: 1.7;">
                            Portal digital terpadu untuk monitoring kepatuhan standar mutu, pengisian instrumen evaluasi pembelajaran, audit mutu internal (AMI), serta rekapitulasi data akreditasi institusi.
                        </p>
                    </div>
                    <div class="col-md-auto text-center text-md-end">
                        @if(!empty($ppm->link_portal))
                            <a href="{{ $ppm->link_portal }}" target="_blank" rel="noopener noreferrer" class="btn btn-success btn-lg rounded-pill px-4 py-2.5 fw-bold d-inline-flex align-items-center gap-2 shadow-lg">
                                <span>Buka Portal Mutu</span>
                                <i class="fas fa-external-link-alt small"></i>
                            </a>
                        @else
                            <button class="btn btn-secondary rounded-pill px-4 py-2 disabled">Tautan Belum Diisi</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- 4. DAFTAR DOKUMEN MUTU (DI BAWAH PORTAL - MODEL LIST) --}}
    <div class="row justify-content-center mb-5" id="daftar-dokumen">
        <div class="col-lg-10">
            <div class="ppm-doc-section-card">
                
                {{-- Header List Dokumen --}}
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 pb-3 border-bottom border-white border-opacity-10 gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-3 text-white" style="width: 46px; height: 46px; background: rgba(74, 222, 128, 0.2); border: 1px solid rgba(74, 222, 128, 0.35);">
                            <i class="fas fa-folder-open text-success fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-white mb-0" style="font-size: 1.25rem;">
                                Dokumen &amp; Standar Mutu
                            </h4>
                            <span class="text-slate-400 small">Daftar arsip dokumen resmi SPMI yang dapat ditinjau dan diunduh</span>
                        </div>
                    </div>
                    <div>
                        <span class="badge px-3 py-2 rounded-pill small fw-semibold text-white d-inline-flex align-items-center gap-1.5" style="background: rgba(74, 222, 128, 0.2); border: 1px solid rgba(74, 222, 128, 0.4);">
                            <i class="fas fa-file-alt text-success" style="font-size: 0.95rem;"></i>
                            <span id="docCountBadge">{{ count($dokumens) }} Dokumen Tersedia</span>
                        </span>
                    </div>
                </div>

                {{-- FILTER KATEGORI DARI MASTER KATEGORI & PENCARIAN (LIVE TANPA REFRESH / TANPA SCROLL) --}}
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                    {{-- Tabs Filter --}}
                    <div class="d-flex flex-wrap gap-2" id="ppmCategoryTabs">
                        <button type="button" 
                                data-kat="semua" 
                                class="btn btn-sm rounded-pill px-3 fw-semibold ppm-kat-btn active">
                            Semua Dokumen
                        </button>
                        @foreach($kategoris as $kItem)
                            <button type="button" 
                                    data-kat="{{ $kItem->slug }}" 
                                    class="btn btn-sm rounded-pill px-3 fw-semibold ppm-kat-btn">
                                {{ $kItem->ikon }} {{ $kItem->nama }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Search Input Realtime --}}
                    <div class="d-flex gap-2">
                        <div class="input-group input-group-sm" style="max-width: 280px;">
                            <input type="text" id="ppmSearchInput" class="form-control rounded-start-pill bg-dark border-secondary text-white ps-3" placeholder="Cari nama, tahun, topik..." autocomplete="off">
                            <button class="btn btn-dark border-secondary text-slate-400" type="button" id="ppmResetSearchBtn" title="Hapus pencarian" style="display: none;">
                                <i class="fas fa-times"></i>
                            </button>
                            <button class="btn btn-success rounded-end-pill px-3" type="button" id="ppmSearchBtn" title="Cari">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- List Item Dokumen --}}
                <div class="d-flex flex-column gap-3" id="docListContainer">
                    @forelse($dokumens as $doc)
                        @php
                            $katModel = $doc->kategoriModel;
                            $warna = $katModel ? $katModel->warna : 'success';
                            $ikon = $katModel ? $katModel->ikon : '📜';
                            $namaKat = $katModel ? $katModel->nama : ucfirst(str_replace('-', ' ', $doc->kategori));
                            $ext = strtolower(pathinfo($doc->file_pdf, PATHINFO_EXTENSION));
                            $isWord = in_array($ext, ['doc', 'docx']);
                        @endphp
                        <div class="ppm-doc-item ppm-doc-card"
                             data-kat="{{ $doc->kategori }}"
                             data-title="{{ strtolower($doc->nama_dokumen) }}"
                             data-desc="{{ strtolower($doc->deskripsi ?: '') }}"
                             data-year="{{ strtolower($doc->tahun ?: '') }}"
                             data-katname="{{ strtolower($namaKat) }}">
                            <div class="row align-items-center g-3">
                                <div class="col-auto">
                                    <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 52px; height: 52px; background: {{ $isWord ? '#2563eb' : '#dc2626' }}; color: #ffffff; box-shadow: 0 4px 14px {{ $isWord ? 'rgba(37, 99, 235, 0.4)' : 'rgba(220, 38, 38, 0.4)' }};">
                                        <i class="fas {{ $isWord ? 'fa-file-word' : 'fa-file-pdf' }} fa-2x"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                        <h5 class="fw-bold text-white mb-0" style="font-size: 1.15rem;">
                                            {{ $doc->nama_dokumen }}
                                        </h5>
                                        <span class="badge rounded-pill text-white" style="background: rgba(74, 222, 128, 0.2); border: 1px solid rgba(74, 222, 128, 0.35); font-size: 11px;">
                                            {{ $ikon }} {{ $namaKat }}
                                        </span>
                                        @if($doc->tahun)
                                            <span class="badge rounded-pill text-slate-300" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); font-size: 11px;">
                                                <i class="fas fa-calendar-alt me-1 text-warning"></i>{{ $doc->tahun }}
                                            </span>
                                        @endif
                                        <span class="badge rounded-pill text-uppercase" style="background: {{ $isWord ? 'rgba(37, 99, 235, 0.25)' : 'rgba(239, 68, 68, 0.25)' }}; border: 1px solid {{ $isWord ? 'rgba(59, 130, 246, 0.4)' : 'rgba(239, 68, 68, 0.4)' }}; font-size: 10px; color: {{ $isWord ? '#93c5fd' : '#fca5a5' }};">
                                            {{ $ext }}
                                        </span>
                                    </div>
                                    <p class="text-slate-300 small mb-2" style="line-height: 1.6;">
                                        {{ $doc->deskripsi ?: 'Buku pedoman Sistem Penjaminan Mutu Internal (SPMI), standar mutu tridharma perguruan tinggi, dan ketetapan institusi AMIK Taruna Probolinggo.' }}
                                    </p>
                                    <div class="d-flex flex-wrap align-items-center gap-3 text-slate-400" style="font-size: 12px;">
                                        <span><i class="fas fa-paperclip {{ $isWord ? 'text-primary' : 'text-danger' }} me-1"></i>{{ $doc->file_pdf }}</span>
                                        <span>•</span>
                                        <span><i class="fas fa-university text-success me-1"></i>PPM AMIK Taruna</span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-auto text-md-end mt-2 mt-md-0">
                                    <div class="d-flex flex-wrap gap-2 justify-content-start justify-content-md-end">
                                        <button type="button" 
                                                class="btn btn-outline-light rounded-pill px-3.5 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" 
                                                style="font-size: 0.88rem;"
                                                onclick="openPpmDocViewer('{{ asset('uploads/ppm/' . $doc->file_pdf) }}', '{{ addslashes($doc->nama_dokumen) }}', '{{ $ext }}')">
                                            <i class="fas fa-eye text-success"></i>
                                            <span>Lihat</span>
                                        </button>
                                        <a href="{{ asset('uploads/ppm/' . $doc->file_pdf) }}" download class="btn {{ $isWord ? 'btn-primary' : 'btn-danger' }} rounded-pill px-3.5 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" style="font-size: 0.88rem;">
                                            <i class="fas fa-download"></i>
                                            <span>Unduh {{ strtoupper($ext) }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse

                    {{-- Empty State (Tampil otomatis jika hasil filter atau pencarian tidak ada) --}}
                    <div id="docEmptyState" class="p-4 rounded-4 text-center text-md-start" style="background: rgba(6, 28, 18, 0.65); border: 1px solid rgba(74, 222, 128, 0.2); display: {{ count($dokumens) == 0 ? 'block' : 'none' }};">
                        <div class="d-flex flex-column flex-md-row align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width: 58px; height: 58px; background: rgba(74, 222, 128, 0.15); border: 1px solid rgba(74, 222, 128, 0.3);">
                                <i class="fas fa-search text-warning fa-2x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold text-white mb-1" id="emptyStateTitle">Belum Ada Dokumen Mutu pada Kategori Ini</h6>
                                <p class="text-slate-300 small mb-0" id="emptyStateDesc" style="line-height: 1.6;">
                                    Dokumen belum diunggah untuk kategori yang dipilih atau kata kunci pencarian tidak ditemukan. Silakan pilih tab "Semua Dokumen".
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <button type="button" id="btnResetFilter" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                    <i class="fas fa-undo me-1"></i>Reset Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const katButtons = document.querySelectorAll('.ppm-kat-btn');
    const searchInput = document.getElementById('ppmSearchInput');
    const resetSearchBtn = document.getElementById('ppmResetSearchBtn');
    const searchBtn = document.getElementById('ppmSearchBtn');
    const docCards = document.querySelectorAll('.ppm-doc-card');
    const emptyState = document.getElementById('docEmptyState');
    const emptyTitle = document.getElementById('emptyStateTitle');
    const emptyDesc = document.getElementById('emptyStateDesc');
    const countBadge = document.getElementById('docCountBadge');
    const resetFilterBtn = document.getElementById('btnResetFilter');

    let activeCategory = 'semua';
    let searchQuery = '';

    // Cek query parameter URL saat halaman pertama kali dibuka
    const initialParams = new URLSearchParams(window.location.search);
    if (initialParams.has('kategori')) {
        activeCategory = initialParams.get('kategori') || 'semua';
    }
    if (initialParams.has('search')) {
        searchQuery = initialParams.get('search').trim();
        if (searchInput) searchInput.value = searchQuery;
    }

    function runFilter(updateUrl = true) {
        const query = searchQuery.toLowerCase().trim();
        let visibleCount = 0;

        docCards.forEach(card => {
            const cardKat = card.getAttribute('data-kat') || '';
            const cardTitle = card.getAttribute('data-title') || '';
            const cardDesc = card.getAttribute('data-desc') || '';
            const cardYear = card.getAttribute('data-year') || '';
            const cardKatName = card.getAttribute('data-katname') || '';

            const matchCategory = (activeCategory === 'semua' || cardKat === activeCategory);
            const matchSearch = (!query ||
                cardTitle.includes(query) ||
                cardDesc.includes(query) ||
                cardYear.includes(query) ||
                cardKatName.includes(query)
            );

            if (matchCategory && matchSearch) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Update tombol tab kategori aktif
        katButtons.forEach(btn => {
            const kat = btn.getAttribute('data-kat');
            if (kat === activeCategory) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        // Tombol silang untuk bersihkan pencarian
        if (resetSearchBtn) {
            resetSearchBtn.style.display = query.length > 0 ? 'inline-block' : 'none';
        }

        // Tampilan empty state jika hasil 0
        if (emptyState) {
            if (visibleCount === 0) {
                emptyState.style.display = 'block';
                if (query) {
                    emptyTitle.textContent = `Dokumen "${query}" Tidak Ditemukan`;
                    emptyDesc.textContent = `Tidak ada dokumen yang cocok dengan kata kunci "${query}". Silakan ubah kata kunci atau ganti kategori.`;
                } else {
                    emptyTitle.textContent = 'Belum Ada Dokumen pada Kategori Ini';
                    emptyDesc.textContent = 'Arsip dokumen belum diunggah untuk kategori yang dipilih. Silakan pilih tab "Semua Dokumen".';
                }
            } else {
                emptyState.style.display = 'none';
            }
        }

        // Perbarui badge jumlah dokumen
        if (countBadge) {
            countBadge.textContent = `${visibleCount} Dokumen Ditampilkan`;
        }

        // Sinkronkan URL di address bar tanpa reload/refresh (history.replaceState)
        if (updateUrl) {
            const url = new URL(window.location);
            if (activeCategory !== 'semua') {
                url.searchParams.set('kategori', activeCategory);
            } else {
                url.searchParams.delete('kategori');
            }
            if (query) {
                url.searchParams.set('search', query);
            } else {
                url.searchParams.delete('search');
            }
            window.history.replaceState({}, '', url.pathname + (url.search ? url.search : ''));
        }
    }

    // Klik Tab Kategori: Langsung filter, tidak reload, tidak scroll ke atas
    katButtons.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            activeCategory = this.getAttribute('data-kat');
            runFilter(true);
        });
    });

    // Real-time Search: Filter seketika saat mengetik
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            searchQuery = this.value;
            runFilter(true);
        });

        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Jangan submit form / jangan refresh
            }
        });
    }

    if (searchBtn) {
        searchBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (searchInput) {
                searchQuery = searchInput.value;
                runFilter(true);
            }
        });
    }

    // Tombol silang reset text pencarian
    if (resetSearchBtn) {
        resetSearchBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (searchInput) {
                searchInput.value = '';
                searchQuery = '';
                runFilter(true);
                searchInput.focus();
            }
        });
    }

    // Tombol reset filter pada empty state
    if (resetFilterBtn) {
        resetFilterBtn.addEventListener('click', function (e) {
            e.preventDefault();
            activeCategory = 'semua';
            if (searchInput) {
                searchInput.value = '';
                searchQuery = '';
            }
            runFilter(true);
        });
    }

    // Inisialisasi awal (tanpa ubah URL)
    runFilter(false);
});

// Pop-up Document Viewer handler
let ppmDocModalObj = null;

function getPpmModal() {
    const modalEl = document.getElementById('ppmDocModal');
    if (!modalEl) return null;
    if (!ppmDocModalObj) {
        ppmDocModalObj = bootstrap.Modal.getOrCreateInstance(modalEl, {
            backdrop: true,
            keyboard: true,
            focus: true
        });
    }
    return ppmDocModalObj;
}

function openPpmDocViewer(fileUrl, docTitle, ext) {
    const isWord = ['doc', 'docx'].includes((ext || '').toLowerCase());
    const iframeEl = document.getElementById('ppmDocIframe');
    const wordFallbackEl = document.getElementById('ppmDocWordFallback');
    const fullTabBtn = document.getElementById('ppmDocFullTab');
    
    document.getElementById('ppmDocTitle').textContent = docTitle;
    document.getElementById('ppmDocBadge').textContent = (ext || 'PDF').toUpperCase();
    document.getElementById('ppmDocDownload').href = fileUrl;
    document.getElementById('ppmDocNewTab').href = fileUrl;
    if (fullTabBtn) fullTabBtn.href = fileUrl;

    if (isWord) {
        if (iframeEl) {
            iframeEl.style.display = 'none';
            iframeEl.src = 'about:blank';
        }
        if (wordFallbackEl) {
            wordFallbackEl.classList.remove('d-none');
            wordFallbackEl.classList.add('d-flex');
            document.getElementById('ppmWordDocTitle').textContent = docTitle;
            document.getElementById('ppmWordDownload').href = fileUrl;
            document.getElementById('ppmWordNewTab').href = fileUrl;
        }
    } else {
        if (wordFallbackEl) {
            wordFallbackEl.classList.add('d-none');
            wordFallbackEl.classList.remove('d-flex');
        }
        if (iframeEl) {
            iframeEl.style.display = 'block';
            // Set URL hash to fit-width & page-width so it scrolls continuously on both Firefox and Chromium
            iframeEl.src = fileUrl + '#view=FitH&zoom=page-width&toolbar=1&navpanes=0&scrollbar=1';
        }
    }

    const modal = getPpmModal();
    if (modal) {
        modal.show();
        // Beri fokus ke iframe agar mousewheel langsung aktif menggulir dokumen
        setTimeout(() => {
            if (iframeEl && !isWord) {
                try {
                    iframeEl.focus();
                    if (iframeEl.contentWindow) iframeEl.contentWindow.focus();
                } catch(e) {}
            }
        }, 350);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const modalEl = document.getElementById('ppmDocModal');
    if (modalEl) {
        modalEl.addEventListener('hidden.bs.modal', function () {
            const iframe = document.getElementById('ppmDocIframe');
            if (iframe) iframe.src = 'about:blank';

            // Bersihkan sisa efek backdrop dan pastikan scroll halaman utama kembali aktif
            setTimeout(function() {
                document.body.classList.remove('modal-open');
                document.documentElement.classList.remove('modal-open');
                document.body.style.removeProperty('overflow');
                document.body.style.removeProperty('padding-right');
                document.documentElement.style.removeProperty('overflow');
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            }, 80);
        });
    }
});
</script>

<!-- SPMI Pop-up Document Viewer Modal (Dapat Di-scroll Sempurna di Desktop & HP) -->
<div class="modal fade modal-doc-viewer" id="ppmDocModal" tabindex="-1" aria-labelledby="ppmDocTitle" aria-hidden="true" style="z-index: 100050 !important;">
    <div class="modal-dialog modal-xl my-2 my-md-3" style="max-width: 1120px;">
        <div class="modal-content rounded-4 border-0 shadow-2xl d-flex flex-column" style="background: #0f172a; border: 1px solid rgba(74, 222, 128, 0.3) !important; height: calc(100vh - 2rem); max-height: calc(100vh - 2rem);">
            
            <!-- Modal Header -->
            <div class="modal-header border-0 py-3 px-4 flex-shrink-0" style="background: #022c22; border-bottom: 1px solid rgba(74, 222, 128, 0.2) !important;">
                <div class="d-flex align-items-center gap-2 min-w-0 flex-grow-1">
                    <span id="ppmDocBadge" class="badge rounded-pill text-uppercase font-monospace bg-dark text-emerald-400 border border-success">PDF</span>
                    <h6 class="modal-title fw-bold text-white text-truncate mb-0" id="ppmDocTitle">Pratinjau Dokumen SPMI</h6>
                </div>
                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                    <a id="ppmDocNewTab" href="#" target="_blank" class="btn btn-sm btn-outline-light rounded-pill px-3 d-none d-sm-inline-flex align-items-center gap-1">
                        <i class="fas fa-external-link-alt text-xs"></i> Tab Baru
                    </a>
                    <a id="ppmDocDownload" href="#" download class="btn btn-sm btn-success rounded-pill px-3.5 d-inline-flex align-items-center gap-1.5 fw-bold">
                        <i class="fas fa-download text-xs"></i> Unduh Berkas
                    </a>
                    <button type="button" class="btn btn-sm btn-light rounded-circle text-dark fw-bold d-inline-flex align-items-center justify-content-center shadow-sm" data-bs-dismiss="modal" aria-label="Close" style="width: 34px; height: 34px; padding: 0;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Sub-Toolbar Bantuan Scroll & Navigasi -->
            <div class="px-3 py-2 bg-dark bg-opacity-75 border-bottom border-emerald-500 border-opacity-20 text-slate-300 small d-flex flex-wrap align-items-center justify-content-between gap-2 flex-shrink-0">
                <div class="d-flex align-items-center gap-2 text-emerald-300">
                    <i class="fas fa-info-circle text-emerald-400"></i>
                    <span class="d-none d-md-inline">Klik area dokumen lalu gunakan scroll mouse / usap layar ke bawah untuk melihat seluruh halaman.</span>
                    <span class="d-md-none">Usap layar untuk scroll halaman dokumen.</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a id="ppmDocFullTab" href="#" target="_blank" class="btn btn-xs btn-outline-success text-emerald-300 rounded-pill px-2.5 py-1 text-decoration-none fw-semibold small d-inline-flex align-items-center gap-1">
                        <i class="fas fa-external-link-alt"></i> Buka Layar Penuh
                    </a>
                </div>
            </div>

            <!-- Modal Body (Scrollable Container) -->
            <div class="modal-body p-0 flex-grow-1 position-relative d-flex flex-column" style="background: #020617; overflow: hidden; height: 100%;">
                <!-- PDF Viewer Frame -->
                <iframe id="ppmDocIframe" 
                        src="" 
                        class="w-100 flex-grow-1 border-0 bg-white" 
                        style="display: block; width: 100%; height: 100%; min-height: 400px;" 
                        scrolling="yes" 
                        allow="fullscreen">
                </iframe>

                <!-- Word Document Fallback Card -->
                <div id="ppmDocWordFallback" class="d-none w-100 h-100 flex-column align-items-center justify-content-center text-center p-4 p-md-5 my-auto" style="min-height: 480px;">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 76px; height: 76px;">
                        <i class="fas fa-file-word fa-3x"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-2" id="ppmWordDocTitle">Dokumen Microsoft Word</h5>
                    <p class="text-slate-400 small mb-4 mx-auto" style="max-width: 500px; line-height: 1.6;">
                        Format dokumen Word (.doc / .docx) tidak dapat ditampilkan secara interaktif di dalam bingkai peramban. Silakan unduh atau buka berkas untuk membaca seluruh isinya.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <a id="ppmWordDownload" href="#" download class="btn btn-primary rounded-pill px-4 py-2 fw-bold d-inline-flex align-items-center gap-2">
                            <i class="fas fa-download"></i> Unduh Berkas Word
                        </a>
                        <a id="ppmWordNewTab" href="#" target="_blank" class="btn btn-outline-light rounded-pill px-4 py-2 fw-semibold d-inline-flex align-items-center gap-2">
                            <i class="fas fa-external-link-alt"></i> Buka Berkas Langsung
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection