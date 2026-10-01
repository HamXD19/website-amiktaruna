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
                            Nama Dosen & Gelar
                        </label>

                        <input type="text"
                               name="nama"
                               class="form-control"
                               placeholder="Masukkan nama dosen"
                               required>

                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="fw-semibold mb-0">
                                    Tingkat Organigram / Bagan <span class="text-danger">*</span>
                                </label>
                                <a href="{{ route('admin.kategori.index', ['modul' => 'organigram']) }}" target="_blank" class="small text-success text-decoration-none fw-semibold">
                                    <i class="fas fa-cog me-1"></i>Master Tingkat Organigram
                                </a>
                            </div>
                            <select name="level_organigram" class="form-select" required>
                                @if(isset($organigramLevels) && $organigramLevels->count() > 0)
                                    @foreach($organigramLevels as $lvl)
                                        <option value="{{ $lvl->level_organigram }}" {{ $lvl->level_organigram == 7 ? 'selected' : '' }}>
                                            {{ $lvl->nama }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="1">Level 1 - Direktur (Pimpinan Utama)</option>
                                    <option value="2">Level 2 - Wakil Direktur (Wadir I, II, III)</option>
                                    <option value="3">Level 3 - Lembaga, Pusat & Unit Penunjang (PPM, LPPM, Perpustakaan, Kerjasama)</option>
                                    <option value="4">Level 4 - Ketua Program Studi (Kaprodi)</option>
                                    <option value="5">Level 5 - Kepala Bagian (Kabag)</option>
                                    <option value="6">Level 6 - Staf & Tenaga Kependidikan</option>
                                    <option value="7" selected>Level 7 - Dosen Pengajar Lainnya</option>
                                @endif
                            </select>
                            <small class="text-muted d-block mt-1">Menentukan posisi bagan struktur di halaman Tentang Kampus.</small>
                        </div>

                    </div>

<!-- JABATAN -->
<div class="col-md-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <label class="fw-semibold mb-0">
            Jabatan <span class="text-danger">*</span>
        </label>
        <a href="{{ route('admin.kategori.index', ['modul' => 'jabatan']) }}" target="_blank" class="small text-success text-decoration-none fw-semibold">
            <i class="fas fa-cog me-1"></i>Master Jabatan
        </a>
    </div>

    <select name="jabatan[]"
            id="jabatanSelectIndex"
            class="form-select"
            multiple
            required
            style="height:220px;">
        @foreach($jabatanList as $j)
            <option value="{{ $j }}" {{ $j === 'Dosen' ? 'selected' : '' }}>
                {{ $j }}
            </option>
        @endforeach
    </select>

    <!-- Quick Add New Jabatan -->
    <div class="mt-2">
        <div class="input-group input-group-sm">
            <input type="text" id="newJabatanInputIndex" class="form-control" placeholder="Ketik jabatan baru jika belum ada...">
            <button type="button" class="btn btn-outline-success fw-bold" onclick="addCustomJabatan('jabatanSelectIndex', 'newJabatanInputIndex')">
                <i class="fas fa-plus me-1"></i>Tambah
            </button>
        </div>
        <small class="text-muted d-block mt-1">
            Tekan CTRL untuk memilih lebih dari 1 jabatan.
        </small>
    </div>
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

<script>
function addCustomJabatan(selectId, inputId) {
    const input = document.getElementById(inputId);
    const select = document.getElementById(selectId);
    if (!input || !select) return;

    const val = input.value.trim();
    if (!val) {
        alert('Silakan ketik nama jabatan baru terlebih dahulu.');
        input.focus();
        return;
    }

    // Check if option already exists
    let exists = false;
    for (let i = 0; i < select.options.length; i++) {
        if (select.options[i].value.toLowerCase() === val.toLowerCase()) {
            select.options[i].selected = true;
            exists = true;
            break;
        }
    }

    if (!exists) {
        const newOpt = new Option(val, val, true, true);
        select.add(newOpt);

        // Auto save to master kategori in background
        fetch('{{ route("admin.kategori.storeAjax") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ nama: val })
        }).catch(() => {});
    }

    input.value = '';
    input.focus();
}

document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('newJabatanInputIndex');
    if (input) {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addCustomJabatan('jabatanSelectIndex', 'newJabatanInputIndex');
            }
        });
    }
});
</script>

@endsection