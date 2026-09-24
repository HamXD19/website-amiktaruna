@extends('layouts.main')

@section('content')

<div class="container py-5">

    <div class="mb-4">
        <a href="/tentang" class="btn btn-outline-success rounded-pill px-4 text-emerald-300 border-emerald-500/30 hover:bg-emerald-500/20">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Profil Kampus &amp; Dosen
        </a>
    </div>

    <div class="card dosen-profile-card shadow-lg border-0 rounded-4 p-4 p-md-5">

        <div class="row align-items-center g-5">

            <div class="col-lg-4 text-center">

                @if($dosen->foto)

                    <img src="{{ asset('uploads/'.$dosen->foto) }}"
                         class="rounded-circle shadow-lg border border-3 border-emerald-500/40"
                         width="220"
                         height="220"
                         style="object-fit:cover;">

                @else

                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center bg-emerald-950/80 border border-3 border-emerald-500/40 text-emerald-300"
                         style="width: 220px; height: 220px; font-size: 5rem;">
                        <i class="fas fa-user-tie"></i>
                    </div>

                @endif

            </div>

            <div class="col-lg-8">

                <span class="badge bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 px-3 py-1.5 rounded-pill mb-2">
                    Tenaga Pendidik &amp; Sivitas
                </span>

                <h1 class="fw-bold text-white mb-2">
                    {{ $dosen->nama }}
                </h1>

                <h5 class="text-emerald-400 mb-4 fw-semibold">
                    {{ $dosen->jabatan }}
                </h5>

                <div class="row gy-3 text-slate-300">

                    <div class="col-md-6">
                        <span class="text-slate-400 d-block small font-monospace text-uppercase">NIDN</span>
                        <strong class="text-white">{{ $dosen->nidn ?? '-' }}</strong>
                    </div>

                    <div class="col-md-6">
                        <span class="text-slate-400 d-block small font-monospace text-uppercase">Email Resmi</span>
                        <strong class="text-white">{{ $dosen->email ?? '-' }}</strong>
                    </div>

                    <div class="col-md-6">
                        <span class="text-slate-400 d-block small font-monospace text-uppercase">Pendidikan Terakhir</span>
                        <strong class="text-white">{{ $dosen->pendidikan ?? '-' }}</strong>
                    </div>

                    <div class="col-md-6">
                        <span class="text-slate-400 d-block small font-monospace text-uppercase">Bidang Keahlian</span>
                        <strong class="text-white">{{ $dosen->bidang_keahlian ?? '-' }}</strong>
                    </div>

                </div>

                <hr class="my-4" style="border-color: rgba(74, 222, 128, 0.2);">

                <h4 class="fw-bold text-white mb-3">
                    Biografi &amp; Pengantar
                </h4>

                <p class="text-slate-300" style="line-height:1.9;">
                    {{ $dosen->bio ?? 'Profil dan biografi dosen belum tersedia.' }}
                </p>

                @if($dosen->linkedin)

                    <div class="mt-4">
                        <a href="{{ $dosen->linkedin }}"
                           target="_blank"
                           class="btn btn-success rounded-pill px-4">
                            <i class="fab fa-linkedin me-2"></i> Kunjungi LinkedIn
                        </a>
                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

<style>
.dosen-profile-card {
    background: rgba(8, 38, 24, 0.88);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(74, 222, 128, 0.25) !important;
    border-radius: 28px;
    box-shadow: 0 16px 40px -4px rgba(0, 0, 0, 0.5);
    color: #f1f5f9;
}
</style>

@endsection