@extends('layouts.app')

@section('content')

<div class="container py-5">

    {{-- ALERT --}}
    @if(session('success'))

        <div class="alert alert-success rounded-4 shadow-sm border-0">
            {{ session('success') }}
        </div>

    @endif

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-warning py-3 rounded-top-4">

            <h5 class="mb-0 fw-bold text-dark">
                Edit Akreditasi
            </h5>

        </div>

        <div class="card-body p-4">

            <form action="{{ route('akreditasi.update', $edit->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row g-4">

                    {{-- JUDUL --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Judul
                        </label>

                        <input type="text"
                               name="judul"
                               value="{{ old('judul', $edit->judul) }}"
                               class="form-control rounded-3"
                               placeholder="Akreditasi Kampus">

                    </div>

                    {{-- TAHUN --}}
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Tahun
                        </label>

                        <input type="text"
                               name="tahun"
                               value="{{ old('tahun', $edit->tahun) }}"
                               class="form-control rounded-3"
                               placeholder="2025">

                    </div>

                    {{-- PERINGKAT --}}
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Peringkat
                        </label>

                        <input type="text"
                               name="peringkat"
                               value="{{ old('peringkat', $edit->peringkat) }}"
                               class="form-control rounded-3"
                               placeholder="Unggul">

                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Deskripsi
                        </label>

                        <textarea name="deskripsi"
                                  rows="5"
                                  class="form-control rounded-3"
                                  placeholder="Deskripsi akreditasi">{{ old('deskripsi', $edit->deskripsi) }}</textarea>

                    </div>

                    {{-- GAMBAR --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Upload Gambar Baru
                        </label>

                        <input type="file"
                               name="gambar"
                               class="form-control rounded-3">

                        <small class="text-muted">
                            Kosongkan jika tidak ingin mengganti gambar
                        </small>

                    </div>

                    {{-- STATUS --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <select name="is_active"
                                class="form-select rounded-3">

                            <option value="1"
                                {{ $edit->is_active == 1 ? 'selected' : '' }}>

                                Aktif

                            </option>

                            <option value="0"
                                {{ $edit->is_active == 0 ? 'selected' : '' }}>

                                Nonaktif

                            </option>

                        </select>

                    </div>

                    {{-- PREVIEW --}}
                    @if($edit->gambar)

                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Gambar Saat Ini
                        </label>

                        <div>

                            <img src="{{ asset('uploads/'.$edit->gambar) }}"
                                 width="220"
                                 class="rounded-4 shadow-sm border">

                        </div>

                    </div>

                    @endif

                </div>

                {{-- BUTTON --}}
                <div class="d-flex gap-2 mt-4">

                    <button type="submit"
                            class="btn btn-success rounded-3 px-4">

                        Update Data

                    </button>

                    <a href="/admin/akreditasi"
                       class="btn btn-secondary rounded-3 px-4">

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection