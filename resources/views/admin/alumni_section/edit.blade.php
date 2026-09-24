@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit Alumni Section</h4>
            <p class="text-muted mb-0 small">Perbarui data section alumni</p>
        </div>
        <a href="/admin/alumni-section" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- ALERT SUCCESS -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- FORM EDIT -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <form action="/admin/alumni-section/{{ $edit->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">

                    <!-- JUDUL -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Judul <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="judul"
                               value="{{ old('judul', $edit->judul) }}"
                               class="form-control rounded-3 @error('judul') is-invalid @enderror"
                               placeholder="Masukkan judul section">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- TYPE -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            Type <span class="text-danger">*</span>
                        </label>
                        <select name="type"
                                class="form-select rounded-3 @error('type') is-invalid @enderror">
                            <option value="">-- Pilih Type --</option>
                            <option value="tracer_study"
                                {{ old('type', $edit->type) == 'tracer_study' ? 'selected' : '' }}>
                                Tracer Study
                            </option>
                            <option value="dana_abadi"
                                {{ old('type', $edit->type) == 'dana_abadi' ? 'selected' : '' }}>
                                Dana Abadi
                            </option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

<!-- LAYOUT -->
<div class="col-md-3">
    <label class="form-label fw-semibold">
        Layout <span class="text-danger">*</span>
    </label>

    <select name="layout"
            class="form-select rounded-3 @error('layout') is-invalid @enderror">

        <option value="">
            -- Pilih Layout --
        </option>

        <option value="left_image"
            {{ old('layout', $edit->layout) == 'left_image' ? 'selected' : '' }}>
            Gambar Kiri
        </option>

        <option value="right_image"
            {{ old('layout', $edit->layout) == 'right_image' ? 'selected' : '' }}>
            Gambar Kanan
        </option>

    </select>

    @error('layout')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
                    <!-- DESKRIPSI -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            Deskripsi <span class="text-danger">*</span>
                        </label>
                        <textarea name="deskripsi"
                                  rows="5"
                                  class="form-control rounded-3 @error('deskripsi') is-invalid @enderror"
                                  placeholder="Masukkan deskripsi section">{{ old('deskripsi', $edit->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- LINK -->
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Link <span class="text-muted small">(opsional)</span></label>
                        <div class="input-group">
                            <span class="input-group-text rounded-start-3">
                                <i class="fas fa-link text-muted"></i>
                            </span>
                            <input type="text"
                                   name="link"
                                   value="{{ old('link', $edit->link) }}"
                                   class="form-control rounded-end-3 @error('link') is-invalid @enderror"
                                   placeholder="https://...">
                        </div>
                        @error('link')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- STATUS -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select name="is_active"
                                class="form-select rounded-3 @error('is_active') is-invalid @enderror">
                            <option value="1"
                                {{ old('is_active', $edit->is_active) == '1' ? 'selected' : '' }}>
                                ✅ Aktif
                            </option>
                            <option value="0"
                                {{ old('is_active', $edit->is_active) == '0' ? 'selected' : '' }}>
                                ❌ Nonaktif
                            </option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- IMAGE -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            Gambar <span class="text-muted small">(opsional, max 2MB — jpg/jpeg/png)</span>
                        </label>

                        <!-- Preview gambar lama -->
                        @if($edit->image)
                            <div class="mb-3">
                                <p class="small text-muted mb-1">Gambar saat ini:</p>
                                <img src="{{ asset('uploads/' . $edit->image) }}"
                                     alt="Gambar"
                                     class="rounded-3 border"
                                     style="height: 160px; object-fit: cover;">
                                <p class="small text-muted mt-1">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Upload gambar baru untuk mengganti. Biarkan kosong jika tidak ingin mengubah.
                                </p>
                            </div>
                        @endif

                        <input type="file"
                               name="image"
                               id="imageInput"
                               accept="image/jpg,image/jpeg,image/png"
                               class="form-control rounded-3 @error('image') is-invalid @enderror"
                               onchange="previewImage(this)">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <!-- Preview gambar baru -->
                        <div id="previewWrap" class="mt-3" style="display:none;">
                            <p class="small text-muted mb-1">Preview gambar baru:</p>
                            <img id="previewImg"
                                 src=""
                                 class="rounded-3 border"
                                 style="height: 160px; object-fit: cover;">
                        </div>
                    </div>

                </div>

                <!-- TOMBOL -->
                <div class="d-flex gap-2 mt-4 pt-2 border-top">
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                    <a href="/admin/alumni-section" class="btn btn-outline-secondary rounded-pill px-4">
                        Batal
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<script>
    function previewImage(input) {
        const wrap = document.getElementById('previewWrap');
        const img  = document.getElementById('previewImg');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
                wrap.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            wrap.style.display = 'none';
        }
    }
</script>

@endsection