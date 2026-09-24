{{-- BACKUP LEGACY TENTANG BLADE (PHASE 4 AUDIT PRESERVATION) --}}
@extends('layouts.main')

@section('content')

<style>
    body {
        background: #f5f7fb;
    }

    .section-title {
        font-weight: 700;
        color: #0f172a;
    }

    .section-subtitle {
        color: #64748b;
    }

    /* FORCE SEMUA CARD PAKAI BACKGROUND PUTIH */
    .profile-card,
    .visi-card,
    .dosen-card,
    .akreditasi-card,
    .org-card {
        border: none;
        border-radius: 28px;
        overflow: hidden;
        background: white !important;
        background-color: white !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    }

    /* Profile card tetap gradient hijau (tidak kena force putih) */
    .profile-card {
        padding: 45px;
        background: linear-gradient(135deg, #16a34a, #15803d) !important;
        color: white;
    }

    .profile-card h2 {
        font-weight: 700;
        margin-bottom: 20px;
    }

    .visi-card {
        padding: 35px;
        height: 100%;
        transition: 0.35s;
        background: white !important;
    }

    .visi-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 40px rgba(0,0,0,0.12);
    }

    .visi-card h4 {
        font-weight: 700;
        margin-bottom: 18px;
        color: #16a34a;
    }

    /* =========================================
       AKREDITASI
    ========================================= */
    .akreditasi-title {
        font-size: 30px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 40px;
        position: relative;
        display: inline-block;
    }

    .akreditasi-title::after {
        content: '';
        width: 60%;
        height: 4px;
        background: linear-gradient(135deg, #16a34a, #15803d);
        position: absolute;
        left: 0;
        bottom: -10px;
        border-radius: 10px;
    }

    .akreditasi-card {
        transition: 0.35s;
        height: 100%;
        background: white !important;
    }

    .akreditasi-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 45px rgba(0,0,0,0.12);
    }

    .akreditasi-image {
        width: 100%;
        height: 230px;
        object-fit: cover;
    }

    .akreditasi-body {
        padding: 25px;
    }

    .akreditasi-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 30px;
        background: #dcfce7;
        color: #15803d;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .akreditasi-body h5 {
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 10px;
    }

    .akreditasi-body p {
        color: #64748b;
        margin-bottom: 0;
    }

    /* =========================================
       DOSEN / STRUKTUR ORGANISASI
    ========================================= */
    .dosen-section-title {
        font-size: 2rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 40px;
        position: relative;
        display: inline-block;
    }

    .dosen-section-title::after {
        content: '';
        width: 60%;
        height: 4px;
        background: linear-gradient(135deg, #16a34a, #15803d);
        position: absolute;
        left: 0;
        bottom: -10px;
        border-radius: 10px;
    }

    .jabatan-title {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 25px;
    }

    .dosen-card {
        text-align: center;
        padding: 30px 20px;
        transition: 0.35s;
        height: 100%;
        background: white !important;
    }

    .dosen-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 45px rgba(0,0,0,0.12);
    }

    .dosen-foto {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #f1f5f9;
        margin: auto;
        margin-bottom: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    .badge-jabatan {
        display: inline-block;
        padding: 10px 18px;
        border-radius: 30px;
        background: #dcfce7;
        color: #15803d;
        font-size: 13px;
        font-weight: 600;
        margin-top: 10px;
    }

    /* STRUKTUR ORGANISASI */
    .org-row {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 30px;
    }

    .connector {
        width: 3px;
        height: 55px;
        background: #16a34a;
        margin: 25px auto;
    }

    .org-card {
        width: 250px;
        background: white !important;
        border-radius: 24px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 12px 35px rgba(0,0,0,.08);
        transition: .3s;
    }

    .org-card:hover {
        transform: translateY(-8px);
    }

    .org-card.small {
        width: 220px;
    }

    .org-photo {
        width: 95px;
        height: 95px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #dcfce7;
        margin-bottom: 18px;
    }

    .org-card h5,
    .org-card h6 {
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 10px;
    }

    .org-card span {
        display: inline-block;
        background: #dcfce7;
        color: #15803d;
        padding: 8px 16px;
        border-radius: 40px;
        font-size: 13px;
    }

    /* Alert empty state */
    .alert-light {
        background: white !important;
        border: 1px solid #e2e8f0 !important;
    }

    @media (max-width: 768px) {
        .connector {
            display: none;
        }
    }
</style>

<div class="container py-5">

    <!-- HEADER -->
    <div class="text-center mb-5">
        <h1 class="section-title display-5">Tentang AMIK Taruna</h1>
        <p class="section-subtitle">Profil kampus, akreditasi, dan struktur dosen AMIK Taruna</p>
    </div>

    <!-- PROFIL -->
    <div class="profile-card mb-5">
        <h2>Profil Kampus</h2>
        <p class="mb-0 fs-5">{{ $visimisi->deskripsi ?? 'Deskripsi belum diisi oleh admin' }}</p>
    </div>

    <!-- VISI MISI -->
    <div class="row g-4 mb-5">
        <!-- VISI -->
        <div class="col-md-6">
            <div class="visi-card">
                <h4>Visi</h4>
                <p class="mb-0">{{ $visimisi->visi ?? '-' }}</p>
            </div>
        </div>

        <!-- MISI -->
        <div class="col-md-6">
            <div class="visi-card">
                <h4>Misi</h4>
                <p class="mb-0">{!! nl2br(e($visimisi->misi ?? '-')) !!}</p>
            </div>
        </div>
    </div>

    <!-- AKREDITASI -->
    <div class="mb-4">
        <h2 class="akreditasi-title">Akreditasi Kampus</h2>
    </div>

    <div class="row g-4 mb-5">
        @forelse($akreditasi as $a)
        <div class="col-lg-4 col-md-6">
            <div class="akreditasi-card">
                @if($a->gambar)
                <img src="{{ asset('uploads/'.$a->gambar) }}" class="akreditasi-image">
                @else
                <img src="https://placehold.co/600x400?text=Akreditasi" class="akreditasi-image">
                @endif
                <div class="akreditasi-body">
                    <div class="akreditasi-badge">{{ $a->tahun }}</div>
                    <h5>{{ $a->judul ?? 'Akreditasi Kampus' }}</h5>
                    <p>{{ $a->deskripsi }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-light border rounded-4 text-center py-4">Data akreditasi belum tersedia</div>
        </div>
        @endforelse
    </div>

    <!-- STRUKTUR ORGANISASI DOSEN -->
    <section class="py-5">
        <div class="text-center mb-5">
            <h2 class="dosen-section-title">Struktur Organisasi AMIK Taruna</h2>
        </div>

        <!-- LAYER 1 - DIREKTUR -->
        <div class="org-row justify-content-center">
            @foreach($dosen->filter(fn($d)=>str_contains($d->jabatan,'Direktur AMIK Taruna')) as $d)
                @include('partials.orgcard',['d'=>$d])
            @endforeach
        </div>
        <div class="connector"></div>

        <!-- LAYER 2 - WAKIL DIREKTUR -->
        <div class="org-row">
            @foreach($dosen->filter(fn($d)=>str_contains($d->jabatan,'Wakil Direktur')) as $d)
                @include('partials.orgcard',['d'=>$d])
            @endforeach
        </div>
        <div class="connector"></div>

        <!-- LAYER 3 - KETUA LEMBAGA/PUSAT/UPT -->
        <div class="org-row">
            @foreach($dosen->filter(function($d){
                return str_contains($d->jabatan,'Ketua Lembaga')
                    || str_contains($d->jabatan,'Ketua Pusat')
                    || str_contains($d->jabatan,'Ketua UPT')
                    || str_contains($d->jabatan,'Ketua Unit');
            }) as $d)
                @include('partials.orgcard',['d'=>$d])
            @endforeach
        </div>
        <div class="connector"></div>

        <!-- LAYER 4 - KETUA PROGRAM STUDI -->
        <div class="org-row">
            @foreach($dosen->filter(fn($d)=>str_contains($d->jabatan,'Ketua Program Studi')) as $d)
                @include('partials.orgcard',['d'=>$d])
            @endforeach
        </div>
        <div class="connector"></div>

        <!-- LAYER 5 - KEPALA BAGIAN -->
        <div class="org-row">
            @foreach($dosen->filter(fn($d)=>str_contains($d->jabatan,'Kepala Bagian')) as $d)
                @include('partials.orgcard',['d'=>$d])
            @endforeach
        </div>
        <div class="connector"></div>

        <!-- LAYER 6 - STAF -->
        <div class="org-row">
            @foreach($dosen->filter(function($d){
                return str_contains($d->jabatan,'Staf') || str_contains($d->jabatan,'Staff');
            }) as $d)
                @include('partials.orgcard',['d'=>$d])
            @endforeach
        </div>
        <div class="connector"></div>

        <!-- LAYER 7 - DOSEN -->
        <div class="org-row">
            @foreach($dosen->filter(fn($d)=>str_contains($d->jabatan,'Dosen')) as $d)
                @include('partials.orgcard',['d'=>$d])
            @endforeach
        </div>
    </section>

</div>

@endsection
