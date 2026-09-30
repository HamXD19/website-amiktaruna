@extends('layouts.app')

@section('title', 'Kelola Dokumen Kampus & Regulasi')

@section('content')

<div class="container-fluid p-0">

    <!-- Header Page -->
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-slate-900 mb-1">Kelola Dokumen Kampus &amp; Regulasi</h4>
            <p class="text-slate-500 small mb-0">Kelola berkas resmi institusi (Statuta, Renstra, SK Kebijakan Direktur, Pedoman, Laporan Tahunan) secara terpusat</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ url('/dokumen-kampus') }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold">
                <i class="fas fa-eye me-1"></i>Lihat Halaman Publik
            </a>
            <a href="{{ route('admin.kategori.index', ['modul' => 'dokumen_kampus']) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold">
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

    <!-- FORM TAMBAH DOKUMEN KAMPUS -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-bottom py-3 px-4 rounded-top-4">
            <h6 class="fw-bold mb-0 text-slate-900 d-flex align-items-center gap-2">
                <i class="fas fa-file-circle-plus text-primary"></i>
                Tambah Dokumen Kampus Baru (PDF, DOC, DOCX)
            </h6>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.dokumen_kampus.storeDokumen') }}" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <!-- Judul Dokumen -->
                    <div class="col-md-8">
                        <label class="form-label small fw-semibold text-slate-700">Judul / Nama Dokumen <span class="text-danger">*</span></label>
                        <input type="text" name="nama_dokumen" class="form-control rounded-3" placeholder="Contoh: Rencana Strategis (Renstra) AMIK Taruna 2024-2028" required>
                    </div>

                    <!-- Tahun / Periode -->
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold text-slate-700">Tahun / Periode</label>
                        <input type="text" name="tahun" class="form-control rounded-3" placeholder="Contoh: 2024-2028 atau 2025">
                    </div>

                    <!-- Kategori Dokumen (Dari Master Kategori) -->
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-semibold text-slate-700 mb-0">Kategori Dokumen <span class="text-danger">*</span></label>
                            <a href="{{ route('admin.kategori.index', ['modul' => 'dokumen_kampus']) }}" target="_blank" class="small text-success text-decoration-none fw-semibold">
                                <i class="fas fa-plus-circle me-1"></i>Master Kategori
                            </a>
                        </div>
                        <select name="kategori" class="form-select rounded-3" required>
                            <option value="">-- Pilih Kategori Dokumen --</option>
                            @if(isset($kategoris) && $kategoris->count())
                                @foreach($kategoris as $kat)
                                    <option value="{{ $kat->slug }}">
                                        {{ $kat->ikon ?: '📌' }} {{ $kat->nama }}
                                    </option>
                                @endforeach
                            @else
                                <option value="statuta-renstra">📜 Statuta &amp; Renstra Kampus</option>
                                <option value="sk-direktur">⚖️ SK &amp; Kebijakan Direktur</option>
                                <option value="pedoman-standar">📋 Pedoman &amp; Standar Pelayanan</option>
                                <option value="laporan-tahunan">📊 Laporan Tahunan &amp; Kinerja</option>
                            @endif
                        </select>
                    </div>

                    <!-- Upload File Dokumen (PDF, DOC, DOCX) -->
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold text-slate-700">
                            Upload File Dokumen <span class="text-danger">*</span> <span class="badge bg-primary ms-1">PDF, DOC, DOCX</span>
                        </label>
                        <input type="file" name="file_pdf" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="form-control rounded-3" required>
                        <small class="text-slate-400">Maksimal 30MB.</small>
                    </div>

                    <!-- Urutan -->
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold text-slate-700">Urutan</label>
                        <input type="number" name="urutan" class="form-control rounded-3" value="0" min="0">
                    </div>

                    <!-- Deskripsi Singkat -->
                    <div class="col-12">
                        <label class="form-label small fw-semibold text-slate-700">Keterangan / Ringkasan Isi Dokumen</label>
                        <textarea name="deskripsi" rows="2" class="form-control rounded-3" placeholder="Keterangan singkat mengenai substansi atau latar belakang dokumen ini..."></textarea>
                    </div>

                    <div class="col-12 text-end pt-1">
                        <button type="submit" class="btn btn-primary fw-bold rounded-pill px-4 py-2 shadow-xs">
                            <i class="fas fa-file-upload me-1"></i>Tambahkan Dokumen
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- DAFTAR DOKUMEN KAMPUS TERPASANG -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-3">
                <div>
                    <h6 class="fw-bold text-slate-900 mb-0 d-flex align-items-center gap-2">
                        <i class="fas fa-folder-open text-warning"></i>
                        Daftar Seluruh Dokumen Kampus Terpasang
                    </h6>
                    <small class="text-slate-500">Semua dokumen PDF yang terdaftar dapat ditinjau dan diunduh publik di menu Profil &gt; Dokumen Kampus</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm" style="max-width: 260px;">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="adminKampusDocSearch" class="form-control border-start-0" placeholder="Cari dokumen di tabel...">
                    </div>
                    <span class="badge bg-emerald-100 text-emerald-800 rounded-pill px-3 py-1 font-monospace" id="adminKampusDocCountBadge">
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
                            <th width="180">Kategori</th>
                            <th width="110" class="text-center">Tahun</th>
                            <th width="170" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dokumens as $index => $doc)
                        @php
                            $katModel = $doc->kategoriModel;
                        @endphp
                        <tr class="admin-kampus-doc-row" data-text="{{ strtolower($doc->nama_dokumen . ' ' . $doc->deskripsi . ' ' . ($katModel?->nama ?? $doc->kategori) . ' ' . $doc->tahun) }}">
                            <!-- NO / URUTAN -->
                            <td class="text-center fw-semibold text-slate-500">
                                {{ $doc->urutan ?: ($index + 1) }}
                            </td>

                            <!-- TIPE / EXTENSION ICON -->
                            <td class="text-center">
                                @php
                                    $ext = strtolower(pathinfo($doc->file_pdf, PATHINFO_EXTENSION));
                                @endphp
                                @if($ext === 'pdf')
                                    <span class="badge bg-danger bg-opacity-10 text-danger p-2 rounded-3" title="Format PDF">
                                        <i class="fas fa-file-pdf fs-5"></i>
                                    </span>
                                @else
                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2 rounded-3" title="Format Word (DOC/DOCX)">
                                        <i class="fas fa-file-word fs-5"></i>
                                    </span>
                                @endif
                            </td>

                            <!-- NAMA & KETERANGAN -->
                            <td>
                                <div class="fw-bold text-slate-900 mb-0.5">
                                    {{ $doc->nama_dokumen }}
                                </div>
                                @if($doc->deskripsi)
                                    <div class="text-slate-500 small text-truncate" style="max-width: 450px;" title="{{ $doc->deskripsi }}">
                                        {{ $doc->deskripsi }}
                                    </div>
                                @endif
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <a href="{{ asset('uploads/dokumen_kampus/' . $doc->file_pdf) }}" target="_blank" class="small text-decoration-none text-success">
                                        <i class="fas fa-arrow-up-right-from-square me-1"></i>Pratinjau File
                                    </a>
                                </div>
                            </td>

                            <!-- KATEGORI -->
                            <td>
                                @if($katModel)
                                    <span class="badge bg-{{ $katModel->warna ?: 'primary' }} bg-opacity-15 text-{{ $katModel->warna ?: 'primary' }} border border-{{ $katModel->warna ?: 'primary' }} border-opacity-25 px-2.5 py-1 rounded-pill small">
                                        {{ $katModel->ikon ?: '📌' }} {{ $katModel->nama }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-25 text-slate-700 px-2.5 py-1 rounded-pill small">
                                        {{ $doc->kategori }}
                                    </span>
                                @endif
                            </td>

                            <!-- TAHUN -->
                            <td class="text-center">
                                @if($doc->tahun)
                                    <span class="badge bg-light text-slate-700 border rounded-pill px-2.5 py-1">
                                        {{ $doc->tahun }}
                                    </span>
                                @else
                                    <span class="text-slate-400 small">-</span>
                                @endif
                            </td>

                            <!-- AKSI -->
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-1.5">
                                    <!-- Edit Button -->
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-warning rounded-pill px-3 py-1 fw-semibold d-inline-flex align-items-center gap-1"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEditKampusDokumen{{ $doc->id }}"
                                            title="Edit metadata atau ganti berkas">
                                        <i class="fas fa-edit"></i>
                                        <span>Edit</span>
                                    </button>

                                    <!-- Delete Button -->
                                    <form method="POST" action="{{ route('admin.dokumen_kampus.destroyDokumen', $doc->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen \'{{ addslashes($doc->nama_dokumen) }}\'? Berkas fisik di server juga akan dihapus.');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-1" title="Hapus dokumen">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>

                                <!-- MODAL EDIT DOKUMEN -->
                                <div class="modal fade text-start" id="modalEditKampusDokumen{{ $doc->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow-lg">
                                            <div class="modal-header border-bottom py-3 px-4">
                                                <h6 class="modal-title fw-bold text-slate-900 d-flex align-items-center gap-2">
                                                    <i class="fas fa-edit text-warning"></i>
                                                    Edit Dokumen Kampus: {{ $doc->nama_dokumen }}
                                                </h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.dokumen_kampus.updateDokumen', $doc->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body p-4">
                                                    <div class="row g-3">
                                                        <div class="col-md-8">
                                                            <label class="form-label small fw-semibold text-slate-700">Nama Dokumen <span class="text-danger">*</span></label>
                                                            <input type="text" name="nama_dokumen" class="form-control rounded-3" value="{{ $doc->nama_dokumen }}" required>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label small fw-semibold text-slate-700">Tahun / Periode</label>
                                                            <input type="text" name="tahun" class="form-control rounded-3" value="{{ $doc->tahun }}">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-semibold text-slate-700">Kategori Dokumen <span class="text-danger">*</span></label>
                                                            <select name="kategori" class="form-select rounded-3" required>
                                                                @foreach($kategoris as $kOption)
                                                                    <option value="{{ $kOption->slug }}" {{ $doc->kategori == $kOption->slug ? 'selected' : '' }}>
                                                                        {{ $kOption->ikon ?: '📌' }} {{ $kOption->nama }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-semibold text-slate-700">Ganti File (Biarkan kosong jika tidak ingin mengubah)</label>
                                                            <input type="file" name="file_pdf" accept=".pdf,.doc,.docx" class="form-control rounded-3">
                                                            <small class="text-slate-400">File saat ini: <span class="text-dark fw-bold font-monospace">{{ $doc->file_pdf }}</span></small>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label small fw-semibold text-slate-700">Urutan Tampil</label>
                                                            <input type="number" name="urutan" class="form-control rounded-3" value="{{ $doc->urutan }}" min="0">
                                                        </div>

                                                        <div class="col-md-8">
                                                            <label class="form-label small fw-semibold text-slate-700">Status Aktif</label>
                                                            <select name="is_active" class="form-select rounded-3">
                                                                <option value="1" {{ $doc->is_active ? 'selected' : '' }}>Aktif (Tampil di Publik)</option>
                                                                <option value="0" {{ !$doc->is_active ? 'selected' : '' }}>Arsip Nonaktif (Sembunyikan)</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-12">
                                                            <label class="form-label small fw-semibold text-slate-700">Deskripsi / Keterangan</label>
                                                            <textarea name="deskripsi" rows="3" class="form-control rounded-3">{{ $doc->deskripsi }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top py-2.5 px-4 justify-content-between">
                                                    <button type="button" class="btn btn-secondary btn-sm rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">
                                                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-slate-400">
                                <i class="fas fa-folder-open fs-2 mb-2 d-block"></i>
                                Belum ada dokumen kampus yang ditambahkan. Gunakan formulir di atas untuk mengunggah dokumen baru.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('adminKampusDocSearch');
        const rows = document.querySelectorAll('.admin-kampus-doc-row');
        const badge = document.getElementById('adminKampusDocCountBadge');

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const query = this.value.trim().toLowerCase();
                let count = 0;

                rows.forEach(row => {
                    const text = row.getAttribute('data-text') || '';
                    if (query === '' || text.includes(query)) {
                        row.style.display = '';
                        count++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (badge) {
                    badge.innerText = `${count} Dokumen`;
                }
            });
        }
    });
</script>
@endpush

@endsection
