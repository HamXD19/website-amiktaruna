@extends('layouts.main')

@section('content')

<style>
    /* Hero Header Berita */
    .berita-hero-header {
        background: rgba(8, 38, 24, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(74, 222, 128, 0.22);
        border-radius: 28px;
        padding: 40px 32px;
        box-shadow: 0 16px 40px -4px rgba(2, 20, 12, 0.5);
    }

    /* Tab Filter Kategori */
    .berita-tab-btn {
        transition: all 0.25s ease;
        font-size: 0.82rem;
        font-weight: 600;
        border-radius: 50px;
        padding: 7px 18px;
        border: 1px solid rgba(255, 255, 255, 0.18);
        color: #cbd5e1;
        background: rgba(255, 255, 255, 0.05);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .berita-tab-btn:hover {
        background: rgba(74, 222, 128, 0.18);
        border-color: rgba(74, 222, 128, 0.45);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .berita-tab-btn.active {
        background: #16a34a !important;
        border-color: #22c55e !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(22, 163, 74, 0.4);
    }

    /* Featured Headline Card */
    .berita-featured-card {
        background: rgba(10, 42, 27, 0.88);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(74, 222, 128, 0.24);
        border-radius: 26px;
        overflow: hidden;
        transition: all 0.35s ease;
        box-shadow: 0 14px 35px rgba(0, 0, 0, 0.35);
    }

    .berita-featured-card:hover {
        border-color: rgba(74, 222, 128, 0.45);
        box-shadow: 0 18px 40px rgba(74, 222, 128, 0.15), 0 10px 25px rgba(0, 0, 0, 0.4);
    }

    /* Regular Grid Card */
    .berita-grid-card {
        background: rgba(8, 36, 23, 0.82);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(74, 222, 128, 0.18);
        border-radius: 22px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .berita-grid-card:hover {
        transform: translateY(-5px);
        background: rgba(12, 48, 30, 0.95);
        border-color: rgba(74, 222, 128, 0.45);
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.35), 0 0 20px rgba(74, 222, 128, 0.15);
    }

    /* Image Wrappers & Fallback Graphic */
    .berita-img-holder {
        position: relative;
        width: 100%;
        overflow: hidden;
        background: #041d11;
    }

    .berita-img-holder img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .berita-grid-card:hover .berita-img-holder img,
    .berita-featured-card:hover .berita-img-holder img {
        transform: scale(1.05);
    }

    .berita-fallback-graphic {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #052616 0%, #0d4428 50%, #041d11 100%);
        color: #ffffff;
        text-align: center;
        padding: 20px;
    }

    .berita-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    /* Title clamp */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<div class="container py-5">

    {{-- 1. HERO HEADER PORTAL BERITA --}}
    <div class="berita-hero-header mb-5 position-relative">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill mb-3" style="background: rgba(74, 222, 128, 0.15); border: 1px solid rgba(74, 222, 128, 0.3);">
                    <i class="fas fa-newspaper text-success"></i>
                    <span class="text-success fw-bold small text-uppercase tracking-wider">Portal Publikasi &amp; Warta</span>
                </div>
                <h1 class="fw-extrabold text-white mb-2" style="font-size: 2.3rem; letter-spacing: -0.5px;">
                    Warta &amp; Kabar Kampus
                </h1>
                <p class="text-slate-300 mb-0" style="font-size: 1rem; line-height: 1.7;">
                    Informasi resmi, agenda kegiatan, pengumuman akademik, dan publikasi Tridharma Perguruan Tinggi AMIK Taruna Probolinggo.
                </p>
            </div>

            {{-- Kolom Kanan: Pencarian --}}
            <div class="col-lg-5">
                <form method="GET" action="{{ url('/berita') }}" id="searchBeritaForm">
                    <div class="input-group p-1 rounded-pill" style="background: rgba(4, 26, 16, 0.85); border: 1px solid rgba(74, 222, 128, 0.35);">
                        <span class="input-group-text bg-transparent border-0 text-slate-400 ps-3">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text"
                               name="search"
                               id="beritaSearchInput"
                               class="form-control bg-transparent border-0 text-white shadow-none"
                               placeholder="Cari judul, topik, atau kata kunci..."
                               value="{{ request('search') }}"
                               autocomplete="off">
                        @if(request('search'))
                            <a href="{{ url('/berita') }}" class="btn btn-sm btn-dark rounded-circle me-1 my-auto d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;" title="Reset Pencarian">
                                <i class="fas fa-times text-slate-400" style="font-size: 11px;"></i>
                            </a>
                        @endif
                        <button class="btn btn-success rounded-pill px-4 fw-bold" type="submit">
                            Cari
                        </button>
                    </div>
                </form>
                @if(request('search'))
                    <div class="mt-2 text-end">
                        <small class="text-emerald-400">
                            <i class="fas fa-filter me-1"></i>Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                        </small>
                    </div>
                @endif
            </div>
        </div>

        {{-- Tabs Filter Kategori Berita --}}
        <div class="d-flex flex-wrap gap-2 align-items-center mt-4 pt-3 border-top border-white border-opacity-10" id="beritaCategoryTabs">
            <span class="text-slate-400 small fw-semibold me-2">Kategori:</span>

            <button type="button" 
                    data-category="semua" 
                    class="berita-tab-btn active">
                Semua Warta ({{ count($allBerita) }})
            </button>

            @foreach($kategoriData as $kSlug => $kItem)
                @if(count($kItem['data']) > 0)
                    <button type="button" 
                            data-category="{{ $kSlug }}" 
                            class="berita-tab-btn">
                        <span>{{ $kItem['icon'] }}</span>
                        <span>{{ $kItem['label'] }} ({{ count($kItem['data']) }})</span>
                    </button>
                @endif
            @endforeach
        </div>
    </div>

    @php
        $featured = $allBerita->first();
        $otherBeritas = $allBerita->slice(1);
    @endphp

    {{-- 2. SOROTAN UTAMA (FEATURED HEADLINE) JIKA TIDAK SEDANG SEARCH TERTENTU --}}
    @if($featured && !request('search'))
        @php
            $fKat = $featured->kategori ?: 'warta';
            $fKatData = $kategoriData[$fKat] ?? [
                'label' => ucfirst(str_replace('_', ' ', $fKat)),
                'icon'  => '📰',
                'color' => 'success'
            ];
        @endphp
        <div class="berita-featured-card mb-5 p-4 p-lg-5 position-relative headline-article-container" data-category="{{ $fKat }}">
            <div class="row align-items-center g-4 g-lg-5">
                {{-- Gambar Headline --}}
                <div class="col-lg-7">
                    <div class="berita-img-holder rounded-4 shadow-lg" style="aspect-ratio: 16/10;">
                        @if($featured->gambar)
                            <img src="{{ asset('uploads/berita/gambar/' . $featured->gambar) }}" 
                                 alt="{{ $featured->judul }}"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        @endif

                        {{-- Fallback Graphic jika gambar tidak ada atau gagal load --}}
                        <div class="berita-fallback-graphic" style="{{ $featured->gambar ? 'display: none;' : 'display: flex;' }}">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2" style="width: 70px; height: 70px; background: rgba(74, 222, 128, 0.18); border: 2px solid rgba(74, 222, 128, 0.4);">
                                <span style="font-size: 2rem;">{{ $fKatData['icon'] }}</span>
                            </div>
                            <span class="font-monospace fw-bold text-success text-uppercase small tracking-wider">AMIK Taruna Probolinggo</span>
                            <span class="text-slate-400 small">Warta Resmi Kampus Digital</span>
                        </div>

                        {{-- Badges di atas gambar --}}
                        <div class="position-absolute top-0 start-0 p-3 d-flex gap-2">
                            <span class="badge rounded-pill bg-success text-white px-3 py-1.5 small fw-bold shadow">
                                <i class="fas fa-star me-1 text-warning"></i>Sorotan Utama
                            </span>
                            <span class="badge rounded-pill bg-dark bg-opacity-75 text-emerald-300 border border-success border-opacity-25 px-3 py-1.5 small fw-bold">
                                {{ $fKatData['icon'] }} {{ $fKatData['label'] }}
                            </span>
                        </div>

                        @if($featured->video)
                            <div class="position-absolute bottom-0 end-0 p-3">
                                <span class="badge rounded-pill bg-danger text-white px-3 py-1.5 small fw-bold shadow">
                                    <i class="fas fa-play me-1"></i>Video Liputan
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Detail Headline --}}
                <div class="col-lg-5">
                    <div class="d-flex align-items-center gap-3 text-slate-400 small mb-2">
                        <span class="text-emerald-400 fw-semibold">
                            <i class="far fa-calendar-alt me-1"></i>{{ $featured->publish_at ? \Carbon\Carbon::parse($featured->publish_at)->format('d F Y') : $featured->created_at->format('d F Y') }}
                        </span>
                        <span>•</span>
                        <span><i class="far fa-user me-1"></i>{{ $featured->penulis ?? 'Humas AMIK' }}</span>
                    </div>

                    <h2 class="fw-bold text-white mb-3" style="font-size: 1.75rem; line-height: 1.4;">
                        <a href="{{ url('/berita/' . ($featured->slug ?: $featured->id)) }}" class="text-white text-decoration-none hover-emerald">
                            {{ $featured->judul }}
                        </a>
                    </h2>

                    <p class="text-slate-300 mb-4" style="line-height: 1.8; font-size: 0.96rem;">
                        {{ Str::limit(strip_tags($featured->isi), 175) }}
                    </p>

                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <a href="{{ url('/berita/' . ($featured->slug ?: $featured->id)) }}" class="btn btn-success rounded-pill px-4 py-2.5 fw-bold d-inline-flex align-items-center gap-2 shadow-lg">
                            <span>Baca Selengkapnya</span>
                            <i class="fas fa-arrow-right small"></i>
                        </a>

                        @if($featured->file_pdf)
                            <span class="badge rounded-pill text-danger px-3 py-2 small" style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.35);">
                                <i class="fas fa-paperclip me-1"></i>Lampiran Dokumen
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- 3. GRID DAFTAR WARTA --}}
    <div class="mb-4 d-flex align-items-center justify-content-between pb-2 border-bottom border-white border-opacity-10">
        <div>
            <h4 class="fw-bold text-white mb-0 d-flex align-items-center gap-2" style="font-size: 1.25rem;">
                <i class="fas fa-layer-group text-success"></i>
                <span id="gridSectionTitle">Semua Warta Terpublikasi</span>
            </h4>
        </div>
        <span class="badge px-3 py-1.5 rounded-pill small fw-semibold text-emerald-300" style="background: rgba(74, 222, 128, 0.15); border: 1px solid rgba(74, 222, 128, 0.35);" id="articleCountBadge">
            {{ count($allBerita) }} Artikel Tersedia
        </span>
    </div>

    {{-- Container Kartu Grid --}}
    <div class="row g-4" id="beritaGridContainer">
        @forelse($allBerita as $b)
            @php
                $bKat = $b->kategori ?: 'warta';
                $katInfo = $kategoriData[$bKat] ?? [
                    'label' => ucfirst(str_replace('_', ' ', $bKat)),
                    'icon'  => '📰',
                    'color' => 'success'
                ];
            @endphp
            <div class="col-md-6 col-lg-4 berita-grid-item" data-category="{{ $bKat }}" data-title="{{ strtolower($b->judul) }}" data-excerpt="{{ strtolower(strip_tags($b->isi)) }}">
                <article class="berita-grid-card shadow-sm">
                    
                    {{-- Gambar Kartu dengan Fallback Elegan --}}
                    <div class="berita-img-holder" style="aspect-ratio: 16/9;">
                        @if($b->gambar)
                            <img src="{{ asset('uploads/berita/gambar/' . $b->gambar) }}" 
                                 alt="{{ $b->judul }}"
                                 loading="lazy"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        @endif

                        {{-- Fallback Graphic jika gambar tidak ada / 404 --}}
                        <div class="berita-fallback-graphic" style="{{ $b->gambar ? 'display: none;' : 'display: flex;' }}">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-3 mb-2" style="width: 50px; height: 50px; background: rgba(74, 222, 128, 0.15); border: 1px solid rgba(74, 222, 128, 0.35);">
                                <span style="font-size: 1.5rem;">{{ $katInfo['icon'] }}</span>
                            </div>
                            <span class="font-monospace text-emerald-400 text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 1px;">AMIK TARUNA</span>
                        </div>

                        {{-- Category Badge --}}
                        <div class="position-absolute top-0 start-0 p-3">
                            <span class="berita-badge-pill bg-dark bg-opacity-75 text-white border border-white border-opacity-20 shadow-sm">
                                <span>{{ $katInfo['icon'] }}</span>
                                <span>{{ $katInfo['label'] }}</span>
                            </span>
                        </div>

                        {{-- Video / PDF Badge --}}
                        <div class="position-absolute top-0 end-0 p-3 d-flex gap-1.5">
                            @if($b->video)
                                <span class="badge rounded-circle bg-danger text-white p-2 shadow-sm" title="Ada video liputan">
                                    <i class="fas fa-play" style="font-size: 10px;"></i>
                                </span>
                            @endif
                            @if($b->file_pdf)
                                <span class="badge rounded-circle bg-primary text-white p-2 shadow-sm" title="Ada lampiran berkas">
                                    <i class="fas fa-paperclip" style="font-size: 10px;"></i>
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Body Kartu --}}
                    <div class="p-4 d-flex flex-column flex-grow-1 justify-content-between">
                        <div>
                            {{-- Meta: Tanggal & Penulis --}}
                            <div class="d-flex align-items-center gap-2 text-slate-400 small mb-2" style="font-size: 12px;">
                                <span class="text-emerald-400">
                                    <i class="far fa-calendar-alt me-1"></i>{{ $b->publish_at ? \Carbon\Carbon::parse($b->publish_at)->format('d M Y') : $b->created_at->format('d M Y') }}
                                </span>
                                <span>•</span>
                                <span><i class="far fa-user me-1"></i>{{ $b->penulis ?? 'Admin' }}</span>
                            </div>

                            {{-- Judul Berita --}}
                            <h5 class="fw-bold text-white mb-2 line-clamp-2" style="font-size: 1.12rem; line-height: 1.5;">
                                <a href="{{ url('/berita/' . ($b->slug ?: $b->id)) }}" class="text-white text-decoration-none">
                                    {{ $b->judul }}
                                </a>
                            </h5>

                            {{-- Ringkasan --}}
                            <p class="text-slate-300 small line-clamp-3 mb-3" style="line-height: 1.7;">
                                {{ Str::limit(strip_tags($b->isi), 120) }}
                            </p>
                        </div>

                        {{-- Footer Kartu --}}
                        <div class="pt-3 border-top border-white border-opacity-10 d-flex align-items-center justify-content-between mt-auto">
                            <a href="{{ url('/berita/' . ($b->slug ?: $b->id)) }}" class="btn btn-sm btn-outline-success rounded-pill px-3.5 fw-semibold d-inline-flex align-items-center gap-1.5">
                                <span>Baca Warta</span>
                                <i class="fas fa-arrow-right" style="font-size: 10px;"></i>
                            </a>

                            @if($b->editor)
                                <small class="text-slate-400" style="font-size: 11px;">
                                    <i class="fas fa-user-check text-muted me-1"></i>{{ $b->editor }}
                                </small>
                            @endif
                        </div>
                    </div>

                </article>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="p-5 rounded-4" style="background: rgba(8, 38, 24, 0.7); border: 1px solid rgba(74, 222, 128, 0.2);">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 70px; height: 70px; background: rgba(74, 222, 128, 0.15); border: 1px solid rgba(74, 222, 128, 0.3);">
                        <i class="far fa-newspaper text-success fa-2x"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-2">Belum Ada Warta yang Ditemukan</h5>
                    <p class="text-slate-300 small mb-3">Tidak ada publikasi berita yang sesuai dengan kata kunci atau filter saat ini.</p>
                    <a href="{{ url('/berita') }}" class="btn btn-sm btn-success rounded-pill px-4">
                        Tampilkan Semua Berita
                    </a>
                </div>
            </div>
        @endforelse

        {{-- Dynamic Empty State (Ditampilkan saat filter tab menghasilkan 0) --}}
        <div id="beritaEmptyState" class="col-12 text-center py-5" style="display: none;">
            <div class="p-5 rounded-4" style="background: rgba(8, 38, 24, 0.7); border: 1px solid rgba(74, 222, 128, 0.2);">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 70px; height: 70px; background: rgba(74, 222, 128, 0.15); border: 1px solid rgba(74, 222, 128, 0.3);">
                    <i class="fas fa-folder-open text-muted fa-2x"></i>
                </div>
                <h5 class="fw-bold text-white mb-2" id="emptyTitleText">Belum Ada Warta pada Kategori Ini</h5>
                <p class="text-slate-300 small mb-3">Silakan pilih kategori warta lainnya atau reset filter ke Semua Warta.</p>
                <button type="button" id="btnResetBeritaTab" class="btn btn-sm btn-success rounded-pill px-4">
                    Lihat Semua Warta
                </button>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabButtons = document.querySelectorAll('.berita-tab-btn');
    const gridItems = document.querySelectorAll('.berita-grid-item');
    const headlineContainer = document.querySelector('.headline-article-container');
    const emptyState = document.getElementById('beritaEmptyState');
    const sectionTitle = document.getElementById('gridSectionTitle');
    const countBadge = document.getElementById('articleCountBadge');
    const btnReset = document.getElementById('btnResetBeritaTab');

    let currentCategory = 'semua';

    function filterBerita(category) {
        currentCategory = category;
        let visibleCount = 0;

        gridItems.forEach(item => {
            const itemCat = item.getAttribute('data-category');
            if (category === 'semua' || itemCat === category) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Headline container filter
        if (headlineContainer) {
            const headlineCat = headlineContainer.getAttribute('data-category');
            if (category === 'semua' || headlineCat === category) {
                headlineContainer.style.display = '';
            } else {
                headlineContainer.style.display = 'none';
            }
        }

        // Update active class on tab buttons
        tabButtons.forEach(btn => {
            if (btn.getAttribute('data-category') === category) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        // Update empty state
        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        // Update counter & title
        if (countBadge) {
            countBadge.textContent = `${visibleCount} Artikel Ditampilkan`;
        }
        if (sectionTitle) {
            if (category === 'semua') {
                sectionTitle.textContent = 'Semua Warta Terpublikasi';
            } else {
                const activeBtn = document.querySelector(`.berita-tab-btn[data-category="${category}"]`);
                sectionTitle.textContent = activeBtn ? activeBtn.textContent.trim() : 'Warta Terpilih';
            }
        }
    }

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const cat = this.getAttribute('data-category');
            filterBerita(cat);
        });
    });

    if (btnReset) {
        btnReset.addEventListener('click', function () {
            filterBerita('semua');
        });
    }
});
</script>

@endsection