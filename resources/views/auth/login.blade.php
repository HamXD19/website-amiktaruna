@extends('layouts.guest')

@section('title', 'Login Portal Sivitas | ' . ($setting->nama_website ?? 'AMIK Taruna Probolinggo'))

@section('content')

@php
    $setting = \App\Models\Setting::first();
@endphp

<div class="min-h-screen flex flex-col justify-center items-center px-4 py-12 relative z-10">
    
    <!-- Ambient Glow Blobs -->
    <div class="absolute top-1/4 -left-20 w-80 h-80 bg-emerald-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-1/4 -right-20 w-80 h-80 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md">
        
        <!-- Brand Header with Logo -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex flex-col items-center group transition-transform duration-300 hover:scale-105">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-[#083821] to-[#041d11] p-3 border border-emerald-500/40 shadow-xl shadow-emerald-950/60 mb-3 flex items-center justify-center relative">
                    <div class="absolute inset-0 bg-emerald-400/10 rounded-2xl blur-xs group-hover:bg-emerald-400/20 transition-all"></div>
                    @if($setting && $setting->logo)
                        <img src="{{ asset('uploads/'.$setting->logo) }}"
                             alt="{{ $setting->nama_website ?? 'AMIK Taruna' }}"
                             class="w-full h-full object-contain relative z-10"
                             onerror="this.style.display='none'">
                    @else
                        <i class="fas fa-university text-3xl text-emerald-400 relative z-10"></i>
                    @endif
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-widest bg-emerald-950/80 text-emerald-300 border border-emerald-500/30 shadow-xs mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Portal Sivitas Akademika
                </span>
                <h1 class="text-2xl font-extrabold text-white tracking-tight">
                    {{ $setting->nama_website ?? 'AMIK Taruna' }}
                </h1>
                <p class="text-xs text-slate-400 mt-1 font-medium">
                    Sistem Informasi &amp; Manajemen Kampus Terpadu
                </p>
            </a>
        </div>

        <!-- Glassmorphism Login Card -->
        <div class="bg-[#062919]/90 backdrop-blur-2xl rounded-3xl p-7 sm:p-9 border border-emerald-500/30 shadow-2xl shadow-black/60 relative overflow-hidden">
            
            <!-- Subtle Top Line Accent -->
            <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-transparent via-emerald-400 to-transparent"></div>

            {{-- STATUS SESSION (e.g. password reset status) --}}
            @if(session('status'))
                <div class="mb-5 p-3.5 rounded-xl bg-emerald-950/80 border border-emerald-500/40 text-emerald-200 text-xs font-semibold flex items-center gap-2.5">
                    <i class="fas fa-check-circle text-emerald-400 text-sm"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- EMAIL --}}
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-emerald-300/90 mb-2">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-400/80 text-sm">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@amiktaruna.ac.id"
                            required
                            autofocus
                            class="w-full pl-10 pr-4 py-3 bg-[#031d11]/85 border border-emerald-500/30 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 transition-all"
                        >
                    </div>
                    @error('email')
                        <p class="mt-2 text-xs text-rose-400 flex items-center gap-1.5 font-medium">
                            <i class="fas fa-exclamation-circle text-rose-400"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                {{-- PASSWORD --}}
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-emerald-300/90 mb-2">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-400/80 text-sm">
                            <i class="fas fa-lock"></i>
                        </div>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            required
                            class="w-full pl-10 pr-11 py-3 bg-[#031d11]/85 border border-emerald-500/30 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 transition-all"
                        >
                        <!-- Show / Hide Password Button -->
                        <button
                            type="button"
                            id="togglePasswordBtn"
                            onclick="togglePasswordVisibility()"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-emerald-400 transition-colors focus:outline-none"
                            title="Tampilkan / Sembunyikan Password"
                        >
                            <i id="passwordEyeIcon" class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-xs text-rose-400 flex items-center gap-1.5 font-medium">
                            <i class="fas fa-exclamation-circle text-rose-400"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                {{-- REMEMBER & FORGOT PASSWORD --}}
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none text-xs font-medium text-slate-300 hover:text-white transition-colors">
                        <input
                            type="checkbox"
                            name="remember"
                            id="remember"
                            class="w-4 h-4 rounded bg-[#031d11] border-emerald-500/40 text-emerald-500 focus:ring-emerald-400/30 focus:ring-offset-0 transition"
                        >
                        <span>Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-semibold text-emerald-400 hover:text-emerald-300 hover:underline transition-colors">
                            Lupa password?
                        </a>
                    @endif
                </div>

                {{-- SUBMIT BUTTON --}}
                <button
                    type="submit"
                    class="w-full py-3.5 px-5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-bold text-sm tracking-wide shadow-lg shadow-emerald-950/60 hover:shadow-emerald-500/25 active:scale-[0.99] transition-all flex items-center justify-center gap-2"
                >
                    <i class="fas fa-sign-in-alt text-xs"></i>
                    <span>Masuk ke Dashboard</span>
                </button>
            </form>

            <!-- Bottom Note -->
            <div class="mt-6 pt-5 border-t border-emerald-500/20 text-center text-xs text-slate-400 flex items-center justify-center gap-2">
                <i class="fas fa-shield-alt text-emerald-400"></i>
                <span>Koneksi aman dengan enkripsi SSL 256-Bit</span>
            </div>

        </div>

        <!-- Back to Website -->
        <div class="text-center mt-6">
            <a href="/" class="inline-flex items-center gap-2 text-xs font-semibold text-emerald-400 hover:text-emerald-300 py-2 px-4 rounded-xl hover:bg-emerald-950/50 transition-colors">
                <i class="fas fa-arrow-left text-[11px]"></i>
                <span>Kembali ke Beranda Utama</span>
            </a>
        </div>

    </div>

</div>

<script>
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('passwordEyeIcon');
    if (!passwordInput || !eyeIcon) return;

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}
</script>

@endsection