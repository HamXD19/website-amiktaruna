@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-lg rounded-4" style="background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1 text-white">
                            📋 Kritik & Saran
                        </h3>
                        <p class="text-white-50 mb-0">
                            Daftar masukan dari pengunjung website
                        </p>
                    </div>
                    <div>
                        <span class="badge bg-light text-success fs-6 px-3 py-2 shadow-sm rounded-pill">
                            🧾 Total : {{ $data->count() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th width="50">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Judul</th>
                            <th width="120">Pesan</th>
                            <th width="160">Tanggal</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <td class="text-center fw-bold">
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                <strong>{{ $item->nama }}</strong>
                            </td>
                            <td>
                                {{ $item->email ?? '-' }}
                            </td>
                            <td>
                                <span class="badge bg-success text-white px-3 py-2 rounded-pill">
                                    {{ $item->judul }}
                                </span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-outline-success btn-sm rounded-pill px-3"
                                        data-bs-toggle="modal"
                                        data-bs-target="#pesan{{ $item->id }}">
                                    👁️ Lihat Pesan
                                </button>
                            </td>
                            <td class="text-muted small">
                                <i class="bi bi-calendar3"></i> {{ $item->created_at->format('d M Y') }}
                                <br>
                                <i class="bi bi-clock"></i> {{ $item->created_at->format('H:i') }}
                            </td>
                            <td class="text-center">
                                <button type="button"
                                        class="btn btn-danger btn-sm rounded-pill px-3"
                                        onclick="confirmDelete({{ $item->id }}, '{{ $item->nama }}')">
                                    🗑️ Hapus
                                </button>

                                <form id="delete-form-{{ $item->id }}"
                                      action="{{ route('kritiksaran.destroy', $item->id) }}"
                                      method="POST"
                                      style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Lihat Pesan -->
                        <div class="modal fade"
                             id="pesan{{ $item->id }}"
                             tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <div class="modal-header bg-success text-white rounded-top-4">
                                        <h5 class="modal-title fw-bold">
                                            ✉️ Detail Kritik & Saran
                                        </h5>
                                        <button type="button"
                                                class="btn-close btn-close-white"
                                                data-bs-dismiss="modal">
                                        </button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="mb-3 pb-2 border-bottom">
                                            <strong class="text-success">👤 Nama :</strong>
                                            <p class="mt-1 mb-0">{{ $item->nama }}</p>
                                        </div>
                                        <div class="mb-3 pb-2 border-bottom">
                                            <strong class="text-success">📧 Email :</strong>
                                            <p class="mt-1 mb-0">{{ $item->email ?? '-' }}</p>
                                        </div>
                                        <div class="mb-3 pb-2 border-bottom">
                                            <strong class="text-success">📌 Judul :</strong>
                                            <p class="mt-1 mb-0">{{ $item->judul }}</p>
                                        </div>
                                        <div>
                                            <strong class="text-success">💬 Pesan :</strong>
                                            <div class="border rounded-4 p-3 mt-2 bg-light shadow-sm">
                                                {{ $item->pesan }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button"
                                                class="btn btn-secondary rounded-pill px-4"
                                                data-bs-dismiss="modal">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox fs-1"></i>
                                    <p class="mt-2">Belum ada kritik dan saran.</p>
                                </div>
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

@push('scripts')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<script>
    // Fungsi konfirmasi hapus dengan SweetAlert
    function confirmDelete(id, nama) {
        Swal.fire({
            title: 'Hapus Kritik & Saran?',
            html: `Yakin ingin menghapus pesan dari <strong>${nama}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form delete
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }

    // Notifikasi sukses dari session
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#2ecc71',
        confirmButtonText: 'OK',
        timer: 3000,
        showConfirmButton: true
    });
    @endif

    // Notifikasi error jika ada
    @if($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ $errors->first() }}',
        confirmButtonColor: '#d33'
    });
    @endif
</script>
@endpush