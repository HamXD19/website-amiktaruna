@extends('layouts.app')

@section('title', 'Kelola PPM & Dokumen Mutu')

@section('content')

<div class="container-fluid p-0">

    <!-- Header Page -->
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-slate-900 mb-1">Kelola Pusat Penjaminan Mutu (PPM)</h4>
            <p class="text-slate-500 small mb-0">Atur narasi profil, integrasi portal SPMI, dan kelola seluruh arsip dokumen mutu PDF secara dinamis</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ url('/ppm') }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold">
                <i class="fas fa-eye me-1"></i>Lihat Halaman Publik
            </a>
            <a href="{{ route('admin.kategori.index', ['modul' => 'dokumen']) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold">
                <i class="fas fa-tags me-1"></i>Master Kategori Dokumen
            </a>
        </div>
    </div>

    <!-- Alert Notifikasi -->
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

    <div class="row g-4 mb-4">

        <!-- KOLOM KIRI: PROFIL & PORTAL PPM -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom py-3 px-4 rounded-top-4">
                    <h6 class="fw-bold mb-0 text-slate-900 d-flex align-items-center gap-2">
                        <i class="fas fa-shield-alt text-success"></i>
                        Profil &amp; Portal PPM
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('ppm.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Deskripsi PPM -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-slate-700">
                                Deskripsi Institusional PPM <span class="text-danger">*</span>
                            </label>
                            <textarea name="deskripsi" rows="5" class="form-control rounded-3" placeholder="Jelaskan peran, fungsi, atau komitmen SPMI AMIK Taruna..." required>{{ old('deskripsi', $ppm->deskripsi ?? '') }}</textarea>
                            <small class="text-slate-400">Narasi profil mutu yang tampil pada hero header publik.</small>
                        </div>

                        <!-- Nama Portal -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-slate-700">Nama Portal / Aplikasi</label>
                            <input type="text" name="nama_portal" class="form-control rounded-3" value="{{ old('nama_portal', $ppm->nama_portal ?? 'Website Penjaminan Mutu') }}" placeholder="Contoh: SI-JAMU AMIK Taruna">
                        </div>

                        <!-- Link Portal -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-slate-700">Tautan / URL Portal</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-link text-muted"></i></span>
                                <input type="url" name="link_portal" class="form-control border-start-0 rounded-end-3" value="{{ old('link_portal', $ppm->link_portal ?? '') }}" placeholder="https://si-jamu.amiktaruna.ac.id/login">
                            </div>
                        </div>

                        <!-- Thumbnail Banner -->
                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-slate-700">Thumbnail / Banner Gambar Portal</label>
                            <input type="file" name="gambar" accept="image/*" class="form-control rounded-3">
                            <small class="text-slate-400">Format: JPG, PNG, WEBP (Maksimal 4MB).</small>

                            @if(!empty($ppm->gambar))
                                <div class="mt-2 p-2 bg-light rounded-3 d-flex align-items-center gap-3 border">
                                    <img src="{{ asset('uploads/ppm/' . $ppm->gambar) }}" alt="Thumbnail PPM" class="rounded-2" style="height: 48px; width: 72px; object-fit: cover;">
                                    <div class="small text-truncate">
                                        <span class="badge bg-success-subtle text-success py-1 px-2">Thumbnail Aktif</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-success fw-bold w-100 rounded-pill py-2.5 shadow-xs">
                            <i class="fas fa-save me-1"></i>Simpan Profil &amp; Portal
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: FORM TAMBAH DOKUMEN MUTU -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom py-3 px-4 rounded-top-4">
                    <h6 class="fw-bold mb-0 text-slate-900 d-flex align-items-center gap-2">
                        <i class="fas fa-file-circle-plus text-primary"></i>
                        Tambah Dokumen Mutu Baru (PDF)
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.ppm.dokumen.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <!-- Judul Dokumen -->
                            <div class="col-12">
                                <label class="form-label small fw-semibold text-slate-700">Judul / Nama Dokumen <span class="text-danger">*</span></label>
                                <input type="text" name="nama_dokumen" class="form-control rounded-3" placeholder="Contoh: Standar Penjaminan Mutu Pembelajaran 2025/2026" required>
                            </div>

                            <!-- Kategori Dokumen (Dari Master Kategori) -->
                            <div class="col-md-7">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label small fw-semibold text-slate-700 mb-0">Kategori Dokumen <span class="text-danger">*</span></label>
                                    <a href="{{ route('admin.kategori.index', ['modul' => 'dokumen']) }}" target="_blank" class="small text-success text-decoration-none fw-semibold">
                                        <i class="fas fa-plus-circle me-1"></i>Master Kategori
                                    </a>
                                </div>
                                <select name="kategori" class="form-select rounded-3" required>
                                    <option value="">-- Pilih Kategori Dokumen --</option>
                                    @if(isset($kategoris) && $kategoris->count())
                                        @foreach($kategoris as $kat)
                                            <option value="{{ $kat->slug }}">
                                                {{ $kat->ikon }} {{ $kat->nama }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="spmi-mutu">📜 Standar Mutu SPMI</option>
                                        <option value="kebijakan-sk">⚖️ Kebijakan & SK Mutu</option>
                                        <option value="manual-sop">📋 Manual & SOP Mutu</option>
                                        <option value="laporan-ami">📊 Laporan AMI & Evaluasi</option>
                                    @endif
                                </select>
                            </div>

                            <!-- Tahun / Periode -->
                            <div class="col-md-5">
                                <label class="form-label small fw-semibold text-slate-700">Tahun / Periode</label>
                                <input type="text" name="tahun" class="form-control rounded-3" placeholder="Contoh: 2025/2026 atau 2025">
                            </div>

                            <!-- Upload File Dokumen (PDF, DOC, DOCX) -->
                            <div class="col-md-8">
                                <label class="form-label small fw-semibold text-slate-700">
                                    Upload File Dokumen <span class="text-danger">*</span> <span class="badge bg-primary ms-1">PDF, DOC, DOCX</span>
                                </label>
                                <input type="file" name="file_pdf" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="form-control rounded-3" required>
                                <small class="text-slate-400">Format yang didukung: PDF, DOC, DOCX (Maksimal 30MB).</small>
                            </div>

                            <!-- Urutan -->
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold text-slate-700">Urutan Tampil</label>
                                <input type="number" name="urutan" class="form-control rounded-3" value="0" min="0">
                            </div>

                            <!-- Deskripsi Singkat -->
                            <div class="col-12">
                                <label class="form-label small fw-semibold text-slate-700">Keterangan / Ringkasan Isi Dokumen</label>
                                <textarea name="deskripsi" rows="2" class="form-control rounded-3" placeholder="Keterangan singkat mengenai pedoman atau isi dokumen ini..."></textarea>
                            </div>

                            <div class="col-12 text-end pt-2">
                                <button type="submit" class="btn btn-primary fw-bold rounded-pill px-4 py-2 shadow-xs">
                                    <i class="fas fa-file-upload me-1"></i>Tambahkan Dokumen PDF
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- SECTION 3: DAFTAR DOKUMEN MUTU TERPASANG -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-3">
                <div>
                    <h6 class="fw-bold text-slate-900 mb-0 d-flex align-items-center gap-2">
                        <i class="fas fa-folder-open text-warning"></i>
                        Daftar Seluruh Dokumen Mutu Terpasang
                    </h6>
                    <small class="text-slate-500">Semua dokumen PDF yang terdaftar dapat ditinjau dan diunduh oleh publik pada halaman PPM</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm" style="max-width: 260px;">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="adminDocSearch" class="form-control border-start-0" placeholder="Cari dokumen di tabel...">
                    </div>
                    <span class="badge bg-emerald-100 text-emerald-800 rounded-pill px-3 py-1 font-monospace" id="adminDocCountBadge">
                        {{ count($dokumens) }} Dokumen
                    </span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light">
                        <tr class="text-slate-600 small">
                            <th width="40" class="text-center">No</th>
                            <th width="50" class="text-center">Tipe</th>
                            <th>Nama &amp; Keterangan Dokumen</th>
                            <th width="160">Kategori</th>
                            <th width="110" class="text-center">Tahun</th>
                            <th width="170" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dokumens as $index => $doc)
                        @php
                            $katModel = $doc->kategoriModel;
                        @endphp
                        <tr class="admin-doc-row" data-text="{{ strtolower($doc->nama_dokumen . ' ' . $doc->deskripsi . ' ' . ($katModel?->nama ?? $doc->kategori) . ' ' . $doc->tahun) }}">
                            <!-- NO / URUTAN -->
                            <td class="text-center fw-semibold text-slate-500">
                                {{ $doc->urutan ?: ($index + 1) }}
                            </td>

                            <!-- TIPE ICON -->
                            @php
                                $docExt = strtolower(pathinfo($doc->file_pdf, PATHINFO_EXTENSION));
                                $isWord = in_array($docExt, ['doc', 'docx']);
                            @endphp
                            <td class="text-center">
                                <div class="rounded-3 {{ $isWord ? 'bg-primary bg-opacity-10 text-primary' : 'bg-danger bg-opacity-10 text-danger' }} d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                    <i class="fas {{ $isWord ? 'fa-file-word' : 'fa-file-pdf' }} fs-5"></i>
                                </div>
                            </td>

                            <!-- NAMA & KETERANGAN -->
                            <td>
                                <div class="fw-bold text-slate-900">{{ $doc->nama_dokumen }}</div>
                                <div class="text-slate-500 small text-truncate" style="max-width: 320px;">
                                    {{ $doc->deskripsi ?: 'Tidak ada keterangan tambahan.' }}
                                </div>
                                <div class="text-slate-400 font-monospace" style="font-size: 11px;">
                                    <i class="fas fa-paperclip me-1"></i>{{ $doc->file_pdf }}
                                </div>
                            </td>

                            <!-- KATEGORI -->
                            <td>
                                @php
                                    $katModel = $doc->kategoriModel;
                                    $warna = $katModel ? $katModel->warna : 'secondary';
                                    $ikon = $katModel ? $katModel->ikon : '📜';
                                    $namaKat = $katModel ? $katModel->nama : ucfirst(str_replace('-', ' ', $doc->kategori));
                                @endphp
                                <span class="badge bg-{{ $warna }}-subtle text-{{ $warna }} border border-{{ $warna }}-subtle rounded-pill py-1 px-2.5">
                                    {{ $ikon }} {{ $namaKat }}
                                </span>
                            </td>

                            <!-- TAHUN -->
                            <td class="text-center">
                                @if($doc->tahun)
                                    <span class="badge bg-light text-slate-700 border rounded-pill px-2.5 py-1">
                                        {{ $doc->tahun }}
                                    </span>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>

                            <!-- AKSI -->
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <!-- PREVIEW DOKUMEN -->
                                    <a href="{{ asset('uploads/ppm/' . $doc->file_pdf) }}" target="_blank" class="btn btn-sm btn-outline-{{ $isWord ? 'primary' : 'danger' }} rounded-pill px-2.5" title="Buka Dokumen">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <!-- EDIT MODAL TRIGGER -->
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-warning rounded-pill px-2.5" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEditDokumen{{ $doc->id }}"
                                            title="Edit Dokumen">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- DELETE -->
                                    <form method="POST" action="{{ route('admin.ppm.dokumen.destroy', $doc->id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger rounded-pill px-2.5" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus dokumen {{ $doc->nama_dokumen }}?')"
                                                title="Hapus Dokumen">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- MODAL EDIT DOKUMEN -->
                        <div class="modal fade" id="modalEditDokumen{{ $doc->id }}" tabindex="-1" aria-labelledby="modalEditDokumenLabel{{ $doc->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 border-0 shadow">
                                    <form method="POST" action="{{ route('admin.ppm.dokumen.update', $doc->id) }}" enctype="multipart/form-data">
                                        @csrf

                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold text-slate-900" id="modalEditDokumenLabel{{ $doc->id }}">
                                                <i class="fas fa-edit text-warning me-2"></i>Edit Dokumen Mutu
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body p-4">
                                            <div class="row g-3">
                                                <!-- Nama Dokumen -->
                                                <div class="col-12">
                                                    <label class="form-label small fw-semibold text-slate-700">Judul Dokumen <span class="text-danger">*</span></label>
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
                                                            <option value="spmi-mutu" {{ $doc->kategori == 'spmi-mutu' ? 'selected' : '' }}>📜 Standar Mutu SPMI</option>
                                                            <option value="kebijakan-sk" {{ $doc->kategori == 'kebijakan-sk' ? 'selected' : '' }}>⚖️ Kebijakan & SK Mutu</option>
                                                            <option value="manual-sop" {{ $doc->kategori == 'manual-sop' ? 'selected' : '' }}>📋 Manual & SOP Mutu</option>
                                                            <option value="laporan-ami" {{ $doc->kategori == 'laporan-ami' ? 'selected' : '' }}>📊 Laporan AMI & Evaluasi</option>
                                                        @endif
                                                    </select>
                                                </div>

                                                <!-- Tahun -->
                                                <div class="col-md-5">
                                                    <label class="form-label small fw-semibold text-slate-700">Tahun / Periode</label>
                                                    <input type="text" name="tahun" class="form-control rounded-3" value="{{ $doc->tahun }}">
                                                </div>

                                                <!-- Ganti File Dokumen -->
                                                @php
                                                    $mExt = strtolower(pathinfo($doc->file_pdf, PATHINFO_EXTENSION));
                                                    $mIsWord = in_array($mExt, ['doc', 'docx']);
                                                @endphp
                                                <div class="col-md-8">
                                                    <label class="form-label small fw-semibold text-slate-700">Ganti File Dokumen (Opsional) <span class="badge bg-primary ms-1">PDF, DOC, DOCX</span></label>
                                                    <input type="file" name="file_pdf" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="form-control rounded-3">
                                                    <small class="text-slate-400">Format: PDF, DOC, DOCX (Maks 30MB). Kosongkan jika tidak ingin mengganti file.</small>
                                                </div>

                                                <!-- Urutan -->
                                                <div class="col-md-4">
                                                    <label class="form-label small fw-semibold text-slate-700">Urutan</label>
                                                    <input type="number" name="urutan" class="form-control rounded-3" value="{{ $doc->urutan }}">
                                                </div>

                                                <!-- File Dokumen Saat Ini -->
                                                <div class="col-12">
                                                    <div class="p-2.5 bg-light rounded-3 d-flex align-items-center justify-content-between border">
                                                        <div class="d-flex align-items-center gap-2 small">
                                                            <i class="fas {{ $mIsWord ? 'fa-file-word text-primary' : 'fa-file-pdf text-danger' }} fa-lg"></i>
                                                            <span class="text-truncate text-slate-700" style="max-width: 250px;">{{ $doc->file_pdf }}</span>
                                                        </div>
                                                        <a href="{{ asset('uploads/ppm/' . $doc->file_pdf) }}" target="_blank" class="btn btn-xs btn-outline-{{ $mIsWord ? 'primary' : 'danger' }} rounded-pill px-2.5 py-1">
                                                            <i class="fas fa-external-link-alt me-1"></i>Buka
                                                        </a>
                                                    </div>
                                                </div>

                                                <!-- Deskripsi -->
                                                <div class="col-12">
                                                    <label class="form-label small fw-semibold text-slate-700">Deskripsi / Keterangan Dokumen</label>
                                                    <textarea name="deskripsi" rows="3" class="form-control rounded-3">{{ $doc->deskripsi }}</textarea>
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
                                Belum ada dokumen penjaminan mutu yang diunggah. Gunakan formulir di atas untuk mengunggah dokumen PDF.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('adminDocSearch');
    const badge = document.getElementById('adminDocCountBadge');
    const rows = document.querySelectorAll('.admin-doc-row');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const q = this.value.toLowerCase().trim();
            let count = 0;
            rows.forEach(row => {
                const text = row.getAttribute('data-text') || '';
                if (!q || text.includes(q)) {
                    row.style.display = '';
                    count++;
                } else {
                    row.style.display = 'none';
                }
            });
            if (badge) {
                badge.textContent = count + ' Dokumen';
            }
        });
    }
});
</script>

@endsection