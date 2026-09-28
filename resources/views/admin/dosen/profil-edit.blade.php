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

<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mt-4">
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success rounded-3 px-4">
            Simpan Profil
        </button>
        <a href="{{ route('admin.profil.dosen') }}" class="btn btn-outline-secondary rounded-3 px-4">
            Kembali
        </a>
    </div>
    <div>
        <button type="button" class="btn btn-outline-danger rounded-3 px-4" onclick="if(confirm('Apakah Anda yakin ingin menghapus profil dosen ini?')) { document.getElementById('deleteProfilDosenForm').submit(); }">
            <i class="fas fa-trash me-1"></i> Hapus Profil Dosen
        </button>
    </div>
</div>

</form>

<form id="deleteProfilDosenForm" action="{{ route('admin.profil.dosen.destroy', $dosen->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

</div>

@endsection