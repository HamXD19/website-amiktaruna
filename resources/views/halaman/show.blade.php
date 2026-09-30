@extends('layouts.main')

@section('title', ($halaman->judul ?? 'Informasi') . ' | AMIK Taruna Probolinggo')

@section('content')

<style>
    /* ========================================================
       HALAMAN KUSTOM MODERN EDITORIAL & TECH GLASS STYLING
    ======================================================== */
    .halaman-wrapper {
        min-height: 70vh;
        padding-bottom: 70px;
    }

    /* Breadcrumb Header */
    .halaman-breadcrumb {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(8, 38, 24, 0.70);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(74, 222, 128, 0.22);
        padding: 8px 18px;
        border-radius: 30px;
        font-size: 0.82rem;
        margin-bottom: 24px;
    }
    .halaman-breadcrumb a {
        color: #86efac;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }
    .halaman-breadcrumb a:hover {
        color: #ffffff;
    }
    .halaman-breadcrumb .separator {
        color: rgba(255, 255, 255, 0.35);
        font-size: 0.7rem;
    }
    .halaman-breadcrumb .current {
        color: #ffffff;
        font-weight: 700;
    }

    /* Main Article Container */
    .halaman-article-card {
        background: rgba(10, 38, 25, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(74, 222, 128, 0.22);
        border-radius: 28px;
        padding: 40px;
        box-shadow: 0 16px 40px -4px rgba(2, 20, 12, 0.5);
        color: #e2e8f0;
    }

    /* Category Badge */
    .halaman-cat-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 20px;
        background: rgba(16, 185, 129, 0.20);
        color: #6ee7b7;
        border: 1px solid rgba(110, 231, 183, 0.35);
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.4px;
        text-transform: uppercase;
        margin-bottom: 14px;
    }

    /* Title */
    .halaman-title {
        font-size: 2.35rem;
        font-weight: 800;
        line-height: 1.25;
        letter-spacing: -0.6px;
        color: #ffffff;
        margin-bottom: 16px;
    }

    /* Meta Info */
    .halaman-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 16px;
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.65);
        padding-bottom: 22px;
        border-bottom: 1px solid rgba(74, 222, 128, 0.15);
        margin-bottom: 26px;
    }

    /* Summary Excerpt Quote Box */
    .halaman-summary-box {
        background: rgba(16, 185, 129, 0.08);
        border-left: 4px solid #10b981;
        border-radius: 0 18px 18px 0;
        padding: 18px 24px;
        margin-bottom: 28px;
        font-size: 1.05rem;
        font-weight: 500;
        line-height: 1.75;
        color: #d1fae5;
        font-style: italic;
    }

    /* Featured Cover Image */
    .halaman-cover-wrapper {
        border-radius: 22px;
        overflow: hidden;
        border: 1px solid rgba(74, 222, 128, 0.25);
        margin-bottom: 34px;
        background: rgba(0, 0, 0, 0.25);
        max-height: 480px;
    }
    .halaman-cover-img {
        width: 100%;
        max-height: 480px;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }
    .halaman-cover-wrapper:hover .halaman-cover-img {
        transform: scale(1.02);
    }

    /* Rich Content Typography */
    .halaman-content {
        color: #cbd5e1;
        font-size: 1.02rem;
        line-height: 1.85;
    }
    .halaman-content h1, 
    .halaman-content h2, 
    .halaman-content h3, 
    .halaman-content h4 {
        color: #ffffff;
        font-weight: 700;
        margin-top: 32px;
        margin-bottom: 14px;
        line-height: 1.35;
    }
    .halaman-content h2 {
        font-size: 1.6rem;
        border-bottom: 1px solid rgba(74, 222, 128, 0.15);
        padding-bottom: 8px;
    }
    .halaman-content h3 {
        font-size: 1.35rem;
        color: #86efac;
    }
    .halaman-content p {
        margin-bottom: 18px;
    }
    .halaman-content ul, 
    .halaman-content ol {
        margin-bottom: 20px;
        padding-left: 24px;
    }
    .halaman-content li {
        margin-bottom: 8px;
    }
    .halaman-content blockquote {
        background: rgba(255, 255, 255, 0.04);
        border-left: 4px solid #10b981;
        padding: 14px 20px;
        margin: 20px 0;
        border-radius: 0 14px 14px 0;
        color: #e2e8f0;
        font-style: italic;
    }
    .halaman-content img {
        max-width: 100%;
        height: auto;
        border-radius: 16px;
        margin: 20px 0;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .halaman-content table {
        width: 100%;
        margin-bottom: 24px;
        border-collapse: collapse;
        border-radius: 12px;
        overflow: hidden;
    }
    .halaman-content th {
        background: rgba(16, 185, 129, 0.25);
        color: #ffffff;
        padding: 12px 16px;
        text-align: left;
        font-weight: 700;
        border: 1px solid rgba(74, 222, 128, 0.2);
    }
    .halaman-content td {
        padding: 12px 16px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(0, 0, 0, 0.15);
        color: #cbd5e1;
    }

    /* Sidebar Widgets */
    .halaman-sidebar-card {
        background: rgba(10, 38, 25, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(74, 222, 128, 0.20);
        border-radius: 24px;
        padding: 26px;
        box-shadow: 0 12px 32px rgba(0,0,0,0.35);
        margin-bottom: 24px;
    }
    .sidebar-widget-title {
        font-size: 0.95rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #86efac;
        padding-bottom: 12px;
        border-bottom: 1px solid rgba(74, 222, 128, 0.18);
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .sidebar-nav-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        border-radius: 12px;
        color: #cbd5e1;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.88rem;
        transition: all 0.2s ease;
        background: rgba(255, 255, 255, 0.03);
        margin-bottom: 8px;
        border: 1px solid transparent;
    }
    .sidebar-nav-item:hover {
        background: rgba(16, 185, 129, 0.15);
        color: #ffffff;
        border-color: rgba(74, 222, 128, 0.3);
        transform: translateX(4px);
    }
    .sidebar-nav-item.active {
        background: rgba(16, 185, 129, 0.25);
        color: #6ee7b7;
        border-color: rgba(110, 231, 183, 0.4);
    }

    @media (max-width: 768px) {
        .halaman-title {
            font-size: 1.75rem;
        }
        .halaman-article-card {
            padding: 24px;
        }
        .halaman-summary-box {
            padding: 14px 18px;
            font-size: 0.95rem;
        }
    }
</style>

<div class="halaman-wrapper">

    <!-- Breadcrumb Nav -->
    <div class="halaman-breadcrumb" data-aos="fade-down" data-aos-duration="600">
        <a href="{{ url('/') }}"><i class="fas fa-home me-1"></i>Beranda</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <span>{{ $parentLabel }}</span>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <span class="current">{{ Str::limit($halaman->judul, 36) }}</span>
    </div>

    <div class="row g-4">

        <!-- KOLOM UTAMA: KONTEN ARTIKEL (col-lg-8) -->
        <div class="col-lg-8" data-aos="fade-up" data-aos-duration="700">
            <article class="halaman-article-card">
                
                <!-- Badge Kategori -->
                <div class="halaman-cat-badge">
                    <i class="fas fa-layer-group"></i>
                    <span>{{ $parentLabel }}</span>
                </div>

                <!-- Judul Halaman -->
                <h1 class="halaman-title">
                    {{ $halaman->judul }}
                </h1>

                <!-- Meta Info (Tanggal & Navigasi) -->
                <div class="halaman-meta">
                    <div>
                        <i class="far fa-calendar-alt text-emerald-400 me-1.5"></i>
                        <span>Diperbarui {{ $halaman->updated_at ? $halaman->updated_at->isoFormat('D MMMM Y') : 'Baru saja' }}</span>
                    </div>
                    <div>
                        <i class="fas fa-link text-emerald-400 me-1.5"></i>
                        <span class="font-monospace text-emerald-300 small">/halaman/{{ $halaman->slug }}</span>
                    </div>
                    @if(auth()->check())
                        <div class="ms-auto">
                            <a href="{{ url('/admin/setting/edit#tab-navmenu') }}" class="btn btn-warning btn-sm rounded-pill px-3 py-1 fw-bold text-dark" style="font-size: 0.75rem;">
                                <i class="fas fa-edit me-1"></i>Edit Halaman di Admin
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Ringkasan / Excerpt -->
                @if($halaman->ringkasan)
                    <div class="halaman-summary-box">
                        <i class="fas fa-quote-left text-emerald-400 me-2 opacity-50"></i>
                        {{ $halaman->ringkasan }}
                    </div>
                @endif

                <!-- Cover Image (Jika diunggah) -->
                @if($halaman->gambar)
                    <div class="halaman-cover-wrapper">
                        <img src="{{ $halaman->gambar_url }}" alt="{{ $halaman->judul }}" class="halaman-cover-img" loading="lazy">
                    </div>
                @endif

                <!-- Isi Konten Artikel -->
                <div class="halaman-content">
                    @if($halaman->konten)
                        {!! $halaman->konten !!}
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-file-pen fa-3x mb-3 text-emerald-400 opacity-40"></i>
                            <p class="mb-0">Konten isi halaman ini sedang dalam tahap penyusunan oleh pengelola kampus.</p>
                        </div>
                    @endif
                </div>

                <!-- Footer Bagikan / Action -->
                <div class="pt-4 mt-5 border-top border-emerald-900/40 d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="small text-white-50">
                        <i class="fas fa-shield-halved text-emerald-400 me-1"></i>Informasi Resmi AMIK Taruna Probolinggo
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-outline-light btn-sm rounded-pill px-3 fw-semibold" onclick="salinTautanHalaman()" id="btnSalinTautan">
                            <i class="fas fa-copy me-1"></i>Salin Tautan
                        </button>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($halaman->judul . ' - ' . url()->current()) }}" target="_blank" class="btn btn-success btn-sm rounded-pill px-3 fw-semibold">
                            <i class="fab fa-whatsapp me-1"></i>Bagikan
                        </a>
                    </div>
                </div>

            </article>
        </div>

        <!-- KOLOM KANAN: SIDEBAR WIDGETS (col-lg-4) -->
        <div class="col-lg-4" data-aos="fade-left" data-aos-duration="700" data-aos-delay="100">
            <div class="sticky-top" style="top: 100px;">

                <!-- Widget 1: Halaman Lain dalam Kategori Ini -->
                @if(isset($relatedPages) && $relatedPages->count() > 0)
                    <div class="halaman-sidebar-card">
                        <h4 class="sidebar-widget-title">
                            <i class="fas fa-book-open"></i>
                            <span>Halaman Terkait</span>
                        </h4>
                        <div class="space-y-1">
                            @foreach($relatedPages as $rel)
                                <a href="{{ url('/halaman/' . $rel->slug) }}" class="sidebar-nav-item">
                                    <span class="text-truncate">{{ $rel->judul }}</span>
                                    <i class="fas fa-arrow-right fa-xs text-emerald-400"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Widget 2: Akses Cepat Navigasi Kampus -->
                <div class="halaman-sidebar-card">
                    <h4 class="sidebar-widget-title">
                        <i class="fas fa-compass"></i>
                        <span>Navigasi Kampus</span>
                    </h4>
                    <div class="space-y-1">
                        <a href="{{ url('/tentang') }}" class="sidebar-nav-item">
                            <span><i class="fas fa-university text-emerald-400 me-2"></i>Tentang AMIK Taruna</span>
                            <i class="fas fa-angle-right fa-xs text-muted"></i>
                        </a>
                        <a href="{{ url('/akademik') }}" class="sidebar-nav-item">
                            <span><i class="fas fa-laptop-code text-emerald-400 me-2"></i>Program Studi</span>
                            <i class="fas fa-angle-right fa-xs text-muted"></i>
                        </a>
                        <a href="{{ url('/dokumen-kampus') }}" class="sidebar-nav-item">
                            <span><i class="fas fa-file-contract text-emerald-400 me-2"></i>Dokumen Kampus</span>
                            <i class="fas fa-angle-right fa-xs text-muted"></i>
                        </a>
                        <a href="{{ url('/ppm') }}" class="sidebar-nav-item">
                            <span><i class="fas fa-shield-alt text-emerald-400 me-2"></i>Penjaminan Mutu (PPM)</span>
                            <i class="fas fa-angle-right fa-xs text-muted"></i>
                        </a>
                        <a href="{{ url('/lppm') }}" class="sidebar-nav-item">
                            <span><i class="fas fa-flask text-emerald-400 me-2"></i>Riset &amp; PkM (LPPM)</span>
                            <i class="fas fa-angle-right fa-xs text-muted"></i>
                        </a>
                        <a href="{{ url('/pmb') }}" class="sidebar-nav-item">
                            <span><i class="fas fa-user-plus text-emerald-400 me-2"></i>Pendaftaran PMB</span>
                            <i class="fas fa-angle-right fa-xs text-muted"></i>
                        </a>
                        <a href="{{ url('/berita') }}" class="sidebar-nav-item">
                            <span><i class="far fa-newspaper text-emerald-400 me-2"></i>Warta &amp; Berita Kampus</span>
                            <i class="fas fa-angle-right fa-xs text-muted"></i>
                        </a>
                    </div>
                </div>

                <!-- Widget 3: Kontak & Bantuan Kampus -->
                <div class="halaman-sidebar-card text-center" style="background: linear-gradient(135deg, rgba(8, 38, 24, 0.9), rgba(15, 61, 38, 0.9)); border: 1px solid rgba(74, 222, 128, 0.35);">
                    <div class="w-12 h-12 rounded-circle bg-emerald-500/20 text-emerald-400 d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                        <i class="fas fa-headset fs-4"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-2">Butuh Informasi Tambahan?</h5>
                    <p class="text-white-50 small mb-3">
                        Layanan BAAK &amp; Informasi Sivitas AMIK Taruna siap membantu pertanyaan Anda seputar perkuliahan dan administrasi.
                    </p>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $setting->kontak_whatsapp ?? '6285232101010') }}" target="_blank" class="btn btn-success rounded-pill w-100 fw-bold py-2 shadow-xs d-inline-flex align-items-center justify-content-center gap-2">
                        <i class="fab fa-whatsapp fs-5"></i>
                        <span>Hubungi Sekretariat</span>
                    </a>
                </div>

            </div>
        </div>

    </div>

</div>

<script>
    function salinTautanHalaman() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            const btn = document.getElementById('btnSalinTautan');
            if (btn) {
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check text-emerald-400 me-1"></i> Tersalin!';
                btn.classList.add('btn-success');
                btn.classList.remove('btn-outline-light');
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-outline-light');
                }, 2500);
            }
        });
    }
</script>

@endsection
