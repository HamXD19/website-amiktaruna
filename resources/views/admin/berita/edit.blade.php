@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3 class="fw-bold">
            Edit Berita
        </h3>

        <a href="{{ route('berita.index') }}"
           class="btn btn-secondary rounded-3">

            ← Kembali

        </a>

    </div>

    <!-- ERROR VALIDASI -->
    @if ($errors->any())

        <div class="alert alert-danger rounded-4 shadow-sm border-0">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <!-- CARD -->
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

        <div class="card-header bg-warning py-3 border-0">

            <h4 class="mb-0 fw-bold text-dark">
                Form Edit Berita
            </h4>

        </div>

        <div class="card-body p-4">

            <form action="{{ route('berita.update', $berita->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <!-- JUDUL -->
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Judul
                    </label>

                    <input type="text"
                           name="judul"
                           value="{{ old('judul', $berita->judul) }}"
                           class="form-control rounded-3"
                           required>

                </div>

                <!-- PENULIS -->
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Penulis
                    </label>

                    <input type="text"
                           name="penulis"
                           value="{{ old('penulis', $berita->penulis) }}"
                           class="form-control rounded-3"
                           required>

                </div>

                <div class="mb-3">

    <label class="form-label fw-semibold">
        Editor
    </label>

    <input type="text"
           name="editor"
           value="{{ old('editor',$berita->editor) }}"
           class="form-control rounded-3">

</div>

                <!-- KATEGORI -->
                <div class="mb-3">

                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label fw-semibold mb-0">
                            Kategori
                        </label>
                        <a href="{{ route('admin.kategori.index') }}" target="_blank" class="small text-success text-decoration-none fw-semibold">
                            <i class="fas fa-plus-circle me-1"></i>Kelola Master Kategori
                        </a>
                    </div>

                    <select name="kategori"
                            class="form-select rounded-3"
                            required>

                        @if(isset($kategoris) && $kategoris->count())
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->slug }}"
                                    {{ old('kategori', $berita->kategori) == $kat->slug ? 'selected' : '' }}>
                                    {{ $kat->ikon }} {{ $kat->nama }}
                                </option>
                            @endforeach
                        @else
                            <option value="pengumuman" {{ old('kategori', $berita->kategori) == 'pengumuman' ? 'selected' : '' }}>📢 Pengumuman</option>
                            <option value="pengabdian" {{ old('kategori', $berita->kategori) == 'pengabdian' ? 'selected' : '' }}>🤝 Pengabdian</option>
                            <option value="penelitian" {{ old('kategori', $berita->kategori) == 'penelitian' ? 'selected' : '' }}>🔬 Penelitian</option>
                            <option value="kegiatan_kampus" {{ old('kategori', $berita->kategori) == 'kegiatan_kampus' ? 'selected' : '' }}>🎓 Kegiatan Kampus</option>
                            <option value="ppks" {{ old('kategori', $berita->kategori) == 'ppks' ? 'selected' : '' }}>🛡️ Layanan & Edukasi PPKS</option>
                        @endif

                    </select>

                </div>

                <!-- ISI / DESKRIPSI -->
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Isi Berita / Deskripsi Lengkap
                    </label>

                    <textarea name="isi"
                              rows="8"
                              class="form-control rounded-3"
                              required>{{ old('isi', $berita->isi) }}</textarea>

                </div>

                <!-- GAMBAR -->
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Gambar
                    </label>

                    @if($berita->gambar)

                        <div class="mb-3">

                            <img src="{{ asset('uploads/'.$berita->gambar) }}"
                                 width="220"
                                 class="rounded-4 shadow-sm border">

                        </div>

                    @endif

                    <input type="file"
                           name="gambar"
                           class="form-control rounded-3">

                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengganti gambar
                    </small>

                </div>

                <!-- LINK VIDEO (YOUTUBE / TIKTOK) -->
                <div class="mb-4">

                    <label class="form-label fw-semibold d-flex align-items-center justify-content-between">
                        <span><i class="fab fa-youtube text-danger me-1"></i> / <i class="fab fa-tiktok text-dark me-1"></i> Link Video (YouTube / TikTok)</span>
                        <span class="badge bg-light text-muted fw-normal">Opsional</span>
                    </label>

                    @if($berita->video)
                        <div class="mb-2 p-2 bg-light rounded-3 border d-flex align-items-center justify-content-between">
                            <small class="text-truncate me-2">
                                <strong>Video tersimpan:</strong> 
                                <a href="{{ Str::startsWith($berita->video, 'http') ? $berita->video : asset('uploads/berita/video/'.$berita->video) }}" target="_blank" class="text-decoration-none">
                                    {{ $berita->video }}
                                </a>
                            </small>
                            <span class="badge bg-success">Tersimpan</span>
                        </div>
                    @endif

                    <input type="url"
                           name="video"
                           value="{{ old('video', $berita->video) }}"
                           placeholder="Contoh: https://www.youtube.com/watch?v=... atau https://www.tiktok.com/@..."
                           class="form-control rounded-3">

                    <small class="text-muted">
                        Tempelkan tautan video YouTube atau TikTok. Kosongkan jika tidak ingin menampilkan video.
                    </small>

                </div>

<!-- DOKUMEN LAMPIRAN (PDF, DOC, DOCX) -->
<div class="mb-4">

    <label class="form-label fw-semibold">
        <i class="fas fa-paperclip text-success me-1"></i> File Dokumen Lampiran (PDF, DOC, DOCX)
    </label>

    @if($berita->file_pdf)

        <div class="mb-3">

            <a href="{{ asset('uploads/berita/pdf/'.$berita->file_pdf) }}"
               target="_blank"
               class="btn btn-outline-danger rounded-3">

                <i class="fas fa-file-pdf me-2"></i>
                Lihat Dokumen Saat Ini: {{ $berita->file_pdf }}

            </a>

        </div>

    @endif

    <input type="file"
           name="file_pdf"
           class="form-control rounded-3"
           accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">

    <small class="text-muted">
        Kosongkan jika tidak ingin mengganti file (PDF, DOC, DOCX)
    </small>

</div>

<div class="mb-3">

    <label class="form-label fw-semibold">

        Tanggal Publikasi

    </label>

    <input type="datetime-local"
           name="publish_at"
           value="{{ old('publish_at', $berita->publish_at ? $berita->publish_at->format('Y-m-d\TH:i') : '') }}"
           class="form-control">

</div>
                <!-- BUTTON -->
                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-warning rounded-3 px-4 fw-semibold">

                        💾 Update Berita

                    </button>

                    <a href="{{ route('berita.index') }}"
                       class="btn btn-outline-secondary rounded-3 px-4">

                        Batal

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection