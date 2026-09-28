@extends('layouts.app')

@section('title', 'Kelola Alumni & Testimoni')

@section('content')

<style>
    .card-custom {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        border: 1px solid #e2e8f0;
        background: #ffffff;
    }

    .card-header-custom {
        padding: 16px 22px;
        font-weight: 700;
        font-size: 16px;
        color: white;
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #16a34a, #15803d);
    }

    .bg-gradient-dark {
        background: linear-gradient(135deg, #064e3b, #022c22);
    }

    .bg-gradient-indigo {
        background: linear-gradient(135deg, #4f46e5, #3730a3);
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        font-size: 0.9rem;
    }

    .form-control:focus, .form-select:focus {
        box-shadow: none;
        border-color: #16a34a;
    }

    .btn-custom {
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
    }

    /* Fixed thumbnail previews for all images */
    .preview-img {
        width: 64px;
        height: 64px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
    }

    .preview-img:hover {
        transform: scale(1.08);
        box-shadow: 0 6px 14px rgba(0,0,0,0.12);
        border-color: #16a34a;
    }

    .alumni-avatar-placeholder {
        width: 64px;
        height: 64px;
        border-radius: 12px;
        background: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        font-weight: 700;
        font-size: 1.1rem;
        border: 1px solid #cbd5e1;
    }

    .nav-pills-custom .nav-link {
        color: #475569;
        font-weight: 600;
        padding: 9px 20px;
        border-radius: 9999px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }

    .nav-pills-custom .nav-link:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .nav-pills-custom .nav-link.active {
        background: #16a34a;
        color: #ffffff;
        border-color: #16a34a;
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.25);
    }
</style>

<div class="container-fluid p-0">

    <!-- HEADER TITLE & PUBLIC LINK -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-slate-900 mb-1">🎓 Kelola Portal &amp; Testimoni Alumni</h4>
            <p class="text-slate-500 small mb-0">Kelola program Tracer Study, Dana Abadi, serta kisah sukses dan testimoni alumni AMIK Taruna</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('alumni') }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold">
                <i class="fas fa-external-link-alt me-1"></i> Lihat Halaman Publik
            </a>
        </div>
    </div>

    <!-- TABS NAV -->
    @php
        $activeTab = request('tab', 'section');
    @endphp
    <ul class="nav nav-pills nav-pills-custom gap-2 mb-4" id="alumniTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab == 'section' ? 'active' : '' }}" 
                    id="section-tab" 
                    data-bs-toggle="pill" 
                    data-bs-target="#section-tab-pane" 
                    type="button" 
                    role="tab">
                <i class="fas fa-layer-group me-1.5"></i> Program &amp; Section (Tracer &amp; Dana Abadi)
                <span class="badge bg-white text-dark ms-1.5 rounded-pill">{{ count($data) }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab == 'testimoni' ? 'active' : '' }}" 
                    id="testimoni-tab" 
                    data-bs-toggle="pill" 
                    data-bs-target="#testimoni-tab-pane" 
                    type="button" 
                    role="tab">
                <i class="fas fa-quote-left me-1.5"></i> Testimoni Alumni
                <span class="badge bg-white text-dark ms-1.5 rounded-pill">{{ count($testimonis) }}</span>
            </button>
        </li>
    </ul>

    <div class="tab-content" id="alumniTabContent">

        <!-- ========================================== -->
        <!-- TAB 1: SECTION INFORMASI (TRACER & DANA ABADI) -->
        <!-- ========================================== -->
        <div class="tab-pane fade {{ $activeTab == 'section' ? 'show active' : '' }}" id="section-tab-pane" role="tabpanel">
            <div class="row g-4">
                <!-- FORM TAMBAH SECTION -->
                <div class="col-lg-4">
                    <div class="card card-custom">
                        <div class="card-header-custom bg-gradient-success">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Alumni Section
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('alumni_section.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- JUDUL -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Judul Section <span class="text-danger">*</span></label>
                                    <input type="text" name="judul" class="form-control" placeholder="Contoh: Tracer Study" required>
                                </div>

                                <!-- DESKRIPSI -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Deskripsi <span class="text-danger">*</span></label>
                                    <textarea name="deskripsi" rows="4" class="form-control" placeholder="Masukkan deskripsi program atau informasi..." required></textarea>
                                </div>

                                <!-- LINK -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Link Tujuan (URL)</label>
                                    <input type="url" name="link" class="form-control" placeholder="https://tracerstudy.kemdikbud.go.id">
                                    <div class="form-text small text-muted">Tautan eksternal saat tombol dipencet di web.</div>
                                </div>

                                <!-- TYPE & LAYOUT -->
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label fw-semibold small">Tipe</label>
                                        <select name="type" class="form-select">
                                            <option value="tracer_study">Tracer Study</option>
                                            <option value="dana_abadi">Dana Abadi</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-semibold small">Tata Letak</label>
                                        <select name="layout" class="form-select">
                                            <option value="left_image">Gambar Kiri</option>
                                            <option value="right_image">Gambar Kanan</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- IMAGE -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Upload Gambar/Banner</label>
                                    <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewUploadImage(this, 'sectionImgPreview')">
                                    <div class="form-text small text-muted">Format JPG/PNG/WebP, maksimal 2MB.</div>
                                    <div id="sectionImgPreviewWrap" class="mt-2 text-center" style="display: none;">
                                        <img id="sectionImgPreview" src="" class="rounded-3 border" style="max-height: 120px; object-fit: cover;">
                                    </div>
                                </div>

                                <!-- STATUS -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold small">Status Tampil</label>
                                    <select name="is_active" class="form-select">
                                        <option value="1">Aktif (Tampil di Web)</option>
                                        <option value="0">Nonaktif</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-success btn-custom w-100 shadow-xs">
                                    <i class="fas fa-save me-1"></i> Simpan Section
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- TABLE SECTION -->
                <div class="col-lg-8">
                    <div class="card card-custom">
                        <div class="card-header-custom bg-gradient-dark d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-list me-1"></i> Data Program &amp; Section Alumni</span>
                            <span class="badge bg-light text-dark">{{ count($data) }} Total</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-middle table-hover mb-0">
                                    <thead class="table-light text-slate-700 small">
                                        <tr>
                                            <th width="40" class="text-center">No</th>
                                            <th width="80" class="text-center">Gambar</th>
                                            <th>Judul &amp; Deskripsi</th>
                                            <th>Tipe</th>
                                            <th>Link</th>
                                            <th width="90" class="text-center">Status</th>
                                            <th width="120" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($data as $item)
                                        <tr>
                                            <td class="text-center text-muted fw-semibold">{{ $loop->iteration }}</td>
                                            <td class="text-center">
                                                @if($item->image)
                                                    <img src="{{ asset('uploads/'.$item->image) }}" 
                                                         class="preview-img" 
                                                         alt="{{ $item->judul }}" 
                                                         title="Klik untuk memperbesar" 
                                                         onclick="openImageLightbox('{{ asset('uploads/'.$item->image) }}', '{{ addslashes($item->judul) }}')">
                                                @else
                                                    <div class="alumni-avatar-placeholder mx-auto">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-bold text-slate-900 mb-0.5">{{ $item->judul }}</div>
                                                <div class="text-muted small" style="max-width: 320px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                    {{ $item->deskripsi }}
                                                </div>
                                            </td>
                                            <td>
                                                @if($item->type == 'tracer_study')
                                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2.5 py-1 small">
                                                        <i class="fas fa-search-location me-1"></i> Tracer Study
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-2.5 py-1 small">
                                                        <i class="fas fa-hand-holding-usd me-1"></i> Dana Abadi
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->link)
                                                    <a href="{{ $item->link }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-2.5 py-1 text-nowrap" style="font-size: 0.8rem;">
                                                        <i class="fas fa-link me-1"></i> Buka Link
                                                    </a>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($item->is_active)
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 small">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1 small">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1.5">
                                                    <a href="{{ route('alumni_section.edit', $item->id) }}" class="btn btn-sm btn-outline-warning rounded-pill px-2.5" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form id="deleteSectionForm{{ $item->id }}" action="{{ route('alumni_section.destroy', $item->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2.5" title="Hapus" onclick="confirmDeleteSweet(event, 'deleteSectionForm{{ $item->id }}', '{{ addslashes($item->judul) }}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <i class="fas fa-folder-open fa-2x mb-2 d-block opacity-50"></i>
                                                Belum ada data Alumni Section. Silakan tambahkan melalui form di samping.
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

        <!-- ========================================== -->
        <!-- TAB 2: TESTIMONI ALUMNI -->
        <!-- ========================================== -->
        <div class="tab-pane fade {{ $activeTab == 'testimoni' ? 'show active' : '' }}" id="testimoni-tab-pane" role="tabpanel">
            <div class="row g-4">
                <!-- FORM TAMBAH TESTIMONI -->
                <div class="col-lg-4">
                    <div class="card card-custom">
                        <div class="card-header-custom bg-gradient-indigo">
                            <i class="fas fa-user-plus me-1"></i> Tambah Testimoni Alumni
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('alumni_testimoni.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- NAMA -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Nama Lengkap Alumni <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Rian Hidayat, A.Md.Kom" required>
                                </div>

                                <!-- PROGRAM STUDI -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Program Studi</label>
                                    <input type="text" name="program_studi" list="prodiOptions" class="form-control" placeholder="Contoh: Sistem Informasi">
                                    <datalist id="prodiOptions">
                                        <option value="Sistem Informasi">
                                        <option value="Teknologi Informasi">
                                        <option value="Sistem Informasi Akuntansi">
                                        <option value="Manajemen Informatika">
                                        <option value="Komputerisasi Akuntansi">
                                    </datalist>
                                </div>

                                <!-- TAHUN LULUS / ANGKATAN & RATING -->
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label fw-semibold small">Tahun Lulus</label>
                                        <input type="text" name="tahun_lulus" class="form-control" placeholder="Contoh: 2022">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-semibold small">Rating Bintang</label>
                                        <select name="rating" class="form-select">
                                            <option value="5" selected>⭐⭐⭐⭐⭐ (5)</option>
                                            <option value="4">⭐⭐⭐⭐ (4)</option>
                                            <option value="3">⭐⭐⭐ (3)</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- PEKERJAAN & PERUSAHAAN -->
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label fw-semibold small">Pekerjaan / Jabatan</label>
                                        <input type="text" name="pekerjaan" class="form-control" placeholder="Full Stack Developer">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-semibold small">Instansi / Perusahaan</label>
                                        <input type="text" name="perusahaan" class="form-control" placeholder="PT Telkom Indonesia">
                                    </div>
                                </div>

                                <!-- FOTO ALUMNI -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Foto Profil Alumni</label>
                                    <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewUploadImage(this, 'testimoniImgPreview')">
                                    <div class="form-text small text-muted">Format JPG/PNG/WebP, maksimal 2MB. Pas foto rapi disarankan.</div>
                                    <div id="testimoniImgPreviewWrap" class="mt-2 text-center" style="display: none;">
                                        <img id="testimoniImgPreview" src="" class="rounded-circle border" style="width: 70px; height: 70px; object-fit: cover;">
                                    </div>
                                </div>

                                <!-- TESTIMONI -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Isi Testimoni / Kutipan <span class="text-danger">*</span></label>
                                    <textarea name="testimoni" rows="4" class="form-control" placeholder="Tuliskan pesan alumni, pengalaman kuliah di AMIK Taruna, dan dampaknya pada karier saat ini..." required></textarea>
                                </div>

                                <!-- URUTAN & STATUS -->
                                <div class="row g-2 mb-4">
                                    <div class="col-6">
                                        <label class="form-label fw-semibold small">No. Urut</label>
                                        <input type="number" name="urutan" class="form-control text-center" value="0" min="0">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-semibold small">Status Tampil</label>
                                        <select name="is_active" class="form-select">
                                            <option value="1">Aktif</option>
                                            <option value="0">Nonaktif</option>
                                        </select>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-custom w-100 shadow-xs" style="background: #4f46e5; border-color: #4f46e5;">
                                    <i class="fas fa-save me-1"></i> Simpan Testimoni
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- TABLE TESTIMONI -->
                <div class="col-lg-8">
                    <div class="card card-custom">
                        <div class="card-header-custom bg-gradient-dark d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-comments me-1"></i> Daftar Testimoni Alumni</span>
                            <span class="badge bg-light text-dark">{{ count($testimonis) }} Testimoni</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-middle table-hover mb-0">
                                    <thead class="table-light text-slate-700 small">
                                        <tr>
                                            <th width="40" class="text-center">No</th>
                                            <th width="75" class="text-center">Foto</th>
                                            <th>Nama &amp; Prodi</th>
                                            <th>Karier Saat Ini</th>
                                            <th>Testimoni &amp; Bintang</th>
                                            <th width="85" class="text-center">Status</th>
                                            <th width="110" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($testimonis as $t)
                                        <tr>
                                            <td class="text-center text-muted fw-semibold">
                                                {{ $t->urutan > 0 ? $t->urutan : $loop->iteration }}
                                            </td>
                                            <td class="text-center">
                                                @if($t->foto)
                                                    <img src="{{ asset('uploads/'.$t->foto) }}" 
                                                         class="preview-img rounded-circle" 
                                                         alt="{{ $t->nama }}" 
                                                         title="Klik untuk memperbesar" 
                                                         onclick="openImageLightbox('{{ asset('uploads/'.$t->foto) }}', '{{ addslashes($t->nama) }}')">
                                                @else
                                                    <div class="alumni-avatar-placeholder rounded-circle mx-auto">
                                                        {{ strtoupper(substr($t->nama, 0, 2)) }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-bold text-slate-900 mb-0.5">{{ $t->nama }}</div>
                                                <div class="text-slate-500 small">
                                                    @if($t->program_studi)
                                                        <span class="text-emerald-700 fw-semibold">{{ $t->program_studi }}</span>
                                                    @endif
                                                    @if($t->tahun_lulus)
                                                        <span class="badge bg-light text-dark border ms-1">Lulus {{ $t->tahun_lulus }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if($t->pekerjaan || $t->perusahaan)
                                                    <div class="fw-semibold text-slate-800 small">{{ $t->pekerjaan ?: '-' }}</div>
                                                    <div class="text-muted small"><i class="fas fa-building text-secondary me-1"></i>{{ $t->perusahaan ?: '-' }}</div>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="small text-warning mb-1">
                                                    @for($s = 1; $s <= ($t->rating ?: 5); $s++)
                                                        <i class="fas fa-star"></i>
                                                    @endfor
                                                </div>
                                                <div class="text-muted small fst-italic" style="max-width: 260px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                    "{{ $t->testimoni }}"
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if($t->is_active)
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 small">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1 small">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1.5">
                                                    <!-- EDIT MODAL TRIGGER -->
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-warning rounded-pill px-2.5" 
                                                            title="Edit"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editTestimoniModal{{ $t->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <!-- DELETE -->
                                                    <form id="deleteTestimoniForm{{ $t->id }}" action="{{ route('alumni_testimoni.destroy', $t->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-danger rounded-pill px-2.5" 
                                                                title="Hapus"
                                                                onclick="confirmDeleteSweet(event, 'deleteTestimoniForm{{ $t->id }}', '{{ addslashes($t->nama) }}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>

                                                <!-- MODAL EDIT TESTIMONI -->
                                                <div class="modal fade text-start" id="editTestimoniModal{{ $t->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content rounded-4 border-0 shadow-lg">
                                                            <div class="modal-header border-0 bg-light py-3 px-4">
                                                                <h6 class="modal-title fw-bold text-slate-800">
                                                                    <i class="fas fa-edit text-warning me-1.5"></i> Edit Testimoni: {{ $t->nama }}
                                                                </h6>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('alumni_testimoni.update', $t->id) }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body p-4">
                                                                    <div class="row g-3">
                                                                        <div class="col-md-6">
                                                                            <label class="form-label fw-semibold small">Nama Alumni <span class="text-danger">*</span></label>
                                                                            <input type="text" name="nama" class="form-control" value="{{ $t->nama }}" required>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="form-label fw-semibold small">Program Studi</label>
                                                                            <input type="text" name="program_studi" list="prodiOptions" class="form-control" value="{{ $t->program_studi }}">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label class="form-label fw-semibold small">Tahun Lulus</label>
                                                                            <input type="text" name="tahun_lulus" class="form-control" value="{{ $t->tahun_lulus }}">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label class="form-label fw-semibold small">Pekerjaan</label>
                                                                            <input type="text" name="pekerjaan" class="form-control" value="{{ $t->pekerjaan }}">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label class="form-label fw-semibold small">Perusahaan / Instansi</label>
                                                                            <input type="text" name="perusahaan" class="form-control" value="{{ $t->perusahaan }}">
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label class="form-label fw-semibold small">Isi Testimoni <span class="text-danger">*</span></label>
                                                                            <textarea name="testimoni" rows="4" class="form-control" required>{{ $t->testimoni }}</textarea>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="form-label fw-semibold small">Foto Alumni</label>
                                                                            @if($t->foto)
                                                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                                                    <img src="{{ asset('uploads/'.$t->foto) }}" class="rounded-circle border" style="width: 48px; height: 48px; object-fit: cover;">
                                                                                    <span class="small text-muted">Foto saat ini terpasang</span>
                                                                                </div>
                                                                            @endif
                                                                            <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/jpg,image/webp">
                                                                            <div class="form-text small text-muted">Kosongkan jika tidak ingin mengubah foto.</div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label class="form-label fw-semibold small">Rating</label>
                                                                            <select name="rating" class="form-select">
                                                                                <option value="5" {{ $t->rating == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5)</option>
                                                                                <option value="4" {{ $t->rating == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4)</option>
                                                                                <option value="3" {{ $t->rating == 3 ? 'selected' : '' }}>⭐⭐⭐ (3)</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label class="form-label fw-semibold small">Status</label>
                                                                            <select name="is_active" class="form-select">
                                                                                <option value="1" {{ $t->is_active ? 'selected' : '' }}>Aktif</option>
                                                                                <option value="0" {{ !$t->is_active ? 'selected' : '' }}>Nonaktif</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer border-0 bg-light py-3 px-4">
                                                                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-success rounded-pill px-4">Simpan Perubahan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <i class="fas fa-user-graduate fa-2x mb-2 d-block opacity-50"></i>
                                                Belum ada testimoni alumni yang dimasukkan. Gunakan formulir di samping untuk menambahkan testimoni baru.
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

    </div>

</div>

<!-- ========================================== -->
<!-- MODAL LIGHTBOX IMAGE PREVIEW -->
<!-- ========================================== -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header border-0 bg-light py-3 px-4">
                <h6 class="modal-title fw-bold text-slate-800" id="imagePreviewTitle">Pratinjau Foto</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-2 text-center bg-dark bg-opacity-75">
                <img id="imagePreviewSrc" src="" alt="Preview" class="img-fluid rounded-3 shadow" style="max-height: 75vh; object-fit: contain;">
            </div>
            <div class="modal-footer border-0 bg-light py-2 px-4 justify-content-between">
                <a id="imagePreviewDownload" href="#" target="_blank" download class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    <i class="fas fa-download me-1"></i> Buka File Asli
                </a>
                <button type="button" class="btn btn-sm btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview gambar lokal sebelum upload
    function previewUploadImage(input, targetImgId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(targetImgId);
                const wrap = img.parentElement;
                img.src = e.target.result;
                wrap.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Lightbox modal view
    function openImageLightbox(src, title) {
        document.getElementById('imagePreviewSrc').src = src;
        document.getElementById('imagePreviewTitle').textContent = title || 'Pratinjau Foto';
        document.getElementById('imagePreviewDownload').href = src;
        const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        modal.show();
    }

    // Animated SweetAlert delete confirmation
    function confirmDeleteSweet(event, formId, itemName) {
        event.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: `Apakah Anda yakin ingin menghapus "${itemName}"? Data yang dihapus tidak dapat dipulihkan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fas fa-trash me-1"></i> Ya, Hapus',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-4 shadow-lg border-0',
                confirmButton: 'btn btn-danger rounded-pill px-4 me-2',
                cancelButton: 'btn btn-secondary rounded-pill px-4'
            },
            buttonsStyling: false,
            showClass: {
                popup: 'animate__animated animate__bounceIn'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>
@endpush

@endsection