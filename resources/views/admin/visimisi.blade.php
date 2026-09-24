@extends('layouts.app')

@section('title', 'Visi & Misi')

@section('content')

<div class="container-fluid p-0">

    <!-- HEADER -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-slate-900 mb-1">Manajemen Visi, Misi &amp; Deskripsi Kampus</h4>
            <p class="text-slate-500 small mb-0">Kelola identitas, arah strategis, dan profil pengenalan AMIK Taruna</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-bold">
                <i class="fas fa-arrow-left me-1"></i>Dashboard
            </a>
            <a href="{{ route('admin.visimisi.edit') }}" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold">
                <i class="fas fa-edit me-1"></i>Edit Visi &amp; Misi
            </a>
        </div>
    </div>

    <!-- CARD CONTENT -->
    <div class="row g-4">
        <!-- Deskripsi Kampus -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-slate-900 mb-3 d-flex align-items-center gap-2">
                        <i class="fas fa-university text-success"></i>
                        Deskripsi AMIK Taruna
                    </h6>
                    <p class="text-slate-600 mb-0" style="line-height: 1.8;">
                        {{ $data->deskripsi ?? 'Belum ada deskripsi yang diinput.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Visi -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-slate-900 mb-3 d-flex align-items-center gap-2">
                        <i class="fas fa-bullseye text-primary"></i>
                        Visi Institusi
                    </h6>
                    <p class="text-slate-600 mb-0" style="line-height: 1.8;">
                        {{ $data->visi ?? 'Belum ada visi yang diinput.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Misi -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-slate-900 mb-3 d-flex align-items-center gap-2">
                        <i class="fas fa-list-check text-warning"></i>
                        Misi Institusi
                    </h6>
                    <div class="text-slate-600 mb-0" style="line-height: 1.8; white-space: pre-line;">
                        {{ $data->misi ?? 'Belum ada misi yang diinput.' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection