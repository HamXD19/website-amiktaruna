@extends('layouts.main')

@section('content')

<div class="container py-5">

    <!-- TITLE -->
    <div class="text-center mb-5">
        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 mb-3 rounded-pill bg-emerald-500/20 text-emerald-300 fw-bold small border border-emerald-500/30">
            <i class="fas fa-graduation-cap"></i> Sivitas Akademika
        </div>
        <h1 class="fw-bold display-6 text-white mb-2">
            Pelayanan Akademik
        </h1>
        <p class="text-slate-300 mx-auto" style="max-width: 600px;">
            Akses cepat ke berbagai portal dan layanan digital mahasiswa AMIK Taruna
        </p>
    </div>

    <div class="row g-4">

        @forelse($layanans as $l)

        <div class="col-md-4 col-lg-3">

            <a href="{{ $l->link }}"
               target="_blank"
               class="text-decoration-none h-100 d-block">

                <div class="card layanan-card border-0 h-100 text-center p-4">

                    <!-- LOGO (ALWAYS CENTERED) -->
                    <div class="layanan-logo-wrapper mb-3 d-flex justify-content-center align-items-center">

                        @if($l->logo)

                            <img src="{{ asset('uploads/'.$l->logo) }}"
                                 alt="{{ $l->nama }}"
                                 class="layanan-logo">

                        @else

                            <div class="logo-kosong">
                                <i class="fas fa-external-link-alt text-base"></i>
                            </div>

                        @endif

                    </div>

                    <!-- CONTENT -->
                    <div class="d-flex flex-column flex-grow-1 h-100">

                        <!-- TITLE -->
                        <h5 class="fw-bold layanan-title">
                            {{ $l->nama }}
                        </h5>

                        <!-- DESKRIPSI -->
                        <p class="layanan-desc mt-2 flex-grow-1">
                            {{ $l->deskripsi ?? 'Layanan mahasiswa AMIK Taruna' }}
                        </p>

                        <!-- BUTTON -->
                        <div class="mt-auto pt-3">

                            <span class="btn btn-{{ $l->warna ?: 'success' }} layanan-btn rounded-pill px-4 py-2">
                                Kunjungi Layanan <i class="fas fa-arrow-right ms-1"></i>
                            </span>

                        </div>

                    </div>

                </div>

            </a>

        </div>

        @empty

        <!-- EMPTY -->
        <div class="col-12">

            <div class="alert text-center rounded-4 shadow-sm border border-emerald-500/30 text-slate-300 py-5" style="background: rgba(8, 38, 24, 0.85);">
                <i class="fas fa-info-circle text-2xl text-emerald-400 mb-2 d-block"></i>
                Belum ada layanan tersedia saat ini.
            </div>

        </div>

        @endforelse

    </div>

</div>

<style>

/* CARD */
.layanan-card {
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

/* GLOW */
.layanan-card::before {
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

/* HOVER */
.layanan-card:hover {
    transform: translateY(-8px);
    background: rgba(12, 48, 30, 0.96);
    border-color: rgba(74, 222, 128, 0.45);
    box-shadow: 0 20px 45px rgba(74, 222, 128, 0.16), 0 10px 25px rgba(0, 0, 0, 0.5);
}

.layanan-card:hover::before {
    transform: scale(1.4);
    background: rgba(74, 222, 128, 0.2);
}

/* LOGO WRAPPER & CENTERING */
.layanan-logo-wrapper {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    margin: 0 auto 1.25rem auto;
}

/* LOGO */
.layanan-logo {
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

.layanan-card:hover .layanan-logo {
    transform: rotate(-4deg) scale(1.06);
}

/* FALLBACK */
.logo-kosong {
    width: 88px;
    height: 88px;
    border-radius: 22px;
    background: rgba(74, 222, 128, 0.15);
    border: 1px solid rgba(74, 222, 128, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: #4ade80;
    margin: 0 auto;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    transition: .4s;
}

.layanan-card:hover .logo-kosong {
    transform: rotate(-4deg) scale(1.06);
}

/* TITLE */
.layanan-title {
    font-size: 19px;
    font-weight: 700;
    color: #ffffff;
    transition: .3s;
}

/* DESC */
.layanan-desc {
    font-size: 13.5px;
    line-height: 1.75;
    color: #cbd5e1;
    transition: .3s;
}

/* BUTTON */
.layanan-btn {
    font-size: 13px;
    font-weight: 700;
    border-radius: 50px;
    padding: 9px 22px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
    transition: .3s;
}

.layanan-card:hover .layanan-btn {
    transform: scale(1.02);
}

/* MOBILE */
@media(max-width: 768px) {
    .layanan-card {
        min-height: auto;
        border-radius: 24px;
    }
    .layanan-logo,
    .logo-kosong {
        width: 76px;
        height: 76px;
    }
}

</style>
@endsection