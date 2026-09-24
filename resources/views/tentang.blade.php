@extends('layouts.frontend')

@section('title', 'Tentang AMIK Taruna — Profil Kampus, Visi Misi & Sivitas')
@section('meta_description', 'Profil lengkap AMIK Taruna Probolinggo, sejarah, visi misi, akreditasi resmi institusi, dan jajaran pimpinan serta dosen pengajar.')

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
    data-page="tentang"
    data-props="{{ json_encode([
        'setting' => $setting ?? null,
        'visimisi' => $visimisi ?? null,
        'dosen' => $dosen ?? [],
        'akreditasi' => $akreditasi ?? [],
    ]) }}"
>
</div>
@endsection