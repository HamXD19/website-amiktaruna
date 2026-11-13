<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Register Laporan Satgas PPKS</title>
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
    </style>
</head>
<body class="{{ !empty($isHtmlFallback) ? 'has-fallback-bar' : '' }}">

    @if(!empty($isHtmlFallback))
        <div class="no-print" style="background: #1e293b; color: white; padding: 12px 24px; font-family: sans-serif; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 9999; margin: -15px -15px 20px -15px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.15);">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 16px;">🛡️</span>
                <div>
                    <strong style="font-size: 13px;">Pratinjau Cetak / Ekspor PDF Register Kasus PPKS</strong>
                    <div style="font-size: 11px; color: #94a3b8;">Laporan Resmi Rahasia. Klik tombol cetak untuk menyimpan sebagai file PDF atau langsung mencetak.</div>
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
        /* KOP SURAT SATGAS PPKS */
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
            font-weight: 700;
            margin: 0 0 2px 0;
            color: #064e3b;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }
        .kop-text h2 {
            font-size: 14px;
            font-weight: 800;
            margin: 0 0 3px 0;
            color: #991b1b;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }
        .kop-text h3 {
            font-size: 13px;
            font-weight: 800;
            margin: 0 0 3px 0;
            color: #064e3b;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }
        .kop-text p {
            font-size: 9px;
            color: #475569;
            margin: 0;
            line-height: 1.35;
        }
        .kop-divider {
            border-top: 2.5px solid #991b1b;
            border-bottom: 1px solid #064e3b;
            height: 3px;
            margin-bottom: 12px;
        }

        /* CONFIDENTIAL BANNER */
        .confidential-tag {
            float: right;
            border: 1px solid #ef4444;
            background-color: #fef2f2;
            color: #b91c1c;
            padding: 3px 8px;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1px;
            border-radius: 3px;
            text-transform: uppercase;
        }

        /* TITLE */
        .doc-title {
            text-align: center;
            margin-bottom: 12px;
            clear: both;
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
            font-size: 9.5px;
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
            background-color: #1e293b;
            color: #ffffff;
            font-weight: 700;
            font-size: 9px;
            text-transform: uppercase;
            padding: 7px 5px;
            border: 1px solid #1e293b;
            text-align: left;
        }
        .data-table th.text-center, .data-table td.text-center {
            text-align: center;
        }
        .data-table td {
            padding: 5px 6px;
            border: 1px solid #cbd5e1;
            font-size: 9px;
            vertical-align: top;
        }
        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 8px;
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
            margin-top: 16px;
            page-break-inside: avoid;
        }
        .signature-table td {
            vertical-align: top;
            padding: 0;
            font-size: 9.5px;
        }
        .sign-box {
            text-align: center;
            width: 250px;
            float: right;
        }
        .sign-space {
            height: 50px;
        }
    </style>
</head>
<body>

    <div class="confidential-tag">RAHASIA / CONFIDENTIAL</div>

    <!-- KOP SURAT SATGAS PPKS -->
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Logo AMIK Taruna">
                @endif
            </td>
            <td class="kop-text">
                <h4>Akademi Manajemen Informatika dan Komputer (AMIK) Taruna Probolinggo</h4>
                <h2>Satuan Tugas Pencegahan &amp; Penanganan Kekerasan Seksual (Satgas PPKS)</h2>
                <p>
                    Berdasarkan Permendikbudristek No. 30 Tahun 2021 | Kanal Pengaduan Aman &amp; Rahasia Sivitas Akademika<br>
                    {{ $setting->alamat ?? 'Jl. Raya Leces No. 3A, Kec. Leces, Kab. Probolinggo, Jawa Timur' }} | Email: {{ $setting->email ?? 'humas.amiktarunaprobolinggo@gmail.com' }}
                </p>
            </td>
        </tr>
    </table>
    <div class="kop-divider"></div>

    <!-- JUDUL DOKUMEN -->
    <div class="doc-title">
        <h3>Rekapitulasi Register Laporan Kasus Satgas PPKS</h3>
        <div class="meta-info">
            Periode: <strong>{{ $periodeText }}</strong> &nbsp;|&nbsp; 
            Filter Status: <strong>{{ $statusFilter ? ucfirst($statusFilter) : 'Semua Status' }}</strong> &nbsp;|&nbsp; 
            Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }} WIB
        </div>
    </div>

    <!-- SUMMARY RINGKAS -->
    <div class="summary-box">
        <table>
            <tr>
                <td width="18%"><span class="label">Total Laporan:</span> <span class="val">{{ $items->count() }} Kasus</span></td>
                <td width="18%"><span class="label">Baru:</span> <span class="val">{{ $items->where('status', 'baru')->count() }}</span></td>
                <td width="18%"><span class="label">Ditinjau:</span> <span class="val">{{ $items->where('status', 'ditinjau')->count() }}</span></td>
                <td width="18%"><span class="label">Investigasi:</span> <span class="val">{{ $items->where('status', 'investigasi')->count() }}</span></td>
                <td width="18%"><span class="label">Selesai:</span> <span class="val">{{ $items->where('status', 'selesai')->count() }}</span></td>
            </tr>
        </table>
    </div>

    <!-- TABEL DATA -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="4%" class="text-center">No</th>
                <th width="12%">Kode Tiket</th>
                <th width="10%">Tgl Masuk</th>
                <th width="14%">Identitas Pelapor</th>
                <th width="15%">Kategori Kekerasan</th>
                <th width="12%">Terlapor</th>
                <th width="10%">Tgl Kejadian</th>
                <th width="14%">Pendampingan</th>
                <th width="9%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <strong style="color: #0f172a;">{{ $item->kode_tiket }}</strong>
                    </td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($item->is_anonim)
                            <span style="color: #b91c1c; font-style: italic; font-weight: 700;">[ Anonim Terlindungi ]</span>
                        @else
                            <strong>{{ $item->nama_pelapor }}</strong>
                        @endif
                        <br>
                        <span style="color: #64748b; font-size: 8px;">{{ $item->status_pelapor }}</span>
                    </td>
                    <td><strong>{{ $item->kategori_kekerasan }}</strong></td>
                    <td>{{ $item->nama_terlapor ?: '-' }}</td>
                    <td>{{ $item->tanggal_kejadian ? $item->tanggal_kejadian->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->kebutuhan_pendampingan ?: '-' }}</td>
                    <td class="text-center">
                        @if($item->status == 'baru')
                            <span class="badge badge-baru">Baru</span>
                        @elseif($item->status == 'ditinjau')
                            <span class="badge badge-ditinjau">Ditinjau</span>
                        @elseif($item->status == 'investigasi')
                            <span class="badge badge-investigasi">Investigasi</span>
                        @else
                            <span class="badge badge-selesai">Selesai</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 18px; color: #64748b;">
                        Tidak ada data laporan PPKS pada kriteria ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TANDA TANGAN -->
    <table class="signature-table">
        <tr>
            <td width="60%">
                <div style="font-size: 8.5px; color: #b91c1c; border-left: 2px solid #b91c1c; padding-left: 8px; line-height: 1.4;">
                    <strong>PERINGATAN KERAHASIAAN INFORMASI:</strong><br>
                    Isi dokumen ini berkategori Rahasia Negara / Institusi. Dilarang menggandakan, menyebarluaskan, atau mempublikasikan data pelapor dan materi kasus di luar kepentingan resmi pemeriksaan Satgas PPKS AMIK Taruna Probolinggo.
                </div>
            </td>
            <td width="40%">
                <div class="sign-box">
                    <div>Probolinggo, {{ now()->translatedFormat('d F Y') }}</div>
                    <div style="font-weight: 700; margin-top: 3px;">Satuan Tugas PPKS,</div>
                    <div class="sign-space"></div>
                    <div style="font-weight: 700; text-decoration: underline;">( Tim Satgas PPKS AMIK Taruna )</div>
                    <div style="font-size: 8.5px; color: #475569;">Ketua / Sekretaris Satgas</div>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
