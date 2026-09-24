@extends('layouts.app')

@section('title', 'Detail Laporan ' . $laporan->kode_tiket)

@section('content')
<div class="container-fluid px-0">

    <!-- HEADER -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <a href="{{ route('admin.ppks.index') }}" class="text-decoration-none text-muted small fw-semibold d-inline-flex align-items-center gap-1 mb-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Laporan
            </a>
            <div class="d-flex align-items-center gap-3">
                <h3 class="fw-bold text-dark mb-0">
                    Laporan {{ $laporan->kode_tiket }}
                </h3>
                @if($laporan->status == 'baru')
                    <span class="badge bg-danger rounded-pill px-3 py-1.5">Baru Masuk</span>
                @elseif($laporan->status == 'ditinjau')
                    <span class="badge bg-warning text-dark rounded-pill px-3 py-1.5">Sedang Ditinjau</span>
                @elseif($laporan->status == 'investigasi')
                    <span class="badge bg-primary rounded-pill px-3 py-1.5">Tahap Investigasi</span>
                @elseif($laporan->status == 'selesai')
                    <span class="badge bg-success rounded-pill px-3 py-1.5">Selesai Ditangani</span>
                @endif
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span class="text-muted small">
                Masuk pada: {{ $laporan->created_at->translatedFormat('d F Y, H:i') }} WIB
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4 border-0">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        
        <!-- KOLOM KIRI: DETAIL LAPORAN & KRONOLOGI -->
        <div class="col-lg-8">
            
            <!-- CARD IDENTITAS & KATEGORI -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fas fa-shield-alt text-emerald-600"></i> Informasi Pelapor &amp; Kejadian
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">Identitas Pelapor:</span>
                            @if($laporan->is_anonim)
                                <span class="fw-bold text-danger">
                                    <i class="fas fa-user-secret me-1"></i> Anonim (Dirahasiakan)
                                </span>
                            @else
                                <span class="fw-bold text-dark">{{ $laporan->nama_pelapor }}</span>
                            @endif
                            <small class="text-muted d-block">Status: {{ $laporan->status_pelapor }}</small>
                        </div>

                        <div class="col-sm-6">
                            <span class="text-muted small d-block">Kontak Rahasia:</span>
                            <span class="fw-bold text-dark d-block">
                                <i class="fab fa-whatsapp text-success me-1"></i> {{ $laporan->no_telp }}
                            </span>
                            @if($laporan->email)
                                <small class="text-muted d-block">{{ $laporan->email }}</small>
                            @endif
                        </div>

                        <div class="col-sm-6">
                            <span class="text-muted small d-block">Kategori Kekerasan:</span>
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1 fw-bold">
                                {{ $laporan->kategori_kekerasan }}
                            </span>
                        </div>

                        <div class="col-sm-6">
                            <span class="text-muted small d-block">Pihak Terlapor:</span>
                            <span class="fw-bold text-dark">
                                {{ $laporan->nama_terlapor ?: '- Tidak disebutkan / anonim -' }}
                            </span>
                        </div>

                        <div class="col-sm-6">
                            <span class="text-muted small d-block">Waktu Kejadian:</span>
                            <span class="text-dark fw-semibold">
                                {{ $laporan->tanggal_kejadian ? $laporan->tanggal_kejadian->translatedFormat('d F Y') : '- Tidak ditentukan -' }}
                            </span>
                        </div>

                        <div class="col-sm-6">
                            <span class="text-muted small d-block">Lokasi Kejadian:</span>
                            <span class="text-dark fw-semibold">
                                {{ $laporan->lokasi_kejadian ?: '- Tidak disebutkan -' }}
                            </span>
                        </div>

                        @if($laporan->kebutuhan_pendampingan)
                            <div class="col-12">
                                <span class="text-muted small d-block mb-1">Permintaan Bantuan / Pendampingan:</span>
                                <div class="d-flex flex-wrap gap-1.5">
                                    @foreach(explode(', ', $laporan->kebutuhan_pendampingan) as $butuh)
                                        <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle rounded-pill px-2.5 py-1">
                                            <i class="fas fa-hand-holding-heart me-1"></i> {{ $butuh }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- CARD KRONOLOGI KEJADIAN -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fas fa-align-left text-primary"></i> Kronologi Kejadian Lengkap
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="p-3.5 rounded-3 bg-light text-dark leading-relaxed" style="white-space: pre-line; font-size: 0.95rem;">
                        {{ $laporan->kronologi }}
                    </div>
                </div>
            </div>

            <!-- CARD DOKUMEN LAMPIRAN BUKTI -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fas fa-paperclip text-danger"></i> Dokumen Lampiran Bukti
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($laporan->dokumen_bukti)
                        <div class="p-3 rounded-3 border border-emerald-200 bg-emerald-50/50 d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="w-12 h-12 rounded-3 bg-white border d-flex align-items-center justify-content-center fs-4 text-danger shadow-xs" style="width: 46px; height: 46px;">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div>
                                    <span class="fw-bold text-dark d-block">
                                        {{ $laporan->dokumen_bukti }}
                                    </span>
                                    <span class="text-muted small">Berkas Bukti Resmi Dilampirkan Pelapor</span>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ asset('uploads/ppks/' . $laporan->dokumen_bukti) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                    <i class="fas fa-eye me-1"></i> Lihat Berkas
                                </a>
                                <a href="{{ asset('uploads/ppks/' . $laporan->dokumen_bukti) }}" download class="btn btn-success btn-sm rounded-pill px-3">
                                    <i class="fas fa-download me-1"></i> Unduh Dokumen
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-3 text-muted">
                            <i class="fas fa-file-slash fa-2x mb-2 opacity-50"></i>
                            <p class="small mb-0">Tidak ada berkas bukti yang dilampirkan pada laporan ini.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- KOLOM KANAN: STATUS & CATATAN TINDAK LANJUT -->
        <div class="col-lg-4">
            
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fas fa-sliders text-warning"></i> Tindak Lanjut Satgas
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.ppks.status', $laporan->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Perbarui Status Penanganan:</label>
                            <select name="status" class="form-select rounded-3" required>
                                <option value="baru" {{ $laporan->status == 'baru' ? 'selected' : '' }}>🔴 Baru Masuk</option>
                                <option value="ditinjau" {{ $laporan->status == 'ditinjau' ? 'selected' : '' }}>🟡 Sedang Ditinjau</option>
                                <option value="investigasi" {{ $laporan->status == 'investigasi' ? 'selected' : '' }}>🟠 Tahap Investigasi & Mediasi</option>
                                <option value="selesai" {{ $laporan->status == 'selesai' ? 'selected' : '' }}>🟢 Selesai / Dituntaskan</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Catatan Rahasia Petugas / Satgas:</label>
                            <textarea name="catatan_petugas" rows="5" class="form-control rounded-3" placeholder="Tuliskan catatan tindak lanjut internal Satgas (misal: telah dikontak via WA, dijadwalkan konseling psikolog, klarifikasi terlapor)...">{{ old('catatan_petugas', $laporan->catatan_petugas) }}</textarea>
                            <small class="text-muted" style="font-size: 11px;">Catatan ini hanya terlihat oleh pengelola admin Satgas PPKS.</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2.5 fw-bold shadow-sm">
                            <i class="fas fa-save me-1"></i> Simpan Pembaruan Status
                        </button>
                    </form>

                    <hr class="my-4">

                    <!-- AKSI KONTAK VIA WHATSAPP -->
                    @if($laporan->no_telp)
                        @php
                            $cleanPhone = preg_replace('/[^0-9]/', '', $laporan->no_telp);
                            if (str_starts_with($cleanPhone, '0')) {
                                $cleanPhone = '62' . substr($cleanPhone, 1);
                            }
                            $waMessage = rawurlencode("Halo, kami dari Tim Satgas PPKS AMIK Taruna mengonfirmasi penerimaan laporan Anda dengan kode tiket " . $laporan->kode_tiket . ". Kami siap memberikan ruang aman dan pendampingan.");
                        @endphp
                        <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waMessage }}" target="_blank" class="btn btn-outline-success w-100 rounded-pill py-2 small fw-bold mb-2">
                            <i class="fab fa-whatsapp me-1"></i> Hubungi Pelapor via WA
                        </a>
                    @endif

                    <form action="{{ route('admin.ppks.destroy', $laporan->id) }}" method="POST" onsubmit="return confirm('Peringatan: Menghapus laporan bersifat permanen. Lanjutkan?')" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link text-danger w-100 text-decoration-none small">
                            <i class="fas fa-trash-alt me-1"></i> Hapus Laporan Permanen
                        </button>
                    </form>

                </div>
            </div>

        </div>

    </div>

</div>
@endsection
