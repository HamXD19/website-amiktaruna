@extends('layouts.app')

@section('title', 'Edit Profil Lulusan')

@section('content')

<div class="container-fluid p-0">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-slate-900 mb-1">Edit Profil Lulusan</h4>
            <p class="text-slate-500 small mb-0">Perbarui profil karir atau capaian lulusan program studi</p>
        </div>
        <a href="{{ route('profil-lulusan.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-bold">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    @if(isset($errors) && $errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-xs mb-4" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <span class="fw-bold">Terjadi kesalahan input:</span>
            <ul class="mb-0 mt-1 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('profil-lulusan.update', $profil->id) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-slate-700">Program Studi <span class="text-danger">*</span></label>
                        <select name="program_studi_id" class="form-select rounded-3" required>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}" {{ $profil->program_studi_id == $program->id ? 'selected' : '' }}>
                                    {{ $program->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-slate-700">Judul Profil / Profesi <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control rounded-3" value="{{ old('judul', $profil->judul) }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-semibold text-slate-700">Deskripsi Karir / Kemampuan <span class="text-danger">*</span></label>
                        <textarea name="deskripsi" rows="6" class="form-control rounded-3" required>{{ old('deskripsi', $profil->deskripsi) }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-2">
                    <a href="{{ route('profil-lulusan.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-warning fw-bold text-dark rounded-pill px-4 shadow-xs">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
