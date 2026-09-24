@extends('layouts.guest')

@section('content')

@php
    $setting = \App\Models\Setting::first();
@endphp

<style>

body{
    background:linear-gradient(135deg,#e6f5ec,#f7faf8);
    font-family:'Plus Jakarta Sans',sans-serif;
    margin:0;
}

.login-wrapper{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:40px 20px;
}

.login-card{
    background:#fff;
    width:100%;
    max-width:470px;
    border-radius:28px;
    padding:45px;
    box-shadow:0 25px 70px rgba(0,0,0,.10);
}

.login-logo{
    text-align:center;
    margin-bottom:30px;
}

.login-logo img{
    width:85px;
    margin-bottom:18px;
}

.login-title{
    font-size:2rem;
    font-weight:800;
    color:#0f1f14;
    margin-bottom:10px;
}

.login-sub{
    color:#6b7280;
    font-size:.95rem;
}

.form-control{
    border-radius:14px;
    padding:14px 18px;
    border:1px solid #d1d5db;
}

.form-control:focus{
    border-color:#198754;
    box-shadow:0 0 0 .15rem rgba(25,135,84,.15);
}

.btn-login{
    width:100%;
    background:#198754;
    color:#fff;
    border:none;
    border-radius:14px;
    padding:14px;
    font-weight:700;
    transition:.3s;
}

.btn-login:hover{
    background:#136940;
}

.back-home{
    text-decoration:none;
    color:#198754;
    font-weight:600;
}

.invalid-feedback{
    display:block;
}

</style>

<div class="login-wrapper">

    <div class="login-card">

        <div class="login-logo">

            @if($setting && $setting->logo)

                <img src="{{ asset('uploads/'.$setting->logo) }}"
                     alt="Logo"
                     onerror="this.style.display='none'">

            @endif

            <h1 class="login-title">
                Login Admin
            </h1>

            <p class="login-sub">
                Masuk ke Dashboard {{ $setting->nama_website ?? 'AMIK Taruna' }}
            </p>

        </div>

        {{-- STATUS SESSION --}}
        @if(session('status'))

            <div class="alert alert-success mb-4">

                {{ session('status') }}

            </div>

        @endif

        <form method="POST" action="{{ route('login') }}">

            @csrf

            {{-- EMAIL --}}
            <div class="mb-4">

                <label class="form-label fw-semibold">

                    Email

                </label>

                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       required
                       autofocus>

                @error('email')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            {{-- PASSWORD --}}
            <div class="mb-4">

                <label class="form-label fw-semibold">

                    Password

                </label>

                <input type="password"
                       name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       required>

                @error('password')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            {{-- REMEMBER --}}
            <div class="d-flex justify-content-between mb-4">

                <div class="form-check">

                    <input class="form-check-input"
                           type="checkbox"
                           name="remember"
                           id="remember">

                    <label class="form-check-label"
                           for="remember">

                        Remember me

                    </label>

                </div>

                @if (Route::has('password.request'))

                    <a href="{{ route('password.request') }}"
                       class="back-home">

                        Lupa Password?

                    </a>

                @endif

            </div>

            <button type="submit"
                    class="btn-login">

                <i class="fas fa-sign-in-alt me-2"></i>

                Login Dashboard

            </button>

        </form>

        <div class="text-center mt-4">

            <a href="/"
               class="back-home">

                ← Kembali ke Website

            </a>

        </div>

    </div>

</div>

@endsection