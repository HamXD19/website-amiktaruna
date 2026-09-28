@extends('layouts.app')

@section('content')

<div class="container py-4">

<h2 class="mb-4">
    Profil Dosen
</h2>

<div class="row">

@foreach($dosen as $d)

<div class="col-md-4 mb-4">

<div class="card shadow-sm border-0 rounded-4">

<div class="card-body text-center">

@if($d->foto)

<img src="{{ asset('uploads/'.$d->foto) }}"
     width="90"
     height="90"
     class="rounded-circle mb-3">

@endif

<h5>{{ $d->nama }}</h5>

<p class="text-muted">
    {{ $d->jabatan }}
</p>

<div class="d-flex justify-content-center gap-2">
    <a href="{{ route('admin.profil.dosen.edit',$d->id) }}"
       class="btn btn-success btn-sm rounded-3">
        Kelola Profil
    </a>

    <form method="POST" action="/admin/dosen/{{ $d->id }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data dosen {{ $d->nama }}?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger btn-sm rounded-3">
            <i class="fas fa-trash-alt"></i> Hapus
        </button>
    </form>
</div>
</div>
</div>
</div>

@endforeach

</div>
</div>

@endsection