@extends('layouts.app')

@section('content')

<div class="container py-4">

<h2 class="mb-4">
    Edit Profil Dosen
</h2>

<form method="POST"
      action="{{ route('admin.profil.dosen.update',$dosen->id) }}">

@csrf

<div class="mb-3">

<label>NIDN</label>

<input type="text"
       name="nidn"
       class="form-control"
       value="{{ $dosen->nidn }}">

</div>

<div class="mb-3">

<label>Email</label>

<input type="email"
       name="email"
       class="form-control"
       value="{{ $dosen->email }}">

</div>

<div class="mb-3">

<label>Pendidikan</label>

<input type="text"
       name="pendidikan"
       class="form-control"
       value="{{ $dosen->pendidikan }}">

</div>

<div class="mb-3">

<label>Bidang Keahlian</label>

<input type="text"
       name="bidang_keahlian"
       class="form-control"
       value="{{ $dosen->bidang_keahlian }}">

</div>

<div class="mb-3">

<label>LinkedIn</label>

<input type="text"
       name="linkedin"
       class="form-control"
       value="{{ $dosen->linkedin }}">

</div>

<div class="mb-3">

<label>Bio</label>

<textarea name="bio"
          rows="6"
          class="form-control">{{ $dosen->bio }}</textarea>

</div>

<button class="btn btn-success">

Simpan Profil

</button>

</form>

</div>

@endsection