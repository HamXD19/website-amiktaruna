@extends('layouts.frontend')

@section('title', ($berita->judul ?? 'Warta & Berita') . ' | AMIK Taruna Probolinggo')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($berita->isi ?? 'Informasi resmi publikasi dan kegiatan kampus AMIK Taruna Probolinggo'), 160))

@php
    if (!isset($setting)) {
        try {
            $setting = \App\Models\Setting::first();
        } catch (\Throwable $e) {
            $setting = null;
        }
    }

    try {
        $latestBeritas = \App\Models\Berita::where('id', '!=', $berita->id ?? 0)
            ->where('publish_at', '<=', now())
            ->latest('publish_at')
            ->take(4)
            ->get();
    } catch (\Throwable $e) {
        $latestBeritas = [];
    }
@endphp

@section('content')
<div
    id="app"
    data-page="berita-detail"
    data-props="{{ json_encode([
        'setting' => $setting ?? null,
        'berita' => $berita,
        'latest_beritas' => $latestBeritas ?? [],
    ]) }}"
>
</div>
@endsection
