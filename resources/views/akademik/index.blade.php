@extends('layouts.frontend')

@section('title', 'Program Studi & Akademik | AMIK Taruna Probolinggo')
@section('meta_description', 'Pilihan program studi diploma vokasi teknologi informasi resmi AMIK Taruna Probolinggo: Sistem Informasi, Teknologi Informasi, dan Sistem Informasi Akuntansi.')

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
    data-page="akademik"
    data-props="{{ json_encode([
        'setting' => $setting ?? null,
        'program_studis' => $programs ?? [],
    ]) }}"
>
</div>
@endsection