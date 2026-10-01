<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dosen</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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
                        Nama Dosen & Gelar
                    </label>

                    <input type="text"
                           name="nama"
                           class="form-control"
                           value="{{ $dosen->nama }}"
                           required>

                </div>

                <!-- TINGKAT ORGANIGRAM -->
                <div class="mb-4">

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="label-title mb-0">
                            Tingkat Organigram / Bagan Struktur <span class="text-danger">*</span>
                        </label>
                        <a href="{{ route('admin.kategori.index', ['modul' => 'organigram']) }}" target="_blank" class="small text-success text-decoration-none fw-semibold">
                            <i class="fas fa-cog me-1"></i>Master Tingkat Organigram
                        </a>
                    </div>

                    <select name="level_organigram" class="form-select" required>
                        @if(isset($organigramLevels) && $organigramLevels->count() > 0)
                            @foreach($organigramLevels as $lvl)
                                <option value="{{ $lvl->level_organigram }}" {{ ($dosen->level_organigram ?? 7) == $lvl->level_organigram ? 'selected' : '' }}>
                                    {{ $lvl->nama }}
                                </option>
                            @endforeach
                        @else
                            <option value="1" {{ ($dosen->level_organigram ?? 7) == 1 ? 'selected' : '' }}>Level 1 - Direktur (Pimpinan Utama)</option>
                            <option value="2" {{ ($dosen->level_organigram ?? 7) == 2 ? 'selected' : '' }}>Level 2 - Wakil Direktur (Wadir I, II, III)</option>
                            <option value="3" {{ ($dosen->level_organigram ?? 7) == 3 ? 'selected' : '' }}>Level 3 - Lembaga, Pusat & Unit Penunjang (PPM, LPPM, Perpustakaan, Kerjasama)</option>
                            <option value="4" {{ ($dosen->level_organigram ?? 7) == 4 ? 'selected' : '' }}>Level 4 - Ketua Program Studi (Kaprodi)</option>
                            <option value="5" {{ ($dosen->level_organigram ?? 7) == 5 ? 'selected' : '' }}>Level 5 - Kepala Bagian (Kabag)</option>
                            <option value="6" {{ ($dosen->level_organigram ?? 7) == 6 ? 'selected' : '' }}>Level 6 - Staf & Tenaga Kependidikan</option>
                            <option value="7" {{ ($dosen->level_organigram ?? 7) == 7 ? 'selected' : '' }}>Level 7 - Dosen Pengajar Lainnya</option>
                        @endif
                    </select>
                    <small class="text-muted d-block mt-1">Mengontrol posisi dosen pada bagan struktur hirarkis di halaman Tentang Kampus.</small>

                </div>

<!-- JABATAN -->
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <label class="label-title mb-0">
            Jabatan <span class="text-danger">*</span>
        </label>
        <a href="{{ route('admin.kategori.index', ['modul' => 'jabatan']) }}" target="_blank" class="small text-success text-decoration-none fw-semibold">
            <i class="fas fa-cog me-1"></i>Master Jabatan
        </a>
    </div>

    @php
        $selectedJabatan = array_map('trim', explode('|', $dosen->jabatan ?? ''));
    @endphp

    <select name="jabatan[]"
            id="jabatanSelectEdit"
            class="form-select"
            multiple
            required
            style="height:240px;">
        @foreach($jabatanList as $j)
            <option value="{{ $j }}" {{ in_array($j, $selectedJabatan) ? 'selected' : '' }}>
                {{ $j }}
            </option>
        @endforeach
    </select>

    <!-- Quick Add New Jabatan -->
    <div class="mt-2">
        <div class="input-group input-group-sm">
            <input type="text" id="newJabatanInputEdit" class="form-control" placeholder="Ketik jabatan baru jika belum ada...">
            <button type="button" class="btn btn-outline-success fw-bold" onclick="addCustomJabatan('jabatanSelectEdit', 'newJabatanInputEdit')">
                <i class="fas fa-plus me-1"></i>Tambah
            </button>
        </div>
        <small class="text-muted d-block mt-1">
            Tekan CTRL untuk memilih lebih dari 1 jabatan.
        </small>
    </div>
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
                <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
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

                    <div>
                        <button type="button"
                                class="btn btn-outline-danger btn-custom"
                                onclick="if(confirm('Apakah Anda yakin ingin menghapus data dosen ini?')) { document.getElementById('deleteDosenForm').submit(); }">
                            🗑 Hapus Dosen
                        </button>
                    </div>
                </div>

            </form>

            <form id="deleteDosenForm" action="/admin/dosen/{{ $dosen->id }}" method="POST" class="d-none">
                @csrf
                @method('DELETE')
            </form>

        </div>

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
    const input = document.getElementById('newJabatanInputEdit');
    if (input) {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addCustomJabatan('jabatanSelectEdit', 'newJabatanInputEdit');
            }
        });
    }
});
</script>

</body>
</html>