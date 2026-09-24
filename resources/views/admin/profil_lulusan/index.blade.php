@extends('layouts.app')

@section('title', 'Profil Lulusan')

@section('content')

<style>
.card-box{
    border:none;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,.06);
    background: #ffffff;
    border: 1px solid #e2e8f0;
}

.card-header-custom{
    background:linear-gradient(135deg,#198754,#136940);
    color:white;
    padding:20px 24px;
}

.form-control,
.form-select{
    border-radius:12px;
    padding:10px 14px;
    border: 1px solid #cbd5e1;
}

.form-control:focus,
.form-select:focus{
    box-shadow:none;
    border-color:#198754;
}

.btn-custom{
    border-radius:12px;
    padding:10px 18px;
    font-weight:600;
}

.profile-card{
    border: 1px solid #e2e8f0;
    border-radius:20px;
    background:white;
    overflow:hidden;
    transition:.25s ease;
    box-shadow:0 4px 16px rgba(0,0,0,.03);
}

.profile-card:hover{
    transform:translateY(-4px);
    box-shadow:0 12px 24px rgba(0,0,0,.08);
}

.badge-prodi{
    background:#dcfce7;
    color:#166534;
    border-radius:30px;
    padding:6px 14px;
    font-size:12px;
    font-weight:700;
}

.section-title{
    font-weight:800;
    color:#0f172a;
}
</style>

<div class="container-fluid p-0">

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="section-title">

            Kelola Profil Lulusan

        </h2>

        <p class="text-muted">

            Tambahkan profil lulusan tiap program studi

        </p>

    </div>

    <a href="{{ route('admin.dashboard') }}"
       class="btn btn-secondary btn-custom">

        ← Dashboard

    </a>

</div>

@if(session('success'))

<div class="alert alert-success rounded-4 border-0 shadow-sm">

    {{ session('success') }}

</div>

@endif

<div class="card card-box mb-5">

<div class="card-header-custom">

<h4>

Tambah Profil Lulusan

</h4>

</div>

<div class="card-body p-4">

<form method="POST"
      action="{{ route('profil-lulusan.store') }}">

@csrf

<div class="row g-3">

<div class="col-md-4">

<label class="fw-semibold mb-2">

Program Studi

</label>

<select name="program_studi_id"
        class="form-select"
        required>

<option value="">

Pilih Prodi

</option>

@foreach($programs as $program)

<option value="{{ $program->id }}">

{{ $program->nama_prodi }}

</option>

@endforeach

</select>

</div>

<div class="col-md-4">

<label class="fw-semibold mb-2">

Judul Profil

</label>

<input type="text"
       name="judul"
       class="form-control"
       placeholder="Contoh: Software Engineer"
       required>

</div>

<div class="col-md-12">

<label class="fw-semibold mb-2">

Deskripsi

</label>

<textarea name="deskripsi"
          rows="5"
          class="form-control"
          required></textarea>

</div>

</div>

<div class="mt-4">

<button class="btn btn-success btn-custom">

+ Tambah Profil

</button>

</div>

</form>

</div>

</div>

<div class="row g-4">

@forelse($profils as $profil)

<div class="col-lg-4">

<div class="profile-card p-4 h-100">

<div class="mb-3">

<span class="badge-prodi">
    {{ $profil->programStudi?->nama_prodi ?? 'Prodi Umum' }}
</span>

</div>

<h4 class="fw-bold mb-3">

{{ $profil->judul }}

</h4>

<p class="text-muted">

{{ $profil->deskripsi }}

</p>

<div class="d-flex gap-2 mt-4">

<a href="{{ route('profil-lulusan.edit',$profil->id) }}"
   class="btn btn-warning btn-sm rounded-3 px-3">

Edit

</a>

<form method="POST"
      action="{{ route('profil-lulusan.destroy',$profil->id) }}">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm rounded-3 px-3"
onclick="return confirm('Hapus profil ini?')">

Hapus

</button>

</form>

</div>

</div>

</div>

@empty

<div class="col-12">

<div class="alert alert-warning rounded-4 text-center">

Belum ada data profil lulusan.

</div>

</div>

@endforelse

</div>

@endsection