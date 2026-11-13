<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Acara Laporan PPKS - {{ $laporan->kode_tiket }}</title>
    <style>
        @page {
            margin: 1.4cm 1.4cm 1.4cm 1.4cm;
            size: A4 portrait;
        }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0 !important; }
        }
        @media screen {
            body.has-fallback-bar { padding-top: 15px; }
        }

        /* KOP SURAT */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }
        .kop-table td {
            vertical-align: middle;
            padding: 0;
        }
        .kop-logo {
            width: 75px;
            text-align: center;
        }
        .kop-logo img {
            max-width: 68px;
            max-height: 68px;
        }
        .kop-text {
            text-align: center;
            padding-left: 10px;
            padding-right: 15px;
        }
        .kop-text h4 {
            font-size: 10.5px;
            font-weight: 700;
            margin: 0 0 2px 0;
            color: #064e3b;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .kop-text h2 {
            font-size: 13.5px;
            font-weight: 800;
            margin: 0 0 3px 0;
            color: #991b1b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .kop-text p {
            font-size: 8.5px;
            color: #475569;
            margin: 0;
            line-height: 1.35;
        }
        .kop-divider {
            border-top: 2px solid #991b1b;
            border-bottom: 1px solid #064e3b;
            height: 3px;
            margin-bottom: 12px;
        }

        .confidential-tag {
            float: right;
            border: 1px solid #ef4444;
            background-color: #fef2f2;
            color: #b91c1c;
            padding: 3px 8px;
            font-size: 8.5px;
            font-weight: 800;
            letter-spacing: 1px;
            border-radius: 3px;
            text-transform: uppercase;
        }

        /* TITLE */
        .doc-title {
            text-align: center;
            margin-bottom: 14px;
            clear: both;
        }
        .doc-title h3 {
            font-size: 12.5px;
            font-weight: 800;
            text-transform: uppercase;
            margin: 0 0 3px 0;
            color: #0f172a;
            letter-spacing: 0.5px;
        }
        .doc-title .reg-number {
            font-size: 10.5px;
            font-weight: 800;
            color: #064e3b;
            font-family: monospace;
            letter-spacing: 0.5px;
        }

        /* SECTION HEADER */
        .section-header {
            font-size: 10px;
            font-weight: 700;
            color: #0f172a;
            text-transform: uppercase;
            margin: 10px 0 5px 0;
            border-left: 3px solid #991b1b;
            padding-left: 6px;
            letter-spacing: 0.3px;
        }

        /* DETAIL TABLE */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .info-table th, .info-table td {
            padding: 5px 8px;
            font-size: 9.5px;
            border: 1px solid #e2e8f0;
        }
        .info-table th {
            background-color: #f8fafc;
            color: #475569;
            width: 28%;
            text-align: left;
            font-weight: 600;
        }
        .info-table td {
            color: #0f172a;
        }

        /* TEXT BOX */
        .text-box {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 8px 10px;
            font-size: 9.5px;
            line-height: 1.5;
            color: #1e293b;
            margin-bottom: 10px;
            min-height: 70px;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8.5px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-baru { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .badge-ditinjau { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .badge-investigasi { background-color: #e0f2fe; color: #075985; border: 1px solid #bae6fd; }
        .badge-selesai { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }

        /* SIGNATURE */
        .signature-table {
            width: 100%;
            margin-top: 18px;
            page-break-inside: avoid;
        }
        .signature-table td {
            vertical-align: top;
            padding: 0;
            font-size: 9.5px;
        }
        .sign-box {
            text-align: center;
            width: 220px;
        }
        .sign-space {
            height: 48px;
        }
    </style>
</head>
<body class="{{ !empty($isHtmlFallback) ? 'has-fallback-bar' : '' }}">

    @if(!empty($isHtmlFallback))
        <div class="no-print" style="background: #1e293b; color: white; padding: 12px 24px; font-family: sans-serif; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 9999; margin: -15px -15px 20px -15px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.15);">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 16px;">🛡️</span>
                <div>
                    <strong style="font-size: 13px;">Berita Acara Register Kasus PPKS #{{ $laporan->kode_tiket }}</strong>
                    <div style="font-size: 11px; color: #94a3b8;">Klasifikasi RAHASIA. Klik tombol cetak untuk menyimpan sebagai file PDF atau langsung mencetak.</div>
                </div>
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="button" onclick="window.print()" style="background: #dc2626; color: white; border: none; padding: 7px 16px; border-radius: 9999px; font-weight: bold; cursor: pointer; font-size: 12px; display: inline-flex; align-items: center; gap: 6px;">
                    🖨️ Cetak / Simpan PDF (Ctrl + P)
                </button>
                <button type="button" onclick="window.close()" style="background: #475569; color: white; border: none; padding: 7px 14px; border-radius: 9999px; cursor: pointer; font-size: 12px;">
                    Tutup Tab
                </button>
            </div>
        </div>
    @endif

    <div class="confidential-tag">RAHASIA / CONFIDENTIAL</div>

    <!-- KOP SURAT RESMI SATGAS PPKS -->
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Logo AMIK Taruna">
                @endif
            </td>
            <td class="kop-text">
                <h4>Akademi Manajemen Informatika dan Komputer (AMIK) Taruna</h4>
                <h2>Satgas Pencegahan &amp; Penanganan Kekerasan Seksual (PPKS)</h2>
                <p>
                    Kanal Pengaduan Rahasia Sivitas Akademika Berdasarkan Permendikbudristek No. 30 Tahun 2021<br>
                    {{ $setting->alamat ?? 'Jl. Raya Leces No. 3A, Kec. Leces, Kab. Probolinggo' }} | Email: {{ $setting->email ?? 'humas.amiktarunaprobolinggo@gmail.com' }}
                </p>
            </td>
        </tr>
    </table>
    <div class="kop-divider"></div>

    <!-- JUDUL DOKUMEN -->
    <div class="doc-title">
        <h3>Lembar Berita Acara Registrasi Pengaduan PPKS</h3>
        <div class="reg-number">Nomor Tiket: {{ $laporan->kode_tiket }}</div>
    </div>

    <!-- 1. INFORMASI PELAPOR -->
    <div class="section-header">I. Data Identitas Pelapor (Kerahasiaan Dijamin)</div>
    <table class="info-table">
        <tr>
            <th>Status Kerahasiaan</th>
            <td>
                @if($laporan->is_anonim)
                    <span style="color: #b91c1c; font-weight: 700;">[Anonim] Laporan Anonim (Identitas Dirahasiakan Penuh)</span>
                @else
                    <span style="color: #15803d; font-weight: 700;">Identitas Terbuka (Rahasia Satgas)</span>
                @endif
            </td>
        </tr>
        <tr>
            <th>Nama Lengkap Pelapor</th>
            <td>
                @if($laporan->is_anonim)
                    <span style="color: #64748b; font-style: italic;">[ Tidak dicantumkan atas permintaan pelapor ]</span>
                @else
                    <strong>{{ $laporan->nama_pelapor }}</strong>
                @endif
            </td>
        </tr>
        <tr>
            <th>Status Sivitas Akademika</th>
            <td>{{ $laporan->status_pelapor }}</td>
        </tr>
        <tr>
            <th>Kontak Rahasia</th>
            <td>
                Telp/WhatsApp: <strong>{{ $laporan->no_telp }}</strong>
                @if($laporan->email)
                    &nbsp;|&nbsp; Email: {{ $laporan->email }}
                @endif
            </td>
        </tr>
        <tr>
            <th>Waktu Laporan Masuk</th>
            <td>{{ $laporan->created_at->translatedFormat('l, d F Y - H:i') }} WIB</td>
        </tr>
    </table>

    <!-- 2. DATA PERISTIWA / KASUS -->
    <div class="section-header">II. Rincian Peristiwa yang Dilaporkan</div>
    <table class="info-table">
        <tr>
            <th>Kategori Dugaan Kekerasan</th>
            <td><strong style="color: #991b1b;">{{ $laporan->kategori_kekerasan }}</strong></td>
        </tr>
        <tr>
            <th>Pihak Terlapor</th>
            <td><strong>{{ $laporan->nama_terlapor ?: '- Tidak disebutkan / Belum diketahui -' }}</strong></td>
        </tr>
        <tr>
            <th>Waktu &amp; Tanggal Kejadian</th>
            <td>{{ $laporan->tanggal_kejadian ? $laporan->tanggal_kejadian->translatedFormat('d F Y') : '- Tidak ditentukan -' }}</td>
        </tr>
        <tr>
            <th>Lokasi Kejadian</th>
            <td>{{ $laporan->lokasi_kejadian ?: '- Tidak disebutkan -' }}</td>
        </tr>
        <tr>
            <th>Kebutuhan Pendampingan</th>
            <td>{{ $laporan->kebutuhan_pendampingan ?: '- Tidak ada permintaan khusus -' }}</td>
        </tr>
        <tr>
            <th>Lampiran Dokumen Bukti</th>
            <td>
                @if($laporan->dokumen_bukti)
                    <span style="color: #0369a1; font-weight: 600;">Tersedia Lampiran Dokumen Bukti ({{ $laporan->dokumen_bukti }})</span>
                @else
                    <span style="color: #64748b;">- Tidak ada lampiran file -</span>
                @endif
            </td>
        </tr>
    </table>

    <!-- 3. KRONOLOGI KEJADIAN -->
    <div class="section-header">III. Uraian Kronologi Kejadian</div>
    <div class="text-box">
        {!! nl2br(e($laporan->kronologi)) !!}
    </div>

    <!-- 4. STATUS & CATATAN PETUGAS -->
    <div class="section-header">IV. Tindak Lanjut &amp; Catatan Petugas Satgas PPKS</div>
    <table class="info-table">
        <tr>
            <th>Status Penanganan Kasus</th>
            <td>
                @if($laporan->status == 'baru')
                    <span class="badge badge-baru">Baru Masuk</span>
                @elseif($laporan->status == 'ditinjau')
                    <span class="badge badge-ditinjau">Sedang Ditinjau</span>
                @elseif($laporan->status == 'investigasi')
                    <span class="badge badge-investigasi">Tahap Investigasi</span>
                @else
                    <span class="badge badge-selesai">Selesai Ditangani</span>
                @endif
            </td>
        </tr>
    </table>
    <div class="text-box" style="min-height: 50px;">
        @if($laporan->catatan_petugas)
            {!! nl2br(e($laporan->catatan_petugas)) !!}
        @else
            <span style="color: #94a3b8; font-style: italic;">(Belum ada catatan investigasi/tindak lanjut tertulis dari petugas Satgas)</span>
        @endif
    </div>

    <!-- TANDA TANGAN -->
    <table class="signature-table">
        <tr>
            <td width="50%">
                <div class="sign-box" style="float: left;">
                    <div>Penerima Laporan / Verifikator,</div>
                    <div class="sign-space"></div>
                    <div style="font-weight: 700; text-decoration: underline;">( Tim Sekretariat PPKS )</div>
                    <div style="font-size: 8.5px; color: #64748b;">Satgas PPKS AMIK Taruna</div>
                </div>
            </td>
            <td width="50%">
                <div class="sign-box" style="float: right;">
                    <div>Probolinggo, {{ now()->translatedFormat('d F Y') }}</div>
                    <div style="font-weight: 700;">Mengetahui,</div>
                    <div class="sign-space"></div>
                    <div style="font-weight: 700; text-decoration: underline;">( Ketua Satgas PPKS )</div>
                    <div style="font-size: 8.5px; color: #64748b;">AMIK Taruna Probolinggo</div>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
