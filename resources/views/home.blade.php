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
</div>
@endsection