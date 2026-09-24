@php
    use App\Models\Setting;
    if (!isset($setting)) {
        try {
            $setting = Setting::first();
        } catch (\Throwable $e) {
            $setting = null;
        }
    }
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $setting->nama_website ?? 'AMIK Taruna' }}</title>
    <link rel="shortcut icon" href="{{ asset('uploads/' . ($setting->logo ?? '')) }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Unified Design System & Vue App -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --green:       #198754;
            --green-dark:  #136940;
            --green-light: #e6f5ec;
            --orange:      #ff9f1c;
            --orange-dark: #e08a0e;
            --text-dark:   #0f1f14;
            --text-body:   #374151;
            --text-muted:  #6b7280;
            --bg-hero:     #edf6f0;
            --footer-bg:   #0d2318;
            --footer-text: #b8ccc0;
            --footer-link: #ffd596;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 16px;
            line-height: 1.7;
            background: transparent;
            color: var(--text-body);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
        }

  
       
        /* ========== FOOTER BIKIN SENDIRI, TAMBAH BACKGROUND SOLID ========== */
        .footer-modern {
            background: #0d2318 !important;
            color: var(--footer-text);
            padding: 60px 0 0;
            border-radius: 36px 36px 0 0;
            margin-top: 80px;
            position: relative;
            z-index: 2;
        }

        /* Force semua isi footer pake background gelap */
        .footer-modern,
        .footer-modern .container,
        .footer-modern .row,
        .footer-modern [class*="col"],
        .footer-modern .d-flex,
        .footer-modern .kontak-row,
        .footer-modern .social-icons,
        .footer-modern .footer-bottom,
        .footer-modern .icon-wrap,
        .footer-modern p,
        .footer-modern ul,
        .footer-modern li,
        .footer-modern a,
        .footer-modern div {
            background: #0d2318 !important;
            background-color: #0d2318 !important;
        }

        /* Tapi link dan teks tetep keliatan */
        .footer-modern a,
        .footer-modern p,
        .footer-modern li,
        .footer-modern .footer-heading,
        .footer-modern .kontak-text,
        .footer-modern .footer-brand-name,
        .footer-modern .footer-copy {
            background: transparent !important;
        }

        /* Social media icon background */
        .footer-modern .social-icons a {
            background: rgba(255,255,255,0.07) !important;
        }

        .footer-modern .social-icons a:hover {
            background: var(--green) !important;
        }

        /* Icon wrap */
        .footer-modern .icon-wrap {
            background: rgba(255,255,255,0.07) !important;
        }

        /* NAVBAR */
        .navbar {
            background: transparent !important;
            padding: 18px 0;
            transition: background 0.35s ease, box-shadow 0.35s ease, padding 0.35s ease;
            z-index: 1000;
        }

        .navbar.scrolled {
            background: rgba(255,255,255,0.97) !important;
            backdrop-filter: blur(16px);
            box-shadow: 0 2px 24px rgba(15,31,20,0.09);
            padding: 10px 0;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--text-dark) !important;
        }

        .navbar-brand img {
            width: 44px;
            height: 44px;
            object-fit: contain;
            border-radius: 10px;
        }

        .navbar-nav {
            gap: 4px;
        }

        .nav-item {
            display: flex;
            align-items: center;
        }

        .nav-link {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-dark) !important;
            padding: 8px 18px !important;
            border-radius: 40px;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .nav-link:hover {
            background: rgba(25,135,84,0.12);
            color: var(--green) !important;
        }

        .nav-link.active-menu {
            background: var(--green);
            color: #fff !important;
        }

        .nav-item.ms-lg-2 {
            display: flex;
            align-items: center;
        }

        .nav-item .nav-link.p-0 {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-toggler {
            border: none;
            padding: 8px;
        }

        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }

        @media (max-width: 991px) {
            .navbar-collapse {
                background: rgba(255,255,255,0.98);
                backdrop-filter: blur(16px);
                border-radius: 20px;
                padding: 16px 20px;
                margin-top: 12px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            }
            .nav-link {
                padding: 10px 16px !important;
                text-align: center;
            }
            .navbar-nav {
                gap: 6px;
            }
        }

        .hero-modern {
            background: var(--bg-hero);
            padding: 120px 0 80px;
            border-radius: 0 0 48px 48px;
            position: relative;
            overflow: hidden;
        }

        .hero-modern::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(25,135,84,0.12) 0%, transparent 70%);
            top: -100px; right: -100px;
            pointer-events: none;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(25,135,84,0.10);
            color: var(--green);
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            padding: 6px 16px;
            border-radius: 40px;
            margin-bottom: 22px;
            border: 1px solid rgba(25,135,84,0.18);
        }

        .hero-title {
            font-size: 3.4rem;
            font-weight: 800;
            line-height: 1.12;
            letter-spacing: -1.5px;
            color: var(--text-dark);
            margin-bottom: 24px;
        }

        .hero-title .highlight {
            color: var(--orange);
            position: relative;
            display: inline-block;
        }

        .hero-title .highlight::after {
            content: '';
            position: absolute;
            bottom: 4px; left: 0;
            width: 100%; height: 5px;
            background: var(--orange);
            border-radius: 3px;
            opacity: 0.25;
        }

        .hero-sub {
            font-size: 1.05rem;
            color: var(--text-muted);
            line-height: 1.8;
            border-left: 4px solid var(--orange);
            padding-left: 18px;
        }

        .hero-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 36px;
        }

        .btn-cta {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            background: var(--orange);
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
            padding: 15px 34px;
            border-radius: 50px;
            border: none;
            text-decoration: none;
            transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 6px 18px rgba(255,159,28,0.35);
        }

        .btn-cta:hover {
            background: var(--orange-dark);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(255,159,28,0.45);
        }

        .btn-outline-green {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            background: transparent;
            color: var(--green);
            font-size: 1rem;
            font-weight: 700;
            padding: 15px 34px;
            border-radius: 50px;
            border: 2px solid var(--green);
            text-decoration: none;
            transition: background 0.2s, color 0.2s, transform 0.2s;
        }

        .btn-outline-green:hover {
            background: var(--green);
            color: #fff;
            transform: translateY(-2px);
        }

        .carousel-wrapper { position: relative; }
        .carousel-inner {
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 24px 64px rgba(15,31,20,0.16);
        }
        .hero-slide-img {
            height: 420px;
            width: 100%;
            object-fit: cover;
            display: block;
        }
        .carousel-item::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(15,31,20,0.30) 0%, transparent 55%);
            border-radius: 24px;
            pointer-events: none;
        }
        .carousel-indicators { bottom: 16px; }
        .carousel-indicators [data-bs-target] {
            width: 8px; height: 8px;
            border-radius: 50%;
            border: none;
            background: rgba(255,255,255,0.55);
            margin: 0 4px;
            transition: width 0.3s, background 0.3s;
        }
        .carousel-indicators .active {
            background: #fff;
            width: 24px;
            border-radius: 4px;
        }
        .carousel-control-prev,
        .carousel-control-next {
            width: 40px; height: 40px;
            background: rgba(255,255,255,0.90);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0;
            transition: opacity 0.25s;
            box-shadow: 0 2px 10px rgba(0,0,0,0.14);
        }
        .carousel-wrapper:hover .carousel-control-prev,
        .carousel-wrapper:hover .carousel-control-next { opacity: 1; }
        .carousel-control-prev { left: 14px; }
        .carousel-control-next { right: 14px; }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 16px; height: 16px;
            filter: brightness(0) saturate(100%) invert(24%) sepia(80%) hue-rotate(120deg);
        }

        .footer-brand-name {
            font-size: 1.2rem;
            font-weight: 800;
            color: #fff;
            margin: 0;
        }
        .footer-desc {
            font-size: 0.93rem;
            line-height: 1.75;
            color: var(--footer-text);
            margin-top: 8px;
        }
        .footer-heading {
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.4px;
            color: rgba(255,255,255,0.40);
            margin-bottom: 20px;
        }
        .footer-links { list-style: none; padding: 0; margin: 0; }
        .footer-links li { margin-bottom: 10px; }
        .footer-links a {
            color: var(--footer-text);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            display: inline-block;
            transition: color 0.2s, padding-left 0.2s;
        }
        .footer-links a:hover { color: #fff; padding-left: 5px; }
        .social-icons { display: flex; gap: 10px; margin-top: 22px; }
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px; height: 40px;
            border-radius: 50%;
            color: var(--footer-link) !important;
            font-size: 0.95rem;
            text-decoration: none;
            transition: background 0.2s, transform 0.2s, border-color 0.2s;
        }
        .social-icons a:hover {
            background: var(--green);
            border-color: var(--green);
            color: #fff !important;
            transform: translateY(-3px);
        }
        .kontak-row {
            display: flex;
            gap: 14px;
            margin-bottom: 16px;
            align-items: flex-start;
        }
        .kontak-row .icon-wrap {
            width: 38px; height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .kontak-row .icon-wrap i {
            font-size: 0.85rem;
            color: var(--footer-link);
        }
        .kontak-row .kontak-text {
            font-size: 0.93rem;
            line-height: 1.6;
            color: var(--footer-text);
            padding-top: 8px;
        }
        .footer-modern .kontak-text a{
    color: var(--footer-link) !important;
    text-decoration:none !important;
    transition:.3s;
}

.footer-modern .kontak-text a:hover{
    color:#ffffff !important;
}
        .kontak-row a:hover { color: #fff; }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding: 20px 0;
            margin-top: 52px;
        }
        .footer-copy {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.28);
            text-align: center;
            margin: 0;
        }

        @media (max-width: 768px) {
            .hero-modern { padding: 100px 0 56px; border-radius: 0 0 28px 28px; }
            .hero-title { font-size: 2.1rem; letter-spacing: -0.8px; }
            .hero-sub { font-size: 0.95rem; }
            .hero-slide-img { height: 230px; }
            .hero-buttons { flex-direction: column; }
            .btn-cta, .btn-outline-green { width: 100%; justify-content: center; padding: 13px 24px; }
            .footer-modern { border-radius: 24px 24px 0 0; padding: 40px 0 0; margin-top: 48px; }
        }
    </style>
