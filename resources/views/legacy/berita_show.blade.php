
@extends('layouts.main')

@section('content')

<div class="container py-5">

    <div class="mb-4">
        <a href="{{ route('berita.index') }}" class="btn btn-outline-success rounded-pill">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Berita
        </a>
    </div>

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

        {{-- GAMBAR BERITA --}}
        @if(!empty($berita->gambar))
            <img src="{{ asset('uploads/berita/gambar/'.$berita->gambar) }}"
                 alt="{{ $berita->judul }}"
                 class="w-100"
                 style="height:500px;object-fit:cover;"
                 onerror="this.style.display='none'">
        @endif

        <div class="card-body p-4 p-lg-5">

            {{-- KATEGORI --}}
            @if(!empty($berita->kategori))
                <span class="badge bg-success rounded-pill px-3 py-2 mb-3">
                    {{ $berita->kategori }}
                </span>
            @endif

            {{-- JUDUL --}}
            <h1 class="fw-bold mb-4">
                {{ $berita->judul }}
            </h1>

            {{-- META --}}
            <div class="d-flex flex-wrap gap-3 mb-4">

                <span class="badge bg-light text-dark border px-3 py-2">
                    <i class="fas fa-calendar-alt text-success me-2"></i>
                    {{ optional($berita->created_at)->translatedFormat('d F Y') }}
                </span>

                @if(!empty($berita->penulis))
                <span class="badge bg-light text-dark border px-3 py-2">
                    <i class="fas fa-user text-success me-2"></i>
                    {{ $berita->penulis }}
                </span>
                @endif

                @if(!empty($berita->editor))
                <span class="badge bg-light text-dark border px-3 py-2">
                    <i class="fas fa-user-edit text-success me-2"></i>
                    {{ $berita->editor }}
                </span>
                @endif

            </div>

            <hr>

            {{-- ISI BERITA --}}
            <div class="mt-4"
                 style="font-size:1rem;line-height:1.9;color:#374151;">

                {!! nl2br(e($berita->isi)) !!}

            </div>

            {{-- VIDEO --}}
            @if(!empty($berita->video))
            <div class="mt-5">

                <h4 class="fw-bold mb-3">
                    <i class="fas fa-video text-success me-2"></i>
                    Video Dokumentasi
                </h4>

                <video controls class="w-100 rounded-4 shadow">
                    <source src="{{ asset('uploads/berita/video/'.$berita->video) }}"
                            type="video/mp4">
                </video>

            </div>
            @endif

            {{-- PDF --}}
            @if(!empty($berita->file_pdf))
            <div class="mt-5">

                <div class="card bg-light border-0 rounded-4">

                    <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">

                        <div>

                            <h5 class="fw-bold mb-1">
                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                Lampiran PDF
                            </h5>

                            <small class="text-muted">
                                Dokumen pendukung berita tersedia untuk diunduh.
                            </small>

                        </div>

                        <a href="{{ asset('uploads/berita/pdf/'.$berita->file_pdf) }}"
                           target="_blank"
                           class="btn btn-danger rounded-pill px-4">

                            <i class="fas fa-download me-2"></i>
                            Download PDF

                        </a>

                    </div>

                </div>

            </div>
            @endif

        </div>

    </div>

</div>

@endsection

