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

<a href="{{ route('admin.profil.dosen.edit',$d->id) }}"
   class="btn btn-success">

    Kelola Profil

</a>

</div>
</div>
</div>

@endforeach

</div>
</div>

@endsection