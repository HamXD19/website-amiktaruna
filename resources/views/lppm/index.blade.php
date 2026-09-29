@extends('layouts.main')

@section('content')

<div class="container py-5">

    <!-- HEADER TITLE -->
    <div class="text-center mb-5">
        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 mb-3 rounded-pill bg-emerald-500/20 text-emerald-300 fw-bold small border border-emerald-500/30">
            <i class="fas fa-flask"></i> {{ $setting->page_headers['lppm']['eyebrow'] ?? 'Lembaga Penelitian & Pengabdian Masyarakat' }}
        </div>
        <h1 class="fw-bold display-6 text-white mb-2">
            {{ $setting->page_headers['lppm']['title'] ?? 'Portal & Layanan LPPM' }}
        </h1>
        <p class="text-slate-300 mx-auto" style="max-width: 650px;">
            {{ $setting->page_headers['lppm']['subtitle'] ?? 'Pusat layanan riset, jurnal publikasi ilmiah, dan pengabdian masyarakat Sivitas Akademika AMIK Taruna Probolinggo' }}
        </p>
    </div>

    <!-- DESKRIPSI LPPM (MODERN GLASS CARD) -->
    @if(!empty($lppm->deskripsi))
    <div class="lppm-deskripsi-card mb-5 mx-auto">
        <div class="d-flex align-items-start gap-4">
            <div class="deskripsi-icon-box flex-shrink-0 d-none d-sm-flex">
                <i class="fas fa-atom"></i>
            </div>
            <div class="flex-grow-1">
                <h5 class="fw-bold text-emerald-300 mb-2 d-flex align-items-center gap-2">
                    <i class="fas fa-info-circle d-sm-none"></i> Tentang LPPM
                </h5>
                <p class="text-slate-300 mb-0 leading-relaxed">
                    {{ $lppm->deskripsi }}
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- GRID PORTAL CARDS (LIKE PELAYANAN MAHASISWA) -->
    <div class="row g-4 justify-content-center">

        @forelse($portals as $portal)

        <div class="col-md-6 col-lg-4">

            <a href="{{ $portal->link }}"
               target="_blank"
               class="text-decoration-none h-100 d-block">

                <div class="card lppm-card border-0 h-100 text-center p-4">

                    <!-- LOGO (ALWAYS CENTERED) -->
                    <div class="lppm-logo-wrapper mb-3 d-flex justify-content-center align-items-center">
                        @if($portal->logo)
                            @php
                                $logoPath = file_exists(public_path('uploads/lppm/' . $portal->logo)) 
                                    ? asset('uploads/lppm/' . $portal->logo) 
                                    : (file_exists(public_path('uploads/' . $portal->logo)) ? asset('uploads/' . $portal->logo) : asset('uploads/lppm/' . $portal->logo));
                            @endphp
                            <img src="{{ $logoPath }}"
                                 alt="{{ $portal->nama }}"
                                 class="lppm-logo">
                        @else
                            <div class="lppm-logo-kosong">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                        @endif
                    </div>

                    <!-- CONTENT -->
                    <div class="d-flex flex-column flex-grow-1 h-100">

                        <!-- TITLE -->
                        <h5 class="fw-bold lppm-title">
                            {{ $portal->nama }}
                        </h5>

                        <!-- DESKRIPSI -->
                        <p class="lppm-desc mt-2 flex-grow-1">
                            {{ $portal->deskripsi ?: 'Portal layanan penelitian & pengabdian masyarakat AMIK Taruna.' }}
                        </p>

                        <!-- BUTTON -->
                        <div class="mt-auto pt-3">
                            <span class="btn btn-{{ $portal->warna ?: 'success' }} lppm-btn rounded-pill px-4 py-2">
                                Kunjungi Portal <i class="fas fa-arrow-right ms-1"></i>
                            </span>
                        </div>

                    </div>

                </div>

            </a>

        </div>

        @empty

        <!-- FALLBACK IF EMPTY -->
        <div class="col-md-8 text-center py-5">
            <div class="alert text-center rounded-4 shadow-sm border border-emerald-500/30 text-slate-300 py-5" style="background: rgba(8, 38, 24, 0.85);">
                <i class="fas fa-folder-open fa-3x text-emerald-400 mb-3 d-block"></i>
                <h5 class="fw-bold text-white">Belum Ada Portal LPPM</h5>
                <p class="text-slate-300 small mb-0">Portal layanan LPPM belum ditambahkan oleh administrator.</p>
            </div>
        </div>

        @endforelse

    </div>

    <!-- SECTION DOKUMEN RISET & PENGABDIAN (LPPM) -->
    <div class="row justify-content-center mt-5" id="daftar-dokumen-lppm">
        <div class="col-lg-11">
            <div class="lppm-doc-section-card">

                {{-- Header List Dokumen --}}
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 pb-3 border-bottom border-white border-opacity-10 gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-3 text-white" style="width: 48px; height: 48px; background: rgba(74, 222, 128, 0.2); border: 1px solid rgba(74, 222, 128, 0.35);">
                            <i class="fas fa-book text-emerald-400 fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-white mb-0" style="font-size: 1.35rem;">
                                Dokumen Riset &amp; Pengabdian Masyarakat
                            </h4>
                            <span class="text-slate-300 small">Buku panduan hibah, pedoman PkM, template proposal/laporan, dan publikasi ilmiah LPPM</span>
                        </div>
                    </div>
                    <div>
                        <span class="badge px-3 py-2 rounded-pill small fw-semibold text-white d-inline-flex align-items-center gap-1.5" style="background: rgba(74, 222, 128, 0.2); border: 1px solid rgba(74, 222, 128, 0.4);">
                            <i class="fas fa-file-alt text-emerald-400"></i>
                            <span id="lppmDocCountBadge">{{ count($dokumens ?? []) }} Dokumen Tersedia</span>
                        </span>
                    </div>
                </div>

                {{-- FILTER KATEGORI & PENCARIAN LIVE --}}
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                    {{-- Tabs Filter Kategori --}}
                    <div class="d-flex flex-wrap gap-2" id="lppmCategoryTabs">
                        <button type="button" 
                                data-kat="semua" 
                                class="btn btn-sm rounded-pill px-3 fw-semibold lppm-kat-btn active">
                            Semua Dokumen
                        </button>
                        @foreach($kategoris ?? [] as $kItem)
                            <button type="button" 
                                    data-kat="{{ $kItem->slug }}" 
                                    class="btn btn-sm rounded-pill px-3 fw-semibold lppm-kat-btn">
                                {{ $kItem->ikon }} {{ $kItem->nama }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Search Input --}}
                    <div class="input-group input-group-sm" style="max-width: 320px;">
                        <span class="input-group-text bg-dark border-0 text-slate-400"><i class="fas fa-search"></i></span>
                        <input type="text" id="lppmSearchInput" class="form-control bg-dark text-white border-0" placeholder="Cari panduan, riset, jurnal...">
                        <button class="btn btn-outline-secondary border-0 text-slate-400" type="button" id="lppmResetSearchBtn" style="display: none;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                {{-- DAFTAR DOKUMEN LIST --}}
                <div class="d-flex flex-column gap-3" id="lppmDocListContainer">
                    @forelse($dokumens ?? [] as $doc)
                        @php
                            $katModel = $doc->kategoriModel;
                            $ext = strtolower(pathinfo($doc->file_pdf, PATHINFO_EXTENSION));
                            $isWord = in_array($ext, ['doc', 'docx']);
                        @endphp
                        <div class="lppm-doc-item" 
                             data-kat="{{ $doc->kategori }}" 
                             data-title="{{ strtolower($doc->nama_dokumen) }}" 
                             data-desc="{{ strtolower($doc->deskripsi ?? '') }}" 
                             data-year="{{ $doc->tahun ?? '' }}" 
                             data-katname="{{ strtolower($katModel?->nama ?? $doc->kategori) }}">
                            <div class="row align-items-center g-3">
                                <div class="col-auto">
                                    <div class="lppm-doc-icon {{ $isWord ? 'word-icon' : 'pdf-icon' }}">
                                        <i class="fas {{ $isWord ? 'fa-file-word' : 'fa-file-pdf' }}"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                        <span class="badge {{ $isWord ? 'bg-primary' : 'bg-danger' }} bg-opacity-25 {{ $isWord ? 'text-blue-300' : 'text-red-300' }} border {{ $isWord ? 'border-primary' : 'border-danger' }} border-opacity-25 px-2.5 py-0.5 rounded-pill font-monospace" style="font-size: 11px;">
                                            {{ strtoupper($ext) }}
                                        </span>
                                        @if($katModel)
                                            <span class="badge bg-success bg-opacity-20 text-emerald-300 border border-success border-opacity-30 px-2.5 py-0.5 rounded-pill" style="font-size: 11px;">
                                                {{ $katModel->ikon }} {{ $katModel->nama }}
                                            </span>
                                        @endif
                                        @if($doc->tahun)
                                            <span class="text-slate-400 small">
                                                <i class="fas fa-calendar-alt text-emerald-400 me-1"></i>{{ $doc->tahun }}
                                            </span>
                                        @endif
                                    </div>
                                    <h5 class="fw-bold text-white mb-1" style="font-size: 1.05rem;">
                                        {{ $doc->nama_dokumen }}
                                    </h5>
                                    @if($doc->deskripsi)
                                        <p class="text-slate-300 small mb-2" style="line-height: 1.6;">
                                            {{ $doc->deskripsi }}
                                        </p>
                                    @endif
                                    <div class="d-flex flex-wrap align-items-center gap-3 text-slate-400" style="font-size: 12px;">
                                        <span><i class="fas fa-paperclip {{ $isWord ? 'text-primary' : 'text-danger' }} me-1"></i>{{ $doc->file_pdf }}</span>
                                        <span>•</span>
                                        <span><i class="fas fa-flask text-emerald-400 me-1"></i>LPPM AMIK Taruna</span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-auto text-md-end mt-2 mt-md-0">
                                    <div class="d-flex flex-wrap gap-2 justify-content-start justify-content-md-end">
                                        <button type="button" 
                                                class="btn btn-outline-light rounded-pill px-3.5 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" 
                                                style="font-size: 0.88rem;"
                                                onclick="openLppmDocViewer('{{ asset('uploads/lppm/dokumen/' . $doc->file_pdf) }}', '{{ addslashes($doc->nama_dokumen) }}', '{{ $ext }}')">
                                            <i class="fas fa-eye text-emerald-400"></i>
                                            <span>Lihat</span>
                                        </button>
                                        <a href="{{ asset('uploads/lppm/dokumen/' . $doc->file_pdf) }}" download class="btn {{ $isWord ? 'btn-primary' : 'btn-success' }} rounded-pill px-3.5 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" style="font-size: 0.88rem;">
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
                    <div id="lppmDocEmptyState" class="p-4 rounded-4 text-center text-md-start" style="background: rgba(6, 28, 18, 0.65); border: 1px solid rgba(74, 222, 128, 0.2); display: {{ count($dokumens ?? []) == 0 ? 'block' : 'none' }};">
                        <div class="d-flex flex-column flex-md-row align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width: 58px; height: 58px; background: rgba(74, 222, 128, 0.15); border: 1px solid rgba(74, 222, 128, 0.3);">
                                <i class="fas fa-search text-warning fa-2x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold text-white mb-1" id="lppmEmptyTitle">Belum Ada Dokumen Riset pada Kategori Ini</h6>
                                <p class="text-slate-300 small mb-0" id="lppmEmptyDesc" style="line-height: 1.6;">
                                    Dokumen belum diunggah untuk kategori yang dipilih atau kata kunci pencarian tidak ditemukan. Silakan pilih tab "Semua Dokumen".
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <button type="button" id="btnResetLppmFilter" class="btn btn-sm btn-outline-success rounded-pill px-3">
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

