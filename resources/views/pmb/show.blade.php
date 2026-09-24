@extends('layouts.main')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <a href="{{ url('/pmb') }}" class="btn btn-success">
            ← Kembali ke Halaman PMB
        </a>
    </div>

    <div class="card pmb-show-card shadow-sm border-0 rounded-4 overflow-hidden">
        @if($berita->gambar)
            <img src="{{ asset('uploads/beritapmb/gambar/'.$berita->gambar) }}"
                 class="card-img-top"
                 alt="{{ $berita->judul }}"
                 style="height: 450px; width: 100%; object-fit: cover;">
        @endif

        <div class="card-body p-4 p-lg-5">
            <div class="mb-3">
                <span class="badge bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 fs-6 px-3 py-2 rounded-pill">
                    {{ $berita->kategori ?? 'Berita PMB' }}
                </span>
            </div>

            <h1 class="fw-bold text-white mb-3">
                {{ $berita->judul }}
            </h1>

            <div class="text-slate-400 border-bottom pb-3 mb-4" style="border-color: rgba(74, 222, 128, 0.2) !important;">
                <i class="bi bi-person-circle text-emerald-400"></i> Oleh <strong class="text-white">{{ $berita->penulis }}</strong>
                <span class="mx-2">•</span>
                <i class="bi bi-calendar3 text-emerald-400"></i> {{ \Carbon\Carbon::parse($berita->publish_at)->translatedFormat('d F Y H:i') }}
                @if($berita->editor)
                    <span class="mx-2">•</span>
                    <i class="bi bi-pencil-square text-emerald-400"></i> Editor: <span class="text-white">{{ $berita->editor }}</span>
                @endif
            </div>

            <div class="berita-content fs-5 lh-lg mb-5">
                {!! nl2br(e($berita->isi)) !!}
            </div>

            @if($berita->video)
                <div class="mt-5 pt-3 border-top" style="border-color: rgba(74, 222, 128, 0.2) !important;">
                    <h4 class="fw-semibold text-emerald-300 mb-3">
                        🎥 Video Terkait
                    </h4>
                    @php
                        $isVideoUrl = \Illuminate\Support\Str::startsWith($berita->video, ['http://', 'https://']);
                        $isYouTube = \Illuminate\Support\Str::contains($berita->video, ['youtube.com', 'youtu.be']);
                        $isTikTok = \Illuminate\Support\Str::contains($berita->video, 'tiktok.com');
                        
                        $youtubeId = null;
                        if ($isYouTube && preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $berita->video, $matches)) {
                            $youtubeId = $matches[1];
                        }
                    @endphp

                    @if($isYouTube && $youtubeId)
                        <div class="ratio ratio-16x9 rounded-3 shadow-sm overflow-hidden">
                            <iframe src="https://www.youtube-nocookie.com/embed/{{ $youtubeId }}" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    @elseif($isTikTok)
                        <div class="card bg-dark text-white p-4 rounded-3 text-center border border-emerald-500/20">
                            <i class="fab fa-tiktok fs-1 text-white mb-2"></i>
                            <h5 class="mb-3">Tonton Video di TikTok</h5>
                            <div>
                                <a href="{{ $berita->video }}" target="_blank" class="btn btn-light rounded-pill px-4">
                                    <i class="fab fa-tiktok me-1"></i> Buka Video TikTok
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="ratio ratio-16x9">
                            <video controls class="rounded-3 shadow-sm">
                                <source src="{{ $isVideoUrl ? $berita->video : asset('uploads/beritapmb/video/'.$berita->video) }}" type="video/mp4">
                                Browser Anda tidak mendukung video.
                            </video>
                        </div>
                    @endif
                </div>
            @endif

            @if($berita->file_pdf)
                <div class="mt-5 pt-3 border-top" style="border-color: rgba(74, 222, 128, 0.2) !important;">
                    <h4 class="fw-semibold text-emerald-300 mb-3">
                        📄 Dokumen PDF
                    </h4>
                    <a href="{{ asset('uploads/beritapmb/pdf/'.$berita->file_pdf) }}"
                       target="_blank"
                       class="btn btn-outline-success px-4 py-2 text-emerald-300 border-emerald-500/30">
                        📑 Lihat PDF
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-4 text-center">
        <a href="{{ url('/pmb') }}" class="btn btn-outline-success px-4 text-emerald-300 border-emerald-500/30">
            ← Kembali ke Daftar Berita PMB
        </a>
    </div>
</div>

<style>
    .pmb-show-card {
        background: rgba(8, 38, 24, 0.88);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(74, 222, 128, 0.25) !important;
        border-radius: 28px;
        box-shadow: 0 16px 40px -4px rgba(0, 0, 0, 0.5);
        color: #f1f5f9;
    }
    .berita-content {
        text-align: justify;
        color: #e2e8f0;
    }
    .berita-content p {
        margin-bottom: 1rem;
    }
</style>
@endsection