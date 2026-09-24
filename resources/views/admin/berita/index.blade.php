@extends('layouts.app')

@section('content')

<style>
    /* ==========================================
       DATA BERITA - ADMIN PANEL
    ========================================== */
    
    .table-header {
        background: #f8fafc;
        font-weight: 600;
        color: #1e293b;
    }

    .table-header th {
        padding: 16px 12px;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }

    .table tbody td {
        padding: 16px 12px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    .judul-berita {
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 6px;
        font-size: 0.95rem;
    }

    .judul-berita-excerpt {
        color: #64748b;
        font-size: 0.75rem;
        line-height: 1.4;
    }

    .badge-kategori {
        background: #e6f5ec;
        color: #16a34a;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-block;
    }

    .preview-img {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .preview-video {
        width: 100px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .btn-edit {
        background: #f59e0b;
        color: white;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-edit:hover {
        background: #d97706;
        transform: translateY(-1px);
    }

    .btn-delete {
        background: #ef4444;
        color: white;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        border: none;
        transition: all 0.2s;
    }

    .btn-delete:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }

    .btn-pdf-sm {
        background: #dc2626;
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }

    .btn-pdf-sm:hover {
        background: #b91c1c;
        color: white;
    }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
    }

    .empty-state i {
        font-size: 3rem;
        color: #cbd5e1;
        margin-bottom: 15px;
    }

    .empty-state p {
        color: #94a3b8;
        margin-bottom: 0;
    }
</style>

<div class="container py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h3 class="fw-bold mb-1">📰 Data Berita</h3>
            <p class="text-muted mb-0">Kelola berita, gambar, dan video website</p>
        </div>
        <a href="/admin/berita/create" class="btn btn-success rounded-4 shadow-sm px-4 py-2">
            <i class="fas fa-plus me-2"></i>
            Tambah Berita
        </a>
    </div>

    <!-- ALERT SUCCESS -->
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- CARD TABEL -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-header">
                        <tr>
                            <th width="50">No</th>
                            <th>Judul</th>
                            <th width="120">Penulis</th>
                            <th width="120">Editor</th>
                            <th width="130">Kategori</th>
                            <th width="120">Status</th>
                            <th width="100">Gambar</th>
                            <th width="120">Video</th>
                            <th width="80">PDF</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($beritas as $b)
                        <tr>
                            <!-- NO -->
                            <td class="text-muted fw-semibold">{{ $loop->iteration }}</td>

                            <!-- JUDUL -->
                            <td>
                                <div class="judul-berita">{{ $b->judul }}</div>
                                <div class="judul-berita-excerpt">{{ Str::limit(strip_tags($b->isi), 80) }}</div>
                            </td>

                            <!-- PENULIS -->
                            <td>
                                <span class="text-dark fw-medium">{{ $b->penulis ?? '-' }}</span>
                            </td>

                            <!-- EDITOR -->
                            <td>
                                <span class="text-dark fw-medium">{{ $b->editor ?? '-' }}</span>
                            </td>

                            <!-- KATEGORI -->
                            <td>
                                <span class="badge-kategori">{{ $b->kategori ?? 'Umum' }}</span>
                            </td>
                            
                            <td>
    @if($b->publish_at)
        {{ $b->publish_at->format('d M Y H:i') }}
    @else
        -
    @endif
</td>

                            <!-- GAMBAR -->
                            <td>
                                @if($b->gambar)
                                    <img src="{{ asset('uploads/berita/gambar/'.$b->gambar) }}"
                                         class="preview-img"
                                         alt="gambar">
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>

                            <!-- VIDEO -->
                            <td>
                                @if($b->video)
                                    @if(Str::contains($b->video, ['youtube.com', 'youtu.be']))
                                        <a href="{{ $b->video }}" target="_blank" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1" title="Buka YouTube">
                                            <i class="fab fa-youtube"></i>
                                            <span class="small">YouTube</span>
                                        </a>
                                    @elseif(Str::contains($b->video, 'tiktok.com'))
                                        <a href="{{ $b->video }}" target="_blank" class="btn btn-sm btn-outline-dark d-inline-flex align-items-center gap-1" title="Buka TikTok">
                                            <i class="fab fa-tiktok"></i>
                                            <span class="small">TikTok</span>
                                        </a>
                                    @elseif(Str::startsWith($b->video, ['http://', 'https://']))
                                        <a href="{{ $b->video }}" target="_blank" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1" title="Buka Link Video">
                                            <i class="fas fa-external-link-alt"></i>
                                            <span class="small">Video</span>
                                        </a>
                                    @else
                                        <video class="preview-video" controls>
                                            <source src="{{ asset('uploads/berita/video/'.$b->video) }}" type="video/mp4">
                                        </video>
                                    @endif
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>

                            <!-- PDF -->
                            <td>
                                @if($b->file_pdf)
                                    <a href="{{ asset('uploads/berita/pdf/'.$b->file_pdf) }}"
                                       target="_blank"
                                       class="btn-pdf-sm">
                                        <i class="fas fa-file-pdf"></i>
                                        PDF
                                    </a>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>

                            <!-- AKSI -->
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="/admin/berita/{{ $b->id }}/edit"
                                       class="btn-edit text-decoration-none">
                                        <i class="fas fa-edit me-1"></i>
                                        Edit
                                    </a>
                                    <form action="/admin/berita/{{ $b->id }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus berita ini?')"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">
                                            <i class="fas fa-trash me-1"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11">
                                <div class="empty-state">
                                    <i class="fas fa-newspaper"></i>
                                    <p>Belum ada data berita</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection