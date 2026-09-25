<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $setting = \App\Models\Setting::first();
    @endphp

    <title>@yield('title', 'Login Portal Sivitas | ' . ($setting->nama_website ?? 'AMIK Taruna Probolinggo'))</title>

    @if(!empty($setting->logo))
        <link rel="shortcut icon" href="{{ asset('uploads/' . $setting->logo) }}">
    @endif

    <!-- Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Vite Assets (Tailwind CSS) -->
    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#031d11] text-slate-100 font-sans antialiased min-h-screen relative overflow-x-hidden selection:bg-emerald-500 selection:text-black">
    {{-- Universal Campus Digital Aurora & Tech Mesh Background --}}
    @include('components.animated-background')

    @yield('content')
    {{ $slot ?? '' }}
</body>
</html>