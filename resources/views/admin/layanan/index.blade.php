@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Kelola Menu Mahasiswa</h3>
    </div>

    <!-- ALERT -->
    @if(session('success'))
        <div class="alert alert-success rounded-3 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- FORM TAMBAH -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">

            <h5 class="fw-bold mb-4">
                Tambah Layanan
            </h5>

            <form method="POST"
                  action="/admin/layanan"
                  enctype="multipart/form-data">

                @csrf

                <div class="row">

                    <!-- NAMA -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Nama Layanan
                        </label>

                        <input type="text"
                               name="nama"
                               class="form-control"
                               placeholder="Contoh: JESICA"
                               required>
                    </div>

                    <!-- LINK -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Link URL
                        </label>

                        <input type="text"
                               name="link"
                               class="form-control"
                               placeholder="https://..."
                               required>
                    </div>

                    <!-- LOGO -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Upload Logo
                        </label>

                        <input type="file"
                               name="logo"
                               class="form-control">
                    </div>

                    <!-- WARNA -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Warna Card
                        </label>

                        <select name="warna" class="form-select">

                            <option value="">Default</option>
                            <option value="primary">Primary</option>
                            <option value="success">Success</option>
                            <option value="danger">Danger</option>
                            <option value="warning">Warning</option>
                            <option value="info">Info</option>

                        </select>
                    </div>

                    <!-- DESKRIPSI -->
                    <div class="col-md-12 mb-3">

                        <label class="form-label fw-semibold">
                            Deskripsi
                        </label>

                        <textarea name="deskripsi"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Deskripsi layanan..."></textarea>
                    </div>

                </div>

                <!-- BUTTON -->
                <button class="btn btn-success px-4">
                    Tambah Layanan
                </button>

            </form>

        </div>
    </div>

    <!-- TABEL -->
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-4">
                Daftar Layanan
            </h5>

            <div class="table-responsive">

                <table class="table align-middle table-hover">

                    <thead class="table-light">
                        <tr>
                            <th width="90" class="text-center">Logo</th>
                            <th>Nama</th>
                            <th>Link</th>
                            <th>Warna</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($data as $d)

                        <tr>

                            <!-- LOGO (CENTERED) -->
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center">
                                    @if($d->logo)
                                        <img src="{{ asset('uploads/'.$d->logo) }}"
                                             class="rounded shadow-sm mx-auto d-block"
                                             style="width:55px;height:55px;object-fit:contain;">
                                    @else
                                        <span class="text-muted small">
                                            Tidak ada
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- NAMA -->
                            <td class="fw-semibold">
                                {{ $d->nama }}
                            </td>

                            <!-- LINK -->
                            <td>
                                <a href="{{ $d->link }}"
                                   target="_blank"
                                   class="text-decoration-none">
                                    Buka Link
                                </a>
                            </td>

                            <!-- WARNA -->
                            <td>
                                <span class="badge bg-{{ $d->warna ?: 'secondary' }}">
                                    {{ $d->warna ?: 'default' }}
                                </span>
                            </td>

                            <!-- AKSI -->
                            <td>

                                <div class="d-flex gap-2">

                                    <!-- EDIT -->
                                    <a href="/admin/layanan/edit/{{ $d->id }}"
                                       class="btn btn-warning btn-sm">
                                        ✏ Edit
                                    </a>

                                    <!-- DELETE -->
                                    <form method="POST"
                                          action="/admin/layanan/{{ $d->id }}">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin hapus data ini?')">

                                            🗑 Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center py-4">
                                Belum ada data layanan
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