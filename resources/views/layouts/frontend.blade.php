@php
    use App\Models\Setting;
    if (!isset($setting)) {
        try {
            $setting = Setting::first();
        } catch (\Throwable $e) {
            $setting = null;
        }
    }
@endphp
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', ($setting->nama_website ?? 'AMIK Taruna') . ' — Kampus Teknologi Digital')</title>
    <meta name="description" content="@yield('meta_description', 'Official website of AMIK Taruna Probolinggo - Kampus Teknologi Informasi & Komputasi Terapan.')">
    
    @if(isset($setting->logo) && $setting->logo)
        <link rel="shortcut icon" href="{{ asset('uploads/' . $setting->logo) }}">
    @endif

    <!-- Fonts: Plus Jakarta Sans (Non-blocking with display=swap) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
    </noscript>
    
    <!-- FontAwesome for icons (Asynchronous non-blocking) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </noscript>

    <!-- Vite Assets (Tailwind CSS + Vue 3 App) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="text-slate-800 antialiased overflow-x-hidden font-sans relative">
    {{-- Universal Campus Digital Aurora & Tech Mesh Background --}}
    @include('components.animated-background')

    @yield('content')
</body>
</html>