</head>

<body>

{{-- Universal Campus Digital Aurora & Tech Mesh Background --}}
@include('components.animated-background')

<!-- Unified Vue AppNavbar (Identical to Homepage) -->
<div id="navbar-app" data-setting="{{ json_encode($setting) }}" data-path="{{ '/' . request()->path() }}"></div>

@if(request()->is('/'))
<section class="hero-modern">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="700">
                <div class="hero-badge">
                    <i class="fas fa-star fa-xs"></i>
                    Akademi Manajemen Informatika dan Komputer TARUNA
                </div>
                <h1 class="hero-title">
                    {{ $setting->hero_judul ?? 'AMIK Taruna' }}
                    <span class="highlight">{{ $setting->hero_highlight ?? '' }}</span>
                </h1>
                <p class="hero-sub">{{ $setting->hero_subjudul ?? '' }}</p>
                <div class="hero-buttons">
                    <a href="{{ $setting->hero_button_1_link ?? '/pmb' }}" class="btn-cta">
                        <i class="fas fa-graduation-cap"></i>
                        {{ $setting->hero_button_1_text ?? 'Daftar PMB' }}
                    </a>
                    <a href="{{ $setting->hero_button_2_link ?? '/akademik' }}" class="btn-outline-green">
                        {{ $setting->hero_button_2_text ?? 'Program Studi' }}
                        <i class="fas fa-arrow-right fa-sm"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="700" data-aos-delay="100">
                <div class="carousel-wrapper">
                    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3500">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active"><img src="{{ asset('uploads/' . ($setting->hero_slide_1 ?? '')) }}" class="hero-slide-img" alt="Slide 1"></div>
                            <div class="carousel-item"><img src="{{ asset('uploads/' . ($setting->hero_slide_2 ?? '')) }}" class="hero-slide-img" alt="Slide 2"></div>
                            <div class="carousel-item"><img src="{{ asset('uploads/' . ($setting->hero_slide_3 ?? '')) }}" class="hero-slide-img" alt="Slide 3"></div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<main class="main-content" style="padding-top: 84px;">
    <div class="container mt-3">
        @yield('content')
    </div>
