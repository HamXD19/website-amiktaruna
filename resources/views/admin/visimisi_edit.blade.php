@extends('layouts.app')

@section('title', 'Edit Visi & Misi')

@section('content')

<div class="container-fluid p-0">

    <!-- HEADER -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-slate-900 mb-1">Edit Visi, Misi &amp; Deskripsi Kampus</h4>
            <p class="text-slate-500 small mb-0">Perbarui rumusan visi, poin-poin misi, dan profil pengantar institusi</p>
        </div>

        <a href="{{ route('admin.visimisi') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-bold">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <!-- FORM -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">

            <form action="{{ route('admin.visimisi.update') }}" method="POST">
                @csrf

                <!-- DESKRIPSI -->
                <div class="mb-4">
                    <label class="form-label small fw-bold text-slate-700">Deskripsi Kampus</label>
                    <textarea name="deskripsi" class="form-control rounded-3" rows="4" placeholder="Masukkan deskripsi pengenalan kampus...">{{ $data->deskripsi ?? '' }}</textarea>
                </div>

                <!-- VISI -->
                <div class="mb-4">
                    <label class="form-label small fw-bold text-slate-700">Visi Kampus</label>
                    <textarea name="visi" class="form-control rounded-3" rows="3" placeholder="Masukkan rumusan visi kampus...">{{ $data->visi ?? '' }}</textarea>
                </div>

                <!-- MISI -->
                <div class="mb-4">
                    <label class="form-label small fw-bold text-slate-700">Misi Kampus</label>
                    <textarea name="misi" class="form-control rounded-3" rows="6" placeholder="Masukkan butir-butir misi kampus...">{{ $data->misi ?? '' }}</textarea>
                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('admin.visimisi') }}" class="btn btn-light rounded-pill px-4 fw-bold">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection