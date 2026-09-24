@extends('layouts.app')

@section('title', 'Program Studi')

@section('content')

<style>
/* ===== TYPOGRAPHY & UTILITIES ===== */
.page-title {
    font-size: 1.8rem;
    font-weight: 800;
    color: #0f172a;
}

.section-subtitle {
    color: #64748b;
    font-size: 0.95rem;
}

.card-modern {
    border: none;
    border-radius: 24px;
    background: #ffffff;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    overflow: hidden;
    border: 1px solid #e2e8f0;
}

.header-modern {
    background: linear-gradient(135deg, #065f46, #047857);
    padding: 22px 28px;
    color: #ffffff;
}

.header-modern h3 {
    font-weight: 700;
    font-size: 1.25rem;
    margin: 0;
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

.btn-modern {
    border-radius: 12px;
    font-weight: 600;
    padding: 10px 20px;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
}

.prodi-card {
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    overflow: hidden;
    background: white;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
    transition: all 0.25s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.prodi-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 28px rgba(0, 0, 0, 0.08);
    border-color: #10b981;
}

.prodi-img {
    height: 170px;
    object-fit: cover;
    width: 100%;
}

.badge-jenjang {
    background: #ecfdf5;
    color: #059669;
    border: 1px solid #a7f3d0;
    border-radius: 30px;
    padding: 5px 12px;
    font-size: 0.75rem;
    font-weight: 700;
}

.submenu-grid {
    display: flex;
    gap: 8px;
    justify-content: space-between;
}

.submenu-grid .btn {
    border-radius: 12px;
    padding: 8px 0;
    font-size: 0.78rem;
    transition: all 0.2s;
    background: #f8fafc;
    color: #1e293b;
    border: 1px solid #e2e8f0;
    font-weight: 600;
}

.submenu-grid .btn i {
    font-size: 1rem;
    margin-bottom: 3px;
    display: block;
}

.submenu-grid .btn-success {
    background: #ecfdf5;
    color: #059669;
    border-color: #a7f3d0;
}

.submenu-grid .btn-primary {
    background: #eff6ff;
    color: #2563eb;
    border-color: #bfdbfe;
}

.submenu-grid .btn-info {
    background: #f0fdfa;
    color: #0d9488;
    border-color: #99f6e4;
}
</style>

<div class="container-fluid p-0">

    <!-- HEADER SECTION dengan layout lebih rapi -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2">
        <div>
            <h1 class="page-title">
                📚 Program Studi
            </h1>
            <p class="section-subtitle">
                Kelola akademik AMIK Taruna — Prodi, fasilitas, profil & FAQ
            </p>
        </div>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-modern dashboard-link">
                <i class="fa-solid fa-gauge-high me-1"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- NOTIFIKASI SUCCESS -->
    @if(session('success'))
    <div class="alert alert-success rounded-4 d-flex align-items-center gap-2">
        <i class="fa-solid fa-circle-check fa-lg"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- FORM TAMBAH PROGRAM STUDI (desain rapi) -->
    <div class="card card-modern mb-5">
        <div class="header-modern">
            <h3>Tambah Program Studi Baru</h3>
        </div>
        <div class="card-body p-4 p-lg-5">
            <form method="POST" action="{{ route('program-studi.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label><i class="fa-regular fa-building me-1"></i> Nama Prodi</label>
                        <input type="text" name="nama_prodi" class="form-control" required placeholder="Contoh: Teknik Informatika">
                    </div>
                    <div class="col-md-6">
                        <label><i class="fa-regular fa-tag me-1"></i> Tagline</label>
                        <input type="text" name="tagline" class="form-control" placeholder="Tagline menarik">
                    </div>
                    <div class="col-md-6">
                        <label><i class="fa-regular fa-star me-1"></i> Akreditasi</label>
                        <input type="text" name="akreditasi" class="form-control" placeholder="Contoh: Unggul / B">
                    </div>
                    <div class="col-md-6">
                        <label><i class="fa-regular fa-image me-1"></i> Thumbnail</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label><i class="fa-regular fa-calendar me-1"></i> Kalender Akademik (PDF, DOC, DOCX)</label>
                        <input type="file" name="kalender_akademik" class="form-control" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                    </div>
                    <div class="col-md-6">
                        <label><i class="fa-regular fa-clock me-1"></i> Jadwal Semester (PDF, DOC, DOCX)</label>
                        <input type="file" name="jadwal_semester" class="form-control" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                    </div>
                    <div class="col-12">
                        <label><i class="fa-regular fa-note-sticky me-1"></i> Deskripsi</label>
                        <textarea name="deskripsi" rows="4" class="form-control" placeholder="Deskripsi lengkap program studi..."></textarea>
                    </div>
                    <div class="col-md-6">
                        <label><i class="fa-regular fa-eye me-1"></i> Visi</label>
                        <textarea name="visi" rows="4" class="form-control" placeholder="Visi program studi..."></textarea>
                    </div>
                    <div class="col-md-6">
                        <label><i class="fa-regular fa-flag me-1"></i> Misi</label>
                        <textarea name="misi" rows="4" class="form-control" placeholder="Misi program studi..."></textarea>
                    </div>
                </div>
                <div class="mt-5">
                    <button class="btn btn-success btn-modern px-5 py-3">
                        <i class="fa-solid fa-plus-circle me-2"></i> Tambah Program Studi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- LIST PROGRAM STUDI dengan grid rapi & design konsisten -->
    <div class="mb-3 d-flex align-items-center">
        <h3 class="fw-bold fs-3" style="color: #0f3b2c;">📖 Daftar Program Studi</h3>
        <div class="ms-3 flex-grow-1" style="height: 3px; background: linear-gradient(90deg, #86efac, #e2e8f0);"></div>
    </div>

    <div class="row g-4">
        @foreach($programs as $program)
        <div class="col-lg-4 col-md-6">
            <div class="prodi-card">
                @if($program->thumbnail)
                <img src="{{ asset('uploads/program_studi/'.$program->thumbnail) }}" class="thumb" alt="{{ $program->nama_prodi }}">
                @else
                <div class="thumb d-flex align-items-center justify-content-center bg-light" style="background: #f1f5f9;">
                    <i class="fa-solid fa-graduation-cap fa-4x text-muted opacity-50"></i>
                </div>
                @endif
                <div class="p-4 d-flex flex-column flex-grow-1">
                    <h4 class="fw-bold mb-2">{{ $program->nama_prodi }}</h4>
                    <p class="text-muted small">{{ $program->tagline ?? '—' }}</p>
                    <div class="badge-akreditasi align-self-start mb-3">
                        <i class="fa-regular fa-medal me-1"></i> {{ $program->akreditasi ?? 'Akreditasi' }}
                    </div>
                    <p class="text-secondary" style="font-size: 0.9rem;">
                        {{ Str::limit($program->deskripsi, 100) }}
                    </p>
                    
                    <div class="d-grid gap-3 mt-auto pt-3">
                        <!-- KELOLA DOKUMEN PRODI (PROFIL LULUSAN, PEDOMAN, KURIKULUM, RPS) -->
                        <a href="{{ route('program-studi.dokumen.index', $program->id) }}" class="btn btn-modern w-100 text-white shadow-xs" style="background: linear-gradient(135deg, #065f46, #047857); border: none;">
                            <i class="fa-solid fa-folder-open me-2"></i> Dokumen Akademik
                            @if(($program->dokumens_count ?? 0) > 0)
                                <span class="badge bg-white text-success ms-2 rounded-pill fw-bold">{{ $program->dokumens_count }}</span>
                            @endif
                        </a>

                        <!-- EDIT BUTTON -->
                        <a href="{{ route('program-studi.edit', $program->id) }}" class="btn btn-warning btn-modern w-100">
                            <i class="fa-solid fa-pen-to-square me-2"></i> Edit Program Studi
                        </a>
                        
                        <!-- SUBMENU (Profil, Fasilitas, FAQ) dengan ikon & label -->
                        <div class="submenu-grid">
                            <a href="{{ route('profil.index', $program->id) }}" class="btn btn-success w-100">
                                <i class="fa-solid fa-user-graduate"></i>
                                <span>Profil</span>
                            </a>
                            <a href="{{ route('fasilitas.index', $program->id) }}" class="btn btn-primary w-100">
                                <i class="fa-solid fa-building"></i>
                                <span>Fasilitas</span>
                            </a>
                            <a href="{{ route('faq.index', $program->id) }}" class="btn btn-info w-100">
                                <i class="fa-solid fa-circle-question"></i>
                                <span>FAQ</span>
                            </a>
                        </div>
                        
                        <!-- DELETE FORM -->
                        <form method="POST" action="{{ route('program-studi.destroy', $program->id) }}" onsubmit="return confirm('Yakin ingin menghapus program studi ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-modern w-100">
                                <i class="fa-solid fa-trash me-2"></i> Hapus Program Studi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Jika data kosong tampilkan pesan elegan (opsional) -->
    @if(count($programs) == 0)
    <div class="text-center py-5 mt-3">
        <div class="bg-white rounded-4 shadow-sm p-5">
            <i class="fa-regular fa-folder-open fa-4x text-muted mb-3"></i>
            <h5 class="text-secondary">Belum ada program studi</h5>
            <p class="text-muted">Silakan tambah program studi melalui form di atas.</p>
        </div>
    </div>
    @endif

    <!-- Footer informasi ringkas (tidak mengubah struktur) -->
    <div class="text-center mt-5 pt-3 small text-muted">
        <i class="fa-regular fa-copyright me-1"></i> AMIK Taruna — Sistem Akademik Terintegrasi
    </div>

</div>

@endsection