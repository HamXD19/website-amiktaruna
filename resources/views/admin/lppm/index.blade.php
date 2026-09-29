@extends('layouts.app')

@section('title', 'Kelola LPPM')

@section('content')

<div class="container-fluid p-0">

    <!-- Header Page -->
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-slate-900 mb-1">Kelola Lembaga Penelitian &amp; Pengabdian (LPPM)</h4>
            <p class="text-slate-500 small mb-0">Atur deskripsi profil dan kelola card portal layanan LPPM secara dinamis</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('lppm') }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold">
                <i class="fas fa-eye me-1"></i>Lihat Halaman Publik
            </a>
            <a href="{{ route('admin.kategori.index', ['modul' => 'lppm_dokumen']) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold">
                <i class="fas fa-tags me-1"></i>Master Kategori Dokumen LPPM
            </a>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-xs mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
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

    <!-- TAB NAVIGATION -->
    @php
        $activeTab = request('tab', 'portal');
    @endphp
    <ul class="nav nav-pills mb-4 bg-white p-2 rounded-4 shadow-sm border gap-2" id="lppmTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-pill fw-bold px-4 py-2 d-flex align-items-center gap-2 {{ $activeTab === 'portal' ? 'active' : '' }}" 
                    id="tab-portal-btn" 
                    data-bs-toggle="pill" 
                    data-bs-target="#tab-portal" 
                    type="button" 
                    role="tab" 
                    aria-controls="tab-portal" 
                    aria-selected="{{ $activeTab === 'portal' ? 'true' : 'false' }}">
                <i class="fas fa-th-large"></i>
                <span>Portal Layanan LPPM</span>
                <span class="badge {{ $activeTab === 'portal' ? 'bg-white text-primary' : 'bg-light text-slate-700' }} rounded-pill ms-1">{{ count($portals) }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-pill fw-bold px-4 py-2 d-flex align-items-center gap-2 {{ $activeTab === 'dokumen' ? 'active' : '' }}" 
                    id="tab-dokumen-btn" 
                    data-bs-toggle="pill" 
                    data-bs-target="#tab-dokumen" 
                    type="button" 
                    role="tab" 
                    aria-controls="tab-dokumen" 
                    aria-selected="{{ $activeTab === 'dokumen' ? 'true' : 'false' }}">
                <i class="fas fa-file-alt"></i>
                <span>Dokumen Riset &amp; Pengabdian</span>
                <span class="badge {{ $activeTab === 'dokumen' ? 'bg-white text-primary' : 'bg-light text-slate-700' }} rounded-pill ms-1">{{ count($dokumens) }}</span>
            </button>
        </li>
    </ul>

    <!-- TAB CONTENTS -->
    <div class="tab-content" id="lppmTabsContent">

        <!-- TAB 1: PORTAL LAYANAN -->
        <div class="tab-pane fade {{ $activeTab === 'portal' ? 'show active' : '' }}" id="tab-portal" role="tabpanel" aria-labelledby="tab-portal-btn">
            <div class="row g-4">

        <!-- KOLOM KIRI: DESKRIPSI LPPM -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-slate-900 mb-3 d-flex align-items-center gap-2">
                        <i class="fas fa-align-left text-success"></i>
                        Profil & Deskripsi LPPM
                    </h6>

                    <form method="POST" action="{{ route('lppm.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-slate-700">Deskripsi Singkat LPPM</label>
                            <textarea name="deskripsi" rows="7" class="form-control rounded-3" placeholder="Masukkan deskripsi profil LPPM AMIK Taruna...">{{ $lppm->deskripsi ?? '' }}</textarea>
                            <small class="text-slate-400 d-block mt-1">Ditampilkan pada kotak informasi atas di halaman publik LPPM.</small>
                        </div>

                        <button type="submit" class="btn btn-success fw-bold w-100 rounded-pill py-2 shadow-xs">
                            <i class="fas fa-save me-1"></i>Simpan Deskripsi
                        </button>
                    </form>
                </div>
            </div>

            <!-- INFO CARD BANTUAN -->
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #ecfdf5, #f0fdf4); border: 1px solid #a7f3d0 !important;">
                <div class="card-body p-4 text-center">
                    <i class="fas fa-shapes fa-2x text-success mb-2"></i>
                    <h6 class="fw-bold text-slate-900 mb-1">Card Portal Dinamis</h6>
                    <p class="text-slate-500 small mb-0">
                        Anda dapat menambah portal baru seperti JESICA, Jurnal Riset, MBKM Penelitian, atau Portal Dosen. Tampilan di frontend akan otomatis tersusun rapi mirip Pelayanan Mahasiswa.
                    </p>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: TAMBAH & KELOLA PORTAL LPPM -->
        <div class="col-lg-8">

            <!-- FORM TAMBAH PORTAL -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-slate-900 mb-3 d-flex align-items-center gap-2">
                        <i class="fas fa-plus-circle text-primary"></i>
                        Tambah Portal LPPM Baru
                    </h6>

                    <form method="POST" action="{{ route('admin.lppm.portal.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <!-- NAMA PORTAL -->
                            <div class="col-md-7">
                                <label class="form-label small fw-semibold text-slate-700">Nama Portal <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control rounded-3" placeholder="Contoh: JESICA / Portal Riset" required>
                            </div>

                            <!-- URUTAN -->
                            <div class="col-md-5">
                                <label class="form-label small fw-semibold text-slate-700">Urutan Tampil</label>
                                <input type="number" name="urutan" class="form-control rounded-3" value="0" min="0">
                            </div>

                            <!-- LINK URL -->
                            <div class="col-md-7">
                                <label class="form-label small fw-semibold text-slate-700">Tautan / Link URL <span class="text-danger">*</span></label>
                                <input type="text" name="link" class="form-control rounded-3" placeholder="https://..." required>
                            </div>

                            <!-- WARNA CARD / BUTTON -->
                            <div class="col-md-5">
                                <label class="form-label small fw-semibold text-slate-700">Warna Aksen Tombol</label>
                                <select name="warna" class="form-select rounded-3">
                                    <option value="success" selected>Hijau (Success)</option>
                                    <option value="primary">Biru (Primary)</option>
                                    <option value="info">Cyan (Info)</option>
                                    <option value="warning">Kuning (Warning)</option>
                                    <option value="danger">Merah (Danger)</option>
                                    <option value="dark">Gelap (Dark)</option>
                                </select>
                            </div>

                            <!-- UPLOAD LOGO -->
                            <div class="col-12">
                                <label class="form-label small fw-semibold text-slate-700">Logo / Icon Portal (Gambar PNG, JPG, SVG)</label>
                                <input type="file" name="logo" class="form-control rounded-3" accept="image/*">
                                <small class="text-slate-400">Rekomendasi rasio 1:1 (persegi) dengan latar transparan atau putih.</small>
                            </div>

                            <!-- DESKRIPSI -->
                            <div class="col-12">
                                <label class="form-label small fw-semibold text-slate-700">Deskripsi Singkat Portal</label>
                                <textarea name="deskripsi" rows="2" class="form-control rounded-3" placeholder="Jelaskan secara singkat fungsi portal ini..."></textarea>
                            </div>

                            <!-- TOMBOL SUBMIT -->
                            <div class="col-12 text-end pt-2">
                                <button type="submit" class="btn btn-primary fw-bold rounded-pill px-4 py-2 shadow-xs">
                                    <i class="fas fa-plus me-1"></i>Tambah Portal
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- DAFTAR PORTAL LPPM -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="fw-bold text-slate-900 mb-0 d-flex align-items-center gap-2">
                            <i class="fas fa-th-large text-success"></i>
                            Daftar Portal LPPM Terpasang
                        </h6>
                        <span class="badge bg-emerald-100 text-emerald-800 rounded-pill px-3 py-1 font-monospace">
                            {{ count($portals) }} Portal
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light">
                                <tr class="text-slate-600 small">
                                    <th width="50" class="text-center">No</th>
                                    <th width="80" class="text-center">Logo</th>
                                    <th>Nama &amp; Deskripsi</th>
                                    <th>Link URL</th>
                                    <th width="90">Warna</th>
                                    <th width="130" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($portals as $index => $portal)
                                <tr>
                                    <!-- NO / URUTAN -->
                                    <td class="text-center fw-semibold text-slate-500">
                                        {{ $portal->urutan ?: ($index + 1) }}
                                    </td>

                                    <!-- LOGO (CENTERED) -->
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center">
                                            @if($portal->logo)
                                                @php
                                                    $imgUrl = file_exists(public_path('uploads/lppm/' . $portal->logo)) 
                                                        ? asset('uploads/lppm/' . $portal->logo) 
                                                        : (file_exists(public_path('uploads/' . $portal->logo)) ? asset('uploads/' . $portal->logo) : asset('uploads/lppm/' . $portal->logo));
                                                @endphp
                                                <img src="{{ $imgUrl }}"
                                                     class="rounded-3 shadow-xs border bg-white p-1 mx-auto d-block"
                                                     style="width: 50px; height: 50px; object-fit: contain;">
                                            @else
                                                <div class="rounded-3 bg-light d-flex align-items-center justify-content-center text-muted border mx-auto"
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fas fa-globe"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- NAMA & DESKRIPSI -->
                                    <td>
                                        <div class="fw-bold text-slate-900">{{ $portal->nama }}</div>
                                        <div class="text-slate-500 small text-truncate" style="max-width: 250px;">
                                            {{ $portal->deskripsi ?: 'Tidak ada deskripsi' }}
                                        </div>
                                    </td>

                                    <!-- LINK -->
                                    <td>
                                        <a href="{{ $portal->link }}" target="_blank" class="badge bg-light text-primary border text-decoration-none py-1.5 px-2">
                                            <i class="fas fa-external-link-alt me-1"></i>Buka Link
                                        </a>
                                    </td>

                                    <!-- WARNA -->
                                    <td>
                                        <span class="badge bg-{{ $portal->warna ?: 'secondary' }}">
                                            {{ $portal->warna ?: 'success' }}
                                        </span>
                                    </td>

                                    <!-- AKSI -->
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- EDIT BUTTON TRIGGER MODAL -->
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-warning rounded-pill px-2.5" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalEditPortal{{ $portal->id }}"
                                                    title="Edit Portal">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <!-- DELETE BUTTON -->
                                            <form method="POST" action="{{ route('admin.lppm.portal.destroy', $portal->id) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger rounded-pill px-2.5" 
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus portal {{ $portal->nama }}?')"
                                                        title="Hapus Portal">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- MODAL EDIT PORTAL -->
                                <div class="modal fade" id="modalEditPortal{{ $portal->id }}" tabindex="-1" aria-labelledby="modalEditPortalLabel{{ $portal->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <form method="POST" action="{{ route('admin.lppm.portal.update', $portal->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title fw-bold text-slate-900" id="modalEditPortalLabel{{ $portal->id }}">
                                                        <i class="fas fa-edit text-warning me-2"></i>Edit Portal LPPM
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body p-4">
                                                    <div class="row g-3">
                                                        <div class="col-md-8">
                                                            <label class="form-label small fw-semibold text-slate-700">Nama Portal <span class="text-danger">*</span></label>
                                                            <input type="text" name="nama" class="form-control rounded-3" value="{{ $portal->nama }}" required>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label small fw-semibold text-slate-700">Urutan</label>
                                                            <input type="number" name="urutan" class="form-control rounded-3" value="{{ $portal->urutan }}">
                                                        </div>

                                                        <div class="col-12">
                                                            <label class="form-label small fw-semibold text-slate-700">Tautan / Link URL <span class="text-danger">*</span></label>
                                                            <input type="text" name="link" class="form-control rounded-3" value="{{ $portal->link }}" required>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-semibold text-slate-700">Warna Aksen Tombol</label>
                                                            <select name="warna" class="form-select rounded-3">
                                                                <option value="success" {{ $portal->warna == 'success' ? 'selected' : '' }}>Hijau (Success)</option>
                                                                <option value="primary" {{ $portal->warna == 'primary' ? 'selected' : '' }}>Biru (Primary)</option>
                                                                <option value="info" {{ $portal->warna == 'info' ? 'selected' : '' }}>Cyan (Info)</option>
                                                                <option value="warning" {{ $portal->warna == 'warning' ? 'selected' : '' }}>Kuning (Warning)</option>
                                                                <option value="danger" {{ $portal->warna == 'danger' ? 'selected' : '' }}>Merah (Danger)</option>
                                                                <option value="dark" {{ $portal->warna == 'dark' ? 'selected' : '' }}>Gelap (Dark)</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-semibold text-slate-700">Ganti Logo</label>
                                                            <input type="file" name="logo" class="form-control rounded-3" accept="image/*">
                                                        </div>

                                                        @if($portal->logo)
                                                            <div class="col-12 text-center">
                                                                <span class="small text-muted d-block mb-1">Logo saat ini:</span>
                                                                <img src="{{ $imgUrl }}" class="rounded border p-1 bg-white mx-auto d-block" style="height: 50px; object-fit: contain;">
                                                            </div>
                                                        @endif

                                                        <div class="col-12">
                                                            <label class="form-label small fw-semibold text-slate-700">Deskripsi Singkat</label>
                                                            <textarea name="deskripsi" rows="3" class="form-control rounded-3">{{ $portal->deskripsi }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer border-0 pt-0 d-flex justify-content-between">
                                                    <button type="button" class="btn btn-outline-danger rounded-pill px-3" onclick="if(confirm('Apakah Anda yakin ingin menghapus portal {{ $portal->nama }}?')) { document.getElementById('deleteLppmPortalModalForm{{ $portal->id }}').submit(); }">
                                                        <i class="fas fa-trash me-1"></i>Hapus Portal
                                                    </button>
                                                    <div class="d-flex gap-2">
                                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-warning fw-bold rounded-pill px-4 text-dark">
                                                            <i class="fas fa-save me-1"></i>Simpan Perubahan
                                                        </button>
                                                    </div>
                                                </div>

                                            </form>
                                            <form id="deleteLppmPortalModalForm{{ $portal->id }}" method="POST" action="{{ route('admin.lppm.portal.destroy', $portal->id) }}" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fas fa-folder-open d-block fa-2x mb-2 text-slate-300"></i>
                                        Belum ada portal LPPM yang ditambahkan. Gunakan formulir di atas untuk menambahkan portal baru.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>

    </div>
    <!-- /TAB 1 -->
    </div>

    <!-- ========================================== -->
    <!-- TAB 2: DOKUMEN RISET & PENGABDIAN (LPPM)  -->
    <!-- ========================================== -->
    <div class="tab-pane fade {{ $activeTab === 'dokumen' ? 'show active' : '' }}" id="tab-dokumen" role="tabpanel" aria-labelledby="tab-dokumen-btn">
        <div class="row g-4">

            <!-- FORM UPLOAD DOKUMEN LPPM -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-bottom py-3 px-4 rounded-top-4">
                        <h6 class="fw-bold mb-0 text-slate-900 d-flex align-items-center gap-2">
                            <i class="fas fa-file-circle-plus text-success"></i>
                            Unggah Dokumen LPPM Baru
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.lppm.dokumen.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                <!-- Judul Dokumen -->
                                <div class="col-12">
                                    <label class="form-label small fw-semibold text-slate-700">Judul / Nama Dokumen <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_dokumen" class="form-control rounded-3" placeholder="Contoh: Panduan Hibah Riset Dosen Pemula 2026" required>
                                </div>

                                <!-- Kategori Dokumen (Dari Master Kategori lppm_dokumen) -->
                                <div class="col-md-7">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label small fw-semibold text-slate-700 mb-0">Kategori <span class="text-danger">*</span></label>
                                        <a href="{{ route('admin.kategori.index', ['modul' => 'lppm_dokumen']) }}" target="_blank" class="small text-success text-decoration-none fw-semibold">
                                            <i class="fas fa-plus-circle me-1"></i>Master Kategori
                                        </a>
                                    </div>
                                    <select name="kategori" class="form-select rounded-3" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @if(isset($kategoris) && $kategoris->count())
                                            @foreach($kategoris as $kat)
                                                <option value="{{ $kat->slug }}">
                                                    {{ $kat->ikon }} {{ $kat->nama }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="panduan-penelitian">🔬 Panduan Penelitian</option>
                                            <option value="pedoman-pengabdian">🤝 Pedoman Pengabdian</option>
                                            <option value="template-lppm">📋 Template Proposal &amp; Laporan</option>
                                            <option value="jurnal-lppm">📚 Publikasi &amp; Jurnal Ilmiah</option>
                                        @endif
                                    </select>
                                </div>

                                <!-- Tahun / Periode -->
                                <div class="col-md-5">
                                    <label class="form-label small fw-semibold text-slate-700">Tahun / Periode</label>
                                    <input type="text" name="tahun" class="form-control rounded-3" placeholder="Contoh: 2026 atau 2025/2026">
                                </div>

                                <!-- Upload File Dokumen (PDF, DOC, DOCX) -->
                                <div class="col-md-8">
                                    <label class="form-label small fw-semibold text-slate-700">
                                        File Dokumen <span class="text-danger">*</span> <span class="badge bg-success ms-1">PDF, DOC, DOCX</span>
                                    </label>
                                    <input type="file" name="file_pdf" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="form-control rounded-3" required>
                                    <small class="text-slate-400">Maksimal 30MB.</small>
                                </div>

                                <!-- Urutan -->
                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold text-slate-700">Urutan Tampil</label>
                                    <input type="number" name="urutan" class="form-control rounded-3" value="0" min="0">
                                </div>

                                <!-- Deskripsi Singkat -->
                                <div class="col-12">
                                    <label class="form-label small fw-semibold text-slate-700">Keterangan / Ringkasan Isi</label>
                                    <textarea name="deskripsi" rows="2" class="form-control rounded-3" placeholder="Ringkasan atau catatan mengenai dokumen ini..."></textarea>
                                </div>

                                <div class="col-12 text-end pt-2">
                                    <button type="submit" class="btn btn-success fw-bold rounded-pill px-4 py-2 shadow-xs">
                                        <i class="fas fa-file-upload me-1"></i>Unggah Dokumen
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- DAFTAR DOKUMEN LPPM TERPASANG -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-3">
                            <div>
                                <h6 class="fw-bold text-slate-900 mb-0 d-flex align-items-center gap-2">
                                    <i class="fas fa-folder-open text-warning"></i>
                                    Daftar Dokumen Riset &amp; Pengabdian
                                </h6>
                                <small class="text-slate-500">Arsip dokumen dapat dilihat langsung dengan pop-up viewer dan diunduh publik</small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-emerald-100 text-emerald-800 rounded-pill px-3 py-1 font-monospace">
                                    {{ count($dokumens) }} Dokumen
                                </span>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle table-hover mb-0">
                                <thead class="table-light">
                                    <tr class="text-slate-600 small">
                                        <th width="40" class="text-center">No</th>
                                        <th width="45" class="text-center">Tipe</th>
                                        <th>Nama Dokumen</th>
                                        <th width="150">Kategori</th>
                                        <th width="80" class="text-center">Tahun</th>
                                        <th width="140" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($dokumens as $index => $doc)
                                    @php
                                        $katModel = $doc->kategoriModel;
                                        $docExt = strtolower(pathinfo($doc->file_pdf, PATHINFO_EXTENSION));
                                        $isWord = in_array($docExt, ['doc', 'docx']);
                                    @endphp
                                    <tr>
                                        <td class="text-center fw-semibold text-slate-500">
                                            {{ $doc->urutan ?: ($index + 1) }}
                                        </td>

                                        <td class="text-center">
                                            <div class="rounded-3 {{ $isWord ? 'bg-primary bg-opacity-10 text-primary' : 'bg-danger bg-opacity-10 text-danger' }} d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                                <i class="fas {{ $isWord ? 'fa-file-word' : 'fa-file-pdf' }}"></i>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="fw-bold text-slate-900">{{ $doc->nama_dokumen }}</div>
                                            @if($doc->deskripsi)
                                                <div class="text-slate-500 small text-truncate" style="max-width: 250px;">
                                                    {{ $doc->deskripsi }}
                                                </div>
                                            @endif
                                            <div class="text-slate-400 font-monospace" style="font-size: 11px;">
                                                <i class="fas fa-paperclip me-1"></i>{{ $doc->file_pdf }}
                                            </div>
                                        </td>

                                        <td>
                                            @php
                                                $warna = $katModel ? $katModel->warna : 'secondary';
                                                $ikon = $katModel ? $katModel->ikon : '📋';
                                                $namaKat = $katModel ? $katModel->nama : ucfirst(str_replace('-', ' ', $doc->kategori));
                                            @endphp
                                            <span class="badge bg-{{ $warna }}-subtle text-{{ $warna }} border border-{{ $warna }}-subtle rounded-pill py-1 px-2.5">
                                                {{ $ikon }} {{ $namaKat }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            @if($doc->tahun)
                                                <span class="badge bg-light text-slate-700 border rounded-pill px-2 py-0.5 small">
                                                    {{ $doc->tahun }}
                                                </span>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <!-- PREVIEW DOKUMEN -->
                                                <a href="{{ asset('uploads/lppm/dokumen/' . $doc->file_pdf) }}" target="_blank" class="btn btn-sm btn-outline-{{ $isWord ? 'primary' : 'danger' }} rounded-pill px-2.5" title="Buka Dokumen">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <!-- EDIT MODAL TRIGGER -->
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-warning rounded-pill px-2.5" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#modalEditLppmDoc{{ $doc->id }}"
                                                        title="Edit Dokumen">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <!-- DELETE -->
                                                <form method="POST" action="{{ route('admin.lppm.dokumen.destroy', $doc->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger rounded-pill px-2.5" 
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus dokumen {{ $doc->nama_dokumen }}? File fisik juga akan dihapus.')"
                                                            title="Hapus Dokumen">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- MODAL EDIT DOKUMEN LPPM -->
                                    <div class="modal fade" id="modalEditLppmDoc{{ $doc->id }}" tabindex="-1" aria-labelledby="modalEditLppmDocLabel{{ $doc->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content rounded-4 border-0 shadow">
                                                <form method="POST" action="{{ route('admin.lppm.dokumen.update', $doc->id) }}" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="modal-header border-0 pb-0">
                                                        <h5 class="modal-title fw-bold text-slate-900" id="modalEditLppmDocLabel{{ $doc->id }}">
                                                            <i class="fas fa-edit text-warning me-2"></i>Edit Dokumen LPPM
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body p-4">
                                                        <div class="row g-3">
                                                            <!-- Judul Dokumen -->
                                                            <div class="col-12">
                                                                <label class="form-label small fw-semibold text-slate-700">Judul / Nama Dokumen <span class="text-danger">*</span></label>
                                                                <input type="text" name="nama_dokumen" class="form-control rounded-3" value="{{ $doc->nama_dokumen }}" required>
                                                            </div>

                                                            <!-- Kategori Dokumen -->
                                                            <div class="col-md-7">
                                                                <label class="form-label small fw-semibold text-slate-700">Kategori Dokumen <span class="text-danger">*</span></label>
                                                                <select name="kategori" class="form-select rounded-3" required>
                                                                    @if(isset($kategoris) && $kategoris->count())
                                                                        @foreach($kategoris as $kat)
                                                                            <option value="{{ $kat->slug }}" {{ $doc->kategori == $kat->slug ? 'selected' : '' }}>
                                                                                {{ $kat->ikon }} {{ $kat->nama }}
                                                                            </option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="panduan-penelitian" {{ $doc->kategori == 'panduan-penelitian' ? 'selected' : '' }}>🔬 Panduan Penelitian</option>
                                                                        <option value="pedoman-pengabdian" {{ $doc->kategori == 'pedoman-pengabdian' ? 'selected' : '' }}>🤝 Pedoman Pengabdian</option>
                                                                        <option value="template-lppm" {{ $doc->kategori == 'template-lppm' ? 'selected' : '' }}>📋 Template Proposal &amp; Laporan</option>
                                                                        <option value="jurnal-lppm" {{ $doc->kategori == 'jurnal-lppm' ? 'selected' : '' }}>📚 Publikasi &amp; Jurnal Ilmiah</option>
                                                                    @endif
                                                                </select>
                                                            </div>

                                                            <!-- Tahun / Periode -->
                                                            <div class="col-md-5">
                                                                <label class="form-label small fw-semibold text-slate-700">Tahun / Periode</label>
                                                                <input type="text" name="tahun" class="form-control rounded-3" value="{{ $doc->tahun }}" placeholder="Contoh: 2026">
                                                            </div>

                                                            <!-- Ganti File Dokumen -->
                                                            <div class="col-md-8">
                                                                <label class="form-label small fw-semibold text-slate-700">Ganti File Dokumen (Opsional)</label>
                                                                <input type="file" name="file_pdf" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="form-control rounded-3">
                                                                <small class="text-slate-400">Biarkan kosong jika tidak ingin mengubah file saat ini.</small>
                                                            </div>

                                                            <!-- Urutan -->
                                                            <div class="col-md-4">
                                                                <label class="form-label small fw-semibold text-slate-700">Urutan Tampil</label>
                                                                <input type="number" name="urutan" class="form-control rounded-3" value="{{ $doc->urutan }}">
                                                            </div>

                                                            <!-- File Info Saat Ini -->
                                                            <div class="col-12">
                                                                <div class="p-2 bg-light rounded-3 d-flex align-items-center justify-content-between border">
                                                                    <div class="d-flex align-items-center gap-2 small">
                                                                        <i class="fas {{ $isWord ? 'fa-file-word text-primary' : 'fa-file-pdf text-danger' }} fs-5"></i>
                                                                        <span class="text-truncate text-slate-700" style="max-width: 300px;">{{ $doc->file_pdf }}</span>
                                                                    </div>
                                                                    <a href="{{ asset('uploads/lppm/dokumen/' . $doc->file_pdf) }}" target="_blank" class="btn btn-xs btn-outline-secondary rounded-pill px-2.5 py-1">
                                                                        <i class="fas fa-external-link-alt me-1"></i>Buka File
                                                                    </a>
                                                                </div>
                                                            </div>

                                                            <!-- Deskripsi Singkat -->
                                                            <div class="col-12">
                                                                <label class="form-label small fw-semibold text-slate-700">Keterangan / Ringkasan Isi</label>
                                                                <textarea name="deskripsi" rows="3" class="form-control rounded-3">{{ $doc->deskripsi }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer border-0 pt-0 d-flex justify-content-between">
                                                        <button type="button" class="btn btn-outline-danger rounded-pill px-3" onclick="if(confirm('Hapus dokumen {{ $doc->nama_dokumen }}?')) { document.getElementById('deleteLppmDocModalForm{{ $doc->id }}').submit(); }">
                                                            <i class="fas fa-trash me-1"></i>Hapus Dokumen
                                                        </button>
                                                        <div class="d-flex gap-2">
                                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-warning fw-bold rounded-pill px-4 text-dark">
                                                                <i class="fas fa-save me-1"></i>Simpan Perubahan
                                                            </button>
                                                        </div>
                                                    </div>

                                                </form>
                                                <form id="deleteLppmDocModalForm{{ $doc->id }}" method="POST" action="{{ route('admin.lppm.dokumen.destroy', $doc->id) }}" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="fas fa-folder-open d-block fa-2x mb-2 text-slate-300"></i>
                                            Belum ada dokumen LPPM yang diunggah. Gunakan formulir di sebelah kiri untuk mengunggah dokumen baru.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- /TAB CONTENTS -->
    </div>

</div>

@endsection