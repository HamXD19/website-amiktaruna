
@extends('layouts.app')

@section('title', 'Profil Lulusan Prodi')

@section('content')

<style>
.card-modern{
border:none;
border-radius:24px;
box-shadow:0 10px 30px rgba(0,0,0,.04);
border: 1px solid #e2e8f0;
overflow:hidden;
}

.header-modern{
background:linear-gradient(135deg,#16a34a,#15803d);
color:white;
padding:24px 28px;
}

.item-card{
border: 1px solid #e2e8f0;
border-radius:20px;
background:white;
box-shadow:0 4px 16px rgba(0,0,0,.03);
transition:.25s ease;
}

.item-card:hover{
transform:translateY(-4px);
box-shadow:0 12px 24px rgba(0,0,0,.08);
}
</style>

<div class="container-fluid p-0">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h1 class="fw-bold">

🎓 Profil Lulusan

</h1>

<p class="text-muted">

{{ $program->nama_prodi }}

</p>

</div>

<a
href="{{ route('program-studi.index') }}"
class="btn btn-dark btn-modern">

← Kembali

</a>

</div>

@if(session('success'))

<div class="alert alert-success rounded-4">

{{ session('success') }}

</div>

@endif

<div class="card card-modern mb-5">

<div class="header-modern d-flex justify-content-between">

<h3 class="m-0">

Tambah Profil Lulusan

</h3>

</div>

<div class="card-body p-4">

<form
method="POST"
action="{{ route('profil.store') }}">

@csrf

<input
type="hidden"
name="program_studi_id"
value="{{ $program->id }}">

<div class="mb-3">

<label>Judul</label>

<input
type="text"
name="judul"
class="form-control rounded-4"
required>

</div>

<div class="mb-3">

<label>Deskripsi</label>

<textarea
name="deskripsi"
rows="5"
class="form-control rounded-4"
required></textarea>

</div>

<button class="btn btn-success btn-modern">

+ Simpan Profil

</button>

</form>

</div>

</div>

<div class="row g-4">

@forelse($program->profilLulusans as $profil)

<div class="col-lg-4">

<div class="item-card p-4 h-100">

<h4 class="fw-bold mb-3">

{{ $profil->judul }}

</h4>

<p class="text-muted">

{{ $profil->deskripsi }}

</p>

<div class="d-flex gap-2 mt-4">

<button
class="btn btn-warning btn-modern"
data-bs-toggle="modal"
data-bs-target="#edit{{ $profil->id }}">

Edit

</button>

<form
method="POST"
action="{{ route('profil.destroy',$profil->id) }}">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-modern">

Hapus

</button>

</form>

</div>

</div>

</div>

<div
class="modal fade"
id="edit{{ $profil->id }}">

<div class="modal-dialog">

<div class="modal-content rounded-5 border-0">

<div class="modal-header bg-warning">

<h5 class="fw-bold">

Edit Profil

</h5>

<button
class="btn-close"
data-bs-dismiss="modal"></button>

</div>

<div class="modal-body">

<form
method="POST"
action="{{ route('profil.update',$profil->id) }}">

@csrf

<div class="mb-3">

<label>Judul</label>

<input
type="text"
name="judul"
value="{{ $profil->judul }}"
class="form-control rounded-4">

</div>

<div class="mb-3">

<label>Deskripsi</label>

<textarea
name="deskripsi"
rows="5"
class="form-control rounded-4">{{ $profil->deskripsi }}</textarea>

</div>

<button class="btn btn-warning btn-modern w-100">

Update

</button>

</form>

</div>

</div>

</div>

</div>

@empty

<div class="col-12">

<div class="alert alert-light rounded-4">

Belum ada profil lulusan.

</div>

</div>

@endforelse

</div>

</div>

@endsection

