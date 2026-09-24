@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Edit Layanan Mahasiswa</h3>

        <a href="/admin/layanan" class="btn btn-secondary">
            ← Kembali
        </a>
    </div>

    <!-- ERROR -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- CARD -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <form method="POST"
                  action="/admin/layanan/update/{{ $layanan->id }}"
                  enctype="multipart/form-data">

                @csrf

                <!-- NAMA -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Layanan
                    </label>

                    <input type="text"
                           name="nama"
                           class="form-control"
                           value="{{ $layanan->nama }}"
                           required>
                </div>

                <!-- LINK -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Link URL
                    </label>

                    <input type="text"
                           name="link"
                           class="form-control"
                           value="{{ $layanan->link }}"
                           required>
                </div>

                <!-- LOGO -->
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Logo Layanan
                    </label>

                    @if($layanan->logo)
                        <div class="mb-3 text-center">
                            <span class="small text-muted d-block mb-1">Logo saat ini:</span>
                            <img src="{{ asset('uploads/'.$layanan->logo) }}"
                                 class="rounded shadow-sm mx-auto d-block"
                                 style="width:90px;height:90px;object-fit:contain;">
                        </div>
                    @endif

                    <input type="file"
                           name="logo"
                           class="form-control">
                </div>

                <!-- WARNA -->
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Warna Card
                    </label>

                    <select name="warna" class="form-select">

                        <option value="">Default</option>

                        <option value="primary"
                            {{ $layanan->warna=='primary'?'selected':'' }}>
                            Primary
                        </option>

                        <option value="success"
                            {{ $layanan->warna=='success'?'selected':'' }}>
                            Success
                        </option>

                        <option value="danger"
                            {{ $layanan->warna=='danger'?'selected':'' }}>
                            Danger
                        </option>

                        <option value="warning"
                            {{ $layanan->warna=='warning'?'selected':'' }}>
                            Warning
                        </option>

                        <option value="info"
                            {{ $layanan->warna=='info'?'selected':'' }}>
                            Info
                        </option>

                    </select>
                </div>

                <!-- DESKRIPSI -->
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Deskripsi
                    </label>

                    <textarea name="deskripsi"
                              class="form-control"
                              rows="3">{{ $layanan->deskripsi }}</textarea>
                </div>

                <!-- BUTTON -->
                <button class="btn btn-primary px-4">
                    💾 Update Layanan
                </button>

            </form>

        </div>
    </div>

</div>

@endsection