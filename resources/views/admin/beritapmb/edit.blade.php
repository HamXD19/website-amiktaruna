@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-success">Edit Berita PMB</h2>
        <a href="{{ route('beritapmb.index') }}" class="btn btn-outline-secondary">
            ← Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('beritapmb.update', $beritapmb->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Judul</label>
                        <input type="text" name="judul" class="form-control" value="{{ $beritapmb->judul }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Penulis</label>
                        <input type="text" name="penulis" class="form-control" value="{{ $beritapmb->penulis }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Editor</label>
                        <input type="text" name="editor" class="form-control" value="{{ $beritapmb->editor }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label fw-semibold mb-0">Kategori</label>
                            <a href="{{ route('admin.kategori.index', ['modul' => 'pmb']) }}" target="_blank" class="small text-success text-decoration-none fw-semibold">
                                <i class="fas fa-plus-circle me-1"></i>Master Kategori
                            </a>
                        </div>
                        <select name="kategori" class="form-select" required>
                            @if(isset($kategoris) && $kategoris->count())
                                @foreach($kategoris as $kat)
                                    <option value="{{ $kat->slug }}" {{ old('kategori', $beritapmb->kategori) == $kat->slug ? 'selected' : '' }}>
                                        {{ $kat->ikon }} {{ $kat->nama }}
                                    </option>
                                @endforeach
                            @else
                                <option value="pmb-reguler" {{ old('kategori', $beritapmb->kategori) == 'pmb-reguler' ? 'selected' : '' }}>📝 PMB Reguler</option>
                                <option value="pmb-beasiswa" {{ old('kategori', $beritapmb->kategori) == 'pmb-beasiswa' ? 'selected' : '' }}>🌟 PMB Beasiswa</option>
                                <option value="pengumuman" {{ old('kategori', $beritapmb->kategori) == 'pengumuman' ? 'selected' : '' }}>📢 Pengumuman</option>
                            @endif
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">Isi Berita</label>
                        <textarea name="isi" rows="8" class="form-control">{{ $beritapmb->isi }}</textarea>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Gambar Baru</label>
                        <input type="file" name="gambar" class="form-control">
                        @if($beritapmb->gambar)
                            <small class="text-muted">Gambar saat ini: {{ $beritapmb->gambar }}</small>
                        @endif
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold"><i class="fab fa-youtube text-danger me-1"></i> / <i class="fab fa-tiktok text-dark me-1"></i> Link Video</label>
                        <input type="url" name="video" value="{{ old('video', $beritapmb->video) }}" placeholder="https://youtube.com/... atau tiktok.com/..." class="form-control">
                        @if($beritapmb->video)
                            <small class="text-muted d-block text-truncate">Saat ini: <a href="{{ Str::startsWith($beritapmb->video, ['http://', 'https://']) ? $beritapmb->video : asset('uploads/beritapmb/video/'.$beritapmb->video) }}" target="_blank">{{ $beritapmb->video }}</a></small>
                        @else
                            <small class="text-muted">Link YouTube atau TikTok</small>
                        @endif
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Dokumen Lampiran (PDF, DOC, DOCX)</label>
                        <input type="file" name="file_pdf" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="form-control">
                        @if($beritapmb->file_pdf)
                            <small class="text-muted">Berkas saat ini: {{ $beritapmb->file_pdf }}</small>
                        @endif
                    </div>

                    <div class="col-md-6 mb-3">
    <label class="form-label fw-semibold">Tanggal Publish</label>
    <input type="datetime-local"
           name="publish_at"
           class="form-control"
           value="{{ $beritapmb->publish_at ? \Carbon\Carbon::parse($beritapmb->publish_at)->format('Y-m-d\TH:i') : '' }}">
</div>
                </div>

                <hr class="my-3">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success px-4">
                        ✏️ Update
                    </button>
                    <a href="{{ route('beritapmb.index') }}" class="btn btn-outline-secondary">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection