@extends('layouts.app')

@section('title', 'Setting Website')

@php
    $setting = $setting ?? new \App\Models\Setting();
@endphp

@section('content')

<style>
    .card-setting{
        border:none;
        border-radius:24px;
        box-shadow:0 10px 30px rgba(0,0,0,0.05);
        overflow:hidden;
    }

    .card-header-custom{
        background:white;
        padding:25px 30px;
        border-bottom:1px solid #e5e7eb;
    }

    .card-header-custom h5{
        margin:0;
        font-weight:700;
    }

    .card-body{
        padding:30px;
    }

    .form-label{
        font-weight:600;
        margin-bottom:8px;
    }

    .form-control{
        border-radius:14px;
        padding:12px 15px;
        border:1px solid #d1d5db;
    }

    .form-control:focus{
        box-shadow:none;
        border-color:#059669;
    }

    .preview-img{
        width:100%;
        max-width:220px;
        border-radius:18px;
        margin-top:10px;
        border:4px solid white;
        box-shadow:0 5px 20px rgba(0,0,0,0.08);
    }

    .btn-save{
        background:#059669;
        color:white;
        border:none;
        padding:12px 30px;
        border-radius:14px;
        font-weight:600;
    }

    .btn-save:hover{
        background:#047857;
        color:white;
    }

    .section-title{
        font-size:18px;
        font-weight:700;
        margin-bottom:25px;
        color:#0f172a;
        border-left:5px solid #059669;
        padding-left:12px;
    }
</style>

<div class="container-fluid p-0">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-slate-900 mb-1">Pengaturan Website</h4>
            <p class="text-slate-500 small mb-0">Konfigurasi nama portal, identitas kampus, logo, kontak, dan footer</p>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-bold">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="card card-setting">

        <div class="card-header-custom">

            <h5>
                Kelola Tampilan Website
            </h5>

        </div>

        <div class="card-body">

            <form action="/admin/setting/update"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                @method('PUT')

                <!-- IDENTITAS -->

                <div class="section-title">
                    Identitas Website
                </div>

                <div class="row">

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Nama Website
                        </label>

                        <input type="text"
                               name="nama_website"
                               class="form-control"
                               value="{{ $setting->nama_website }}">

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Tagline
                        </label>

                        <input type="text"
                               name="tagline"
                               class="form-control"
                               value="{{ $setting->tagline }}">

                    </div>

                </div>

                <!-- LOGO -->

                <div class="section-title">
                    Logo Website
                </div>

                <div class="mb-4">

                    <label class="form-label">
                        Upload Logo
                    </label>

                    <input type="file"
                           name="logo"
                           class="form-control">

                    @if($setting->logo)

                        <img src="{{ asset('uploads/' . $setting->logo) }}"
                             class="preview-img">

                    @endif

                </div>

                <!-- HERO -->

                <div class="section-title">
                    Hero Section
                </div>

                <div class="row">

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Hero Judul
                        </label>

                        <input type="text"
                               name="hero_judul"
                               class="form-control"
                               value="{{ $setting->hero_judul }}">

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Hero Highlight
                        </label>

                        <input type="text"
                               name="hero_highlight"
                               class="form-control"
                               value="{{ $setting->hero_highlight }}">

                    </div>

                </div>

                <div class="mb-4">

                    <label class="form-label">
                        Hero Subjudul
                    </label>

                    <textarea name="hero_subjudul"
                              rows="4"
                              class="form-control">{{ $setting->hero_subjudul }}</textarea>

                </div>

                <!-- BUTTON HERO -->

                <div class="row">

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Button 1 Text
                        </label>

                        <input type="text"
                               name="hero_button_1_text"
                               class="form-control"
                               value="{{ $setting->hero_button_1_text }}">

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Button 1 Link
                        </label>

                        <input type="text"
                               name="hero_button_1_link"
                               class="form-control"
                               value="{{ $setting->hero_button_1_link }}">

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Button 2 Text
                        </label>

                        <input type="text"
                               name="hero_button_2_text"
                               class="form-control"
                               value="{{ $setting->hero_button_2_text }}">

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Button 2 Link
                        </label>

                        <input type="text"
                               name="hero_button_2_link"
                               class="form-control"
                               value="{{ $setting->hero_button_2_link }}">

                    </div>

                </div>

                <!-- HERO SLIDER -->

                <div class="section-title">
                    Hero Carousel
                </div>

                <div class="row">

                    <!-- SLIDE 1 -->

                    <div class="col-md-4 mb-4">

                        <label class="form-label">
                            Slide 1
                        </label>

                        <input type="file"
                               name="hero_slide_1"
                               class="form-control">

                        @if($setting->hero_slide_1)

                            <img src="{{ asset('uploads/' . $setting->hero_slide_1) }}"
                                 class="preview-img">

                        @endif

                    </div>

                    <!-- SLIDE 2 -->

                    <div class="col-md-4 mb-4">

                        <label class="form-label">
                            Slide 2
                        </label>

                        <input type="file"
                               name="hero_slide_2"
                               class="form-control">

                        @if($setting->hero_slide_2)

                            <img src="{{ asset('uploads/' . $setting->hero_slide_2) }}"
                                 class="preview-img">

                        @endif

                    </div>

                    <!-- SLIDE 3 -->

                    <div class="col-md-4 mb-4">

                        <label class="form-label">
                            Slide 3
                        </label>

                        <input type="file"
                               name="hero_slide_3"
                               class="form-control">

                        @if($setting->hero_slide_3)

                            <img src="{{ asset('uploads/' . $setting->hero_slide_3) }}"
                                 class="preview-img">

                        @endif

                    </div>

                </div>

                <!-- FOOTER -->

                <div class="section-title">
                    Footer & Kontak
                </div>

                <div class="mb-4">

                    <label class="form-label">
                        Footer Deskripsi
                    </label>

                    <textarea name="footer_deskripsi"
                              rows="4"
                              class="form-control">{{ $setting->footer_deskripsi }}</textarea>

                </div>

                <div class="mb-4">

                    <label class="form-label">
                        Alamat
                    </label>

                    <textarea name="alamat"
                              rows="3"
                              class="form-control">{{ $setting->alamat }}</textarea>

                </div>

                <div class="row">

                    <div class="col-md-4 mb-4">

                        <label class="form-label">
                            Telepon
                        </label>

                        <input type="text"
                               name="telepon"
                               class="form-control"
                               value="{{ $setting->telepon }}">

                    </div>

                    <div class="col-md-4 mb-4">

                        <label class="form-label">
                            Email
                        </label>

                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ $setting->email }}">

                    </div>

                    <div class="col-md-4 mb-4">

                        <label class="form-label">
                            Jam Operasional
                        </label>

                        <input type="text"
                               name="jam_operasional"
                               class="form-control"
                               value="{{ $setting->jam_operasional }}">

                    </div>

                </div>

                <!-- SOSMED -->

                <div class="section-title">
                    Sosial Media
                </div>

                <div class="row">

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Instagram
                        </label>

                        <input type="text"
                               name="instagram"
                               class="form-control"
                               value="{{ $setting->instagram }}">

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Facebook
                        </label>

                        <input type="text"
                               name="facebook"
                               class="form-control"
                               value="{{ $setting->facebook }}">

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Youtube
                        </label>

                        <input type="text"
                               name="youtube"
                               class="form-control"
                               value="{{ $setting->youtube }}">

                    </div>

                    <div class="col-md-6 mb-5">

                        <label class="form-label">
                            TikTok
                        </label>

                        <input type="text"
                               name="tiktok"
                               class="form-control"
                               value="{{ $setting->tiktok }}">

                    </div>

                </div>

                <!-- BUTTON -->

                <button type="submit"
                        class="btn btn-primary btn-save">

                    <i data-lucide="save"></i>

                    Simpan Setting

                </button>

            </form>

        </div>

    </div>

</div>

@endsection