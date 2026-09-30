@extends('layouts.main')

@section('title', 'Dokumen Kampus & Regulasi | AMIK Taruna Probolinggo')

@section('content')

<style>
    /* Hero Banner Dokumen Kampus */
    .kampus-hero-header {
        background: rgba(8, 38, 24, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(74, 222, 128, 0.22);
        border-radius: 28px;
        padding: 40px 30px;
        box-shadow: 0 16px 40px -4px rgba(2, 20, 12, 0.5);
    }

    /* Deskripsi Card */
    .kampus-deskripsi-card {
        background: rgba(10, 42, 27, 0.82);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: 24px;
        padding: 32px 36px;
        border: 1px solid rgba(74, 222, 128, 0.20);
        box-shadow: 0 12px 30px rgba(0,0,0,0.3);
    }

    /* List Dokumen Section Card */
    .kampus-doc-section-card {
        background: rgba(10, 38, 25, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: 24px;
        border: 1px solid rgba(74, 222, 128, 0.22);
        padding: 28px 30px;
        box-shadow: 0 12px 32px rgba(0,0,0,0.35);
    }

    /* Document Item Row Card */
    .kampus-doc-item {
        background: rgba(13, 48, 32, 0.70);
        border: 1px solid rgba(74, 222, 128, 0.16);
        border-radius: 18px;
        padding: 18px 22px;
        transition: all 0.25s ease;
    }

    .kampus-doc-item:hover {
        background: rgba(18, 64, 42, 0.95);
        border-color: rgba(74, 222, 128, 0.45);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
    }

    /* Category Filter Buttons */
    .kampus-kat-btn {
        background: rgba(14, 48, 32, 0.7);
        color: #d1fae5;
        border: 1px solid rgba(74, 222, 128, 0.25);
        transition: all 0.2s ease;
    }

    .kampus-kat-btn:hover {
        background: rgba(74, 222, 128, 0.25);
        color: #ffffff;
        border-color: rgba(74, 222, 128, 0.5);
    }

    .kampus-kat-btn.active {
        background: #198754 !important;
        color: #ffffff !important;
        border-color: #20c997 !important;
        box-shadow: 0 4px 14px rgba(25, 135, 84, 0.45);
    }

    /* Continuous Scroll PDF Canvas Container */
    .kampus-pdf-page-wrapper {
        margin: 0 auto 16px auto;
        box-shadow: 0 4px 20px rgba(0,0,0,0.5);
        background: white;
        border-radius: 4px;
        overflow: hidden;
    }

    .kampus-pdf-page-canvas {
        display: block;
        max-width: 100%;
        height: auto;
    }

    #kampusDocModal {
        z-index: 100050 !important;
    }

    .modal-backdrop.show {
        z-index: 100040 !important;
    }
</style>

<div class="container py-4">

    {{-- 1. BREADCRUMB --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="/" class="text-success text-decoration-none"><i class="fas fa-home me-1"></i>Beranda</a></li>
            <li class="breadcrumb-item"><a href="/tentang" class="text-success text-decoration-none">Profil</a></li>
            <li class="breadcrumb-item active text-slate-300" aria-current="page">Dokumen Kampus</li>
        </ol>
    </nav>

    {{-- 2. HERO HEADER DOKUMEN KAMPUS --}}
    <div class="row justify-content-center mb-4">
        <div class="col-lg-10">
            <div class="kampus-hero-header">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill small fw-bold mb-2" style="background: rgba(74, 222, 128, 0.15); color: #4ade80; border: 1px solid rgba(74, 222, 128, 0.3);">
                            <i class="fas fa-university"></i>
                            <span>Arsip Resmi AMIK Taruna</span>
                        </div>
                        <h2 class="fw-bold text-white mb-1" style="font-size: 2.1rem; letter-spacing: -0.5px;">
                            Dokumen &amp; Regulasi Kampus
                        </h2>
                        <p class="text-slate-300 mb-0" style="font-size: 1rem;">
                            Pusat keterbukaan informasi dan publikasi dokumen statuta, rencana strategis, SK kebijakan pimpinan, serta pedoman tata kelola institusi.
                        </p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <a href="#daftar-dokumen" class="btn btn-success rounded-pill px-4 py-2.5 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
                            <i class="fas fa-folder-open"></i>
                            <span>Jelajahi Berkas</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. DESKRIPSI RINGKAS ARSIP INSTITUSI --}}
    <div class="row justify-content-center mb-5">
        <div class="col-lg-10">
            <div class="kampus-deskripsi-card">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="d-inline-flex align-items-center justify-center rounded-3" style="width: 44px; height: 44px; background: rgba(74, 222, 128, 0.18); color: #4ade80; border: 1px solid rgba(74, 222, 128, 0.35);">
                        <i class="fas fa-shield-halved fa-lg"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-white mb-0" style="font-size: 1.25rem;">
                            Komitmen Transparansi &amp; Tata Pamong
                        </h4>
                        <span class="text-slate-400 small">Akademi Manajemen Informatika dan Komputer Taruna Probolinggo</span>
                    </div>
                </div>
                <p class="text-slate-300 mb-0" style="font-size: 0.98rem; line-height: 1.8;">
                    Sebagai perguruan tinggi vokasi yang berkomitmen terhadap mutu dan akuntabilitas publik, seluruh regulasi pokok, rencana strategis (Renstra), standar operasional prosedur, serta keputusan direktur didokumentasikan secara terpusat untuk mempermudah akses bagi sivitas akademika, pemangku kepentingan, dan masyarakat luas.
                </p>
            </div>
        </div>
    </div>

    {{-- 4. DAFTAR DOKUMEN KAMPUS --}}
    <div class="row justify-content-center mb-5" id="daftar-dokumen">
        <div class="col-lg-10">
            <div class="kampus-doc-section-card">
                
                {{-- Header List Dokumen --}}
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 pb-3 border-bottom border-white border-opacity-10 gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-inline-flex align-items-center justify-center rounded-3 text-white" style="width: 46px; height: 46px; background: rgba(74, 222, 128, 0.2); border: 1px solid rgba(74, 222, 128, 0.35);">
                            <i class="fas fa-file-contract text-success fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-white mb-0" style="font-size: 1.25rem;">
                                Dokumen Resmi Institusi
                            </h4>
                            <span class="text-slate-400 small">Daftar arsip dokumen yang dapat ditinjau langsung (pop-up) dan diunduh</span>
                        </div>
                    </div>
                    <div>
                        <span class="badge px-3 py-2 rounded-pill small fw-semibold text-white d-inline-flex align-items-center gap-1.5" style="background: rgba(74, 222, 128, 0.2); border: 1px solid rgba(74, 222, 128, 0.4);">
                            <i class="fas fa-file-pdf text-success" style="font-size: 0.95rem;"></i>
                            <span id="kampusDocCountBadge">{{ count($dokumens) }} Dokumen Tersedia</span>
                        </span>
                    </div>
                </div>

                {{-- FILTER KATEGORI & PENCARIAN LIVE --}}
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                    {{-- Tabs Filter --}}
                    <div class="d-flex flex-wrap gap-2" id="kampusCategoryTabs">
                        <button type="button" 
                                data-kat="semua" 
                                class="btn btn-sm rounded-pill px-3 fw-semibold kampus-kat-btn active">
                            Semua Dokumen
                        </button>
                        @foreach($kategoris as $kItem)
                            <button type="button" 
                                    data-kat="{{ $kItem->slug }}" 
                                    class="btn btn-sm rounded-pill px-3 fw-semibold kampus-kat-btn">
                                {{ $kItem->ikon ?: '📌' }} {{ $kItem->nama }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Search Input Realtime --}}
                    <div class="d-flex gap-2">
                        <div class="input-group input-group-sm" style="max-width: 280px;">
                            <input type="text" id="kampusSearchInput" class="form-control rounded-start-pill bg-dark border-secondary text-white ps-3" placeholder="Cari nama, tahun, topik..." autocomplete="off">
                            <button class="btn btn-dark border-secondary text-slate-400" type="button" id="kampusResetSearchBtn" title="Hapus pencarian" style="display: none;">
                                <i class="fas fa-times"></i>
                            </button>
                            <button class="btn btn-success rounded-end-pill px-3" type="button" id="kampusSearchBtn" title="Cari">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Item List Dokumen --}}
                <div class="d-flex flex-column gap-3" id="kampusDocListContainer">
                    @forelse($dokumens as $doc)
                        @php
                            $ext = strtolower(pathinfo($doc->file_pdf, PATHINFO_EXTENSION));
                            $isPdf = ($ext === 'pdf');
                            $badgeColor = $doc->kategoriModel->warna ?? 'primary';
                            $katLabel = $doc->kategoriModel->nama ?? $doc->kategori;
                            $katIkon = $doc->kategoriModel->ikon ?? '📄';
                        @endphp
                        <div class="kampus-doc-item" 
                             data-kat="{{ $doc->kategori }}" 
                             data-title="{{ strtolower($doc->nama_dokumen) }}" 
                             data-desc="{{ strtolower($doc->deskripsi ?? '') }}" 
                             data-year="{{ strtolower($doc->tahun ?? '') }}"
                             data-kategori-name="{{ strtolower($katLabel) }}">
                            <div class="row align-items-center g-3">
                                
                                {{-- Icon Format --}}
                                <div class="col-auto">
                                    <div class="d-inline-flex align-items-center justify-center rounded-3 shadow-xs" 
                                         style="width: 50px; height: 50px; background: rgba(74, 222, 128, 0.18); border: 1px solid rgba(74, 222, 128, 0.35);">
                                        @if($isPdf)
                                            <i class="fas fa-file-pdf text-danger fa-2x"></i>
                                        @else
                                            <i class="fas fa-file-word text-primary fa-2x"></i>
                                        @endif
                                    </div>
                                </div>

                                {{-- Info Dokumen --}}
                                <div class="col">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                        <span class="badge bg-{{ $badgeColor }} bg-opacity-25 text-{{ $badgeColor }} border border-{{ $badgeColor }} border-opacity-35 px-2.5 py-0.5 rounded-pill small fw-semibold">
                                            {{ $katIkon }} {{ $katLabel }}
                                        </span>
                                        @if($doc->tahun)
                                            <span class="badge bg-dark text-slate-300 border border-secondary px-2.5 py-0.5 rounded-pill small">
                                                <i class="fas fa-calendar-alt text-success me-1"></i>Tahun {{ $doc->tahun }}
                                            </span>
                                        @endif
                                        <span class="badge bg-secondary bg-opacity-25 text-slate-300 small text-uppercase">
                                            {{ $ext }}
                                        </span>
                                    </div>
                                    <h5 class="fw-bold text-white mb-1" style="font-size: 1.08rem; line-height: 1.4;">
                                        {{ $doc->nama_dokumen }}
                                    </h5>
                                    @if($doc->deskripsi)
                                        <p class="text-slate-300 small mb-0" style="line-height: 1.5;">
                                            {{ $doc->deskripsi }}
                                        </p>
                                    @endif
                                </div>

                                {{-- Tombol Aksi: Lihat (Modal) & Unduh --}}
                                <div class="col-12 col-md-auto text-md-end mt-2 mt-md-0">
                                    <div class="d-flex flex-wrap align-items-center gap-2 justify-content-end">
                                        @if($isPdf)
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-light rounded-pill px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5 shadow-xs text-white" 
                                                    onclick="openKampusDocModal('{{ asset('uploads/dokumen_kampus/' . $doc->file_pdf) }}', '{{ addslashes($doc->nama_dokumen) }}', '{{ addslashes($katLabel) }}', '{{ $doc->tahun ?? '' }}')"
                                                    title="Lihat dokumen langsung di layar">
                                                <i class="fas fa-eye text-success"></i>
                                                <span>Lihat</span>
                                            </button>
                                        @endif
                                        <a href="{{ asset('uploads/dokumen_kampus/' . $doc->file_pdf) }}" 
                                           download 
                                           class="btn btn-sm btn-success rounded-pill px-3.5 py-1.5 fw-bold d-inline-flex align-items-center gap-1.5 shadow-sm"
                                           title="Unduh file ke perangkat">
                                            <i class="fas fa-download"></i>
                                            <span>Unduh</span>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5" id="kampusEmptyInitial">
                            <i class="fas fa-folder-open text-slate-500 fa-3x mb-3"></i>
                            <h5 class="text-white fw-bold">Belum Ada Dokumen Kampus</h5>
                            <p class="text-slate-400 small mb-0">Arsip dokumen kampus belum diunggah atau sedang dalam pembaruan.</p>
                        </div>
                    @endforelse

                    {{-- Empty State hasil filter / pencarian --}}
                    <div class="text-center py-5 d-none" id="kampusFilterEmptyState">
                        <i class="fas fa-search text-slate-500 fa-3x mb-3"></i>
                        <h5 class="text-white fw-bold">Tidak Ada Dokumen Yang Cocok</h5>
                        <p class="text-slate-400 small mb-3">Coba gunakan kata kunci pencarian lain atau pilih kategori Semua Dokumen.</p>
                        <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3" onclick="resetKampusFilter()">
                            Reset Filter &amp; Pencarian
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

{{-- 5. MODAL POP-UP PDF DOKUMEN KAMPUS (PERSIS PPM) --}}
<div class="modal fade" id="kampusDocModal" tabindex="-1" aria-labelledby="kampusDocModalLabel" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" style="max-width: 95vw; height: 94vh; margin: auto;">
        <div class="modal-content border-0 shadow-2xl rounded-4 overflow-hidden d-flex flex-column" style="background: #091e14; border: 1px solid rgba(74, 222, 128, 0.35) !important; height: 94vh; max-height: 94vh;">
            
            {{-- Modal Header --}}
            <div class="modal-header border-bottom border-white border-opacity-10 py-3 px-4 flex-shrink-0" style="background: rgba(4, 20, 12, 0.95);">
                <div class="d-flex align-items-center gap-3 min-w-0 me-3">
                    <div class="rounded-3 p-2 d-none d-sm-flex align-items-center justify-center flex-shrink-0" style="background: rgba(74, 222, 128, 0.2); width: 40px; height: 40px;">
                        <i class="fas fa-file-pdf text-danger fs-5"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="d-flex align-items-center gap-2 mb-0.5">
                            <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-30 rounded-pill px-2.5 py-0.5 small fw-semibold" id="kampusModalKategoriBadge">
                                Kategori
                            </span>
                            <span class="text-slate-400 small" id="kampusModalTahunBadge"></span>
                        </div>
                        <h5 class="modal-title fw-bold text-white text-truncate mb-0" id="kampusDocModalLabel" style="font-size: 1.15rem;">
                            Judul Dokumen Kampus
                        </h5>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                    <a href="#" id="kampusModalOpenNewTab" target="_blank" class="btn btn-sm btn-outline-light rounded-pill px-3 py-1.5 fw-semibold d-none d-sm-inline-flex align-items-center gap-1.5">
                        <i class="fas fa-external-link-alt text-success"></i>
                        <span>Tab Baru</span>
                    </a>
                    <a href="#" id="kampusModalDownloadBtn" download class="btn btn-sm btn-success rounded-pill px-3.5 py-1.5 fw-bold d-inline-flex align-items-center gap-1.5 shadow-sm">
                        <i class="fas fa-download"></i>
                        <span class="d-none d-md-inline">Unduh Berkas</span>
                    </a>
                    <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
            </div>

            {{-- Zoom Toolbar --}}
            <div class="px-4 py-2 bg-dark bg-opacity-75 border-bottom border-white border-opacity-10 d-flex flex-wrap align-items-center justify-content-between text-slate-300 small flex-shrink-0 gap-2">
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-xs btn-outline-secondary rounded-2 px-2 py-1 text-white" onclick="kampusZoom(-0.15)" title="Perkecil">
                        <i class="fas fa-search-minus"></i>
                    </button>
                    <span id="kampusZoomLevel" class="font-monospace text-success fw-bold px-1">100%</span>
                    <button type="button" class="btn btn-xs btn-outline-secondary rounded-2 px-2 py-1 text-white" onclick="kampusZoom(0.15)" title="Perbesar">
                        <i class="fas fa-search-plus"></i>
                    </button>
                    <button type="button" class="btn btn-xs btn-outline-secondary rounded-2 px-2 py-1 text-slate-300 ms-1" onclick="kampusResetZoom()" title="Reset Zoom">
                        Reset
                    </button>
                </div>
                <div class="text-slate-400 small">
                    <span id="kampusPageCountInfo">Memuat halaman...</span>
                </div>
            </div>

            {{-- Modal Body: Continuous Scroll PDF Viewer --}}
            <div class="modal-body p-0 position-relative d-flex flex-column" style="flex: 1 1 auto; min-height: 0; background: #07150e; overscroll-behavior: contain;">
                
                {{-- Loading Spinner --}}
                <div id="kampusPdfLoading" class="position-absolute top-50 start-50 translate-middle text-center text-white" style="z-index: 10;">
                    <div class="spinner-border text-success mb-2" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Memuat PDF...</span>
                    </div>
                    <div class="small fw-semibold text-slate-300">Menyiapkan halaman dokumen...</div>
                </div>

                {{-- Continuous Scroll Canvas List Container --}}
                <div id="kampusPdfContinuousView" class="w-100 h-100 overflow-auto py-4 px-2 px-md-4" style="flex: 1 1 auto; min-height: 0; overscroll-behavior: contain; -webkit-overflow-scrolling: touch; display: none;">
                    {{-- Canvas pages dynamically inserted here --}}
                </div>

                {{-- Fallback Iframe (jika PDF.js tidak tersedia) --}}
                <iframe id="kampusDocIframe" src="" class="w-100 h-100 border-0 d-none" style="flex: 1 1 auto; min-height: 0;" title="Pratinjau PDF"></iframe>
            </div>

            {{-- Modal Footer --}}
            <div class="modal-footer border-top border-white border-opacity-10 py-2.5 px-4 justify-content-between flex-shrink-0" style="background: rgba(4, 20, 12, 0.95);">
                <div class="text-slate-400 small d-flex align-items-center gap-1.5">
                    <i class="fas fa-info-circle text-success"></i>
                    <span class="d-none d-sm-inline">Gunakan scroll mouse atau usap layar ke bawah untuk membaca seluruh halaman berkas.</span>
                    <span class="d-sm-none">Scroll ke bawah untuk baca seluruh halaman.</span>
                </div>
                <button type="button" class="btn btn-secondary btn-sm rounded-pill px-4" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    // State Filter & Search Client-Side
    let activeKampusCategory = 'semua';
    let kampusSearchQuery = '';

    // PDF.js State
    let kampusCurrentPdfDoc = null;
    let kampusCurrentScale = 1.0;
    let kampusCurrentUrl = null;

    function applyKampusFilter() {
        const items = document.querySelectorAll('#kampusDocListContainer .kampus-doc-item');
        let visibleCount = 0;

        items.forEach(item => {
            const itemKat = item.getAttribute('data-kat') || '';
            const title = item.getAttribute('data-title') || '';
            const desc = item.getAttribute('data-desc') || '';
            const year = item.getAttribute('data-year') || '';
            const katName = item.getAttribute('data-kategori-name') || '';

            const matchCat = (activeKampusCategory === 'semua' || itemKat === activeKampusCategory);
            const matchSearch = (kampusSearchQuery === '' || 
                title.includes(kampusSearchQuery) || 
                desc.includes(kampusSearchQuery) || 
                year.includes(kampusSearchQuery) || 
                katName.includes(kampusSearchQuery));

            if (matchCat && matchSearch) {
                item.style.setProperty('display', 'block', 'important');
                visibleCount++;
            } else {
                item.style.setProperty('display', 'none', 'important');
            }
        });

        // Update badge count
        const badgeEl = document.getElementById('kampusDocCountBadge');
        if (badgeEl) {
            badgeEl.innerText = `${visibleCount} Dokumen Tersedia`;
        }

        // Empty state
        const emptyState = document.getElementById('kampusFilterEmptyState');
        if (emptyState) {
            if (visibleCount === 0) {
                emptyState.classList.remove('d-none');
            } else {
                emptyState.classList.add('d-none');
            }
        }
    }

    function resetKampusFilter() {
        activeKampusCategory = 'semua';
        kampusSearchQuery = '';
        
        const input = document.getElementById('kampusSearchInput');
        if (input) input.value = '';
        const resetBtn = document.getElementById('kampusResetSearchBtn');
        if (resetBtn) resetBtn.style.display = 'none';

        document.querySelectorAll('#kampusCategoryTabs .kampus-kat-btn').forEach(btn => {
            if (btn.getAttribute('data-kat') === 'semua') {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        applyKampusFilter();
    }

    // Modal Instance Helper with Auto-Teleport
    function getKampusModal() {
        const modalEl = document.getElementById('kampusDocModal');
        if (!modalEl) return null;
        if (modalEl.parentElement !== document.body) {
            document.body.appendChild(modalEl);
        }
        let inst = bootstrap.Modal.getInstance(modalEl);
        if (!inst) {
            inst = new bootstrap.Modal(modalEl, {
                backdrop: true,
                keyboard: true
            });
        }
        return inst;
    }

    // Open Modal and Load PDF
    function openKampusDocModal(pdfUrl, title, category, year) {
        document.getElementById('kampusDocModalLabel').innerText = title || 'Pratinjau Dokumen Kampus';
        document.getElementById('kampusModalKategoriBadge').innerText = category || 'Dokumen Resmi';
        const tahunBadge = document.getElementById('kampusModalTahunBadge');
        if (tahunBadge) {
            tahunBadge.innerText = year ? `• Tahun ${year}` : '';
        }

        document.getElementById('kampusModalOpenNewTab').setAttribute('href', pdfUrl);
        document.getElementById('kampusModalDownloadBtn').setAttribute('href', pdfUrl);

        const modalInst = getKampusModal();
        if (modalInst) {
            modalInst.show();
        }

        kampusCurrentUrl = pdfUrl;
        kampusCurrentScale = 1.0;
        document.getElementById('kampusZoomLevel').innerText = '100%';

        // Check if PDF.js is loaded
        if (typeof pdfjsLib !== 'undefined') {
            loadKampusPdfWithPdfJs(pdfUrl);
        } else {
            // Fallback iframe
            const iframe = document.getElementById('kampusDocIframe');
            const contView = document.getElementById('kampusPdfContinuousView');
            const loader = document.getElementById('kampusPdfLoading');
            loader.style.display = 'none';
            contView.style.display = 'none';
            iframe.classList.remove('d-none');
            iframe.setAttribute('src', pdfUrl + '#view=FitH');
        }
    }

    async function loadKampusPdfWithPdfJs(pdfUrl) {
        const loader = document.getElementById('kampusPdfLoading');
        const contView = document.getElementById('kampusPdfContinuousView');
        const iframe = document.getElementById('kampusDocIframe');
        const pageCountEl = document.getElementById('kampusPageCountInfo');

        loader.style.display = 'block';
        contView.style.display = 'none';
        iframe.classList.add('d-none');
        contView.innerHTML = '';
        pageCountEl.innerText = 'Memuat dokumen...';

        try {
            if (!pdfjsLib.GlobalWorkerOptions.workerSrc) {
                pdfjsLib.GlobalWorkerOptions.workerSrc = '/vendor/pdfjs/pdf.worker.min.js';
            }

            const loadingTask = pdfjsLib.getDocument({
                url: pdfUrl
            });

            kampusCurrentPdfDoc = await loadingTask.promise;
            pageCountEl.innerText = `Total: ${kampusCurrentPdfDoc.numPages} Halaman`;

            loader.style.display = 'none';
            contView.style.display = 'block';

            await renderAllKampusPages(kampusCurrentPdfDoc, kampusCurrentScale);
        } catch (err) {
            console.warn('PDF.js gagal memuat, gunakan fallback iframe:', err);
            loader.style.display = 'none';
            contView.style.display = 'none';
            iframe.classList.remove('d-none');
            iframe.setAttribute('src', pdfUrl + '#view=FitH');
            pageCountEl.innerText = 'Pratinjau Standar';
        }
    }

    async function renderAllKampusPages(pdfDoc, scale) {
        const contView = document.getElementById('kampusPdfContinuousView');
        contView.innerHTML = '';

        for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
            const page = await pdfDoc.getPage(pageNum);
            const viewport = page.getViewport({ scale: scale * 1.5 });

            const pageWrapper = document.createElement('div');
            pageWrapper.className = 'kampus-pdf-page-wrapper';
            pageWrapper.style.width = `${viewport.width / 1.5}px`;

            const canvas = document.createElement('canvas');
            canvas.className = 'kampus-pdf-page-canvas';
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            canvas.style.width = `${viewport.width / 1.5}px`;
            canvas.style.height = `${viewport.height / 1.5}px`;

            pageWrapper.appendChild(canvas);
            contView.appendChild(pageWrapper);

            const renderContext = {
                canvasContext: canvas.getContext('2d'),
                viewport: viewport
            };

            await page.render(renderContext).promise;
        }
    }

    function kampusZoom(delta) {
        if (!kampusCurrentPdfDoc) return;
        kampusCurrentScale = Math.min(Math.max(0.5, kampusCurrentScale + delta), 2.5);
        document.getElementById('kampusZoomLevel').innerText = Math.round(kampusCurrentScale * 100) + '%';
        renderAllKampusPages(kampusCurrentPdfDoc, kampusCurrentScale);
    }

    function kampusResetZoom() {
        if (!kampusCurrentPdfDoc) return;
        kampusCurrentScale = 1.0;
        document.getElementById('kampusZoomLevel').innerText = '100%';
        renderAllKampusPages(kampusCurrentPdfDoc, kampusCurrentScale);
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Auto-teleport modal to body immediately
        const modalEl = document.getElementById('kampusDocModal');
        if (modalEl && modalEl.parentElement !== document.body) {
            document.body.appendChild(modalEl);
        }

        // Active wheel listener for continuous viewer
        const continuousView = document.getElementById('kampusPdfContinuousView');
        if (continuousView) {
            continuousView.addEventListener('wheel', function(e) {
                e.stopPropagation();
            }, { passive: true });
        }

        // Category filter buttons
        document.querySelectorAll('#kampusCategoryTabs .kampus-kat-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('#kampusCategoryTabs .kampus-kat-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                activeKampusCategory = this.getAttribute('data-kat');
                applyKampusFilter();
            });
        });

        // Search input
        const searchInput = document.getElementById('kampusSearchInput');
        const resetBtn = document.getElementById('kampusResetSearchBtn');
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                kampusSearchQuery = this.value.trim().toLowerCase();
                if (resetBtn) {
                    resetBtn.style.display = (kampusSearchQuery.length > 0) ? 'inline-block' : 'none';
                }
                applyKampusFilter();
            });
        }

        if (resetBtn) {
            resetBtn.addEventListener('click', function () {
                if (searchInput) searchInput.value = '';
                this.style.display = 'none';
                kampusSearchQuery = '';
                applyKampusFilter();
            });
        }
    });
</script>
@endpush

@endsection
