@extends('layouts.frontend')

@section('title', ($program->nama_prodi ?? 'Program Studi') . ' | AMIK Taruna Probolinggo')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($program->tagline ?? $program->deskripsi ?? 'Program Studi Vokasi AMIK Taruna Probolinggo'), 160))

@php
    if (!isset($setting)) {
        try {
            $setting = \App\Models\Setting::first();
        } catch (\Throwable $e) {
            $setting = null;
        }
    }
@endphp

@section('content')
<div
    id="app"
    data-page="akademik-detail"
    data-props="{{ json_encode([
        'setting' => $setting ?? null,
        'program' => $program,
        'kategoriDokumen' => $kategoriDokumen ?? [],
    ]) }}"
>
</div>
@endsection
