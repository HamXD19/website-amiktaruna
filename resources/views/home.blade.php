@extends('layouts.frontend')

@php
    try {
        $programStudis = \App\Models\ProgramStudi::all();
    } catch (\Throwable $e) {
        $programStudis = [];
    }

    try {
        $alumniSections = \App\Models\AlumniSection::where('is_active', 1)->latest()->get();
    } catch (\Throwable $e) {
        $alumniSections = [];
    }
@endphp

@section('content')
<div
    id="app"
    data-page="home"
    data-props="{{ json_encode([
        'setting' => $setting ?? null,
        'beritas' => $beritas ?? [],
        'pengumuman' => $pengumuman ?? [],
        'pengabdian' => $pengabdian ?? [],
        'penelitian' => $penelitian ?? [],
        'kegiatan' => $kegiatan ?? [],
        'visimisi' => $visimisi ?? null,
        'dosen' => $dosen ?? [],
        'program_studis' => $programStudis ?? [],
        'alumni_sections' => $alumniSections ?? [],
    ]) }}"
>
    {{-- Instant First-Paint Critical Shell (Replaced automatically upon Vue hydration) --}}
    <!-- Mobile Initial Critical View -->
    <div class="lg:hidden min-h-screen bg-[#031d11] text-white pt-20 px-4">
        <div class="bg-gradient-to-r from-[#062c1b] to-[#041f13] rounded-2xl p-4 border border-emerald-500/25 shadow-lg mb-4">
            <div class="flex items-center gap-3">
                @if(isset($setting->logo) && $setting->logo)
                    <img src="{{ asset('uploads/' . $setting->logo) }}" alt="Logo" class="w-11 h-11 object-contain rounded-xl p-1 bg-emerald-950 border border-emerald-500/40" width="44" height="44">
                @endif
                <div>
                    <span class="text-xs font-bold text-white tracking-wide uppercase block">{{ $setting->nama_website ?? 'AMIK Taruna' }}</span>
                    <p class="text-[11px] text-slate-300 mt-0.5">Sistem Informasi &amp; Portal Sivitas Digital</p>
                </div>
            </div>
        </div>
        <div class="rounded-2xl p-5 border border-emerald-500/30 bg-gradient-to-br from-[#063820] via-[#042817] to-[#02150c] shadow-xl text-left">
            <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-emerald-400 text-slate-950 mb-2">PMB DIBUKA</span>
            <h1 class="text-lg font-extrabold text-white tracking-tight leading-snug">Penerimaan Mahasiswa Baru <span class="text-emerald-300 block">TA 2024/2025</span></h1>
            <p class="text-xs text-slate-300 mt-1 leading-relaxed">Jalur Beasiswa KIP &amp; Prestasi Akademik. Siapkan karir digital Anda!</p>
        </div>
    </div>

    <!-- Desktop Initial Critical View -->
    <div class="hidden lg:block pt-36 pb-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-12 gap-8 items-stretch">
            <div class="col-span-7 card rounded-3xl p-10 flex flex-col justify-between">
                <div>
                    <span class="inline-flex items-center gap-2 text-xs font-bold text-emerald-300 tracking-wider uppercase bg-emerald-500/20 px-3 py-1 rounded-md border border-emerald-500/30 mb-4">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        Akademi Manajemen Informatika &amp; Komputer TARUNA
                    </span>
                    <h1 class="text-3xl lg:text-4xl xl:text-5xl font-extrabold text-white tracking-tight leading-[1.14]">
                        Pendidikan Vokasi Teknologi
                        <span class="block text-emerald-400 font-bold mt-1">Kesiapan Nyata di Dunia Kerja</span>
                    </h1>
                    <p class="mt-4 text-base text-slate-300 leading-relaxed max-w-xl">
                        AMIK Taruna membekali mahasiswa dengan keahlian praktis manajemen informatika, kurikulum terapan yang relevan dengan kebutuhan industri, serta integritas kepemimpinan profesional.
                    </p>
                </div>
            </div>
            <div class="col-span-5 card rounded-3xl p-6 flex flex-col justify-between">
                <div class="rounded-xl overflow-hidden border border-emerald-500/30 bg-emerald-950/40 aspect-[16/11]">
                    @if(isset($setting->hero_slide_1) && $setting->hero_slide_1)
                        <img src="{{ asset('uploads/' . $setting->hero_slide_1) }}" alt="Kampus AMIK Taruna" class="w-full h-full object-cover" fetchpriority="high" width="640" height="440">
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection