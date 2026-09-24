@extends('layouts.app')

@section('title', 'Dokumen Akademik - ' . $program->nama_prodi)

@section('content')

<style>
/* ===== DESIGN TOKENS & UTILITIES ===== */
.page-header-box {
    background: linear-gradient(135deg, #064e3b 0%, #065f46 60%, #047857 100%);
    border-radius: 20px;
    padding: 26px 30px;
    color: white;
    box-shadow: 0 10px 25px -5px rgba(6, 78, 59, 0.25);
    margin-bottom: 24px;
}

.card-modern {
    border: none;
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid #e2e8f0;
    overflow: hidden;
}

.stat-box {
    background: #ffffff;
    border-radius: 16px;
    padding: 18px 20px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
    transition: all 0.2s ease;
}

.stat-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.06);
}

.file-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 700;
}

.file-pill.pdf {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.file-pill.doc {
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #bfdbfe;
}
</style>

<div class="container-fluid p-0">

    <!-- HEADER PRODI -->
    <div class="page-header-box d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-3 py-1 font-monospace small">
                    <i class="fas fa-graduation-cap me-1"></i> Program Studi
                </span>
                <span class="badge bg-emerald-400 text-dark fw-bold rounded-pill px-2.5 py-1 small">
                    Akreditasi {{ $program->akreditasi ?? '-' }}
                </span>
            </div>
            <h2 class="fw-bold text-white mb-1">
                📑 Dokumen &amp; Panduan: {{ $program->nama_prodi }}
            </h2>
            <p class="text-emerald-100 small mb-0 opacity-90">
                Kelola arsip dokumen akademik prodi (Profil Lulusan, Pedoman Akademik, Kurikulum, RPS, dll) dengan Master Kategori.
            </p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.kategori.index', ['modul' => 'prodi_dokumen']) }}" class="btn btn-light btn-sm rounded-pill px-3 fw-bold shadow-xs">
                <i class="fas fa-tags text-success me-1"></i> Master Kategori
            </a>
            <a href="{{ route('program-studi.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3 fw-semibold">
                <i class="fas fa-arrow-left me-1"></i> Daftar Prodi
            </a>
            <a href="{{ url('/akademik/' . $program->slug) }}" target="_blank" class="btn btn-emerald-600 btn-sm rounded-pill px-3 fw-bold bg-white text-dark shadow-xs">
                <i class="fas fa-external-link-alt me-1"></i> Lihat di Web
            </a>
        </div>
    </div>

    <!-- NOTIFIKASI -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-xs mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-xs mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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

    <!-- STATISTIK DOKUMEN -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4 col-xl">
            <div class="stat-box border-start border-success border-4 h-100">
                <div class="text-slate-400 small fw-semibold mb-1">Total Dokumen</div>
                <div class="h3 fw-bold text-slate-900 mb-0">{{ $stats['total'] }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="stat-box border-start border-success border-4 h-100">
                <div class="text-slate-400 small fw-semibold mb-1">Profil Lulusan</div>
                <div class="h3 fw-bold text-success mb-0">{{ $stats['profil_lulusan'] }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="stat-box border-start border-primary border-4 h-100">
                <div class="text-slate-400 small fw-semibold mb-1">Pedoman Akademik</div>
                <div class="h3 fw-bold text-primary mb-0">{{ $stats['pedoman_akademik'] }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="stat-box border-start border-warning border-4 h-100">
                <div class="text-slate-400 small fw-semibold mb-1">Kurikulum</div>
                <div class="h3 fw-bold text-warning mb-0">{{ $stats['kurikulum'] }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="stat-box border-start border-danger border-4 h-100">
                <div class="text-slate-400 small fw-semibold mb-1">RPS (Silabus)</div>
                <div class="h3 fw-bold text-danger mb-0">{{ $stats['rps'] }}</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        <!-- KOLOM KIRI: FORM UPLOAD DOKUMEN -->
        <div class="col-lg-4">
            <div class="card card-modern">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-slate-900 mb-3 d-flex align-items-center gap-2">
                        <i class="fas fa-file-upload text-success"></i>
                        Unggah Dokumen Baru
                    </h5>
                    
                    <form method="POST" action="{{ route('program-studi.dokumen.store', $program->id) }}" enctype="multipart/form-data">
                        @csrf

                        <!-- NAMA DOKUMEN -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-slate-700">Nama / Judul Dokumen <span class="text-danger">*</span></label>
                            <input type="text" name="nama_dokumen" class="form-control rounded-3" placeholder="Contoh: Kurikulum 2024 D3 Manajemen Informatika" required>
                        </div>

                        <!-- KATEGORI (DARI MASTER KATEGORI) -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label small fw-semibold text-slate-700 mb-0">Kategori Dokumen <span class="text-danger">*</span></label>
                                <a href="{{ route('admin.kategori.index', ['modul' => 'prodi_dokumen']) }}" target="_blank" class="text-xs text-success text-decoration-none fw-semibold">
                                    + Tambah di Master
                                </a>
                            </div>
                            <select name="kategori" class="form-select rounded-3" required>
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                @foreach($kategoris as $kat)
                                    <option value="{{ $kat->slug }}">
                                        {{ $kat->ikon ?: '📌' }} {{ $kat->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-slate-400">Kategori terintegrasi langsung dari Master Kategori.</small>
                        </div>

                        <!-- FILE DOKUMEN (PDF, DOC, DOCX) -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-slate-700">Berkas Dokumen <span class="text-danger">*</span></label>
                            <input type="file" name="file_dokumen" class="form-control rounded-3" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" required>
                            <div class="form-text text-slate-500 mt-1 small">
                                <i class="fas fa-info-circle me-1 text-primary"></i> Wajib format: <strong>PDF, DOC, DOCX</strong> (Maks. 30 MB).
                            </div>
                        </div>

                        <!-- TAHUN / SEMESTER & URUTAN -->
                        <div class="row g-2 mb-3">
                            <div class="col-7">
                                <label class="form-label small fw-semibold text-slate-700">Tahun / Periode</label>
                                <input type="text" name="tahun" class="form-control rounded-3" placeholder="Contoh: 2024 / Gasal">
                            </div>
                            <div class="col-5">
                                <label class="form-label small fw-semibold text-slate-700">No. Urut</label>
                                <input type="number" name="urutan" class="form-control rounded-3 text-center" value="0" min="0">
                            </div>
                        </div>

                        <!-- DESKRIPSI -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-slate-700">Keterangan / Deskripsi Singkat</label>
                            <textarea name="deskripsi" rows="3" class="form-control rounded-3" placeholder="Penjelasan singkat mengenai isi dokumen ini..."></textarea>
                        </div>

                        <!-- STATUS AKTIF -->
                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActiveDokumen" value="1" checked>
                            <label class="form-check-label small fw-semibold text-slate-700" for="isActiveDokumen">Tampilkan di Web Publik</label>
                        </div>

                        <button type="submit" class="btn btn-success fw-bold w-100 rounded-pill py-2 shadow-xs">
                            <i class="fas fa-upload me-1"></i> Simpan Dokumen
                        </button>
                    </form>
                </div>
            </div>

            <!-- CARD PANDUAN PENGHAPUSAN OTOMATIS -->
            <div class="card card-modern mt-3 border-0 bg-light">
                <div class="card-body p-3 small text-slate-600">
                    <div class="d-flex gap-2">
                        <i class="fas fa-shield-alt text-success mt-1"></i>
                        <div>
                            <strong>Manajemen Berkas Bersih:</strong>
                            <p class="mb-0 text-slate-500 mt-0.5">
                                Setiap kali Anda menghapus dokumen atau mengunggah revisi berkas baru, sistem secara otomatis membersihkan file fisik dari server storage agar tidak menumpuk.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: DAFTAR DOKUMEN PRODI -->
        <div class="col-lg-8">
            <div class="card card-modern">
                <div class="card-body p-4">
                    
                    <!-- FILTER KATEGORI & PENCARIAN -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                        <!-- TABS KATEGORI -->
                        <div class="d-flex flex-wrap gap-1">
                            @php $currentKat = request('kategori', 'semua'); @endphp
                            <a href="{{ route('program-studi.dokumen.index', ['program_studi_id' => $program->id, 'kategori' => 'semua', 'search' => request('search')]) }}"
                               class="btn btn-sm rounded-pill px-3 {{ $currentKat == 'semua' ? 'btn-success fw-bold' : 'btn-light text-slate-600' }}">
                                Semua ({{ $stats['total'] }})
                            </a>
                            @foreach($kategoris as $k)
                                <a href="{{ route('program-studi.dokumen.index', ['program_studi_id' => $program->id, 'kategori' => $k->slug, 'search' => request('search')]) }}"
                                   class="btn btn-sm rounded-pill px-3 {{ $currentKat == $k->slug ? 'btn-success fw-bold' : 'btn-light text-slate-600' }}">
                                    {{ $k->ikon ?: '📌' }} {{ $k->nama }}
                                </a>
                            @endforeach
                        </div>

                        <!-- SEARCH -->
                        <form method="GET" action="{{ route('program-studi.dokumen.index', $program->id) }}" class="d-flex gap-2">
                            <input type="hidden" name="kategori" value="{{ request('kategori', 'semua') }}">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control rounded-start-pill ps-3" placeholder="Cari dokumen..." value="{{ request('search') }}">
                                <button class="btn btn-outline-secondary rounded-end-pill px-3" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- TABEL DOKUMEN -->
                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light">
                                <tr class="text-slate-600 small">
                                    <th width="40" class="text-center">No</th>
                                    <th>Nama Dokumen &amp; Info</th>
                                    <th width="140">Kategori</th>
                                    <th width="100" class="text-center">Berkas</th>
                                    <th width="90" class="text-center">Status</th>
                                    <th width="120" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dokumens as $index => $dok)
                                    @php
                                        $ext = strtolower(pathinfo($dok->file_dokumen, PATHINFO_EXTENSION));
                                    @endphp
                                    <tr>
                                        <!-- NO / URUTAN -->
                                        <td class="text-center fw-semibold text-slate-500">
                                            {{ $dok->urutan ?: ($dokumens->firstItem() + $index) }}
                                        </td>

                                        <!-- NAMA & INFO -->
                                        <td>
                                            <div class="fw-bold text-slate-900 mb-0.5">
                                                {{ $dok->nama_dokumen }}
                                            </div>
                                            @if($dok->deskripsi)
                                                <div class="text-slate-500 small text-truncate" style="max-width: 320px;">
                                                    {{ $dok->deskripsi }}
                                                </div>
                                            @endif
                                            @if($dok->tahun)
                                                <div class="text-slate-400 small mt-0.5">
                                                    <i class="fas fa-calendar-alt me-1"></i> Periode: {{ $dok->tahun }}
                                                </div>
                                            @endif
                                        </td>

                                        <!-- KATEGORI -->
                                        <td>
                                            @if($dok->kategoriModel)
                                                <span class="badge bg-{{ $dok->kategoriModel->warna ?: 'success' }}-subtle text-{{ $dok->kategoriModel->warna ?: 'success' }} border border-{{ $dok->kategoriModel->warna ?: 'success' }}-subtle rounded-pill py-1 px-2.5 small">
                                                    {{ $dok->kategoriModel->ikon ?: '📌' }} {{ $dok->kategoriModel->nama }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary rounded-pill py-1 px-2.5 small font-monospace">
                                                    {{ $dok->kategori }}
                                                </span>
                                            @endif
                                        </td>

                                        <!-- BERKAS FILE -->
                                        <td class="text-center">
                                            @if($dok->file_dokumen)
                                                <a href="{{ asset('uploads/program_studi/dokumen/' . $dok->file_dokumen) }}" target="_blank" download class="file-pill {{ $ext == 'pdf' ? 'pdf' : 'doc' }} text-decoration-none">
                                                    <i class="fas {{ $ext == 'pdf' ? 'fa-file-pdf' : 'fa-file-word' }}"></i>
                                                    {{ strtoupper($ext) }}
                                                </a>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>

                                        <!-- STATUS -->
                                        <td class="text-center">
                                            @if($dok->is_active)
                                                <span class="badge bg-success text-white rounded-pill px-2.5 py-1 small">
                                                    <i class="fas fa-check me-1"></i>Aktif
                                                </span>
                                            @else
                                                <span class="badge bg-secondary text-white rounded-pill px-2.5 py-1 small">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>

                                        <!-- AKSI -->
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <!-- EDIT BUTTON -->
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-warning rounded-pill px-2.5" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#modalEditDokumen{{ $dok->id }}"
                                                        title="Edit Dokumen">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <!-- DELETE BUTTON -->
                                                <form method="POST" action="{{ route('program-studi.dokumen.destroy', $dok->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger rounded-pill px-2.5" 
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus dokumen \'{{ $dok->nama_dokumen }}\'? File fisik dari server juga akan dihapus permanen.')"
                                                            title="Hapus Dokumen">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- MODAL EDIT DOKUMEN -->
                                    <div class="modal fade" id="modalEditDokumen{{ $dok->id }}" tabindex="-1" aria-labelledby="modalEditDokumenLabel{{ $dok->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded-4 border-0 shadow">
                                                <form method="POST" action="{{ route('program-studi.dokumen.update', $dok->id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-header border-0 pb-0">
                                                        <h5 class="modal-title fw-bold text-slate-900" id="modalEditDokumenLabel{{ $dok->id }}">
                                                            <i class="fas fa-edit text-warning me-2"></i>Edit Dokumen Akademik
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body p-4">
                                                        <div class="row g-3">
                                                            <div class="col-12">
                                                                <label class="form-label small fw-semibold text-slate-700">Nama / Judul Dokumen <span class="text-danger">*</span></label>
                                                                <input type="text" name="nama_dokumen" class="form-control rounded-3" value="{{ $dok->nama_dokumen }}" required>
                                                            </div>

                                                            <div class="col-md-7">
                                                                <label class="form-label small fw-semibold text-slate-700">Kategori Dokumen <span class="text-danger">*</span></label>
                                                                <select name="kategori" class="form-select rounded-3" required>
                                                                    @foreach($kategoris as $kat)
                                                                        <option value="{{ $kat->slug }}" {{ $dok->kategori == $kat->slug ? 'selected' : '' }}>
                                                                            {{ $kat->ikon ?: '📌' }} {{ $kat->nama }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-md-5">
                                                                <label class="form-label small fw-semibold text-slate-700">No. Urut</label>
                                                                <input type="number" name="urutan" class="form-control rounded-3 text-center" value="{{ $dok->urutan }}" min="0">
                                                            </div>

                                                            <div class="col-12">
                                                                <label class="form-label small fw-semibold text-slate-700">Tahun / Periode</label>
                                                                <input type="text" name="tahun" class="form-control rounded-3" value="{{ $dok->tahun }}" placeholder="Contoh: 2024 / Gasal">
                                                            </div>

                                                            <div class="col-12">
                                                                <label class="form-label small fw-semibold text-slate-700">Ganti Berkas (Opsional)</label>
                                                                <input type="file" name="file_dokumen" class="form-control rounded-3" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                                                                <div class="small text-slate-400 mt-1">
                                                                    Berkas saat ini: 
                                                                    <a href="{{ asset('uploads/program_studi/dokumen/' . $dok->file_dokumen) }}" target="_blank" class="text-success fw-bold">
                                                                        {{ $dok->file_dokumen }}
                                                                    </a>
                                                                    (Kosongkan jika tidak ingin mengganti).
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <label class="form-label small fw-semibold text-slate-700">Keterangan / Deskripsi Singkat</label>
                                                                <textarea name="deskripsi" rows="3" class="form-control rounded-3">{{ $dok->deskripsi }}</textarea>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" name="is_active" id="editActiveDokumen{{ $dok->id }}" value="1" {{ $dok->is_active ? 'checked' : '' }}>
                                                                    <label class="form-check-label small fw-semibold text-slate-700" for="editActiveDokumen{{ $dok->id }}">Tampilkan di Web Publik</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer border-0 pt-0">
                                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-warning fw-bold rounded-pill px-4 text-dark">
                                                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                                                        </button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fas fa-folder-open d-block fa-3x mb-3 text-slate-300"></i>
                                            <h6 class="fw-bold text-slate-700 mb-1">Belum Ada Dokumen Akademik</h6>
                                            <p class="text-slate-400 small mb-0">
                                                Gunakan formulir di sebelah kiri untuk mengunggah dokumen seperti Profil Lulusan, Pedoman Akademik, Kurikulum, atau RPS.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- PAGINATION -->
                    @if($dokumens->hasPages())
                        <div class="mt-4 d-flex justify-content-end">
                            {{ $dokumens->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>

</div>

@endsection
