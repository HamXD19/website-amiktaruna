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
        <div class="d-flex gap-2">
            <a href="{{ route('lppm') }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold">
                <i class="fas fa-eye me-1"></i>Lihat Halaman Publik
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

                                                <div class="modal-footer border-0 pt-0">
                                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-warning fw-bold rounded-pill px-4 text-dark">
                                                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                                                    </button>
                                                </div>

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

</div>

@endsection