</main>

<footer class="footer-modern">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ asset('uploads/' . $setting->logo) }}" width="56" height="56" style="object-fit:contain; border-radius:12px;">
                    <p class="footer-brand-name">{{ $setting->nama_website }}</p>
                </div>
                <p class="footer-desc">{{ $setting->footer_deskripsi }}</p>
                <div class="social-icons">
                    @if($setting->instagram) <a href="{{ $setting->instagram }}"><i class="fab fa-instagram"></i></a> @endif
                    @if($setting->facebook) <a href="{{ $setting->facebook }}"><i class="fab fa-facebook-f"></i></a> @endif
                    @if($setting->youtube) <a href="{{ $setting->youtube }}"><i class="fab fa-youtube"></i></a> @endif
                    @if($setting->tiktok) <a href="{{ $setting->tiktok }}"><i class="fab fa-tiktok"></i></a> @endif
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-6">
                <p class="footer-heading">Tautan</p>
                <ul class="footer-links">
                    <li><a href="/">Beranda</a></li>
                    <li><a href="/mahasiswa">Pelayanan</a></li>
                    <li><a href="/alumni">Alumni</a></li>
                    <li><a href="/berita">Berita</a></li>
                    <li><a href="/tentang">Tentang AMIK</a></li>
                    <li><a href="/akademik">Akademik</a></li>
                    <li><a href="/penjaminan_mutu">Penjaminan Mutu</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-6 ms-lg-auto">
                <p class="footer-heading">Kontak Kami</p>
             @if($setting->alamat)
