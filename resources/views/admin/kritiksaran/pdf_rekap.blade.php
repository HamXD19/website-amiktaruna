<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi Kritik &amp; Saran</title>
    <style>
        @page {
            margin: 1.2cm 1.2cm 1.2cm 1.2cm;
            size: A4 landscape;
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
            width: 80px;
            text-align: center;
        }
        .kop-logo img {
            max-width: 72px;
            max-height: 72px;
        }
        .kop-text {
            text-align: center;
            padding-left: 10px;
            padding-right: 20px;
        }
        .kop-text h4 {
            font-size: 11px;
            font-weight: 600;
            margin: 0 0 2px 0;
            color: #334155;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .kop-text h2 {
            font-size: 15px;
            font-weight: 800;
            margin: 0 0 3px 0;
            color: #064e3b;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }
        .kop-text p {
            font-size: 9.5px;
            color: #475569;
            margin: 0;
            line-height: 1.35;
        }
        .kop-divider {
            border-top: 2.5px solid #064e3b;
            border-bottom: 1px solid #064e3b;
            height: 3px;
            margin-bottom: 12px;
        }

        /* TITLE */
        .doc-title {
            text-align: center;
            margin-bottom: 12px;
        }
        .doc-title h3 {
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            margin: 0 0 3px 0;
            color: #0f172a;
            letter-spacing: 0.5px;
        }
        .doc-title .meta-info {
            font-size: 9.5px;
            color: #64748b;
        }

        /* STATS SUMMARY */
        .summary-box {
            width: 100%;
            margin-bottom: 12px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 7px 10px;
        }
        .summary-box table {
            width: 100%;
            border-collapse: collapse;
        }
        .summary-box td {
            font-size: 10px;
            padding: 2px 6px;
        }
        .summary-box .label {
            color: #64748b;
            font-weight: 500;
        }
        .summary-box .val {
            font-weight: 700;
            color: #0f172a;
        }

        /* DATA TABLE */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        .data-table th {
            background-color: #064e3b;
            color: #ffffff;
            font-weight: 700;
            font-size: 9.5px;
            text-transform: uppercase;
            padding: 7px 6px;
            border: 1px solid #064e3b;
            text-align: left;
        }
        .data-table th.text-center, .data-table td.text-center {
            text-align: center;
        }
        .data-table td {
            padding: 6px 7px;
            border: 1px solid #cbd5e1;
            font-size: 9.5px;
            vertical-align: top;
        }
        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8.5px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-baru {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .badge-dibaca {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        /* SIGNATURE */
        .signature-table {
            width: 100%;
            margin-top: 16px;
            page-break-inside: avoid;
        }
        .signature-table td {
            vertical-align: top;
            padding: 0;
            font-size: 10px;
        }
        .sign-box {
            text-align: center;
            width: 240px;
            float: right;
        }
        .sign-space {
            height: 50px;
        }
    </style>
</head>
<body class="{{ !empty($isHtmlFallback) ? 'has-fallback-bar' : '' }}">

    @if(!empty($isHtmlFallback))
        <div class="no-print" style="background: #1e293b; color: white; padding: 12px 24px; font-family: sans-serif; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 9999; margin: -15px -15px 20px -15px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.15);">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 16px;">📄</span>
                <div>
                    <strong style="font-size: 13px;">Pratinjau Cetak / Ekspor PDF</strong>
                    <div style="font-size: 11px; color: #94a3b8;">Klik tombol cetak untuk menyimpan sebagai file PDF atau langsung mencetak dokumen.</div>
                </div>
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="button" onclick="window.print()" style="background: #10b981; color: white; border: none; padding: 7px 16px; border-radius: 9999px; font-weight: bold; cursor: pointer; font-size: 12px; display: inline-flex; align-items: center; gap: 6px;">
                    🖨️ Cetak / Simpan PDF (Ctrl + P)
                </button>
                <button type="button" onclick="window.close()" style="background: #475569; color: white; border: none; padding: 7px 14px; border-radius: 9999px; cursor: pointer; font-size: 12px;">
                    Tutup Tab
                </button>
            </div>
        </div>
    @endif

    <!-- KOP SURAT RESMI -->
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Logo AMIK Taruna">
                @endif
            </td>
            <td class="kop-text">
                <h4>Yayasan Pendidikan Taruna Probolinggo</h4>
                <h2>Akademi Manajemen Informatika dan Komputer (AMIK) Taruna</h2>
                <p>
                    {{ $setting->alamat ?? 'Jl. Raya Leces No. 3A, Kec. Leces, Kab. Probolinggo, Jawa Timur' }}<br>
                    Telp: {{ $setting->telepon ?? '(0335) 421234' }} | Email: {{ $setting->email ?? 'humas.amiktarunaprobolinggo@gmail.com' }} | Website: https://amiktaruna.ac.id
                </p>
            </td>
        </tr>
    </table>
    <div class="kop-divider"></div>

    <!-- JUDUL DOKUMEN -->
    <div class="doc-title">
        <h3>Laporan Rekapitulasi Pengaduan Kritik &amp; Saran</h3>
        <div class="meta-info">
            Periode: <strong>{{ $periodeText }}</strong> &nbsp;|&nbsp; 
            Status: <strong>{{ $statusFilter ? ucfirst($statusFilter) : 'Semua Status' }}</strong> &nbsp;|&nbsp; 
            Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }} WIB
        </div>
    </div>

    <!-- SUMMARY RINGKAS -->
    <div class="summary-box">
        <table>
            <tr>
                <td width="22%"><span class="label">Total Pengaduan:</span> <span class="val">{{ $items->count() }} Data</span></td>
                <td width="20%"><span class="label">Status Baru:</span> <span class="val">{{ $items->where('status', 'baru')->count() }} Data</span></td>
                <td width="20%"><span class="label">Status Dibaca:</span> <span class="val">{{ $items->where('status', '!=', 'baru')->count() }} Data</span></td>
                <td width="38%" style="text-align: right;"><span class="label">Dokumen Rekapitulasi Resmi Sivitas &amp; Pengunjung</span></td>
            </tr>
        </table>
    </div>

    <!-- TABEL DATA -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="4%" class="text-center">No</th>
                <th width="12%">Tgl &amp; Waktu</th>
                <th width="16%">Nama Pengirim</th>
                <th width="18%">Email / Kontak</th>
                <th width="18%">Subjek / Topik</th>
                <th width="24%">Isi Pesan Masukan</th>
                <th width="8%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->created_at->format('d/m/Y') }}</strong><br>
                        <span style="color: #64748b; font-size: 8.5px;">{{ $item->created_at->format('H:i') }} WIB</span>
                    </td>
                    <td><strong>{{ $item->nama }}</strong></td>
                    <td>{{ $item->email ?: '-' }}</td>
                    <td><strong>{{ $item->judul }}</strong></td>
                    <td>{{ $item->pesan }}</td>
                    <td class="text-center">
                        @if($item->status == 'baru')
                            <span class="badge badge-baru">Baru</span>
                        @else
                            <span class="badge badge-dibaca">Dibaca</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 18px; color: #64748b;">
                        Tidak ada data kritik &amp; saran pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TANDA TANGAN -->
    <table class="signature-table">
        <tr>
            <td width="60%">
                <div style="font-size: 9px; color: #64748b; padding-top: 15px;">
                    * Dokumen rekapitulasi ini dihasilkan secara otomatis oleh Sistem Informasi AMIK Taruna Probolinggo.<br>
                    * Arsip kritik &amp; saran digunakan sebagai bahan evaluasi perbaikan mutu dan layanan kampus.
                </div>
            </td>
            <td width="40%">
                <div class="sign-box">
                    <div>Probolinggo, {{ now()->translatedFormat('d F Y') }}</div>
                    <div style="font-weight: 700; margin-top: 3px;">Pengelola Layanan Aspirasi Kampus,</div>
                    <div class="sign-space"></div>
                    <div style="font-weight: 700; text-decoration: underline;">( Tim Humas &amp; Layanan AMIK )</div>
                    <div style="font-size: 9px; color: #475569;">AMIK Taruna Probolinggo</div>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
