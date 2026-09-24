{{-- BACKUP LEGACY ALUMNI BLADE (PHASE 4 AUDIT PRESERVATION) --}}
@extends('layouts.main')

@section('content')

<div class="container py-5">

    <!-- HEADER -->
    <div class="text-center mb-5">
        <h1 class="fw-bold display-5 mb-3">
            Portal Alumni AMIK Taruna
        </h1>

        <p class="text-muted fs-5">
            Terhubung bersama alumni dan berkontribusi untuk kemajuan kampus
        </p>
    </div>

    @forelse($data as $item)

        @php
            $isTracer = $item->type === 'tracer_study';
            $isLeft = $item->layout === 'left_image';
            $link = trim($item->link ?? '#');
        @endphp

        <section class="mb-5">

            <div class="card border-0 shadow-lg rounded-5 overflow-hidden">

                <div class="row g-0 align-items-center">

                    {{-- IMAGE LEFT --}}
                    @if($isLeft)
                        <div class="col-lg-5">
                            <img src="{{ asset('uploads/'.$item->image) }}"
                                 class="img-fluid w-100 h-100"
                                 style="object-fit:cover; min-height:350px;"
                                 alt="{{ $item->judul }}">
                        </div>
                    @endif

                    {{-- CONTENT --}}
                    <div class="col-lg-7">
                        <div class="p-5">

                            {{-- BADGE --}}
                            <span class="badge rounded-pill px-4 py-2 mb-3
                                {{ $isTracer ? 'bg-primary' : 'bg-warning text-dark' }}">

                                {{ $isTracer ? 'Tracer Study' : 'Dana Abadi Alumni' }}

                            </span>

                            {{-- TITLE --}}
                            <h2 class="fw-bold mb-3">
                                {{ $item->judul }}
                            </h2>

                            {{-- DESCRIPTION --}}
                            <p class="text-muted fs-5 mb-4" style="line-height:1.8;">
                                {{ $item->deskripsi }}
                            </p>

                            {{-- BUTTON --}}
                            <a href="{{ $link }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="btn {{ $isTracer ? 'btn-primary' : 'btn-warning text-dark' }}
                                      rounded-pill px-5 py-3 fw-semibold shadow-sm">

                                @if($isTracer)
                                    <i class="fas fa-user-graduate me-2"></i>
                                    Masuk Portal Tracer
                                @else
                                    <i class="fas fa-hand-holding-heart me-2"></i>
                                    Donasi Dana Abadi
                                @endif

                            </a>

                        </div>
                    </div>

                    {{-- IMAGE RIGHT --}}
                    @if(!$isLeft)
                        <div class="col-lg-5">
                            <img src="{{ asset('uploads/'.$item->image) }}"
                                 class="img-fluid w-100 h-100"
                                 style="object-fit:cover; min-height:350px;"
                                 alt="{{ $item->judul }}">
                        </div>
                    @endif

                </div>

            </div>

        </section>

    @empty

        <div class="text-center py-5">

            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486740.png"
                 width="180"
                 class="mb-4">

            <h3 class="fw-bold">
                Belum Ada Data Alumni
            </h3>

            <p class="text-muted">
                Silakan tambahkan data alumni section terlebih dahulu
            </p>

        </div>

    @endforelse

</div>

@endsection