<!-- LPPM Pop-up Document Viewer Modal (Dapat Di-scroll Sempurna di Desktop & HP) -->
<div class="modal fade modal-doc-viewer" id="lppmDocModal" tabindex="-1" aria-labelledby="lppmDocTitle" aria-hidden="true" style="z-index: 100050 !important;">
    <div class="modal-dialog modal-xl my-2 my-md-3" style="max-width: 1120px;">
        <div class="modal-content rounded-4 border-0 shadow-2xl d-flex flex-column" style="background: #0f172a; border: 1px solid rgba(74, 222, 128, 0.3) !important; height: calc(100vh - 2rem); max-height: calc(100vh - 2rem);">
            
            <!-- Modal Header -->
            <div class="modal-header border-0 py-3 px-4 flex-shrink-0" style="background: #022c22; border-bottom: 1px solid rgba(74, 222, 128, 0.2) !important;">
                <div class="d-flex align-items-center gap-2 min-w-0 flex-grow-1">
                    <span id="lppmDocBadge" class="badge rounded-pill text-uppercase font-monospace bg-dark text-emerald-400 border border-success">PDF</span>
                    <h6 class="modal-title fw-bold text-white text-truncate mb-0" id="lppmDocTitle">Pratinjau Dokumen LPPM</h6>
                </div>
                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                    <a id="lppmDocNewTab" href="#" target="_blank" class="btn btn-sm btn-outline-light rounded-pill px-3 d-none d-sm-inline-flex align-items-center gap-1">
                        <i class="fas fa-external-link-alt text-xs"></i> Tab Baru
                    </a>
                    <a id="lppmDocDownload" href="#" download class="btn btn-sm btn-success rounded-pill px-3.5 d-inline-flex align-items-center gap-1.5 fw-bold">
                        <i class="fas fa-download text-xs"></i> Unduh Berkas
                    </a>
                    <button type="button" class="btn btn-sm btn-light rounded-circle text-dark fw-bold d-inline-flex align-items-center justify-content-center shadow-sm" data-bs-dismiss="modal" aria-label="Close" style="width: 34px; height: 34px; padding: 0;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Sub-Toolbar Interaktif: Navigasi, Zoom, Mode Kanvas Continuous Scroll -->
            <div id="lppmDocToolbar" class="px-3 py-2 bg-dark bg-opacity-75 border-bottom border-emerald-500 border-opacity-20 text-slate-300 small d-flex flex-wrap align-items-center justify-content-between gap-2 flex-shrink-0">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="d-inline-flex align-items-center gap-1.5 text-emerald-300 fw-semibold">
                        <i class="fas fa-file-alt text-emerald-400"></i>
                        <span>Hal:</span>
                        <span id="lppmCurrentPageBadge" class="badge bg-emerald-950 text-emerald-300 border border-emerald-500/40">1 / 1</span>
                    </span>

                    <!-- Quick Page Scroll Buttons -->
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-xs btn-outline-secondary text-white rounded-start-pill px-2" onclick="lppmScrollPage(-1)" title="Gulir ke Atas">
                            <i class="fas fa-chevron-up"></i>
                        </button>
                        <button type="button" class="btn btn-xs btn-outline-secondary text-white rounded-end-pill px-2" onclick="lppmScrollPage(1)" title="Gulir ke Bawah">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>

                    <!-- Zoom Controls (Canvas Mode) -->
                    <div id="lppmCanvasControls" class="d-inline-flex align-items-center gap-1 ms-1">
                        <button type="button" class="btn btn-xs btn-outline-secondary text-white rounded-circle p-0" style="width: 24px; height: 24px;" onclick="lppmZoom(-0.15)" title="Perkecil">
                            <i class="fas fa-minus text-[10px]"></i>
                        </button>
                        <span id="lppmZoomLevel" class="small text-slate-300 font-monospace px-1">Fit</span>
                        <button type="button" class="btn btn-xs btn-outline-secondary text-white rounded-circle p-0" style="width: 24px; height: 24px;" onclick="lppmZoom(0.15)" title="Perbesar">
                            <i class="fas fa-plus text-[10px]"></i>
                        </button>
                        <button type="button" class="btn btn-xs btn-outline-secondary text-white rounded-pill px-2 ms-1" onclick="lppmFitWidth()" title="Sesuaikan Lebar">
                            <i class="fas fa-expand-arrows-alt text-[10px]"></i> Pas Lebar
                        </button>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <button type="button" id="lppmToggleModeBtn" class="btn btn-xs btn-outline-light text-slate-300 rounded-pill px-2.5 py-1 small d-inline-flex align-items-center gap-1" onclick="toggleLppmViewMode()" title="Ganti antara mode kanvas berkelanjutan dan bingkai browser bawaan">
                        <i class="fas fa-desktop"></i> Mode Browser
                    </button>
                    <a id="lppmDocFullTab" href="#" target="_blank" class="btn btn-xs btn-outline-success text-emerald-300 rounded-pill px-2.5 py-1 text-decoration-none fw-semibold small d-inline-flex align-items-center gap-1">
                        <i class="fas fa-external-link-alt"></i> Layar Penuh
                    </a>
                </div>
            </div>

            <!-- Modal Body (Continuous Canvas & Fallback) -->
            <div class="modal-body p-0 flex-grow-1 position-relative d-flex flex-column" style="background: #020617; overflow: hidden; height: 100%;">
                
                <!-- 1. High Performance Continuous Scroll Canvas View (Semua halaman di-scroll mulus) -->
                <div id="lppmPdfContinuousView" class="w-100 flex-grow-1" style="overflow-y: auto; overflow-x: hidden; -webkit-overflow-scrolling: touch; padding: 24px 12px; background: #0b1329;">
                    <!-- Loading Indicator -->
                    <div id="lppmPdfLoading" class="text-center py-5 text-emerald-400">
                        <div class="spinner-border spinner-border-sm text-success mb-2" role="status"></div>
                        <div class="small fw-semibold">Memuat halaman dokumen secara interaktif...</div>
                    </div>
                    <!-- Canvases Container (Setiap halaman ditumpuk ke bawah, scroll mouse langsung aktif) -->
                    <div id="lppmPdfPagesContainer" class="d-flex flex-column align-items-center"></div>
                </div>

                <!-- 2. Native Browser PDF Viewer Frame (Fallback / Mode Browser) -->
                <iframe id="lppmDocIframe" 
                        src="" 
                        class="d-none w-100 flex-grow-1 border-0 bg-white" 
                        style="width: 100%; height: 100%; min-height: 400px;" 
                        scrolling="yes" 
                        allow="fullscreen">
                </iframe>

                <!-- Word Document Fallback Card -->
                <div id="lppmDocWordFallback" class="d-none w-100 h-100 flex-column align-items-center justify-content-center text-center p-4 p-md-5 my-auto" style="min-height: 480px;">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 76px; height: 76px;">
                        <i class="fas fa-file-word fa-3x"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-2" id="lppmWordDocTitle">Dokumen Microsoft Word</h5>
                    <p class="text-slate-400 small mb-4 mx-auto" style="max-width: 500px; line-height: 1.6;">
                        Format dokumen Word (.doc / .docx) tidak dapat ditampilkan secara interaktif di dalam bingkai peramban. Silakan unduh atau buka berkas untuk membaca seluruh isinya.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <a id="lppmWordDownload" href="#" download class="btn btn-primary rounded-pill px-4 py-2 fw-bold d-inline-flex align-items-center gap-2">
                            <i class="fas fa-download"></i> Unduh Berkas Word
                        </a>
                        <a id="lppmWordNewTab" href="#" target="_blank" class="btn btn-outline-light rounded-pill px-4 py-2 fw-semibold d-inline-flex align-items-center gap-2">
                            <i class="fas fa-external-link-alt"></i> Buka Berkas Langsung
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const katButtons = document.querySelectorAll('.lppm-kat-btn');
    const searchInput = document.getElementById('lppmSearchInput');
    const resetSearchBtn = document.getElementById('lppmResetSearchBtn');
    const docItems = document.querySelectorAll('.lppm-doc-item');
    const emptyState = document.getElementById('lppmDocEmptyState');
    const emptyTitle = document.getElementById('lppmEmptyTitle');
    const emptyDesc = document.getElementById('lppmEmptyDesc');
    const countBadge = document.getElementById('lppmDocCountBadge');
    const resetFilterBtn = document.getElementById('btnResetLppmFilter');

    let activeCategory = 'semua';
    let searchQuery = '';

    function runLppmFilter() {
        const query = searchQuery.toLowerCase().trim();
        let visibleCount = 0;

        docItems.forEach(item => {
            const cardKat = item.getAttribute('data-kat') || '';
            const cardTitle = item.getAttribute('data-title') || '';
            const cardDesc = item.getAttribute('data-desc') || '';
            const cardYear = item.getAttribute('data-year') || '';
            const cardKatName = item.getAttribute('data-katname') || '';

            const matchCategory = (activeCategory === 'semua' || cardKat === activeCategory);
            const matchSearch = (!query ||
                cardTitle.includes(query) ||
                cardDesc.includes(query) ||
                cardYear.includes(query) ||
                cardKatName.includes(query)
            );

            if (matchCategory && matchSearch) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        katButtons.forEach(btn => {
            const kat = btn.getAttribute('data-kat');
            if (kat === activeCategory) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        if (resetSearchBtn) {
            resetSearchBtn.style.display = query.length > 0 ? 'inline-block' : 'none';
        }

        if (emptyState) {
            if (visibleCount === 0) {
                emptyState.style.display = 'block';
                if (query) {
                    emptyTitle.textContent = `Dokumen "${query}" Tidak Ditemukan`;
                    emptyDesc.textContent = `Tidak ada dokumen riset yang cocok dengan kata kunci "${query}". Silakan ubah kata kunci atau ganti kategori.`;
                } else {
                    emptyTitle.textContent = 'Belum Ada Dokumen Riset pada Kategori Ini';
                    emptyDesc.textContent = 'Arsip dokumen belum diunggah untuk kategori yang dipilih. Silakan pilih tab "Semua Dokumen".';
                }
            } else {
                emptyState.style.display = 'none';
            }
        }

        if (countBadge) {
            countBadge.textContent = `${visibleCount} Dokumen Ditampilkan`;
        }
    }

    katButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            activeCategory = this.getAttribute('data-kat') || 'semua';
            runLppmFilter();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            searchQuery = this.value;
            runLppmFilter();
        });
    }

    if (resetSearchBtn) {
        resetSearchBtn.addEventListener('click', function () {
            if (searchInput) searchInput.value = '';
            searchQuery = '';
            runLppmFilter();
        });
    }

    if (resetFilterBtn) {
        resetFilterBtn.addEventListener('click', function () {
            activeCategory = 'semua';
            if (searchInput) searchInput.value = '';
            searchQuery = '';
            runLppmFilter();
        });
    }

    runLppmFilter();
});

// Pop-up Document Viewer handler with Continuous Canvas PDF.js Engine for LPPM
let lppmDocModalObj = null;
let lppmPdfDoc = null;
let lppmCurrentScale = 'fit';
let lppmCurrentFileUrl = '';
let lppmRenderToken = 0;
let lppmIsCanvasMode = true;

function getLppmModal() {
    const modalEl = document.getElementById('lppmDocModal');
    if (!modalEl) return null;
    if (!lppmDocModalObj) {
        lppmDocModalObj = bootstrap.Modal.getOrCreateInstance(modalEl, {
            backdrop: true,
            keyboard: true,
            focus: true
        });
    }
    return lppmDocModalObj;
}

function updateLppmZoomText() {
    const zoomText = document.getElementById('lppmZoomLevel');
    if (zoomText) {
        if (lppmCurrentScale === 'fit') {
            zoomText.textContent = 'Fit';
        } else {
            zoomText.textContent = Math.round(lppmCurrentScale * 100) + '%';
        }
    }
}

async function renderLppmPdf() {
    if (!lppmPdfDoc) return;
    const token = ++lppmRenderToken;
    const pagesContainer = document.getElementById('lppmPdfPagesContainer');
    const loadingEl = document.getElementById('lppmPdfLoading');
    const wrapper = document.getElementById('lppmPdfContinuousView');
    if (!pagesContainer || !wrapper) return;

    if (loadingEl) loadingEl.classList.remove('d-none');
    pagesContainer.innerHTML = '';

    const containerWidth = wrapper.clientWidth || 800;
    const outputScale = Math.min(window.devicePixelRatio || 1, 2);

    try {
        for (let pageNum = 1; pageNum <= lppmPdfDoc.numPages; pageNum++) {
            if (token !== lppmRenderToken) return;

            const page = await lppmPdfDoc.getPage(pageNum);
            if (token !== lppmRenderToken) return;

            const unscaled = page.getViewport({ scale: 1 });
            let scale = lppmCurrentScale;
            if (scale === 'fit' || typeof scale !== 'number') {
                scale = Math.min(2.5, Math.max(0.5, (containerWidth - 40) / unscaled.width));
            }

            const viewport = page.getViewport({ scale: scale });

            const pageCard = document.createElement('div');
            pageCard.className = 'pdf-page-card mb-4 text-center';
            pageCard.setAttribute('data-page-num', pageNum);

            const canvas = document.createElement('canvas');
            canvas.className = 'shadow-2xl rounded-2 mx-auto d-block';
            canvas.style.maxWidth = '100%';
            canvas.style.height = 'auto';
            canvas.style.backgroundColor = '#ffffff';

            canvas.width = Math.floor(viewport.width * outputScale);
            canvas.height = Math.floor(viewport.height * outputScale);
            canvas.style.width = Math.floor(viewport.width) + 'px';

            const ctx = canvas.getContext('2d', { alpha: false });
            const transform = outputScale !== 1 ? [outputScale, 0, 0, outputScale, 0, 0] : null;

            pageCard.appendChild(canvas);

            const pageFooter = document.createElement('div');
            pageFooter.className = 'text-slate-400 small mt-1 font-monospace';
            pageFooter.textContent = `Halaman ${pageNum} dari ${lppmPdfDoc.numPages}`;
            pageCard.appendChild(pageFooter);

            pagesContainer.appendChild(pageCard);

            const renderContext = {
                canvasContext: ctx,
                transform: transform,
                viewport: viewport
            };
            await page.render(renderContext).promise;

            if (pageNum === 1 && loadingEl) {
                loadingEl.classList.add('d-none');
            }
        }
    } catch (e) {
        console.error('Error rendering LPPM PDF:', e);
    } finally {
        if (loadingEl) loadingEl.classList.add('d-none');
    }
}

