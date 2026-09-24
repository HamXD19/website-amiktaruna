@extends('layouts.app')

@section('title', 'Master Kategori')

@section('content')

<div class="container-fluid p-0">

    <!-- Header Page -->
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-slate-900 mb-1">Master Kategori Universal</h4>
            <p class="text-slate-500 small mb-0">Pusat pengaturan kategori dinamis untuk Berita Kampus, PMB, Dokumen SPMI, Layanan, dan modul lainnya.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('berita.index') }}" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold">
                <i class="fas fa-newspaper me-1"></i>Kelola Berita
            </a>
            <a href="{{ route('beritapmb.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold">
                <i class="fas fa-bullhorn me-1"></i>Berita PMB
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

    <!-- STATS CARDS -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="text-slate-400 small fw-semibold mb-1">Total Kategori</div>
                <div class="h3 fw-bold text-slate-900 mb-0">{{ $stats['total'] }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-success border-4">
                <div class="text-slate-400 small fw-semibold mb-1">Berita Kampus</div>
                <div class="h3 fw-bold text-success mb-0">{{ $stats['berita'] }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-primary border-4">
                <div class="text-slate-400 small fw-semibold mb-1">Berita PMB</div>
                <div class="h3 fw-bold text-primary mb-0">{{ $stats['pmb'] }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-warning border-4">
                <div class="text-slate-400 small fw-semibold mb-1">Dokumen Mutu</div>
                <div class="h3 fw-bold text-warning mb-0">{{ $stats['dokumen'] }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-purple border-4" style="border-left-color: #8b5cf6 !important;">
                <div class="text-slate-400 small fw-semibold mb-1">Dokumen Prodi</div>
                <div class="h3 fw-bold mb-0" style="color: #8b5cf6;">{{ $stats['prodi_dokumen'] }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-info border-4">
                <div class="text-slate-400 small fw-semibold mb-1">Layanan</div>
                <div class="h3 fw-bold text-info mb-0">{{ $stats['layanan'] }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-secondary border-4">
                <div class="text-slate-400 small fw-semibold mb-1">Umum / Semua</div>
                <div class="h3 fw-bold text-secondary mb-0">{{ $stats['umum'] }}</div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <!-- KOLOM KIRI: FORM TAMBAH KATEGORI -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-slate-900 mb-3 d-flex align-items-center gap-2">
                        <i class="fas fa-plus-circle text-success"></i>
                        Tambah Kategori Baru
                    </h6>

                    <form method="POST" action="{{ route('admin.kategori.store') }}">
                        @csrf

                        <!-- NAMA KATEGORI -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-slate-700">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control rounded-3" placeholder="Contoh: Prestasi Mahasiswa / Beasiswa" required>
                        </div>

                        <!-- MODUL / FITUR -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-slate-700">Modul / Fitur Target <span class="text-danger">*</span></label>
                            <select name="modul" class="form-select rounded-3" required>
                                <option value="berita" selected>Berita Kampus</option>
                                <option value="pmb">Berita & Informasi PMB</option>
                                <option value="dokumen">Dokumen Mutu (PPM / LPPM)</option>
                                <option value="prodi_dokumen">Dokumen Prodi (Profil, RPS, Kurikulum)</option>
                                <option value="layanan">Layanan Akademik</option>
                                <option value="umum">Umum (Bisa Dipakai di Semua)</option>
                            </select>
                            <small class="text-slate-400">Pilih fitur di mana kategori ini akan muncul.</small>
                        </div>

                        <!-- SLUG / IDENTIFIER -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-slate-700">Slug / Kode (Opsional)</label>
                            <input type="text" name="slug" class="form-control rounded-3" placeholder="Otomatis dibuat jika dikosongkan">
                            <small class="text-slate-400">Hanya huruf kecil, angka, dan tanda hubung (-).</small>
                        </div>

                        <div class="row g-2 mb-3">
                            <!-- WARNA BADGE -->
                            <div class="col-7">
                                <label class="form-label small fw-semibold text-slate-700">Warna Aksen</label>
                                <select name="warna" class="form-select rounded-3">
                                    <option value="success" selected>Hijau (Success)</option>
                                    <option value="primary">Biru (Primary)</option>
                                    <option value="warning">Kuning (Warning)</option>
                                    <option value="danger">Merah (Danger)</option>
                                    <option value="info">Cyan (Info)</option>
                                    <option value="dark">Gelap (Dark)</option>
                                </select>
                            </div>

                            <!-- IKON / EMOJI -->
                            <div class="col-5">
                                <label class="form-label small fw-semibold text-slate-700">Ikon / Emoji</label>
                                <input type="text" name="ikon" class="form-control rounded-3 text-center" value="📌" placeholder="Emoji / Ikon">
                            </div>
                        </div>

                        <!-- URUTAN -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-slate-700">Nomor Urutan Tampil</label>
                            <input type="number" name="urutan" class="form-control rounded-3" value="0" min="0">
                        </div>

                        <!-- KETERANGAN -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-slate-700">Keterangan / Subjudul Singkat</label>
                            <textarea name="keterangan" rows="2" class="form-control rounded-3" placeholder="Contoh: Informasi dan capaian prestasi mahasiswa AMIK Taruna..."></textarea>
                        </div>

                        <!-- STATUS AKTIF -->
                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitch" value="1" checked>
                            <label class="form-check-label small fw-semibold text-slate-700" for="isActiveSwitch">Aktifkan Kategori Ini</label>
                        </div>

                        <button type="submit" class="btn btn-success fw-bold w-100 rounded-pill py-2 shadow-xs">
                            <i class="fas fa-plus me-1"></i>Simpan Kategori Baru
                        </button>
                    </form>
                </div>
            </div>

            <!-- BANTUAN ARSITEKTUR -->
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #ecfdf5, #f0fdf4); border: 1px solid #a7f3d0 !important;">
                <div class="card-body p-4 text-center">
                    <i class="fas fa-magic fa-2x text-success mb-2"></i>
                    <h6 class="fw-bold text-slate-900 mb-1">Otomatis Terintegrasi</h6>
                    <p class="text-slate-500 small mb-0">
                        Setiap kategori yang ditambahkan atau diubah di sini langsung otomatis muncul pada opsi form input admin dan halaman depan tanpa harus mengubah kode program.
                    </p>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: DAFTAR KATEGORI & FILTER -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <!-- FILTER MODUL TABS & SEARCH -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                        <!-- TABS -->
                        <div class="d-flex flex-wrap gap-1">
                            @php $currentModul = request('modul', 'semua'); @endphp
                            <a href="{{ route('admin.kategori.index', ['modul' => 'semua', 'search' => request('search')]) }}" 
                               class="btn btn-sm rounded-pill px-3 {{ $currentModul == 'semua' ? 'btn-success fw-bold' : 'btn-light text-slate-600' }}">
                                Semua ({{ $stats['total'] }})
                            </a>
                            <a href="{{ route('admin.kategori.index', ['modul' => 'berita', 'search' => request('search')]) }}" 
                               class="btn btn-sm rounded-pill px-3 {{ $currentModul == 'berita' ? 'btn-success fw-bold' : 'btn-light text-slate-600' }}">
                                Berita ({{ $stats['berita'] }})
                            </a>
                            <a href="{{ route('admin.kategori.index', ['modul' => 'pmb', 'search' => request('search')]) }}" 
                               class="btn btn-sm rounded-pill px-3 {{ $currentModul == 'pmb' ? 'btn-success fw-bold' : 'btn-light text-slate-600' }}">
                                PMB ({{ $stats['pmb'] }})
                            </a>
                            <a href="{{ route('admin.kategori.index', ['modul' => 'dokumen', 'search' => request('search')]) }}" 
                               class="btn btn-sm rounded-pill px-3 {{ $currentModul == 'dokumen' ? 'btn-success fw-bold' : 'btn-light text-slate-600' }}">
                                Dokumen Mutu ({{ $stats['dokumen'] }})
                            </a>
                            <a href="{{ route('admin.kategori.index', ['modul' => 'prodi_dokumen', 'search' => request('search')]) }}" 
                               class="btn btn-sm rounded-pill px-3 {{ $currentModul == 'prodi_dokumen' ? 'btn-success fw-bold' : 'btn-light text-slate-600' }}">
                                Dokumen Prodi ({{ $stats['prodi_dokumen'] }})
                            </a>
                            <a href="{{ route('admin.kategori.index', ['modul' => 'layanan', 'search' => request('search')]) }}" 
                               class="btn btn-sm rounded-pill px-3 {{ $currentModul == 'layanan' ? 'btn-success fw-bold' : 'btn-light text-slate-600' }}">
                                Layanan ({{ $stats['layanan'] }})
                            </a>
                        </div>

                        <!-- SEARCH -->
                        <form method="GET" action="{{ route('admin.kategori.index') }}" class="d-flex gap-2">
                            <input type="hidden" name="modul" value="{{ request('modul', 'semua') }}">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control rounded-start-pill ps-3" placeholder="Cari kategori..." value="{{ request('search') }}">
                                <button class="btn btn-outline-secondary rounded-end-pill px-3" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- TABEL KATEGORI -->
                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light">
                                <tr class="text-slate-600 small">
                                    <th width="40" class="text-center">No</th>
                                    <th width="50" class="text-center">Ikon</th>
                                    <th>Kategori &amp; Keterangan</th>
                                    <th width="110">Modul</th>
                                    <th width="80" class="text-center">Berita</th>
                                    <th width="90" class="text-center">Status</th>
                                    <th width="120" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kategoris as $index => $kat)
                                <tr>
                                    <!-- NO / URUTAN -->
                                    <td class="text-center fw-semibold text-slate-500">
                                        {{ $kat->urutan ?: ($kategoris->firstItem() + $index) }}
                                    </td>

                                    <!-- IKON -->
                                    <td class="text-center fs-5">
                                        {{ $kat->ikon ?: '📌' }}
                                    </td>

                                    <!-- NAMA & SLUG -->
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fw-bold text-slate-900">{{ $kat->nama }}</span>
                                            <span class="badge bg-{{ $kat->warna ?: 'secondary' }}-subtle text-{{ $kat->warna ?: 'secondary' }} border border-{{ $kat->warna ?: 'secondary' }}-subtle rounded-pill small py-0.5 px-2">
                                                {{ $kat->warna ?: 'default' }}
                                            </span>
                                        </div>
                                        <div class="text-slate-400 font-monospace small">
                                            slug: {{ $kat->slug }}
                                        </div>
                                        @if($kat->keterangan)
                                            <div class="text-slate-500 small text-truncate mt-0.5" style="max-width: 280px;">
                                                {{ $kat->keterangan }}
                                            </div>
                                        @endif
                                    </td>

                                    <!-- MODUL -->
                                    <td>
                                        @if($kat->modul == 'berita')
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2.5 py-1">Berita</span>
                                        @elseif($kat->modul == 'pmb')
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2.5 py-1">PMB</span>
                                        @elseif($kat->modul == 'dokumen')
                                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2.5 py-1">Mutu</span>
                                        @elseif($kat->modul == 'prodi_dokumen')
                                            <span class="badge bg-purple bg-opacity-10 text-purple rounded-pill px-2.5 py-1" style="background-color: #f3e8ff; color: #7e22ce;">Dokumen Prodi</span>
                                        @elseif($kat->modul == 'layanan')
                                            <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-2.5 py-1">Layanan</span>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2.5 py-1">Umum</span>
                                        @endif
                                    </td>

                                    <!-- JUMLAH BERITA TERKAIT -->
                                    <td class="text-center">
                                        <span class="badge bg-light text-slate-700 border rounded-pill px-2.5 py-1">
                                            {{ $kat->beritas_count }}
                                        </span>
                                    </td>

                                    <!-- STATUS -->
                                    <td class="text-center">
                                        @if($kat->is_active)
                                            <span class="badge bg-success text-white rounded-pill px-2 py-1 small">
                                                <i class="fas fa-check me-1"></i>Aktif
                                            </span>
                                        @else
                                            <span class="badge bg-secondary text-white rounded-pill px-2 py-1 small">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <!-- AKSI -->
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- EDIT BUTTON TRIGGER MODAL -->
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-warning rounded-pill px-2.5" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalEditKategori{{ $kat->id }}"
                                                    title="Edit Kategori">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <!-- DELETE BUTTON -->
                                            <form method="POST" action="{{ route('admin.kategori.destroy', $kat->id) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger rounded-pill px-2.5" 
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $kat->nama }}?')"
                                                        title="Hapus Kategori">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- MODAL EDIT KATEGORI -->
                                <div class="modal fade" id="modalEditKategori{{ $kat->id }}" tabindex="-1" aria-labelledby="modalEditKategoriLabel{{ $kat->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <form method="POST" action="{{ route('admin.kategori.update', $kat->id) }}">
                                                @csrf

                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title fw-bold text-slate-900" id="modalEditKategoriLabel{{ $kat->id }}">
                                                        <i class="fas fa-edit text-warning me-2"></i>Edit Kategori
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body p-4">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label small fw-semibold text-slate-700">Nama Kategori <span class="text-danger">*</span></label>
                                                            <input type="text" name="nama" class="form-control rounded-3" value="{{ $kat->nama }}" required>
                                                        </div>

                                                        <div class="col-md-7">
                                                            <label class="form-label small fw-semibold text-slate-700">Slug / Identifier <span class="text-danger">*</span></label>
                                                            <input type="text" name="slug" class="form-control rounded-3 font-monospace" value="{{ $kat->slug }}" required>
                                                        </div>

                                                        <div class="col-md-5">
                                                            <label class="form-label small fw-semibold text-slate-700">Urutan Tampil</label>
                                                            <input type="number" name="urutan" class="form-control rounded-3" value="{{ $kat->urutan }}" min="0">
                                                        </div>

                                                        <div class="col-md-7">
                                                            <label class="form-label small fw-semibold text-slate-700">Modul / Fitur <span class="text-danger">*</span></label>
                                                            <select name="modul" class="form-select rounded-3" required>
                                                                <option value="berita" {{ $kat->modul == 'berita' ? 'selected' : '' }}>Berita Kampus</option>
                                                                <option value="pmb" {{ $kat->modul == 'pmb' ? 'selected' : '' }}>Berita & Informasi PMB</option>
                                                                <option value="dokumen" {{ $kat->modul == 'dokumen' ? 'selected' : '' }}>Dokumen Mutu (PPM / LPPM)</option>
                                                                <option value="prodi_dokumen" {{ $kat->modul == 'prodi_dokumen' ? 'selected' : '' }}>Dokumen Prodi (Profil, RPS, Kurikulum)</option>
                                                                <option value="layanan" {{ $kat->modul == 'layanan' ? 'selected' : '' }}>Layanan Akademik</option>
                                                                <option value="umum" {{ $kat->modul == 'umum' ? 'selected' : '' }}>Umum (Semua Fitur)</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-5">
                                                            <label class="form-label small fw-semibold text-slate-700">Ikon / Emoji</label>
                                                            <input type="text" name="ikon" class="form-control rounded-3 text-center" value="{{ $kat->ikon }}">
                                                        </div>

                                                        <div class="col-12">
                                                            <label class="form-label small fw-semibold text-slate-700">Warna Aksen</label>
                                                            <select name="warna" class="form-select rounded-3">
                                                                <option value="success" {{ $kat->warna == 'success' ? 'selected' : '' }}>Hijau (Success)</option>
                                                                <option value="primary" {{ $kat->warna == 'primary' ? 'selected' : '' }}>Biru (Primary)</option>
                                                                <option value="warning" {{ $kat->warna == 'warning' ? 'selected' : '' }}>Kuning (Warning)</option>
                                                                <option value="danger" {{ $kat->warna == 'danger' ? 'selected' : '' }}>Merah (Danger)</option>
                                                                <option value="info" {{ $kat->warna == 'info' ? 'selected' : '' }}>Cyan (Info)</option>
                                                                <option value="dark" {{ $kat->warna == 'dark' ? 'selected' : '' }}>Gelap (Dark)</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-12">
                                                            <label class="form-label small fw-semibold text-slate-700">Keterangan / Deskripsi Singkat</label>
                                                            <textarea name="keterangan" rows="2" class="form-control rounded-3">{{ $kat->keterangan }}</textarea>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" name="is_active" id="editActiveSwitch{{ $kat->id }}" value="1" {{ $kat->is_active ? 'checked' : '' }}>
                                                                <label class="form-check-label small fw-semibold text-slate-700" for="editActiveSwitch{{ $kat->id }}">Kategori Ini Aktif</label>
                                                            </div>
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
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="fas fa-folder-open d-block fa-2x mb-2 text-slate-300"></i>
                                        Belum ada kategori yang sesuai dengan filter. Gunakan formulir di sebelah kiri untuk menambahkan kategori baru.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- PAGINATION -->
                    @if($kategoris->hasPages())
                        <div class="mt-4 d-flex justify-content-end">
                            {{ $kategoris->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>

</div>

@endsection
