@extends('layouts.app')

@section('title', 'Edit Program Studi - ' . $program->nama_prodi)

@section('content')

<style>
.card-modern {
    border: none;
    border-radius: 20px;
    background: #ffffff;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid #e2e8f0;
    overflow: hidden;
}

.header-modern {
    background: linear-gradient(135deg, #065f46, #047857);
    padding: 24px 28px;
    color: #ffffff;
}

.form-control, .form-select {
    border-radius: 12px;
    padding: 10px 14px;
    border: 1px solid #cbd5e1;
    font-size: 0.9rem;
}

.form-control:focus, .form-select:focus {
    border-color: #059669;
    box-shadow: none;
}
</style>

<div class="container-fluid p-0">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-slate-900 mb-1">
                ✏️ Edit Program Studi
            </h2>
            <p class="text-slate-500 small mb-0">
                Perbarui profil, akreditasi, visi-misi, serta informasi akademik {{ $program->nama_prodi }}.
            </p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('program-studi.dokumen.index', $program->id) }}" class="btn btn-emerald-700 btn-sm rounded-pill px-3 fw-bold text-white shadow-xs" style="background: #065f46;">
                <i class="fas fa-folder-open me-1"></i> Kelola Dokumen Prodi ({{ $program->dokumens()->count() }})
            </a>
            <a href="{{ route('program-studi.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Alert Sukses / Error -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-xs mb-4">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-xs mb-4">
            <i class="fas fa-exclamation-triangle me-2"></i> Terjadi kesalahan input:
            <ul class="mb-0 mt-1 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card card-modern">
        <div class="header-modern d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-white">Formulir Data Program Studi</h5>
            <span class="badge bg-white text-dark rounded-pill px-3 py-1 font-monospace">
                ID: #{{ $program->id }}
            </span>
        </div>

        <div class="card-body p-4 p-lg-5">
            <form method="POST" action="{{ route('program-studi.update', $program->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <!-- NAMA PRODI -->
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-slate-700"><i class="fa-regular fa-building me-1 text-success"></i> Nama Prodi <span class="text-danger">*</span></label>
                        <input type="text" name="nama_prodi" class="form-control" value="{{ old('nama_prodi', $program->nama_prodi) }}" required>
                    </div>

                    <!-- TAGLINE -->
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-slate-700"><i class="fa-regular fa-tag me-1 text-success"></i> Tagline</label>
                        <input type="text" name="tagline" class="form-control" value="{{ old('tagline', $program->tagline) }}">
                    </div>

                    <!-- AKREDITASI -->
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-slate-700"><i class="fa-regular fa-star me-1 text-success"></i> Akreditasi</label>
                        <input type="text" name="akreditasi" class="form-control" value="{{ old('akreditasi', $program->akreditasi) }}" placeholder="Contoh: Baik Sekali / Unggul / B">
                    </div>

                    <!-- THUMBNAIL FOTO -->
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-slate-700"><i class="fa-regular fa-image me-1 text-success"></i> Thumbnail / Foto Utama</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                        @if($program->thumbnail)
                            <div class="small text-slate-400 mt-1">
                                Berkas saat ini: <a href="{{ asset('uploads/program_studi/' . $program->thumbnail) }}" target="_blank" class="text-success fw-bold">{{ $program->thumbnail }}</a>
                            </div>
                        @endif
                    </div>

                    <!-- KALENDER AKADEMIK -->
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-slate-700"><i class="fa-regular fa-calendar me-1 text-success"></i> Kalender Akademik (PDF, DOC, DOCX)</label>
                        <input type="file" name="kalender_akademik" class="form-control" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        @if($program->kalender_akademik)
                            <div class="small text-slate-400 mt-1">
                                Berkas saat ini: <a href="{{ asset('uploads/program_studi/' . $program->kalender_akademik) }}" target="_blank" class="text-success fw-bold">{{ $program->kalender_akademik }}</a>
                            </div>
                        @endif
                    </div>

                    <!-- JADWAL SEMESTER -->
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-slate-700"><i class="fa-regular fa-clock me-1 text-success"></i> Jadwal Perkuliahan / Semester (PDF, DOC, DOCX)</label>
                        <input type="file" name="jadwal_semester" class="form-control" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        @if($program->jadwal_semester)
                            <div class="small text-slate-400 mt-1">
                                Berkas saat ini: <a href="{{ asset('uploads/program_studi/' . $program->jadwal_semester) }}" target="_blank" class="text-success fw-bold">{{ $program->jadwal_semester }}</a>
                            </div>
                        @endif
                    </div>

                    <!-- DESKRIPSI -->
                    <div class="col-12">
                        <label class="form-label small fw-semibold text-slate-700"><i class="fa-regular fa-note-sticky me-1 text-success"></i> Deskripsi Program Studi</label>
                        <textarea name="deskripsi" rows="4" class="form-control">{{ old('deskripsi', $program->deskripsi) }}</textarea>
                    </div>

                    <!-- VISI -->
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-slate-700"><i class="fa-regular fa-eye me-1 text-success"></i> Visi Keilmuan</label>
                        <textarea name="visi" rows="4" class="form-control">{{ old('visi', $program->visi) }}</textarea>
                    </div>

                    <!-- MISI -->
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-slate-700"><i class="fa-regular fa-flag me-1 text-success"></i> Misi Program Studi</label>
                        <textarea name="misi" rows="4" class="form-control">{{ old('misi', $program->misi) }}</textarea>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3 mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-success px-4 py-2 rounded-pill fw-bold shadow-xs">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('program-studi.index') }}" class="btn btn-light px-4 py-2 rounded-pill">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
