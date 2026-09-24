@extends('layouts.app')

@section('title', 'Kelola Alumni')

@section('content')

<style>
    .card-custom{
        border:none;
        border-radius:24px;
        overflow:hidden;
        box-shadow:0 10px 30px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0;
    }

    .card-header-custom{
        padding:18px 25px;
        font-weight:700;
        font-size:18px;
        color:white;
    }

    .bg-gradient-success{
        background:linear-gradient(135deg,#16a34a,#15803d);
    }

    .bg-gradient-dark{
        background:linear-gradient(135deg,#064e3b,#022c22);
    }

    .form-control{
        border-radius:12px;
        padding:10px 14px;
        border: 1px solid #cbd5e1;
    }

    .form-control:focus{
        box-shadow:none;
        border-color:#16a34a;
    }

    .btn-custom{
        border-radius:12px;
        padding:10px 20px;
        font-weight:600;
    }
</style>

<div class="container-fluid p-0">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-slate-900 mb-1">Kelola Alumni Section</h4>
            <p class="text-slate-500 small mb-0">Kelola rilis profil, cerita sukses, dan testimoni alumni AMIK Taruna</p>
        </div>

        <a href="{{ route('alumni') }}" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-bold">
            <i class="fas fa-eye me-1"></i>Lihat Halaman Publik
        </a>
    </div>

    <div class="row g-4">

        <!-- FORM -->
        <div class="col-lg-4">

            <div class="card card-custom">

                <div class="card-header-custom bg-gradient-success">
                    Tambah Alumni Section
                </div>

                <div class="card-body p-4">

                    <form action="{{ route('alumni_section.store') }}"
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
                                   class="form-control"
                                   placeholder="Masukkan judul"
                                   required>

                        </div>

                        <!-- DESKRIPSI -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Deskripsi
                            </label>

                            <textarea name="deskripsi"
                                      rows="5"
                                      class="form-control"
                                      placeholder="Masukkan deskripsi"
                                      required></textarea>

                        </div>

                        <!-- LINK -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Link Tujuan
                            </label>

                            <input type="text"
                                   name="link"
                                   class="form-control"
                                   placeholder="https://tracer.amiktaruna.ac.id">

                        </div>

                        <!-- TYPE -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Type
                            </label>

                            <select name="type"
                                    class="form-select">

                                <option value="tracer_study">
                                    Tracer Study
                                </option>

                                <option value="dana_abadi">
                                    Dana Abadi
                                </option>

                            </select>

                        </div>

                        <!-- LAYOUT -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Layout
                            </label>

                            <select name="layout"
                                    class="form-select">

                                <option value="left_image">
                                    Gambar Kiri
                                </option>

                                <option value="right_image">
                                    Gambar Kanan
                                </option>

                            </select>

                        </div>

                        <!-- IMAGE -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Upload Image
                            </label>

                            <input type="file"
                                   name="image"
                                   class="form-control">

                        </div>

                        <!-- STATUS -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Status
                            </label>

                            <select name="is_active"
                                    class="form-select">

                                <option value="1">
                                    Aktif
                                </option>

                                <option value="0">
                                    Nonaktif
                                </option>

                            </select>

                        </div>

                        <button type="submit"
                                class="btn btn-success btn-custom w-100">

                            Simpan Data

                        </button>

                    </form>

                </div>

            </div>

        </div>

        <!-- TABLE -->
        <div class="col-lg-8">

            <div class="card card-custom">

                <div class="card-header-custom bg-gradient-dark">
                    Data Alumni Section
                </div>

                <div class="card-body p-4">

                    <div class="table-responsive">

                        <table class="table align-middle">

                            <thead class="table-light">

                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Judul</th>
                                    <th>Link</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>

                            </thead>

                            <tbody>

                                @forelse($data as $item)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>

                                        @if($item->image)

                                            <img src="{{ asset('uploads/'.$item->image) }}"
                                                 class="preview-img">

                                        @endif

                                    </td>

                                    <td>

                                        <div class="fw-semibold">
                                            {{ $item->judul }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $item->deskripsi }}
                                        </small>

                                    </td>

                                    <!-- LINK -->
                                    <td>

                                        @if($item->link)

                                            <a href="{{ $item->link }}"
                                               target="_blank"
                                               class="btn btn-sm btn-outline-primary rounded-3">

                                                Buka Link

                                            </a>

                                        @else

                                            <span class="text-muted">
                                                Tidak ada link
                                            </span>

                                        @endif

                                    </td>

                                    <!-- TYPE -->
                                    <td>

                                        @if($item->type == 'tracer_study')

                                            <span class="badge bg-primary badge-custom">
                                                Tracer Study
                                            </span>

                                        @else

                                            <span class="badge bg-warning text-dark badge-custom">
                                                Dana Abadi
                                            </span>

                                        @endif

                                    </td>

                                    <!-- STATUS -->
                                    <td>

                                        @if($item->is_active)

                                            <span class="badge bg-success badge-custom">
                                                Aktif
                                            </span>

                                        @else

                                            <span class="badge bg-danger badge-custom">
                                                Nonaktif
                                            </span>

                                        @endif

                                    </td>

                                    <!-- AKSI -->
                                    <td>

                                        <div class="d-flex gap-2">

                                            <a href="{{ route('alumni_section.edit', $item->id) }}"
                                               class="btn btn-warning btn-sm rounded-3">

                                                Edit

                                            </a>

                                            <form action="{{ route('alumni_section.destroy', $item->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-danger btn-sm rounded-3">

                                                    Hapus

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                                @empty

                                <tr>

                                    <td colspan="7"
                                        class="text-center py-5 text-muted">

                                        Belum ada data alumni

                                    </td>

                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection