@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3 class="fw-bold">
            Tambah Berita
        </h3>

        <a href="/admin/berita"
           class="btn btn-secondary rounded-3">

            ← Kembali

        </a>

    </div>

    <!-- ERROR -->
    @if ($errors->any())

        <div class="alert alert-danger rounded-4">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <!-- CARD -->
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <form action="/admin/berita"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <!-- JUDUL -->
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Judul
                    </label>

                    <input type="text"
                           name="judul"
                           class="form-control rounded-3"
                           value="{{ old('judul') }}"
                           required>

                </div>

                <!-- PENULIS -->
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Penulis
                    </label>

                    <input type="text"
                           name="penulis"
                           class="form-control rounded-3"
                           value="{{ old('penulis') }}"
                           required>

                </div>

                <div class="mb-3">

    <label class="form-label fw-semibold">
        Editor
    </label>

    <input type="text"
           name="editor"
           class="form-control rounded-3"
           placeholder="Masukkan nama editor">

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

                        <option value="">
                            -- Pilih Kategori --
                        </option>

                        @if(isset($kategoris) && $kategoris->count())
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->slug }}" {{ (old('kategori', request('kategori')) == $kat->slug) ? 'selected' : '' }}>
                                    {{ $kat->ikon }} {{ $kat->nama }}
                                </option>
                            @endforeach
                        @else
                            <option value="pengumuman" {{ old('kategori') == 'pengumuman' ? 'selected' : '' }}>📢 Pengumuman</option>
                            <option value="pengabdian" {{ old('kategori') == 'pengabdian' ? 'selected' : '' }}>🤝 Pengabdian</option>
                            <option value="penelitian" {{ old('kategori') == 'penelitian' ? 'selected' : '' }}>🔬 Penelitian</option>
                            <option value="kegiatan_kampus" {{ old('kategori') == 'kegiatan_kampus' ? 'selected' : '' }}>🎓 Kegiatan Kampus</option>
                            <option value="ppks" {{ old('kategori', request('kategori')) == 'ppks' ? 'selected' : '' }}>🛡️ Layanan & Edukasi PPKS</option>
                        @endif

                    </select>

                </div>

                <!-- ISI / DESKRIPSI -->
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Isi Berita / Deskripsi Lengkap
                    </label>

                    <textarea name="isi"
                              rows="7"
                              class="form-control rounded-3"
                              placeholder="Tuliskan isi berita, deskripsi kegiatan, atau penjelasan dokumen regulasi di sini..."
                              required>{{ old('isi') }}</textarea>

                </div>

                <!-- GAMBAR -->
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Upload Gambar
                    </label>

                    <input type="file"
                           name="gambar"
                           class="form-control rounded-3">

                    <small class="text-muted">
                        Format: JPG, JPEG, PNG
                    </small>

                </div>

                <!-- LINK VIDEO (YOUTUBE / TIKTOK) -->
                <div class="mb-4">

                    <label class="form-label fw-semibold d-flex align-items-center justify-content-between">
                        <span><i class="fab fa-youtube text-danger me-1"></i> / <i class="fab fa-tiktok text-dark me-1"></i> Link Video (YouTube / TikTok)</span>
                        <span class="badge bg-light text-muted fw-normal">Opsional</span>
                    </label>

                    <input type="url"
                           name="video"
                           value="{{ old('video') }}"
                           placeholder="Contoh: https://www.youtube.com/watch?v=... atau https://www.tiktok.com/@..."
                           class="form-control rounded-3">

                    <small class="text-muted">
                        Masukkan tautan video YouTube atau TikTok agar menghemat kapasitas penyimpanan server.
                    </small>

                </div>

                <!------ PDF ------>
                <div class="mb-3">
         <label class="form-label">File Dokumen (PDF, DOC, DOCX)</label>
         <input type="file"
           name="file_pdf"
           class="form-control"
           accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                 </div>

                 <div class="mb-3">

    <label class="form-label fw-semibold">

        Tanggal Publikasi

    </label>

    <input type="datetime-local"
           name="publish_at"
           class="form-control">

    <small class="text-muted">

        Kosongkan jika ingin langsung tayang

    </small>

</div>

                <!-- BUTTON -->
                <button class="btn btn-success rounded-3 px-4">

                    💾 Simpan Berita

                </button>

            </form>

        </div>

    </div>

</div>

@endsection