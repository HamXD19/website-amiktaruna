@extends('layouts.app')

@section('title', 'FAQ Prodi')

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
background:linear-gradient(135deg,#7c3aed,#6d28d9);
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

.btn-modern{
border-radius:16px;
font-weight:700;
padding:12px 18px;
}

.faq-card{
border:none;
border-radius:24px;
background:white;
box-shadow:0 10px 25px rgba(0,0,0,.06);
transition:.25s;
}

.faq-card:hover{
transform:translateY(-4px);
}

.question{
font-weight:800;
font-size:1.05rem;
color:#6d28d9;
}

.answer{
color:#64748b;
line-height:1.8;
}

</style>

</head>

<body>

<div class="container py-5">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h1 class="fw-bold">

❓ FAQ Program Studi

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

<div class="header-modern">

<h3>

Tambah FAQ

</h3>

</div>

<div class="card-body p-4">

<form
method="POST"
action="{{ route('faq.store') }}">

@csrf

<input
type="hidden"
name="program_studi_id"
value="{{ $program->id }}">

<div class="mb-3">

<label>Pertanyaan</label>

<input
type="text"
name="pertanyaan"
class="form-control rounded-4"
required>

</div>

<div class="mb-3">

<label>Jawaban</label>

<textarea
name="jawaban"
rows="5"
class="form-control rounded-4"
required></textarea>

</div>

<button class="btn btn-primary btn-modern">

+ Simpan FAQ

</button>

</form>

</div>

</div>

<div class="row g-4">

@forelse($program->faqs as $faq)

<div class="col-lg-6">

<div class="faq-card p-4 h-100">

<div class="question mb-3">

<i class="fa-solid fa-circle-question me-2"></i>

{{ $faq->pertanyaan }}

</div>

<div class="answer">

{{ $faq->jawaban }}

</div>

<div class="d-flex gap-2 mt-4">

<button
class="btn btn-warning btn-modern"
data-bs-toggle="modal"
data-bs-target="#edit{{ $faq->id }}">

Edit

</button>

<form
method="POST"
action="{{ route('faq.destroy',$faq->id) }}">

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
id="edit{{ $faq->id }}">

<div class="modal-dialog">

<div class="modal-content rounded-5 border-0">

<div class="modal-header bg-warning">

<h5 class="fw-bold">

Edit FAQ

</h5>

<button
class="btn-close"
data-bs-dismiss="modal"></button>

</div>

<div class="modal-body">

<form
method="POST"
action="{{ route('faq.update',$faq->id) }}">

@csrf

<div class="mb-3">

<label>Pertanyaan</label>

<input
type="text"
name="pertanyaan"
value="{{ $faq->pertanyaan }}"
class="form-control rounded-4">

</div>

<div class="mb-3">

<label>Jawaban</label>

<textarea
name="jawaban"
rows="6"
class="form-control rounded-4">{{ $faq->jawaban }}</textarea>

</div>

<button class="btn btn-warning btn-modern w-100">

Update FAQ

</button>

</form>

</div>

</div>

</div>

</div>

@empty

<div class="col-12">

<div class="alert alert-light rounded-4">

Belum ada FAQ.

</div>

</div>

@endforelse

</div>

@endsection

