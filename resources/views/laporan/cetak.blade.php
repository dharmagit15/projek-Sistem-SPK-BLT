<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil SPK BLT - {{ date('Y') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            color: #333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 14pt;
            text-transform: uppercase;
        }
        .header h3 {
            margin: 5px 0 0 0;
            font-size: 11pt;
            font-weight: normal;
        }
        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 2px 0;
            font-size: 9pt;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }
        .data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            font-size: 9pt;
        }
        .data-table td {
            font-size: 9pt;
        }
        .text-center {
            text-align: center !important;
        }
        .text-right {
            text-align: right !important;
        }
        .badge {
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8pt;
            text-align: center;
            display: inline-block;
        }
        .badge-success {
            background-color: #e6f4ea;
            color: #137333;
        }
        .badge-warning {
            background-color: #fef7e0;
            color: #b06000;
        }
        .badge-danger {
            background-color: #fce8e6;
            color: #c5221f;
        }
        .footer {
            margin-top: 40px;
            width: 100%;
        }
        .footer td {
            border: none;
        }
        .signature {
            text-align: right;
            padding-right: 20px;
            font-size: 9pt;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>SISTEM PENDUKUNG KEPUTUSAN PENERIMA BLT</h2>
        <h2>KECAMATAN PEMBANTU - DESA / KELURAHAN</h2>
        <h3>Laporan Pemeringkatan Kelayakan Penerima Bantuan Langsung Tunai (BLT)</h3>
        <p style="margin: 5px 0 0 0; font-size: 8pt; color: #555;">Dihasilkan secara otomatis melalui Metode Simple Additive Weighting (SAW)</p>
    </div>

    <table class="info-table">
        <tr>
            <td style="width: 15%;">Periode Laporan</td>
            <td style="width: 2%;">:</td>
            <td>Tahun {{ date('Y') }}</td>
            <td style="width: 30%; text-align: right;">Tanggal Cetak: {{ date('d-m-Y') }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 6%; text-align: center;">Rank</th>
                <th style="width: 18%; text-align: center;">NIK</th>
                <th>Nama Warga</th>
                <th>Alamat</th>
                <th style="width: 15%; text-align: center;">Skor Akhir</th>
                <th style="width: 16%; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($alternatifs as $index => $warga)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center" style="font-family: monospace;">{{ $warga->nik }}</td>
                    <td><strong>{{ $warga->nama }}</strong></td>
                    <td>{{ $warga->alamat }}</td>
                    <td class="text-center">{{ number_format($warga->skor_akhir, 4) }}</td>
                    <td class="text-center">
                        @if($warga->status == 'Terverifikasi')
                            TERVERIFIKASI
                        @elseif($warga->status == 'Review')
                            REVIEW
                        @else
                            DITOLAK
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px;">Belum ada data warga/alternatif.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="footer" style="width: 100%;">
        <tr>
            <td style="width: 60%;"></td>
            <td class="signature">
                <p>Kelurahan/Desa, {{ date('d F Y') }}</p>
                <p>Mengetahui,</p>
                <p style="font-weight: bold; margin-bottom: 50px;">Kepala Desa / Lurah</p>
                <p>___________________________</p>
                <p>NIP. .....................................</p>
            </td>
        </tr>
    </table>

</body>
</html>
