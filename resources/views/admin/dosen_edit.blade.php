<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dosen</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        body{
            background:#f4f7fb;
            font-family:'Poppins',sans-serif;
        }

        .navbar{
            background:linear-gradient(135deg,#1e293b,#0f172a);
        }

        .card-custom{
            border:none;
            border-radius:24px;
            overflow:hidden;
            box-shadow:0 10px 30px rgba(0,0,0,0.08);
        }

        .card-header-custom{
            background:linear-gradient(135deg,#16a34a,#15803d);
            padding:22px 30px;
            color:white;
        }

        .card-header-custom h4{
            margin:0;
            font-weight:700;
        }

        .form-control,
        .form-select{
            border-radius:14px;
            padding:12px 15px;
            border:1px solid #dbe2ea;
        }

        .form-control:focus,
        .form-select:focus{
            box-shadow:none;
            border-color:#16a34a;
        }

        .btn-custom{
            border-radius:14px;
            padding:12px 20px;
            font-weight:600;
        }

        .preview-foto{
            width:130px;
            height:130px;
            object-fit:cover;
            border-radius:18px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
        }

        .label-title{
            font-weight:600;
            margin-bottom:8px;
        }

    </style>

</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark px-4 py-3">

    <span class="navbar-brand fw-bold">
        🎓 Admin Dosen
    </span>

</nav>

<div class="container py-5">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Edit Data Dosen
            </h2>

            <p class="text-muted mb-0">
                Perbarui informasi dosen dan jabatan struktural
            </p>

        </div>

        <a href="/admin/dosen"
           class="btn btn-secondary btn-custom">

            ← Kembali

        </a>

    </div>

    <!-- CARD -->
    <div class="card card-custom">

        <!-- HEADER -->
        <div class="card-header-custom">

            <h4>
                Form Edit Dosen
            </h4>

        </div>

        <!-- BODY -->
        <div class="card-body p-4">

            <form method="POST"
                  action="/admin/dosen/update/{{ $dosen->id }}"
                  enctype="multipart/form-data">

                @csrf

                <!-- NAMA -->
                <div class="mb-4">

                    <label class="label-title">
                        Nama Dosen
                    </label>

                    <input type="text"
                           name="nama"
                           class="form-control"
                           value="{{ $dosen->nama }}"
                           required>

                </div>

<!-- JABATAN -->
<div class="mb-4">

    <label class="label-title">
        Jabatan
    </label>

    @php

        $selectedJabatan = explode('|', $dosen->jabatan);

    @endphp

    <select name="jabatan[]"
            class="form-select"
            multiple
            required
            style="height:300px;">

        <option value="Direktur AMIK Taruna"
            {{ in_array('Direktur AMIK Taruna', $selectedJabatan) ? 'selected' : '' }}>
            Direktur AMIK Taruna
        </option>

        <option value="Wakil Direktur I Bidang Akademik"
            {{ in_array('Wakil Direktur I Bidang Akademik', $selectedJabatan) ? 'selected' : '' }}>
            Wakil Direktur I Bidang Akademik
        </option>

        <option value="Wakil Direktur II Bidang Administrasi & Keuangan"
            {{ in_array('Wakil Direktur II Bidang Administrasi & Keuangan', $selectedJabatan) ? 'selected' : '' }}>
            Wakil Direktur II Bidang Administrasi & Keuangan
        </option>

        <option value="Wakil Direktur III Bidang Kemahasiswaan & Alumni"
            {{ in_array('Wakil Direktur III Bidang Kemahasiswaan & Alumni', $selectedJabatan) ? 'selected' : '' }}>
            Wakil Direktur III Bidang Kemahasiswaan & Alumni
        </option>

        <option value="Ketua Pusat Penjaminan Mutu"
            {{ in_array('Ketua Pusat Penjaminan Mutu', $selectedJabatan) ? 'selected' : '' }}>
            Ketua Pusat Penjaminan Mutu
        </option>

        <option value="Ketua Program Studi Teknologi Informasi"
            {{ in_array('Ketua Program Studi Teknologi Informasi', $selectedJabatan) ? 'selected' : '' }}>
            Ketua Program Studi Teknologi Informasi
        </option>

        <option value="Ketua Program Studi Sistem Informasi Akuntansi"
            {{ in_array('Ketua Program Studi Sistem Informasi Akuntansi', $selectedJabatan) ? 'selected' : '' }}>
            Ketua Program Studi Sistem Informasi Akuntansi
        </option>

        <option value="Ketua Program Studi Sistem Informasi"
            {{ in_array('Ketua Program Studi Sistem Informasi', $selectedJabatan) ? 'selected' : '' }}>
            Ketua Program Studi Sistem Informasi
        </option>

        <option value="Staff Pusat Penjaminan Mutu"
            {{ in_array('Staff Pusat Penjaminan Mutu', $selectedJabatan) ? 'selected' : '' }}>
            Staff Pusat Penjaminan Mutu
        </option>

        <option value="Ketua Lembaga Penelitian & Pengabdian Masyarakat"
            {{ in_array('Ketua Lembaga Penelitian & Pengabdian Masyarakat', $selectedJabatan) ? 'selected' : '' }}>
            Ketua Lembaga Penelitian & Pengabdian Masyarakat
        </option>

        <option value="Ketua UPT Perpustakaan & Kearsipan"
            {{ in_array('Ketua UPT Perpustakaan & Kearsipan', $selectedJabatan) ? 'selected' : '' }}>
            Ketua UPT Perpustakaan & Kearsipan
        </option>

        <option value="Ketua Unit Kerjasama & Pengembangan Institusi"
            {{ in_array('Ketua Unit Kerjasama & Pengembangan Institusi', $selectedJabatan) ? 'selected' : '' }}>
            Ketua Unit Kerjasama & Pengembangan Institusi
        </option>

        <option value="Kepala Bagian Administrasi Umum & Keuangan"
            {{ in_array('Kepala Bagian Administrasi Umum & Keuangan', $selectedJabatan) ? 'selected' : '' }}>
            Kepala Bagian Administrasi Umum & Keuangan
        </option>

        <option value="Staf Administrasi Umum & Keuangan"
            {{ in_array('Staf Administrasi Umum & Keuangan', $selectedJabatan) ? 'selected' : '' }}>
            Staf Administrasi Umum & Keuangan
        </option>

        <option value="Kepala Bagian Administrasi Akademik"
            {{ in_array('Kepala Bagian Administrasi Akademik', $selectedJabatan) ? 'selected' : '' }}>
            Kepala Bagian Administrasi Akademik
        </option>

        <option value="Staf Administrasi Akademik"
            {{ in_array('Staf Administrasi Akademik', $selectedJabatan) ? 'selected' : '' }}>
            Staf Administrasi Akademik
        </option>

        <option value="Staf SI, Humas & Layanan"
            {{ in_array('Staf SI, Humas & Layanan', $selectedJabatan) ? 'selected' : '' }}>
            Staf SI, Humas & Layanan
        </option>

        <option value="Staf Alumni & Pusat Karir"
            {{ in_array('Staf Alumni & Pusat Karir', $selectedJabatan) ? 'selected' : '' }}>
            Staf Alumni & Pusat Karir
        </option>

        <option value="Staf Perpustakaan & Kearsipan"
            {{ in_array('Staf Perpustakaan & Kearsipan', $selectedJabatan) ? 'selected' : '' }}>
            Staf Perpustakaan & Kearsipan
        </option>

        <option value="Dosen"
            {{ in_array('Dosen', $selectedJabatan) ? 'selected' : '' }}>
            Dosen
        </option>

    </select>

    <small class="text-muted">
        Tekan CTRL untuk memilih lebih dari satu jabatan
    </small>

</div>

                <!-- FOTO -->
                <div class="mb-4">

                    <label class="label-title">
                        Foto Dosen
                    </label>

                    <div class="mb-3">

                        @if($dosen->foto)

                            <img src="{{ asset('uploads/'.$dosen->foto) }}"
                                 class="preview-foto">

                        @else

                            <img src="https://ui-avatars.com/api/?name={{ urlencode($dosen->nama) }}"
                                 class="preview-foto">

                        @endif

                    </div>

                    <input type="file"
                           name="foto"
                           class="form-control">

                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-success btn-custom">

                        💾 Update Dosen

                    </button>

                    <a href="/admin/dosen"
                       class="btn btn-outline-secondary btn-custom">

                        Batal

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>