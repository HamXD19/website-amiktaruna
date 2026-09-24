@extends('layouts.main')

@section('content')

<style>
    .ppks-hero {
        background: linear-gradient(135deg, rgba(3, 29, 17, 0.95), rgba(6, 44, 27, 0.92));
        border: 1px solid rgba(16, 185, 129, 0.25);
        border-radius: 28px;
        padding: 40px 28px;
        box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.5);
        position: relative;
        overflow: hidden;
    }

    .ppks-hero::before {
        content: '';
        position: absolute;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
        top: -100px;
        right: -80px;
        pointer-events: none;
    }

    .ppks-card {
        background: rgba(4, 26, 16, 0.88);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(16, 185, 129, 0.22);
        border-radius: 24px;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.4);
        color: #f1f5f9;
    }

    .ppks-input, .ppks-select, .ppks-textarea {
        background: rgba(2, 19, 11, 0.85) !important;
        border: 1px solid rgba(16, 185, 129, 0.25) !important;
        color: #ffffff !important;
        border-radius: 12px !important;
        padding: 12px 16px !important;
        font-size: 0.92rem !important;
        transition: all 0.2s ease !important;
    }

    .ppks-input:focus, .ppks-select:focus, .ppks-textarea:focus {
        border-color: #34d399 !important;
        box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.2) !important;
        outline: none !important;
    }

    .ppks-input::placeholder, .ppks-textarea::placeholder {
        color: #94a3b8 !important;
    }

    .ppks-tab-btn {
        padding: 10px 22px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.88rem;
        transition: all 0.25s ease;
        border: 1px solid rgba(16, 185, 129, 0.25);
        color: #cbd5e1;
        background: rgba(2, 20, 12, 0.6);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .ppks-tab-btn:hover {
        color: #ffffff;
        background: rgba(16, 185, 129, 0.2);
        border-color: rgba(16, 185, 129, 0.4);
    }

    .ppks-tab-btn.active {
        color: #022c22 !important;
        background: #34d399 !important;
        border-color: #34d399 !important;
        box-shadow: 0 4px 15px rgba(52, 211, 153, 0.35);
    }

    .ppks-article-card {
        background: rgba(6, 32, 20, 0.85);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .ppks-article-card:hover {
        transform: translateY(-4px);
        border-color: rgba(52, 211, 153, 0.45);
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.4);
    }
</style>

<div class="container py-4 py-lg-5">

    <!-- 1. HERO BANNER -->
    <div class="ppks-hero mb-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 mb-3 rounded-pill bg-emerald-500/20 text-emerald-300 fw-bold small border border-emerald-500/30">
                    <i class="fas fa-shield-alt text-emerald-400"></i> Satgas PPKS AMIK Taruna
                </div>
                <h1 class="fw-bold text-white mb-2" style="font-size: clamp(1.6rem, 3.5vw, 2.4rem); letter-spacing: -0.5px;">
                    Layanan Pencegahan &amp; Penanganan Kekerasan Seksual
                </h1>
                <p class="text-slate-300 mb-0" style="font-size: 0.95rem; line-height: 1.7; max-width: 680px;">
                    Kanal pelaporan resmi, terenkripsi, dan rahasia sesuai <strong>Permendikbudristek No. 30 Tahun 2021</strong>. Kami menjamin perlindungan privasi, keamanan identitas, serta pendampingan psikologis dan pemulihan hak korban.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-inline-flex flex-column align-items-lg-end gap-2 p-3 rounded-2xl bg-black/30 border border-emerald-500/20">
                    <div class="d-flex align-items-center gap-2 text-emerald-300 fw-bold small">
                        <i class="fas fa-lock"></i> Kerahasiaan 100% Terjamin
                    </div>
                    <span class="text-slate-400 small" style="font-size: 11px;">
                        Setiap laporan hanya dapat diakses oleh Tim Satgas PPKS yang tersumpah.
                    </span>
                    <a href="tel:{{ $setting->no_hp ?? '' }}" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1 text-white border-emerald-400/50 mt-1">
                        <i class="fas fa-phone-alt me-1 text-emerald-400"></i> Kontak Darurat
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. TAB NAVIGATION (FORMULIR vs WARTA DOKUMEN) -->
    <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mb-4">
        <button type="button" class="ppks-tab-btn active" id="btnTabForm" onclick="switchPpksTab('form')">
            <i class="fas fa-file-signature"></i>
            <span>Formulir Pelaporan Rahasia</span>
        </button>
        <button type="button" class="ppks-tab-btn" id="btnTabWarta" onclick="switchPpksTab('warta')">
            <i class="fas fa-newspaper"></i>
            <span>Warta, Regulasi &amp; Dokumen PPKS</span>
            @if(count($beritasPPKS) > 0)
                <span class="badge bg-emerald-950 text-emerald-300 border border-emerald-500/30 rounded-pill ms-1">{{ count($beritasPPKS) }}</span>
            @endif
        </button>
    </div>

    <!-- 3. TAB CONTENT 1: FORMULIR PELAPORAN -->
    <div id="tabFormSection">

        @if(session('laporan_sukses'))
            <div class="alert alert-success border border-emerald-400 bg-emerald-950/90 text-white rounded-4 p-4 mb-4 shadow-lg">
                <div class="d-flex align-items-start gap-3">
                    <div class="w-10 h-10 rounded-circle bg-emerald-500 text-black d-flex align-items-center justify-center fs-5 shrink-0 mt-1">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h4 class="fw-bold mb-1 text-emerald-300">Laporan Anda Berhasil Terkirim!</h4>
                        <p class="text-slate-200 mb-2" style="font-size: 0.95rem;">
                            Terima kasih atas keberanian Anda melapor. Tim Satgas PPKS AMIK Taruna akan segera menindaklanjuti laporan ini secara rahasia dan aman.
                        </p>
                        <div class="p-3 bg-black/40 rounded-3 border border-emerald-500/30 d-inline-block">
                            <span class="text-slate-400 small d-block mb-1">Kode Tiket Rahasia Anda:</span>
                            <span class="fs-4 fw-bold text-amber-300 font-monospace">{{ session('kode_tiket') }}</span>
                        </div>
                        <p class="text-slate-300 small mt-2 mb-0">
                            Simpan kode tiket ini untuk memantau proses tindak lanjut bersama Satgas PPKS.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger bg-red-950/80 border border-red-500/40 text-red-200 rounded-3 mb-4">
                <div class="fw-bold mb-1"><i class="fas fa-exclamation-triangle me-2"></i> Mohon lengkapi isian formulir:</div>
                <ul class="mb-0 small ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card ppks-card border-0">
                    <div class="card-body p-4 p-md-5">

                        <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-emerald-500/20">
                            <div>
                                <h2 class="fs-4 fw-bold text-white mb-1">
                                    Formulir Pengaduan Kekerasan &amp; Pelecehan Seksual
                                </h2>
                                <p class="text-slate-400 small mb-0">
                                    Isi data kejadian dengan tenang. Anda memiliki hak penuh untuk menyamarkan identitas (Anonim).
                                </p>
                            </div>
                            <span class="badge bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 px-3 py-2 rounded-pill small">
                                <i class="fas fa-user-shield me-1"></i> Terenkripsi
                            </span>
                        </div>

                        <form action="{{ route('ppks.lapor.store') }}" method="POST" enctype="multipart/form-data" id="formPPKS">
                            @csrf

                            <!-- OPSI ANONIM -->
                            <div class="p-3 mb-4 rounded-3 border border-amber-500/30 bg-amber-950/20">
                                <div class="form-check form-switch d-flex align-items-center gap-3">
                                    <input class="form-check-input fs-5" type="checkbox" role="switch" id="switchAnonim" name="is_anonim" value="1" onchange="toggleAnonimInput(this.checked)" {{ old('is_anonim') ? 'checked' : '' }}>
                                    <label class="form-check-label text-slate-200 fw-semibold" for="switchAnonim">
                                        Laporkan Secara Anonim <span class="text-amber-400 small fw-normal">(Identitas nama Anda tidak akan dicatat)</span>
                                    </label>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <!-- NAMA PELAPOR -->
                                <div class="col-md-6" id="wrapNamaPelapor">
                                    <label class="form-label text-slate-200 fw-semibold small">
                                        Nama Lengkap Pelapor <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama_pelapor" id="inputNamaPelapor" class="form-control ppks-input" placeholder="Masukkan nama Anda" value="{{ old('nama_pelapor') }}">
                                    <small class="text-slate-400" style="font-size: 11px;">Bisa disamarkan jika mengaktifkan opsi anonim di atas.</small>
                                </div>

                                <!-- STATUS PELAPOR -->
                                <div class="col-md-6">
                                    <label class="form-label text-slate-200 fw-semibold small">
                                        Status Sivitas Anda <span class="text-danger">*</span>
                                    </label>
                                    <select name="status_pelapor" class="form-select ppks-select" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Mahasiswa" {{ old('status_pelapor') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa Aktif</option>
                                        <option value="Dosen" {{ old('status_pelapor') == 'Dosen' ? 'selected' : '' }}>Dosen / Tenaga Pendidik</option>
                                        <option value="Tenaga Kependidikan" {{ old('status_pelapor') == 'Tenaga Kependidikan' ? 'selected' : '' }}>Tenaga Kependidikan / Staf</option>
                                        <option value="Alumni" {{ old('status_pelapor') == 'Alumni' ? 'selected' : '' }}>Alumni</option>
                                        <option value="Masyarakat" {{ old('status_pelapor') == 'Masyarakat' ? 'selected' : '' }}>Masyarakat / Tamu Kampus</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <!-- KONTAK WHATSAPP / HP -->
                                <div class="col-md-6">
                                    <label class="form-label text-slate-200 fw-semibold small">
                                        Nomor WhatsApp / Telepon Aktif <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="no_telp" class="form-control ppks-input" placeholder="Contoh: 081234567890" value="{{ old('no_telp') }}" required>
                                    <small class="text-slate-400" style="font-size: 11px;">Hanya digunakan Satgas PPKS untuk konfirmasi &amp; koordinasi rahasia.</small>
                                </div>

                                <!-- EMAIL -->
                                <div class="col-md-6">
                                    <label class="form-label text-slate-200 fw-semibold small">
                                        Alamat Email <span class="text-slate-400 fw-normal">(Opsional)</span>
                                    </label>
                                    <input type="email" name="email" class="form-control ppks-input" placeholder="alamat@email.com" value="{{ old('email') }}">
                                </div>
                            </div>

                            <hr class="border-emerald-500/20 my-4">

                            <!-- KATEGORI KELECEHAN / KEKERASAN -->
                            <div class="mb-3">
                                <label class="form-label text-slate-200 fw-semibold small">
                                    Bentuk / Kategori Kekerasan yang Dilaporkan <span class="text-danger">*</span>
                                </label>
                                <select name="kategori_kekerasan" class="form-select ppks-select" required>
                                    <option value="">-- Pilih Kategori Kejadian --</option>
                                    <option value="Pelecehan Verbal (Catcalling, Komentar Seksual, Lelucon Porno)" {{ old('kategori_kekerasan') == 'Pelecehan Verbal (Catcalling, Komentar Seksual, Lelucon Porno)' ? 'selected' : '' }}>
                                        Pelecehan Verbal (Catcalling, ucapan cabul, rayuan intimidatif)
                                    </option>
                                    <option value="Pelecehan Fisik (Sentuhan, Rabaan, Kontak Fisik Tanpa Persetujuan)" {{ old('kategori_kekerasan') == 'Pelecehan Fisik (Sentuhan, Rabaan, Kontak Fisik Tanpa Persetujuan)' ? 'selected' : '' }}>
                                        Pelecehan Fisik (Sentuhan, rabaan, dekapan tanpa persetujuan)
                                    </option>
                                    <option value="Kekerasan Daring / Siber (Penyebaran Konten Intim, Teror Chat Seksual)" {{ old('kategori_kekerasan') == 'Kekerasan Daring / Siber (Penyebaran Konten Intim, Teror Chat Seksual)' ? 'selected' : '' }}>
                                        Kekerasan Daring / Siber (Penyebaran foto/video intim, teror chat medsos)
                                    </option>
                                    <option value="Intimidasi & Pemaksaan Hubungan Transaksional (Nilai/Jabatan)" {{ old('kategori_kekerasan') == 'Intimidasi & Pemaksaan Hubungan Transaksional (Nilai/Jabatan)' ? 'selected' : '' }}>
                                        Intimidasi &amp; Pemaksaan (Penyalahgunaan wewenang akademis/nilai)
                                    </option>
                                    <option value="Pemaksaan Seksual & Pemerkosaan" {{ old('kategori_kekerasan') == 'Pemaksaan Seksual & Pemerkosaan' ? 'selected' : '' }}>
                                        Pemaksaan Seksual &amp; Pemerkosaan
                                    </option>
                                    <option value="Diskriminasi & Perlakuan Merendahkan Gender" {{ old('kategori_kekerasan') == 'Diskriminasi & Perlakuan Merendahkan Gender' ? 'selected' : '' }}>
                                        Diskriminasi &amp; Perlakuan Merendahkan Martabat Gender
                                    </option>
                                    <option value="Lainnya" {{ old('kategori_kekerasan') == 'Lainnya' ? 'selected' : '' }}>
                                        Bentuk Kekerasan Lainnya
                                    </option>
                                </select>
                            </div>

                            <div class="row g-3 mb-3">
                                <!-- TANGGAL KEJADIAN -->
                                <div class="col-md-6">
                                    <label class="form-label text-slate-200 fw-semibold small">
                                        Tanggal / Perkiraan Waktu Kejadian <span class="text-slate-400 fw-normal">(Opsional)</span>
                                    </label>
                                    <input type="date" name="tanggal_kejadian" class="form-control ppks-input" value="{{ old('tanggal_kejadian') }}">
                                </div>

                                <!-- LOKASI KEJADIAN -->
                                <div class="col-md-6">
                                    <label class="form-label text-slate-200 fw-semibold small">
                                        Lokasi Kejadian <span class="text-slate-400 fw-normal">(Opsional)</span>
                                    </label>
                                    <input type="text" name="lokasi_kejadian" class="form-control ppks-input" placeholder="Contoh: Gedung Lab Komputer, Area Kampus, atau Daring" value="{{ old('lokasi_kejadian') }}">
                                </div>
                            </div>

                            <!-- PIHAK TERLAPOR -->
                            <div class="mb-3">
                                <label class="form-label text-slate-200 fw-semibold small">
                                    Pihak yang Dilaporkan (Terlapor) <span class="text-slate-400 fw-normal">(Jika diketahui / boleh inisial)</span>
                                </label>
                                <input type="text" name="nama_terlapor" class="form-control ppks-input" placeholder="Nama / Inisial / Ciri-ciri terlapor jika Anda mengetahui" value="{{ old('nama_terlapor') }}">
                            </div>

                            <!-- KRONOLOGI -->
                            <div class="mb-4">
                                <label class="form-label text-slate-200 fw-semibold small">
                                    Kronologi Kejadian / Deskripsi Rinci <span class="text-danger">*</span>
                                </label>
                                <textarea name="kronologi" rows="6" class="form-control ppks-textarea" placeholder="Ceritakan secara kronologis apa yang dialami atau disaksikan. Jangan khawatir, cerita Anda berada di ruang yang aman dan terjaga kerahasiaannya." required>{{ old('kronologi') }}</textarea>
                            </div>

                            <!-- LAMPIRAN DOKUMEN / BUKTI -->
                            <div class="mb-4 p-3.5 rounded-3 border border-emerald-500/25 bg-emerald-950/30">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label text-slate-200 fw-semibold small mb-0">
                                        <i class="fas fa-paperclip text-emerald-400 me-1"></i> Lampiran Dokumen Bukti (PDF, DOC, DOCX, Foto)
                                    </label>
                                    <span class="badge bg-emerald-950 text-emerald-300 border border-emerald-500/30 small">Maks. 30MB</span>
                                </div>
                                <input
                                    type="file"
                                    name="dokumen_bukti"
                                    class="form-control ppks-input"
                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/*"
                                >
                                <small class="text-slate-400 mt-1 d-block" style="font-size: 11px;">
                                    Format dokumen wajib: <strong>PDF, DOC, DOCX</strong>, atau gambar bukti (JPG/PNG). Lampiran dapat berupa tangkapan layar percakapan, dokumen surat, atau bukti relevan lainnya.
                                </small>
                            </div>

                            <!-- KEBUTUHAN PENDAMPINGAN -->
                            <div class="mb-4">
                                <label class="form-label text-slate-200 fw-semibold small mb-2 d-block">
                                    Bentuk Pendampingan yang Anda Butuhkan <span class="text-slate-400 fw-normal">(Pilih yang sesuai)</span>:
                                </label>
                                <div class="row g-2">
                                    <div class="col-sm-6">
                                        <div class="form-check p-2.5 rounded-2 border border-emerald-500/20 bg-black/20">
                                            <input class="form-check-input" type="checkbox" name="kebutuhan_pendampingan[]" value="Konseling Psikologis" id="p1">
                                            <label class="form-check-label text-slate-300 small ms-1" for="p1">
                                                Konseling Psikologis &amp; Pemulihan
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check p-2.5 rounded-2 border border-emerald-500/20 bg-black/20">
                                            <input class="form-check-input" type="checkbox" name="kebutuhan_pendampingan[]" value="Perlindungan Keamanan" id="p2">
                                            <label class="form-check-label text-slate-300 small ms-1" for="p2">
                                                Perlindungan Fisik &amp; Keamanan
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check p-2.5 rounded-2 border border-emerald-500/20 bg-black/20">
                                            <input class="form-check-input" type="checkbox" name="kebutuhan_pendampingan[]" value="Pendampingan Hukum" id="p3">
                                            <label class="form-check-label text-slate-300 small ms-1" for="p3">
                                                Pendampingan Hukum / Advokasi
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check p-2.5 rounded-2 border border-emerald-500/20 bg-black/20">
                                            <input class="form-check-input" type="checkbox" name="kebutuhan_pendampingan[]" value="Bantuan Kelonggaran Akademis" id="p4">
                                            <label class="form-check-label text-slate-300 small ms-1" for="p4">
                                                Bantuan &amp; Izin Kelonggaran Akademis
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PERNYATAAN & SUBMIT -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="persetujuan" required>
                                    <label class="form-check-label text-slate-300 small" for="persetujuan">
                                        Saya menyatakan informasi yang saya laporkan dibuat dengan itikad baik dan bersedia didampingi oleh Satgas PPKS demi keadilan dan keamanan bersama.
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success btn-lg w-100 rounded-pill py-3 fw-bold shadow-lg" style="background: linear-gradient(135deg, #10b981, #059669); border: none;">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Laporan Rahasia Sekarang
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- 4. TAB CONTENT 2: WARTA & DOKUMEN PPKS -->
    <div id="tabWartaSection" style="display: none;">
        
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pb-2 border-bottom border-emerald-500/20">
            <div>
                <h3 class="fs-4 fw-bold text-white mb-1">
                    <i class="fas fa-book-open text-emerald-400 me-2"></i> Warta, Edukasi &amp; Dokumen Regulasi PPKS
                </h3>
                <p class="text-slate-400 small mb-0">
                    Publikasi resmi, materi edukasi pencegahan, dan unduhan dokumen SOP Satgas PPKS AMIK Taruna.
                </p>
            </div>

            @auth
                <a href="{{ route('berita.create', ['kategori' => 'ppks']) }}" class="btn btn-sm btn-success rounded-pill px-3 py-2 fw-bold shadow-sm">
                    <i class="fas fa-plus me-1"></i> Buat Warta PPKS &amp; Lampirkan Dokumen
                </a>
            @endauth
        </div>

        @if(count($beritasPPKS) > 0)
            <div class="row g-4">
                @foreach($beritasPPKS as $b)
                    <div class="col-md-6 col-lg-6">
                        <div class="card ppks-article-card h-100 shadow-sm border-0 d-flex flex-column">
                            
                            <!-- GAMBAR BERITA -->
                            <div class="position-relative" style="aspect-ratio: 16/9; overflow: hidden; background: #021a0f;">
                                @if($b->gambar)
                                    <img src="{{ asset('uploads/berita/gambar/' . $b->gambar) }}" alt="{{ $b->judul }}" class="w-100 h-100 object-fit-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                @endif
                                <div class="w-100 h-100 align-items-center justify-content-center text-emerald-400" style="{{ $b->gambar ? 'display: none;' : 'display: flex;' }}">
                                    <i class="fas fa-shield-alt fa-3x opacity-50"></i>
                                </div>

                                <div class="position-absolute top-0 start-0 p-3">
                                    <span class="badge rounded-pill bg-emerald-950/90 text-emerald-300 border border-emerald-500/30 px-2.5 py-1 text-uppercase fw-bold" style="font-size: 10px;">
                                        🛡️ Satgas PPKS
                                    </span>
                                </div>
                            </div>

                            <div class="card-body p-4 d-flex flex-column flex-grow-1 justify-content-between">
                                <div>
                                    <div class="d-flex align-items-center gap-2 text-slate-400 small mb-2" style="font-size: 12px;">
                                        <i class="far fa-calendar-alt text-emerald-400"></i>
                                        <span>{{ \Carbon\Carbon::parse($b->publish_at ?? $b->created_at)->translatedFormat('d F Y') }}</span>
                                        <span>•</span>
                                        <span>{{ $b->penulis ?? 'Satgas PPKS' }}</span>
                                    </div>

                                    <h4 class="fs-5 fw-bold text-white mb-2 leading-snug">
                                        <a href="{{ url('/berita/' . ($b->slug ?: $b->id)) }}" class="text-white text-decoration-none hover-emerald">
                                            {{ $b->judul }}
                                        </a>
                                    </h4>

                                    <!-- DESKRIPSI / ISI -->
                                    <p class="text-slate-300 small line-clamp-3 mb-3 leading-relaxed">
                                        {{ Str::limit(strip_tags($b->isi), 180) }}
                                    </p>
                                </div>

                                <div>
                                    <!-- DOKUMEN LAMPIRAN (PDF, DOC, DOCX) -->
                                    @if($b->file_pdf)
                                        <div class="p-3 rounded-3 border border-emerald-500/30 bg-emerald-950/40 mb-3 d-flex align-items-center justify-between gap-3">
                                            <div class="d-flex align-items-center gap-2 overflow-hidden">
                                                <i class="fas fa-file-pdf text-danger fs-4 shrink-0"></i>
                                                <div class="overflow-hidden">
                                                    <span class="text-xs fw-bold text-white d-block text-truncate">
                                                        {{ $b->file_pdf }}
                                                    </span>
                                                    <span class="text-slate-400" style="font-size: 10px;">Dokumen Resmi Terverifikasi</span>
                                                </div>
                                            </div>
                                            <a href="{{ asset('uploads/berita/pdf/' . $b->file_pdf) }}" target="_blank" download class="btn btn-sm btn-success rounded-pill px-3 py-1.5 fw-bold shrink-0 text-white" style="font-size: 11px;">
                                                <i class="fas fa-download me-1"></i> Unduh
                                            </a>
                                        </div>
                                    @endif

                                    <div class="d-flex align-items-center justify-content-between pt-2 border-t border-emerald-500/15">
                                        <a href="{{ url('/berita/' . ($b->slug ?: $b->id)) }}" class="text-emerald-300 fw-bold small text-decoration-none d-inline-flex align-items-center gap-1">
                                            <span>Baca Selengkapnya</span>
                                            <i class="fas fa-arrow-right fa-xs"></i>
                                        </a>
                                        @if($b->file_pdf)
                                            <span class="badge bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 px-2 py-1 rounded small" style="font-size: 10px;">
                                                <i class="fas fa-paperclip me-1"></i> Ada Berkas
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 ppks-card">
                <i class="fas fa-folder-open text-emerald-400 fa-3x mb-3 opacity-50"></i>
                <h5 class="text-white fw-bold">Belum Ada Warta atau Dokumen Regulasi</h5>
                <p class="text-slate-400 small mb-3">Dokumen pedoman dan publikasi PPKS akan segera diperbarui oleh tim satgas.</p>
                @auth
                    <a href="{{ route('berita.create', ['kategori' => 'ppks']) }}" class="btn btn-sm btn-success rounded-pill px-4 py-2">
                        + Tambah Berita PPKS Pertama
                    </a>
                @endauth
            </div>
        @endif

    </div>

</div>

<script>
function toggleAnonimInput(isAnonim) {
    const wrap = document.getElementById('wrapNamaPelapor');
    const input = document.getElementById('inputNamaPelapor');
    if (isAnonim) {
        input.value = '';
        input.disabled = true;
        input.placeholder = 'Identitas Anda disamarkan sebagai Anonim';
        wrap.style.opacity = '0.5';
    } else {
        input.disabled = false;
        input.placeholder = 'Masukkan nama Anda';
        wrap.style.opacity = '1';
    }
}

function switchPpksTab(tab) {
    const btnForm = document.getElementById('btnTabForm');
    const btnWarta = document.getElementById('btnTabWarta');
    const secForm = document.getElementById('tabFormSection');
    const secWarta = document.getElementById('tabWartaSection');

    if (tab === 'form') {
        btnForm.classList.add('active');
        btnWarta.classList.remove('active');
        secForm.style.display = 'block';
        secWarta.style.display = 'none';
    } else {
        btnWarta.classList.add('active');
        btnForm.classList.remove('active');
        secWarta.style.display = 'block';
        secForm.style.display = 'none';
    }
}
</script>

@endsection
