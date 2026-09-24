@extends('layouts.frontend')

@section('title', 'Portal Alumni | AMIK Taruna Probolinggo')
@section('meta_description', 'Portal resmi alumni AMIK Taruna Probolinggo: Tracer Study penelusuran karir lulusan dan program kontribusi Dana Abadi almamater.')

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
    data-page="alumni"
    data-props="{{ json_encode([
        'setting' => $setting ?? null,
        'alumni_sections' => $data ?? [],
    ]) }}"
>
</div>
@endsection