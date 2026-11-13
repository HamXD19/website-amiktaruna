@extends('layouts.app')

@section('title', 'Layanan & Laporan PPKS')

@section('content')
<div class="container-fluid px-0">

    <!-- PAGE HEADER -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 mb-2 rounded-pill bg-danger-subtle text-danger fw-bold small border border-danger-subtle">
                <i class="fas fa-shield-alt"></i> Satgas PPKS
            </div>
            <h3 class="fw-bold text-dark mb-1">
                Laporan Kekerasan &amp; Pelecehan Seksual
            </h3>
            <p class="text-muted small mb-0">
                Pusat pengaduan rahasia sivitas akademika sesuai Permendikbudristek No. 30 Tahun 2021.
            </p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-danger rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalExportPpksPdf">
                <i class="fas fa-file-pdf me-1"></i> Cetak Laporan PDF
            </button>
            <a href="{{ route('berita.create', ['kategori' => 'ppks']) }}" class="btn btn-outline-success rounded-3 shadow-sm">
                <i class="fas fa-plus me-1"></i> Buat Warta / Dokumen PPKS
            </a>
            <a href="{{ route('ppks.index') }}" target="_blank" class="btn btn-emerald rounded-3 text-white shadow-sm" style="background-color: #059669;">
                <i class="fas fa-external-link-alt me-1"></i> Buka Halaman Publik
            </a>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block">Total Laporan</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1">{{ $counts['total'] }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-center fs-5" style="width: 44px; height: 44px;">
                        <i class="fas fa-folder-open"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-danger small fw-semibold d-block">Laporan Baru</span>
                        <h3 class="fw-bold text-danger mb-0 mt-1">{{ $counts['baru'] }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-3 bg-danger-subtle text-danger d-flex align-items-center justify-center fs-5" style="width: 44px; height: 44px;">
                        <i class="fas fa-bell"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-warning small fw-semibold d-block">Ditinjau / Investigasi</span>
                        <h3 class="fw-bold text-warning mb-0 mt-1">{{ $counts['ditinjau'] + $counts['investigasi'] }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-3 bg-warning-subtle text-warning d-flex align-items-center justify-center fs-5" style="width: 44px; height: 44px;">
                        <i class="fas fa-magnifying-glass"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-success small fw-semibold d-block">Selesai Ditangani</span>
                        <h3 class="fw-bold text-success mb-0 mt-1">{{ $counts['selesai'] }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-3 bg-success-subtle text-success d-flex align-items-center justify-center fs-5" style="width: 44px; height: 44px;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4 border-0">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- FILTER & SEARCH -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.ppks.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" value="{{ $search }}" class="form-control border-start-0 ps-0" placeholder="Cari kode tiket, nama, atau isi kronologi...">
                    </div>
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Semua Status Laporan --</option>
                        <option value="baru" {{ $status == 'baru' ? 'selected' : '' }}>🔴 Baru Masuk</option>
                        <option value="ditinjau" {{ $status == 'ditinjau' ? 'selected' : '' }}>🟡 Sedang Ditinjau</option>
                        <option value="investigasi" {{ $status == 'investigasi' ? 'selected' : '' }}>🟠 Tahap Investigasi</option>
                        <option value="selesai" {{ $status == 'selesai' ? 'selected' : '' }}>🟢 Selesai</option>
                    </select>
                </div>

                <div class="col-md-auto d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-3 rounded-3">Filter</button>
                    @if($status || $search)
                        <a href="{{ route('admin.ppks.index') }}" class="btn btn-light px-3 rounded-3 text-muted">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- TABLE LAPORAN -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase fw-bold">
                    <tr>
                        <th class="py-3 ps-4">Kode Tiket</th>
                        <th>Pelapor</th>
                        <th>Kategori Kejadian</th>
                        <th>Tgl Kejadian</th>
                        <th>Bukti Dokumen</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($laporans as $item)
                        <tr>
                            <!-- KODE TIKET -->
                            <td class="ps-4">
                                <span class="fw-bold font-monospace text-dark d-block">
                                    {{ $item->kode_tiket }}
                                </span>
                                <small class="text-muted" style="font-size: 11px;">
                                    {{ $item->created_at->format('d/m/Y H:i') }}
                                </small>
                            </td>

                            <!-- PELAPOR -->
                            <td>
                                @if($item->is_anonim)
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">
                                        <i class="fas fa-user-secret me-1"></i> Anonim
                                    </span>
                                @else
                                    <span class="fw-semibold text-dark d-block">{{ $item->nama_pelapor }}</span>
                                @endif
                                <small class="text-muted d-block">{{ $item->status_pelapor }} • {{ $item->no_telp }}</small>
                            </td>

                            <!-- KATEGORI -->
                            <td>
                                <span class="small fw-semibold text-dark d-block text-truncate" style="max-width: 220px;" title="{{ $item->kategori_kekerasan }}">
                                    {{ $item->kategori_kekerasan }}
                                </span>
                                @if($item->nama_terlapor)
                                    <small class="text-muted d-block">Terlapor: {{ $item->nama_terlapor }}</small>
                                @endif
                            </td>

                            <!-- TANGGAL KEJADIAN -->
                            <td>
                                <span class="small text-muted">
                                    {{ $item->tanggal_kejadian ? $item->tanggal_kejadian->format('d M Y') : '-' }}
                                </span>
                            </td>

                            <!-- BUKTI DOKUMEN -->
                            <td>
                                @if($item->dokumen_bukti)
                                    <div class="d-inline-flex align-items-center gap-1">
                                        <a href="{{ route('admin.ppks.download_bukti', ['id' => $item->id, 'view' => 1]) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-0.5" style="font-size: 11px;" title="Lihat Berkas">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.ppks.download_bukti', ['id' => $item->id]) }}" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-0.5" style="font-size: 11px;" title="Unduh Berkas Bukti">
                                            <i class="fas fa-download me-1"></i> Unduh
                                        </a>
                                    </div>
                                @else
                                    <span class="text-muted small">- Tidak ada -</span>
                                @endif
                            </td>

                            <!-- STATUS -->
                            <td>
                                @if($item->status == 'baru')
                                    <span class="badge bg-danger rounded-pill px-2.5 py-1">Baru</span>
                                @elseif($item->status == 'ditinjau')
                                    <span class="badge bg-warning text-dark rounded-pill px-2.5 py-1">Ditinjau</span>
                                @elseif($item->status == 'investigasi')
                                    <span class="badge bg-primary rounded-pill px-2.5 py-1">Investigasi</span>
                                @elseif($item->status == 'selesai')
                                    <span class="badge bg-success rounded-pill px-2.5 py-1">Selesai</span>
                                @endif
                            </td>

                            <!-- AKSI -->
                            <td class="text-end pe-4">
                                <div class="d-flex align-items-center justify-content-end gap-1.5">
                                    <a href="{{ route('admin.ppks.export.detail.pdf', $item->id) }}" class="btn btn-sm btn-outline-danger rounded-3 px-2 py-1" title="Buka / Pratinjau Berita Acara PDF" target="_blank">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <a href="{{ route('admin.ppks.export.detail.pdf', ['id' => $item->id, 'download' => 1]) }}" class="btn btn-sm btn-danger rounded-3 px-2 py-1" title="Unduh File Berita Acara PDF">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <a href="{{ route('admin.ppks.show', $item->id) }}" class="btn btn-sm btn-outline-primary rounded-3 px-2.5" title="Lihat Detail & Tindak Lanjut">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </a>

                                    <form action="{{ route('admin.ppks.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data laporan ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 p-1 px-2" title="Hapus Laporan">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 text-secondary opacity-50"></i>
                                <h6 class="fw-bold mb-1">Belum Ada Laporan Pengaduan</h6>
                                <p class="small mb-0">Laporan yang masuk melalui formulir publik PPKS akan muncul di sini secara rahasia.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($laporans->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $laporans->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Cetak Rekapitulasi PPKS PDF -->
    <div class="modal fade" id="modalExportPpksPdf" tabindex="-1" aria-labelledby="modalExportPpksPdfLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-danger text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="modalExportPpksPdfLabel">
                        <i class="fas fa-file-pdf me-2"></i> Cetak Rekapitulasi Laporan PPKS
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.ppks.export.pdf') }}" method="GET" target="_blank">
                    <div class="modal-body p-4">
                        <p class="text-muted small mb-3">
                            Laporan resmi register kasus PPKS dilengkapi Kop Surat Satgas &amp; Logo AMIK Taruna.
                        </p>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Status Penanganan</label>
                            <select name="status" class="form-select rounded-3">
                                <option value="">-- Semua Status --</option>
                                <option value="baru">🔴 Baru Masuk</option>
                                <option value="ditinjau">🟡 Sedang Ditinjau</option>
                                <option value="investigasi">🟠 Tahap Investigasi</option>
                                <option value="selesai">🟢 Selesai</option>
                            </select>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold small">Dari Tanggal</label>
                                <input type="date" name="start_date" class="form-control rounded-3">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold small">Sampai Tanggal</label>
                                <input type="date" name="end_date" class="form-control rounded-3">
                            </div>
                        </div>
                        <div class="alert alert-danger-subtle border border-danger-subtle small text-danger mb-0">
                            <i class="fas fa-lock me-1"></i> Dokumen berklasifikasi <strong>RAHASIA</strong>. Seluruh identitas pelapor anonim akan tetap dilindungi.
                        </div>
                    </div>
                    <div class="modal-footer bg-light rounded-bottom-4 d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                        <div class="d-flex gap-2">
                            <button type="submit" name="download" value="0" class="btn btn-outline-danger rounded-pill px-3 fw-semibold">
                                <i class="fas fa-eye me-1"></i> Buka / Pratinjau
                            </button>
                            <button type="submit" name="download" value="1" class="btn btn-danger rounded-pill px-4 fw-semibold shadow-sm">
                                <i class="fas fa-download me-1"></i> Unduh File PDF
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
