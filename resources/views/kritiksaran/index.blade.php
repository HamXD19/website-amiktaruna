@extends('layouts.main')

@section('content')

<div class="container py-5">
    <div class="text-center mb-5">
        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 mb-3 rounded-pill bg-emerald-500/20 text-emerald-300 fw-bold small border border-emerald-500/30">
            <i class="fas fa-comment-dots"></i> Suara Sivitas & Publik
        </div>
        <h1 class="fw-bold display-6 text-white mb-2">
            Kritik &amp; Saran
        </h1>
        <p class="text-slate-300 mx-auto" style="max-width: 600px;">
            Berikan masukan, kritik konstruktif, dan saran untuk kemajuan tata kelola dan layanan digital AMIK Taruna
        </p>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4 border border-emerald-400 bg-emerald-950/80 text-emerald-200 rounded-3">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button
            type="button"
            class="btn-close btn-close-white"
            data-bs-dismiss="alert">
        </button>
    </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-kritiksaran border-0 shadow-lg p-3 p-sm-4">
                <div class="card-body p-4 p-sm-5">

                    <form action="{{ route('kritiksaran.store') }}" method="POST" id="formKritikSaran">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap Anda" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Alamat Email</label>
                            <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Judul Masukan / Topik</label>
                            <input type="text" name="judul" class="form-control" placeholder="Contoh: Saran Fasilitas Laboratorium / Portal Kampus" required>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-semibold">Pesan Kritik / Saran</label>
                            <textarea name="pesan" rows="5" class="form-control" placeholder="Tuliskan kritik atau saran Anda secara rinci di sini..." required></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill fw-bold py-3 shadow-md">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Masukan Sekarang
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card-kritiksaran {
    background: rgba(8, 38, 24, 0.88);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(74, 222, 128, 0.25) !important;
    border-radius: 28px;
    box-shadow: 0 16px 40px -4px rgba(0, 0, 0, 0.5);
}

.card-kritiksaran .form-label {
    color: #e2e8f0;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.card-kritiksaran .form-control {
    background: rgba(4, 24, 15, 0.85);
    border: 1px solid rgba(74, 222, 128, 0.22);
    color: #ffffff;
    padding: 12px 18px;
    border-radius: 14px;
    font-size: 0.95rem;
    transition: all 0.25s ease;
}

.card-kritiksaran .form-control::placeholder {
    color: #64748b;
}

.card-kritiksaran .form-control:focus {
    background: rgba(6, 32, 20, 0.95);
    border-color: #4ade80;
    color: #ffffff;
    box-shadow: 0 0 0 4px rgba(74, 222, 128, 0.2);
}
</style>

@endsection

@push('scripts')
<!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#198754',
        confirmButtonText: 'OK',
        backdrop: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Kosongkan form setelah popup OK (opsional)
            document.getElementById('formKritikSaran')?.reset();
        }
    });
</script>
@endif

@if($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal mengirim',
        text: '{{ $errors->first() }}',
        confirmButtonColor: '#d33'
    });
</script>
@endif
@endpush