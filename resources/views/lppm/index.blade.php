@extends('layouts.main')

@section('content')

<div class="container py-5">

    <!-- HEADER TITLE -->
    <div class="text-center mb-5">
        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 mb-3 rounded-pill bg-emerald-500/20 text-emerald-300 fw-bold small border border-emerald-500/30">
            <i class="fas fa-flask"></i> Lembaga Penelitian & Pengabdian Masyarakat
        </div>
        <h1 class="fw-bold display-6 text-white mb-2">
            Portal & Layanan LPPM
        </h1>
        <p class="text-slate-300 mx-auto" style="max-width: 650px;">
            Pusat layanan riset, jurnal publikasi ilmiah, dan pengabdian masyarakat Sivitas Akademika AMIK Taruna Probolinggo
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

</div>

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
</style>

@endsection