@extends('layouts.app')

@section('title', 'Kelola Dosen')

@section('content')

<style>
    .card-custom{
        border:none;
        border-radius:24px;
        overflow:hidden;
        box-shadow:0 10px 30px rgba(0,0,0,0.08);
    }

    .card-header-custom{
        background:linear-gradient(135deg,#16a34a,#15803d);
        color:white;
        padding:22px 30px;
    }

    .card-header-custom h4{
        margin:0;
        font-weight:700;
    }

    .form-control,
    .form-select{
        border-radius:14px;
        padding:12px 16px;
        border:1.5px solid #e2e8f0;
    }

    .form-control:focus,
    .form-select:focus{
        box-shadow:none;
        border-color:#16a34a;
    }

    .btn-custom{
        border-radius:14px;
        padding:12px 24px;
        font-weight:600;
    }

    .dosen-card{
        border:none;
        border-radius:20px;
        overflow:hidden;
        transition:all .3s ease;
        box-shadow:0 10px 25px rgba(0,0,0,0.06);
    }

    .dosen-card:hover{
        transform:translateY(-6px);
        box-shadow:0 18px 35px rgba(0,0,0,0.12);
    }

    .dosen-img{
        height:240px;
        object-fit:cover;
        width:100%;
    }

    .section-title{
        font-weight:800;
        color:#0f172a;
    }
        .foto-dosen{
            width:110px;
            height:110px;
            object-fit:cover;
            border-radius:50%;
            border:5px solid #f1f5f9;
            margin:auto;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
        }

        .jabatan-badge{
            display:inline-block;
            padding:8px 16px;
            border-radius:30px;
            background:#dcfce7;
            color:#15803d;
            font-size:13px;
            font-weight:600;
        }
</style>

<div class="container-fluid p-0">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="section-title mb-1">
                Kelola Data Dosen
            </h2>

            <p class="text-muted mb-0">
                Tambah dan kelola data dosen serta jabatan struktural
            </p>

        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="btn btn-secondary btn-custom">

            ← Dashboard

        </a>

    </div>

    <!-- ALERT -->
    @if(session('success'))

        <div class="alert alert-success border-0 rounded-4 shadow-sm">

            {{ session('success') }}

        </div>

    @endif

    <!-- FORM -->
    <div class="card card-custom mb-5">

        <div class="card-header-custom">

            <h4>
                Tambah Data Dosen
            </h4>

        </div>

        <div class="card-body p-4">

            <form method="POST"
                  action="/admin/dosen"
                  enctype="multipart/form-data">

                @csrf

                <div class="row g-3">

                    <!-- NAMA -->
                    <div class="col-md-4">

                        <label class="fw-semibold mb-2">
                            Nama Dosen
                        </label>

                        <input type="text"
                               name="nama"
                               class="form-control"
                               placeholder="Masukkan nama dosen"
                               required>

                    </div>

<!-- JABATAN -->
<div class="col-md-4">

    <label class="fw-semibold mb-2">
        Jabatan
    </label>

    <select name="jabatan[]"
            class="form-select"
            multiple
            required
            style="height:300px;">

        <option value="Direktur AMIK Taruna">
            Direktur AMIK Taruna
        </option>

        <option value="Wakil Direktur I Bidang Akademik">
            Wakil Direktur I Bidang Akademik
        </option>

        <option value="Wakil Direktur II Bidang Administrasi & Keuangan">
            Wakil Direktur II Bidang Administrasi & Keuangan
        </option>

        <option value="Wakil Direktur III Bidang Kemahasiswaan & Alumni">
            Wakil Direktur III Bidang Kemahasiswaan & Alumni
        </option>

        <option value="Ketua Pusat Penjaminan Mutu">
            Ketua Pusat Penjaminan Mutu
        </option>

        <option value="Ketua Program Studi Teknologi Informasi">
            Ketua Program Studi Teknologi Informasi
        </option>

        <option value="Ketua Program Studi Sistem Informasi Akuntansi">
            Ketua Program Studi Sistem Informasi Akuntansi
        </option>

        <option value="Ketua Program Studi Sistem Informasi">
            Ketua Program Studi Sistem Informasi
        </option>

        <option value="Staff Pusat Penjaminan Mutu">
            Staff Pusat Penjaminan Mutu
        </option>

        <option value="Ketua Lembaga Penelitian & Pengabdian Masyarakat">
            Ketua Lembaga Penelitian & Pengabdian Masyarakat
        </option>

        <option value="Ketua UPT Perpustakaan & Kearsipan">
            Ketua UPT Perpustakaan & Kearsipan
        </option>

        <option value="Ketua Unit Kerjasama & Pengembangan Institusi">
            Ketua Unit Kerjasama & Pengembangan Institusi
        </option>

        <option value="Kepala Bagian Administrasi Umum & Keuangan">
            Kepala Bagian Administrasi Umum & Keuangan
        </option>

        <option value="Staf Administrasi Umum & Keuangan">
            Staf Administrasi Umum & Keuangan
        </option>

        <option value="Kepala Bagian Administrasi Akademik">
            Kepala Bagian Administrasi Akademik
        </option>

        <option value="Staf Administrasi Akademik">
            Staf Administrasi Akademik
        </option>

        <option value="Staf SI, Humas & Layanan">
            Staf SI, Humas & Layanan
        </option>

        <option value="Staf Alumni & Pusat Karir">
            Staf Alumni & Pusat Karir
        </option>

        <option value="Staf Perpustakaan & Kearsipan">
            Staf Perpustakaan & Kearsipan
        </option>

        <option value="Dosen">
            Dosen
        </option>

    </select>

    <small class="text-muted">
        Tekan CTRL untuk memilih lebih dari satu jabatan
    </small>

</div>

                    <!-- FOTO -->
                    <div class="col-md-4">

                        <label class="fw-semibold mb-2">
                            Upload Foto
                        </label>

                        <input type="file"
                               name="foto"
                               class="form-control">

                    </div>

                </div>

                <!-- BUTTON -->
                <div class="mt-4">

                    <button class="btn btn-success btn-custom">

                        + Tambah Dosen

                    </button>

                </div>

            </form>

        </div>

    </div>

    <!-- LIST DOSEN -->
    <div class="row g-4">

        @forelse($dosen as $d)

        <div class="col-lg-3 col-md-4 col-sm-6">

            <div class="card dosen-card h-100 text-center p-4">

                <!-- FOTO -->
                <div class="mb-3">

                    @if($d->foto)

                        <img src="{{ asset('uploads/'.$d->foto) }}"
                             class="foto-dosen">

                    @else

                        <img src="https://ui-avatars.com/api/?name={{ urlencode($d->nama) }}"
                             class="foto-dosen">

                    @endif

                </div>

                <!-- NAMA -->
                <h5 class="fw-bold mb-2">

                    {{ $d->nama }}

                </h5>

                <!-- JABATAN -->
                <div class="mb-4">

                    <span class="jabatan-badge">

                        {{ $d->jabatan }}

                    </span>

                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-center gap-2 mt-auto">

                    <a href="/admin/dosen/edit/{{ $d->id }}"
                       class="btn btn-warning btn-sm rounded-3 px-3">

                        Edit

                    </a>

                    <form method="POST"
                          action="/admin/dosen/{{ $d->id }}">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm rounded-3 px-3"
                                onclick="return confirm('Hapus data dosen ini?')">

                            Hapus

                        </button>

                    </form>

                </div>

            </div>

        </div>

        @empty

        <div class="col-12">

            <div class="alert alert-warning text-center rounded-4 shadow-sm border-0">

                Belum ada data dosen

            </div>

        </div>

        @endforelse

    </div>

</div>

@endsection