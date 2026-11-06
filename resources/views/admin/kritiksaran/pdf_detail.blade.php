<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lembar Pengaduan Kritik &amp; Saran #{{ $item->id }}</title>
    <style>
        @page {
            margin: 1.5cm 1.5cm 1.5cm 1.5cm;
            size: A4 portrait;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 11px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
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
            font-size: 9px;
            color: #475569;
            margin: 0;
            line-height: 1.35;
        }
        .kop-divider {
            border-top: 2.5px solid #064e3b;
            border-bottom: 1px solid #064e3b;
            height: 3px;
            margin-bottom: 16px;
        }

        /* TITLE */
        .doc-title {
            text-align: center;
            margin-bottom: 16px;
        }
        .doc-title h3 {
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            margin: 0 0 3px 0;
            color: #0f172a;
            letter-spacing: 0.5px;
        }
        .doc-title .reg-number {
            font-size: 10px;
            font-weight: 700;
            color: #064e3b;
            letter-spacing: 0.5px;
        }

        /* DETAIL TABLE */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        .info-table th, .info-table td {
            padding: 7px 10px;
            font-size: 10.5px;
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

        /* MESSAGE BOX */
        .message-section {
            margin-bottom: 14px;
        }
        .section-header {
            font-size: 10.5px;
            font-weight: 700;
            color: #064e3b;
            text-transform: uppercase;
            margin-bottom: 6px;
            border-left: 3px solid #064e3b;
            padding-left: 8px;
        }
        .message-box {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 12px 14px;
            font-size: 10.5px;
            line-height: 1.6;
            color: #1e293b;
            min-height: 80px;
        }

        /* DISPOSITION BOX */
        .disposisi-box {
            border: 1px dashed #94a3b8;
            border-radius: 4px;
            padding: 10px 14px;
            margin-bottom: 16px;
            min-height: 70px;
            background-color: #ffffff;
        }

        /* SIGNATURE */
        .signature-table {
            width: 100%;
            margin-top: 24px;
            page-break-inside: avoid;
        }
        .signature-table td {
            vertical-align: top;
            padding: 0;
            font-size: 10px;
        }
        .sign-box {
            text-align: center;
            width: 220px;
        }
        .sign-space {
            height: 55px;
        }
    </style>
</head>
<body>

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
        <h3>Lembar Pengaduan Kritik &amp; Saran Pengunjung</h3>
        <div class="reg-number">Nomor Register: KS-{{ date('Y', strtotime($item->created_at)) }}-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</div>
    </div>

    <!-- DETAIL IDENTITAS PENGIRIM -->
    <table class="info-table">
        <tr>
            <th>Tanggal &amp; Waktu Terima</th>
            <td>{{ $item->created_at->translatedFormat('l, d F Y - H:i') }} WIB</td>
        </tr>
        <tr>
            <th>Nama Lengkap Pengirim</th>
            <td><strong>{{ $item->nama }}</strong></td>
        </tr>
        <tr>
            <th>Alamat Email</th>
            <td>{{ $item->email ?: '- Tidak disertakan -' }}</td>
        </tr>
        <tr>
            <th>Subjek / Topik Pengaduan</th>
            <td><strong style="color: #064e3b;">{{ $item->judul }}</strong></td>
        </tr>
        <tr>
            <th>Status Tindak Lanjut</th>
            <td>
                @if($item->status == 'baru')
                    <span style="color: #dc2626; font-weight: 700;">Baru (Belum Ditindaklanjuti)</span>
                @else
                    <span style="color: #16a34a; font-weight: 700;">Telah Ditinjau / Dibaca</span>
                @endif
            </td>
        </tr>
    </table>

    <!-- KONTEN PESAN -->
    <div class="message-section">
        <div class="section-header">Uraian Masukan / Kritik &amp; Saran</div>
        <div class="message-box">
            {!! nl2br(e($item->pesan)) !!}
        </div>
    </div>

    <!-- KOTAK CATATAN / DISPOSISI -->
    <div class="message-section">
        <div class="section-header">Lembar Disposisi / Catatan Tindak Lanjut Pimpinan / Tim Terkait</div>
        <div class="disposisi-box">
            <span style="font-size: 9px; color: #94a3b8; font-style: italic;">
                (Diisi oleh Pimpinan atau Unit Terkait untuk arahan tindak lanjut perbaikan sarana/prasarana/akademik)
            </span>
        </div>
    </div>

    <!-- TANDA TANGAN -->
    <table class="signature-table">
        <tr>
            <td width="50%">
                <div class="sign-box" style="float: left;">
                    <div>Petugas Penerima Pengaduan,</div>
                    <div class="sign-space"></div>
                    <div style="font-weight: 700; text-decoration: underline;">( Tim Humas &amp; Layanan )</div>
                    <div style="font-size: 9px; color: #64748b;">AMIK Taruna Probolinggo</div>
                </div>
            </td>
            <td width="50%">
                <div class="sign-box" style="float: right;">
                    <div>Probolinggo, {{ now()->translatedFormat('d F Y') }}</div>
                    <div style="font-weight: 700;">Mengetahui,</div>
                    <div class="sign-space"></div>
                    <div style="font-weight: 700; text-decoration: underline;">( Pimpinan / Pengelola )</div>
                    <div style="font-size: 9px; color: #64748b;">AMIK Taruna Probolinggo</div>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
