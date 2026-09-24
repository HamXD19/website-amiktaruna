@extends('layouts.app')

@section('content')

<div class="container py-5">

    {{-- ALERT --}}
    @if(session('success'))

        <div class="alert alert-success rounded-4 shadow-sm border-0">
            {{ session('success') }}
        </div>

    @endif

    <div class="row g-4">

        {{-- FORM --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-header bg-success text-white rounded-top-4 py-3">
                    <h5 class="mb-0 fw-bold">
                        Tambah Akreditasi
                    </h5>
                </div>

                <div class="card-body p-4">

                    <form action="{{ route('akreditasi.store') }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf

                        {{-- JUDUL --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Judul
                            </label>

                            <input type="text"
                                   name="judul"
                                   class="form-control"
                                   placeholder="Akreditasi Kampus">

                        </div>

                        {{-- TAHUN --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Tahun
                            </label>

                            <input type="text"
                                   name="tahun"
                                   class="form-control"
                                   placeholder="2025">

                        </div>

                        {{-- PERINGKAT --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Peringkat
                            </label>

                            <input type="text"
                                   name="peringkat"
                                   class="form-control"
                                   placeholder="Baik Sekali / Unggul">

                        </div>

                        {{-- DESKRIPSI --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Deskripsi
                            </label>

                            <textarea name="deskripsi"
                                      rows="4"
                                      class="form-control"
                                      placeholder="Deskripsi akreditasi"></textarea>

                        </div>

                        {{-- GAMBAR --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Upload Sertifikat
                            </label>

                            <input type="file"
                                   name="gambar"
                                   class="form-control">

                        </div>

                        {{-- STATUS --}}
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
                                class="btn btn-success w-100 rounded-3">

                            Simpan Data

                        </button>

                    </form>

                </div>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-header bg-dark text-white rounded-top-4 py-3">
                    <h5 class="mb-0 fw-bold">
                        Data Akreditasi
                    </h5>
                </div>

                <div class="card-body p-4">

                    <div class="table-responsive">

                        <table class="table align-middle">

                            <thead class="table-light">

                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Tahun</th>
                                    <th>Peringkat</th>
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

                                        @if($item->gambar)

                                            <img src="{{ asset('uploads/'.$item->gambar) }}"
                                                 width="90"
                                                 class="rounded-3">

                                        @else

                                            <span class="text-muted">
                                                Tidak ada gambar
                                            </span>

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

                                    <td>
                                        {{ $item->tahun }}
                                    </td>

                                    <td>

                                        <span class="badge bg-primary">
                                            {{ $item->peringkat }}
                                        </span>

                                    </td>

                                    <td>

                                        @if($item->is_active)

                                            <span class="badge bg-success">
                                                Aktif
                                            </span>

                                        @else

                                            <span class="badge bg-danger">
                                                Nonaktif
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <div class="d-flex gap-2">

                                            <a href="{{ route('akreditasi.edit', $item->id) }}"
                                               class="btn btn-warning btn-sm">

                                                Edit

                                            </a>

                                            <form action="{{ route('akreditasi.destroy', $item->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger btn-sm">
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

                                        Belum ada data akreditasi

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