async function loadLppmPdfWithPdfJs(fileUrl) {
    const loadingEl = document.getElementById('lppmPdfLoading');
    const pagesContainer = document.getElementById('lppmPdfPagesContainer');
    const badge = document.getElementById('lppmCurrentPageBadge');
    if (loadingEl) loadingEl.classList.remove('d-none');
    if (pagesContainer) pagesContainer.innerHTML = '';
    if (badge) badge.textContent = 'Memuat...';

    try {
        if (!window.pdfjsLib) throw new Error('PDF.js engine not loaded');
        const loadingTask = window.pdfjsLib.getDocument({
            url: fileUrl,
            cMapUrl: 'https://cdn.jsdelivr.net/npm/pdfjs-dist@3.11.174/cmaps/',
            cMapPacked: true
        });
        lppmPdfDoc = await loadingTask.promise;
        if (badge) badge.textContent = `1 / ${lppmPdfDoc.numPages}`;
        lppmCurrentScale = 'fit';
        updateLppmZoomText();
        await renderLppmPdf();
    } catch (err) {
        console.warn('PDF.js render fallback to native iframe viewer:', err);
        setLppmViewerMode('iframe');
    }
}

function lppmZoom(delta) {
    if (!lppmPdfDoc) return;
    if (lppmCurrentScale === 'fit') {
        lppmCurrentScale = 1.0;
    }
    let newScale = (typeof lppmCurrentScale === 'number' ? lppmCurrentScale : 1.0) + delta;
    newScale = Math.min(3.0, Math.max(0.5, newScale));
    lppmCurrentScale = Math.round(newScale * 100) / 100;
    updateLppmZoomText();
    renderLppmPdf();
}

function lppmFitWidth() {
    if (!lppmPdfDoc) return;
    lppmCurrentScale = 'fit';
    updateLppmZoomText();
    renderLppmPdf();
}

function lppmScrollPage(direction) {
    const wrapper = document.getElementById('lppmPdfContinuousView');
    if (!wrapper) return;
    if (direction > 0) {
        wrapper.scrollBy({ top: wrapper.clientHeight * 0.85, behavior: 'smooth' });
    } else {
        wrapper.scrollBy({ top: -wrapper.clientHeight * 0.85, behavior: 'smooth' });
    }
}

function setLppmViewerMode(mode) {
    lppmIsCanvasMode = mode === 'canvas';
    const canvasWrap = document.getElementById('lppmPdfContinuousView');
    const iframe = document.getElementById('lppmDocIframe');
    const modeBtn = document.getElementById('lppmToggleModeBtn');
    const canvasControls = document.getElementById('lppmCanvasControls');

    if (lppmIsCanvasMode) {
        if (canvasWrap) canvasWrap.classList.remove('d-none');
        if (iframe) {
            iframe.classList.add('d-none');
            iframe.src = 'about:blank';
        }
        if (modeBtn) modeBtn.innerHTML = '<i class="fas fa-desktop"></i> Mode Browser';
        if (canvasControls) canvasControls.classList.remove('d-none');
        if (lppmCurrentFileUrl && !lppmPdfDoc) {
            loadLppmPdfWithPdfJs(lppmCurrentFileUrl);
        }
    } else {
        if (canvasWrap) canvasWrap.classList.add('d-none');
        if (iframe) {
            iframe.classList.remove('d-none');
            iframe.src = lppmCurrentFileUrl + '#view=FitH&zoom=page-width&toolbar=1&navpanes=0&scrollbar=1';
        }
        if (modeBtn) modeBtn.innerHTML = '<i class="fas fa-scroll"></i> Mode Kanvas';
        if (canvasControls) canvasControls.classList.add('d-none');
    }
}

function toggleLppmViewMode() {
    setLppmViewerMode(lppmIsCanvasMode ? 'iframe' : 'canvas');
}

function openLppmDocViewer(fileUrl, docTitle, ext) {
    lppmCurrentFileUrl = fileUrl;
    lppmPdfDoc = null;
    const isWord = ['doc', 'docx'].includes((ext || '').toLowerCase());
    const iframeEl = document.getElementById('lppmDocIframe');
    const canvasWrap = document.getElementById('lppmPdfContinuousView');
    const wordFallbackEl = document.getElementById('lppmDocWordFallback');
    const fullTabBtn = document.getElementById('lppmDocFullTab');
    const toolbar = document.getElementById('lppmDocToolbar');
    
    document.getElementById('lppmDocTitle').textContent = docTitle;
    document.getElementById('lppmDocBadge').textContent = (ext || 'PDF').toUpperCase();
    document.getElementById('lppmDocDownload').href = fileUrl;
    document.getElementById('lppmDocNewTab').href = fileUrl;
    if (fullTabBtn) fullTabBtn.href = fileUrl;

    if (isWord) {
        if (toolbar) toolbar.classList.add('d-none');
        if (canvasWrap) canvasWrap.classList.add('d-none');
        if (iframeEl) {
            iframeEl.classList.add('d-none');
            iframeEl.src = 'about:blank';
        }
        if (wordFallbackEl) {
            wordFallbackEl.classList.remove('d-none');
            wordFallbackEl.classList.add('d-flex');
            document.getElementById('lppmWordDocTitle').textContent = docTitle;
            document.getElementById('lppmWordDownload').href = fileUrl;
            document.getElementById('lppmWordNewTab').href = fileUrl;
        }
    } else {
        if (toolbar) toolbar.classList.remove('d-none');
        if (wordFallbackEl) {
            wordFallbackEl.classList.add('d-none');
            wordFallbackEl.classList.remove('d-flex');
        }
        setLppmViewerMode('canvas');
        loadLppmPdfWithPdfJs(fileUrl);
    }

    const modal = getLppmModal();
    if (modal) {
        modal.show();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const modalEl = document.getElementById('lppmDocModal');
    if (modalEl) {
        modalEl.addEventListener('hidden.bs.modal', function () {
            lppmRenderToken++;
            const iframe = document.getElementById('lppmDocIframe');
            if (iframe) iframe.src = 'about:blank';
            const pagesContainer = document.getElementById('lppmPdfPagesContainer');
            if (pagesContainer) pagesContainer.innerHTML = '';
            lppmPdfDoc = null;

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

    const scrollWrap = document.getElementById('lppmPdfContinuousView');
    if (scrollWrap) {
        scrollWrap.addEventListener('scroll', function() {
            if (!lppmPdfDoc) return;
            const cards = scrollWrap.querySelectorAll('.pdf-page-card');
            const wrapTop = scrollWrap.scrollTop;
            let current = 1;
            cards.forEach(card => {
                if (card.offsetTop - scrollWrap.offsetTop <= wrapTop + 140) {
                    current = parseInt(card.getAttribute('data-page-num')) || current;
                }
            });
            const badge = document.getElementById('lppmCurrentPageBadge');
            if (badge) badge.textContent = `${current} / ${lppmPdfDoc.numPages}`;
        }, { passive: true });
    }
});
</script>

<style>
/* DESKRIPSI CARD */
.lppm-deskripsi-card {
    background: rgba(10, 42, 27, 0.85);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-radius: 26px;
    padding: 28px 32px;
    border: 1px solid rgba(74, 222, 128, 0.22);
    box-shadow: 0 14px 35px rgba(0, 0, 0, 0.35);
    position: relative;
    overflow: hidden;
    max-width: 900px;
}

.lppm-deskripsi-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 6px;
    height: 100%;
    background: linear-gradient(180deg, #4ade80, #16a34a);
}

.deskripsi-icon-box {
    width: 56px;
    height: 56px;
    border-radius: 18px;
    background: rgba(74, 222, 128, 0.15);
    border: 1px solid rgba(74, 222, 128, 0.3);
    color: #4ade80;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

/* LPPM PORTAL CARD */
.lppm-card {
    position: relative;
    overflow: hidden;
    border-radius: 28px;
    background: rgba(8, 38, 24, 0.85);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(74, 222, 128, 0.22);
    min-height: 350px;
    transition: all .4s cubic-bezier(0.165, 0.84, 0.44, 1);
    box-shadow: 0 14px 35px rgba(0, 0, 0, 0.35);
}

/* AMBIENT GLOW CIRCLE */
.lppm-card::before {
    content: '';
    position: absolute;
    width: 180px;
    height: 180px;
    background: rgba(74, 222, 128, 0.12);
    border-radius: 50%;
    top: -70px;
    right: -70px;
    transition: .4s cubic-bezier(0.165, 0.84, 0.44, 1);
}

/* CARD HOVER */
.lppm-card:hover {
    transform: translateY(-8px);
    background: rgba(12, 48, 30, 0.96);
    border-color: rgba(74, 222, 128, 0.45);
    box-shadow: 0 20px 45px rgba(74, 222, 128, 0.16), 0 10px 25px rgba(0, 0, 0, 0.5);
}

.lppm-card:hover::before {
    transform: scale(1.4);
    background: rgba(74, 222, 128, 0.2);
}

/* LOGO WRAPPER & CENTERING */
.lppm-logo-wrapper {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    margin: 0 auto 1.25rem auto;
}

/* LOGO */
.lppm-logo {
    width: 88px;
    height: 88px;
    object-fit: contain;
    border-radius: 22px;
    padding: 10px;
    background: #ffffff;
    border: 1px solid rgba(74, 222, 128, 0.3);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    display: block;
    margin: 0 auto;
    transition: .4s;
}

.lppm-card:hover .lppm-logo {
    transform: rotate(-4deg) scale(1.06);
}

/* FALLBACK LOGO */
.lppm-logo-kosong {
    width: 88px;
    height: 88px;
    border-radius: 22px;
    background: rgba(74, 222, 128, 0.15);
    border: 1px solid rgba(74, 222, 128, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: #4ade80;
    margin: 0 auto;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    transition: .4s;
}

.lppm-card:hover .lppm-logo-kosong {
    transform: rotate(-4deg) scale(1.06);
}

/* TITLE */
.lppm-title {
    font-size: 19px;
    font-weight: 700;
    color: #ffffff;
    transition: .3s;
    line-height: 1.4;
}

/* DESC */
.lppm-desc {
    font-size: 13.5px;
    line-height: 1.75;
    color: #cbd5e1;
    transition: .3s;
}

/* BUTTON */
.lppm-btn {
    font-size: 13px;
    font-weight: 700;
    border-radius: 50px;
    padding: 9px 22px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
    transition: .3s;
}

.lppm-card:hover .lppm-btn {
    transform: scale(1.02);
}

/* MOBILE RESPONSIVENESS */
@media (max-width: 768px) {
    .lppm-card {
        min-height: auto;
        border-radius: 24px;
    }

    .lppm-logo,
    .lppm-logo-kosong {
        width: 76px;
        height: 76px;
    }

    .lppm-deskripsi-card {
        padding: 20px;
    }
}

/* SECTION DOKUMEN LPPM */
.lppm-doc-section-card {
    background: rgba(10, 42, 27, 0.85);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-radius: 26px;
    border: 1px solid rgba(74, 222, 128, 0.22);
    box-shadow: 0 14px 35px rgba(0,0,0,0.35);
    padding: 36px 32px;
}

.lppm-doc-item {
    background: rgba(6, 28, 18, 0.75);
    border: 1px solid rgba(74, 222, 128, 0.18);
    border-radius: 18px;
    padding: 22px 24px;
    transition: all 0.3s ease;
}

.lppm-doc-item:hover {
    background: rgba(12, 48, 30, 0.95);
    border-color: rgba(74, 222, 128, 0.4);
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

.lppm-doc-icon {
    width: 54px;
    height: 54px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    flex-shrink: 0;
}

.lppm-doc-icon.pdf-icon {
    background: rgba(239, 68, 68, 0.15);
    color: #ef4444;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.lppm-doc-icon.word-icon {
    background: rgba(59, 130, 246, 0.15);
    color: #3b82f6;
    border: 1px solid rgba(59, 130, 246, 0.3);
}

.lppm-kat-btn {
    transition: all 0.25s ease;
    font-size: 0.82rem;
    border: 1px solid rgba(255, 255, 255, 0.18);
    color: #cbd5e1;
    background: rgba(255, 255, 255, 0.05);
}

.lppm-kat-btn:hover {
    background: rgba(74, 222, 128, 0.18);
    border-color: rgba(74, 222, 128, 0.5);
    color: #ffffff;
    transform: translateY(-1px);
}

.lppm-kat-btn.active {
    background: #16a34a !important;
    border-color: #22c55e !important;
    color: #ffffff !important;
    box-shadow: 0 4px 14px rgba(22, 163, 74, 0.4);
}
</style>

@endsection