<div class="kontak-row">

    <div class="icon-wrap">
        <i class="fas fa-map-marker-alt"></i>
    </div>

    <div class="kontak-text">

        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($setting->alamat) }}"
           target="_blank">

            {{ $setting->alamat }}
            <i class="fas fa-external-link-alt ms-1"></i>

        </a>

    </div>

</div>
@endif
                @if($setting->telepon)
                <div class="kontak-row">
                    <div class="icon-wrap"><i class="fas fa-phone-alt"></i></div>
                    <div class="kontak-text"><a href="tel:{{ $setting->telepon }}">{{ $setting->telepon }}</a></div>
                </div>
                @endif
                @if($setting->email)
                <div class="kontak-row">
                    <div class="icon-wrap"><i class="fas fa-envelope"></i></div>
                    <div class="kontak-text"><a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a></div>
                </div>
                @endif
                <div class="footer-box">

    <h6 class="fw-bold">
        Kritik & Saran
    </h6>

    <p class="small text-muted">
        Bantu kami meningkatkan kualitas layanan website AMIK Taruna.
    </p>

    <a href="{{ route('kritiksaran.form') }}"
       class="btn btn-success btn-sm rounded-pill">
        Kirim Masukan
    </a>

</div>
            </div>
        </div>
        <div class="footer-bottom">
            <p class="footer-copy">&copy; {{ date('Y') }} {{ $setting->nama_website }}. Semua hak dilindungi.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 700, once: true, offset: 50 });
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 30);
        });
    }
    document.querySelectorAll('.carousel-item img').forEach((img, i) => {
        img.addEventListener('error', () => {
            const item = img.closest('.carousel-item');
            const indicators = document.querySelectorAll('.carousel-indicators [data-bs-slide-to]');
            if (item) item.remove();
            if (indicators[i]) indicators[i].remove();
        });
    });
</script>

</body>
</html>