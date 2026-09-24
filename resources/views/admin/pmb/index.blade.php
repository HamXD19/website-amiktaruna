@extends('layouts.app')

@section('title', 'Kelola PMB Dinamis')

@section('content')
<div class="container-fluid px-0">

    <!-- HEADER -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 mb-2 rounded-pill bg-emerald-100 text-emerald-800 fw-bold small border border-emerald-200">
                <i class="fas fa-sliders"></i> Panel Pengaturan Full Dinamis
            </div>
            <h3 class="fw-bold text-dark mb-1">
                Kelola Penerimaan Mahasiswa Baru (PMB)
            </h3>
            <p class="text-muted small mb-0">
                Ubah seluruh teks, jalur seleksi, alur pendaftaran, jadwal gelombang, syarat berkas, dan FAQ PMB secara dinamis.
            </p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('beritapmb.index') }}" class="btn btn-outline-success rounded-3 shadow-sm">
                <i class="fas fa-bullhorn me-1"></i> Kelola Berita PMB
            </a>
            <a href="{{ route('pmb.frontend') }}" target="_blank" class="btn btn-emerald text-white rounded-3 shadow-sm" style="background-color: #059669;">
                <i class="fas fa-external-link-alt me-1"></i> Lihat Halaman PMB
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4 border-0">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger rounded-3 shadow-sm mb-4 border-0">
            <div class="fw-bold mb-1"><i class="fas fa-exclamation-triangle me-2"></i> Mohon periksa kembali isian:</div>
            <ul class="mb-0 small ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('pmb.store') }}" enctype="multipart/form-data" id="formAdminPmb">
        @csrf

        <!-- CARD TABS NAVIGATION -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white border-bottom p-0">
                <ul class="nav nav-tabs card-header-tabs m-0 border-0" id="pmbTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active py-3 px-4 fw-bold" id="tab-hero-btn" data-bs-toggle="tab" data-bs-target="#tab-hero" type="button" role="tab">
                            <i class="fas fa-bullseye text-emerald-600 me-2"></i> 1. Informasi Utama &amp; Gelombang
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link py-3 px-4 fw-bold text-dark" id="tab-jalur-btn" data-bs-toggle="tab" data-bs-target="#tab-jalur" type="button" role="tab">
                            <i class="fas fa-road text-primary me-2"></i> 2. Jalur Pendaftaran
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link py-3 px-4 fw-bold text-dark" id="tab-alur-btn" data-bs-toggle="tab" data-bs-target="#tab-alur" type="button" role="tab">
                            <i class="fas fa-list-ol text-warning me-2"></i> 3. Alur 4 Langkah
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link py-3 px-4 fw-bold text-dark" id="tab-jadwal-btn" data-bs-toggle="tab" data-bs-target="#tab-jadwal" type="button" role="tab">
                            <i class="far fa-calendar-alt text-danger me-2"></i> 4. Jadwal &amp; Syarat Berkas
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link py-3 px-4 fw-bold text-dark" id="tab-faq-btn" data-bs-toggle="tab" data-bs-target="#tab-faq" type="button" role="tab">
                            <i class="fas fa-circle-question text-info me-2"></i> 5. Tanya Jawab (FAQ)
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4 p-md-5">
                <div class="tab-content" id="pmbTabsContent">

                    <!-- ========================================================
                         TAB 1: INFORMASI UTAMA & HERO GELOMBANG
                    ======================================================== -->
                    <div class="tab-pane fade show active" id="tab-hero" role="tabpanel">
                        <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom">Informasi Header &amp; Live Status Gelombang</h5>

                        <div class="row g-4">
                            <div class="col-md-8">
                                <label class="form-label fw-bold small text-dark">Judul Utama PMB <span class="text-danger">*</span></label>
                                <input type="text" name="judul" class="form-control rounded-3" value="{{ old('judul', $pmb->judul ?? '') }}" required placeholder="Contoh: Penerimaan Mahasiswa Baru AMIK Taruna">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-dark">Nama Gelombang Aktif</label>
                                <input type="text" name="nama_gelombang" class="form-control rounded-3" value="{{ old('nama_gelombang', $pmb->nama_gelombang ?? 'Gelombang 2') }}" placeholder="Contoh: Gelombang 2">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-dark">Subjudul / Tagline Promosi</label>
                                <input type="text" name="subjudul" class="form-control rounded-3" value="{{ old('subjudul', $pmb->subjudul ?? '') }}" placeholder="Contoh: Kuliah Vokasi D3 Praktis Siap Kerja di Bidang Teknologi Informasi">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-dark">Deskripsi Lengkap PMB <span class="text-danger">*</span></label>
                                <textarea name="deskripsi" rows="4" class="form-control rounded-3" required placeholder="Jelaskan gambaran umum perkuliahan, keunggulan kampus, dan ajakan mendaftar...">{{ old('deskripsi', $pmb->deskripsi ?? '') }}</textarea>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-dark">Status Gelombang</label>
                                <input type="text" name="status_gelombang" class="form-control rounded-3" value="{{ old('status_gelombang', $pmb->status_gelombang ?? 'Sedang Berlangsung') }}" placeholder="Contoh: Sedang Berlangsung / Dibuka">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-dark">Periode Gelombang</label>
                                <input type="text" name="periode_gelombang" class="form-control rounded-3" value="{{ old('periode_gelombang', $pmb->periode_gelombang ?? 'Mei s/d Juli 2026') }}" placeholder="Contoh: Mei s/d Juli 2026">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-dark">Info Kuota / Beasiswa</label>
                                <input type="text" name="kuota_info" class="form-control rounded-3" value="{{ old('kuota_info', $pmb->kuota_info ?? 'Tersedia 50 Kuota Beasiswa KIP Kuliah 100% Gratis') }}" placeholder="Contoh: Tersedia 50 Kuota Beasiswa KIP Kuliah 100% Gratis">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark">Tautan Portal / Formulir Pendaftaran Online</label>
                                <input type="text" name="link_portal" class="form-control rounded-3" value="{{ old('link_portal', $pmb->link_portal ?? '') }}" placeholder="Contoh: https://pmb.amiktaruna.ac.id/daftar">
                                <small class="text-muted" style="font-size: 11px;">Tautan tujuan ketika pengunjung mengklik tombol "Daftar Online Sekarang".</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark">Nomor WhatsApp Panitia PMB</label>
                                <input type="text" name="no_whatsapp" class="form-control rounded-3" value="{{ old('no_whatsapp', $pmb->no_whatsapp ?? '') }}" placeholder="Contoh: 081234567890">
                                <small class="text-muted" style="font-size: 11px;">Digunakan untuk tombol "Konsultasi WhatsApp". Kosongkan jika ingin mengikuti pengaturan umum website.</small>
                            </div>

                            <div class="col-md-12">
                                <div class="p-3.5 rounded-3 border bg-light">
                                    <label class="form-label fw-bold small text-dark d-block">
                                        <i class="fas fa-file-pdf text-danger me-1"></i> File Brosur / Panduan PMB (PDF, DOC, DOCX, Gambar)
                                    </label>
                                    @if(!empty($pmb->brosur_file))
                                        <div class="mb-2 d-flex align-items-center gap-2">
                                            <a href="{{ asset('uploads/pmb/' . $pmb->brosur_file) }}" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                <i class="fas fa-eye me-1"></i> Lihat File Saat Ini: {{ $pmb->brosur_file }}
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" name="brosur_file" class="form-control rounded-3" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/*">
                                    <small class="text-muted" style="font-size: 11px;">Format berkas wajib: <strong>PDF, DOC, DOCX</strong> atau Gambar (Maks. 30MB).</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ========================================================
                         TAB 2: JALUR PENDAFTARAN (ADMISSION TRACKS)
                    ======================================================== -->
                    <div class="tab-pane fade" id="tab-jalur" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">Pilihan Jalur Penerimaan (Admission Tracks)</h5>
                                <p class="text-muted small mb-0">Kelola daftar jalur seleksi yang tampil pada kartu di halaman publik PMB.</p>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="addJalurItem()">
                                <i class="fas fa-plus me-1"></i> Tambah Jalur
                            </button>
                        </div>

                        <div id="jalurContainer" class="space-y-4">
                            @php
                                $jalurList = $pmb->jalur_pendaftaran ?? [];
                            @endphp
                            @foreach($jalurList as $idx => $j)
                                <div class="card border rounded-3 p-3 mb-3 bg-light jalur-row">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-secondary rounded-pill">Jalur #{{ $idx + 1 }}</span>
                                        <button type="button" class="btn btn-sm text-danger p-0" onclick="this.closest('.jalur-row').remove()">
                                            <i class="fas fa-trash-alt me-1"></i> Hapus
                                        </button>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-md-5">
                                            <label class="small fw-bold">Nama Jalur</label>
                                            <input type="text" name="jalur[{{ $idx }}][nama]" class="form-control form-control-sm rounded-2" value="{{ $j['nama'] ?? '' }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="small fw-bold">Lencana / Badge</label>
                                            <input type="text" name="jalur[{{ $idx }}][badge]" class="form-control form-control-sm rounded-2" value="{{ $j['badge'] ?? '' }}" placeholder="Contoh: KUOTA TERBATAS / BEBAS TES">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small fw-bold">Ikon FontAwesome</label>
                                            <input type="text" name="jalur[{{ $idx }}][ikon]" class="form-control form-control-sm rounded-2" value="{{ $j['ikon'] ?? 'fas fa-graduation-cap' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small fw-bold">Deskripsi Singkat</label>
                                            <textarea name="jalur[{{ $idx }}][deskripsi]" rows="2" class="form-control form-control-sm rounded-2">{{ $j['deskripsi'] ?? '' }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small fw-bold">Poin Syarat (Pisahkan dengan koma)</label>
                                            <textarea name="jalur[{{ $idx }}][syarat]" rows="2" class="form-control form-control-sm rounded-2" placeholder="Contoh: Memiliki KIP, Lulusan 2024-2026, Wawancara">{{ $j['syarat'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- ========================================================
                         TAB 3: ALUR PENDAFTARAN (STEP FLOW)
                    ======================================================== -->
                    <div class="tab-pane fade" id="tab-alur" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">Tahapan / Alur Pendaftaran Calon Mahasiswa</h5>
                                <p class="text-muted small mb-0">Ubah tahapan registrasi langkah demi langkah yang ditampilkan kepada pengunjung.</p>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="addAlurItem()">
                                <i class="fas fa-plus me-1"></i> Tambah Langkah
                            </button>
                        </div>

                        <div id="alurContainer">
                            @php
                                $alurList = $pmb->alur_pendaftaran ?? [];
                            @endphp
                            @foreach($alurList as $idx => $a)
                                <div class="card border rounded-3 p-3 mb-3 bg-light alur-row">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-secondary rounded-pill">Langkah #{{ $idx + 1 }}</span>
                                        <button type="button" class="btn btn-sm text-danger p-0" onclick="this.closest('.alur-row').remove()">
                                            <i class="fas fa-trash-alt me-1"></i> Hapus
                                        </button>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-md-2">
                                            <label class="small fw-bold">Nomor</label>
                                            <input type="text" name="alur[{{ $idx }}][langkah]" class="form-control form-control-sm rounded-2" value="{{ $a['langkah'] ?? ($idx + 1) }}">
                                        </div>
                                        <div class="col-md-10">
                                            <label class="small fw-bold">Judul Tahapan</label>
                                            <input type="text" name="alur[{{ $idx }}][judul]" class="form-control form-control-sm rounded-2" value="{{ $a['judul'] ?? '' }}" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="small fw-bold">Deskripsi Tahapan</label>
                                            <textarea name="alur[{{ $idx }}][deskripsi]" rows="2" class="form-control form-control-sm rounded-2">{{ $a['deskripsi'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- ========================================================
                         TAB 4: JADWAL & SYARAT BERKAS
                    ======================================================== -->
                    <div class="tab-pane fade" id="tab-jadwal" role="tabpanel">
                        
                        <!-- BAGIAN JADWAL GELOMBANG -->
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">Timeline &amp; Jadwal Gelombang</h5>
                                <p class="text-muted small mb-0">Atur periode dan status tiap gelombang PMB.</p>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="addJadwalItem()">
                                <i class="fas fa-plus me-1"></i> Tambah Gelombang
                            </button>
                        </div>

                        <div id="jadwalContainer" class="mb-5">
                            @php
                                $jadwalList = $pmb->jadwal_gelombang ?? [];
                            @endphp
                            @foreach($jadwalList as $idx => $jd)
                                <div class="card border rounded-3 p-3 mb-3 bg-light jadwal-row">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-secondary rounded-pill">Gelombang #{{ $idx + 1 }}</span>
                                        <button type="button" class="btn btn-sm text-danger p-0" onclick="this.closest('.jadwal-row').remove()">
                                            <i class="fas fa-trash-alt me-1"></i> Hapus
                                        </button>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-md-5">
                                            <label class="small fw-bold">Nama Gelombang</label>
                                            <input type="text" name="jadwal[{{ $idx }}][nama]" class="form-control form-control-sm rounded-2" value="{{ $jd['nama'] ?? '' }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="small fw-bold">Periode Bulan/Tahun</label>
                                            <input type="text" name="jadwal[{{ $idx }}][periode]" class="form-control form-control-sm rounded-2" value="{{ $jd['periode'] ?? '' }}" placeholder="Contoh: Mei s/d Juli 2026">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small fw-bold">Status Badge</label>
                                            <input type="text" name="jadwal[{{ $idx }}][status]" class="form-control form-control-sm rounded-2" value="{{ $jd['status'] ?? 'Sedang Berlangsung' }}" placeholder="Selesai / Sedang Berlangsung / Mendatang">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="small fw-bold">Keterangan Tambahan</label>
                                            <input type="text" name="jadwal[{{ $idx }}][keterangan]" class="form-control form-control-sm rounded-2" value="{{ $jd['keterangan'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- BAGIAN PERSYARATAN BERKAS -->
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">Daftar Dokumen Persyaratan Pendaftaran</h5>
                                <p class="text-muted small mb-0">Checklist berkas yang wajib dipersiapkan calon pendaftar.</p>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="addSyaratItem()">
                                <i class="fas fa-plus me-1"></i> Tambah Dokumen
                            </button>
                        </div>

                        <div id="syaratContainer">
                            @php
                                $syaratList = $pmb->persyaratan_berkas ?? [];
                            @endphp
                            @foreach($syaratList as $idx => $sb)
                                <div class="card border rounded-3 p-3 mb-3 bg-light syarat-row">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-secondary rounded-pill">Dokumen #{{ $idx + 1 }}</span>
                                        <button type="button" class="btn btn-sm text-danger p-0" onclick="this.closest('.syarat-row').remove()">
                                            <i class="fas fa-trash-alt me-1"></i> Hapus
                                        </button>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <label class="small fw-bold">Nama Berkas</label>
                                            <input type="text" name="syarat_berkas[{{ $idx }}][judul]" class="form-control form-control-sm rounded-2" value="{{ $sb['judul'] ?? '' }}" required>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="small fw-bold">Keterangan / Panduan</label>
                                            <input type="text" name="syarat_berkas[{{ $idx }}][keterangan]" class="form-control form-control-sm rounded-2" value="{{ $sb['keterangan'] ?? '' }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small fw-bold">Ikon FontAwesome</label>
                                            <input type="text" name="syarat_berkas[{{ $idx }}][ikon]" class="form-control form-control-sm rounded-2" value="{{ $sb['ikon'] ?? 'fas fa-file-alt' }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                    <!-- ========================================================
                         TAB 5: TANYA JAWAB (FAQ PMB)
                    ======================================================== -->
                    <div class="tab-pane fade" id="tab-faq" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">Pertanyaan Umum Seputar PMB (FAQ)</h5>
                                <p class="text-muted small mb-0">Kelola tanya jawab yang tampil pada accordion di halaman publik PMB.</p>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="addFaqItem()">
                                <i class="fas fa-plus me-1"></i> Tambah Pertanyaan
                            </button>
                        </div>

                        <div id="faqContainer">
                            @php
                                $faqList = $pmb->faq_list ?? [];
                            @endphp
                            @foreach($faqList as $idx => $f)
                                <div class="card border rounded-3 p-3 mb-3 bg-light faq-row">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-secondary rounded-pill">Tanya Jawab #{{ $idx + 1 }}</span>
                                        <button type="button" class="btn btn-sm text-danger p-0" onclick="this.closest('.faq-row').remove()">
                                            <i class="fas fa-trash-alt me-1"></i> Hapus
                                        </button>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-md-12">
                                            <label class="small fw-bold">Pertanyaan (Question)</label>
                                            <input type="text" name="faq[{{ $idx }}][tanya]" class="form-control form-control-sm rounded-2" value="{{ $f['tanya'] ?? '' }}" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="small fw-bold">Jawaban Lengkap (Answer)</label>
                                            <textarea name="faq[{{ $idx }}][jawab]" rows="3" class="form-control form-control-sm rounded-2" required>{{ $f['jawab'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

            <!-- CARD FOOTER SUBMIT -->
            <div class="card-footer bg-white border-top p-3.5 d-flex justify-content-between align-items-center">
                <span class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i> Seluruh perubahan akan langsung diterapkan pada halaman publik PMB.
                </span>
                <button type="submit" class="btn btn-success rounded-pill px-5 py-2.5 fw-bold shadow-sm" style="background-color: #059669;">
                    <i class="fas fa-save me-1"></i> Simpan Semua Pengaturan PMB
                </button>
            </div>
        </div>

    </form>

</div>

<script>
let jalurIndex = {{ count($pmb->jalur_pendaftaran ?? []) }};
function addJalurItem() {
    const container = document.getElementById('jalurContainer');
    const html = `
        <div class="card border rounded-3 p-3 mb-3 bg-light jalur-row">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-secondary rounded-pill">Jalur Baru</span>
                <button type="button" class="btn btn-sm text-danger p-0" onclick="this.closest('.jalur-row').remove()">
                    <i class="fas fa-trash-alt me-1"></i> Hapus
                </button>
            </div>
            <div class="row g-2">
                <div class="col-md-5">
                    <label class="small fw-bold">Nama Jalur</label>
                    <input type="text" name="jalur[${jalurIndex}][nama]" class="form-control form-control-sm rounded-2" placeholder="Nama Jalur Pendaftaran" required>
                </div>
                <div class="col-md-4">
                    <label class="small fw-bold">Lencana / Badge</label>
                    <input type="text" name="jalur[${jalurIndex}][badge]" class="form-control form-control-sm rounded-2" placeholder="Contoh: BEBAS TES">
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold">Ikon FontAwesome</label>
                    <input type="text" name="jalur[${jalurIndex}][ikon]" class="form-control form-control-sm rounded-2" value="fas fa-graduation-cap">
                </div>
                <div class="col-md-6">
                    <label class="small fw-bold">Deskripsi Singkat</label>
                    <textarea name="jalur[${jalurIndex}][deskripsi]" rows="2" class="form-control form-control-sm rounded-2" placeholder="Penjelasan keunggulan jalur ini..."></textarea>
                </div>
                <div class="col-md-6">
                    <label class="small fw-bold">Poin Syarat (Pisahkan koma)</label>
                    <textarea name="jalur[${jalurIndex}][syarat]" rows="2" class="form-control form-control-sm rounded-2" placeholder="Syarat 1, Syarat 2, Syarat 3"></textarea>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    jalurIndex++;
}

let alurIndex = {{ count($pmb->alur_pendaftaran ?? []) }};
function addAlurItem() {
    const container = document.getElementById('alurContainer');
    const html = `
        <div class="card border rounded-3 p-3 mb-3 bg-light alur-row">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-secondary rounded-pill">Langkah Baru</span>
                <button type="button" class="btn btn-sm text-danger p-0" onclick="this.closest('.alur-row').remove()">
                    <i class="fas fa-trash-alt me-1"></i> Hapus
                </button>
            </div>
            <div class="row g-2">
                <div class="col-md-2">
                    <label class="small fw-bold">Nomor</label>
                    <input type="text" name="alur[${alurIndex}][langkah]" class="form-control form-control-sm rounded-2" value="${alurIndex + 1}">
                </div>
                <div class="col-md-10">
                    <label class="small fw-bold">Judul Tahapan</label>
                    <input type="text" name="alur[${alurIndex}][judul]" class="form-control form-control-sm rounded-2" placeholder="Judul Langkah Pendaftaran" required>
                </div>
                <div class="col-md-12">
                    <label class="small fw-bold">Deskripsi Tahapan</label>
                    <textarea name="alur[${alurIndex}][deskripsi]" rows="2" class="form-control form-control-sm rounded-2" placeholder="Penjelasan yang perlu dilakukan calon pendaftar..."></textarea>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    alurIndex++;
}

let jadwalIndex = {{ count($pmb->jadwal_gelombang ?? []) }};
function addJadwalItem() {
    const container = document.getElementById('jadwalContainer');
    const html = `
        <div class="card border rounded-3 p-3 mb-3 bg-light jadwal-row">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-secondary rounded-pill">Gelombang Baru</span>
                <button type="button" class="btn btn-sm text-danger p-0" onclick="this.closest('.jadwal-row').remove()">
                    <i class="fas fa-trash-alt me-1"></i> Hapus
                </button>
            </div>
            <div class="row g-2">
                <div class="col-md-5">
                    <label class="small fw-bold">Nama Gelombang</label>
                    <input type="text" name="jadwal[${jadwalIndex}][nama]" class="form-control form-control-sm rounded-2" placeholder="Nama Gelombang" required>
                </div>
                <div class="col-md-4">
                    <label class="small fw-bold">Periode Bulan/Tahun</label>
                    <input type="text" name="jadwal[${jadwalIndex}][periode]" class="form-control form-control-sm rounded-2" placeholder="Contoh: Mei s/d Juli 2026">
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold">Status Badge</label>
                    <input type="text" name="jadwal[${jadwalIndex}][status]" class="form-control form-control-sm rounded-2" value="Sedang Berlangsung">
                </div>
                <div class="col-md-12">
                    <label class="small fw-bold">Keterangan Tambahan</label>
                    <input type="text" name="jadwal[${jadwalIndex}][keterangan]" class="form-control form-control-sm rounded-2">
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    jadwalIndex++;
}

let syaratIndex = {{ count($pmb->persyaratan_berkas ?? []) }};
function addSyaratItem() {
    const container = document.getElementById('syaratContainer');
    const html = `
        <div class="card border rounded-3 p-3 mb-3 bg-light syarat-row">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-secondary rounded-pill">Dokumen Baru</span>
                <button type="button" class="btn btn-sm text-danger p-0" onclick="this.closest('.syarat-row').remove()">
                    <i class="fas fa-trash-alt me-1"></i> Hapus
                </button>
            </div>
            <div class="row g-2">
                <div class="col-md-4">
                    <label class="small fw-bold">Nama Berkas</label>
                    <input type="text" name="syarat_berkas[${syaratIndex}][judul]" class="form-control form-control-sm rounded-2" placeholder="Nama Berkas Dokumen" required>
                </div>
                <div class="col-md-5">
                    <label class="small fw-bold">Keterangan / Panduan</label>
                    <input type="text" name="syarat_berkas[${syaratIndex}][keterangan]" class="form-control form-control-sm rounded-2" placeholder="Keterangan dokumen...">
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold">Ikon FontAwesome</label>
                    <input type="text" name="syarat_berkas[${syaratIndex}][ikon]" class="form-control form-control-sm rounded-2" value="fas fa-file-alt">
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    syaratIndex++;
}

let faqIndex = {{ count($pmb->faq_list ?? []) }};
function addFaqItem() {
    const container = document.getElementById('faqContainer');
    const html = `
        <div class="card border rounded-3 p-3 mb-3 bg-light faq-row">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-secondary rounded-pill">Tanya Jawab Baru</span>
                <button type="button" class="btn btn-sm text-danger p-0" onclick="this.closest('.faq-row').remove()">
                    <i class="fas fa-trash-alt me-1"></i> Hapus
                </button>
            </div>
            <div class="row g-2">
                <div class="col-md-12">
                    <label class="small fw-bold">Pertanyaan (Question)</label>
                    <input type="text" name="faq[${faqIndex}][tanya]" class="form-control form-control-sm rounded-2" placeholder="Masukkan pertanyaan calon mahasiswa..." required>
                </div>
                <div class="col-md-12">
                    <label class="small fw-bold">Jawaban Lengkap (Answer)</label>
                    <textarea name="faq[${faqIndex}][jawab]" rows="3" class="form-control form-control-sm rounded-2" placeholder="Jawaban rinci..." required></textarea>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    faqIndex++;
}
</script>
@endsection
