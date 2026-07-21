<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Seleksi Penerima BLT - SAW</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background-color: #fff;
            margin: 20px;
            font-size: 12pt;
            line-height: 1.5;
        }
        .kop-surat {
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 25px;
            text-align: center;
        }
        .kop-surat h1 {
            font-size: 16pt;
            text-transform: uppercase;
            margin: 0;
            font-weight: bold;
        }
        .kop-surat h2 {
            font-size: 14pt;
            text-transform: uppercase;
            margin: 5px 0 0 0;
            font-weight: bold;
        }
        .kop-surat p {
            font-size: 10pt;
            margin: 5px 0 0 0;
            font-style: italic;
        }
        .judul-laporan {
            text-align: center;
            margin-bottom: 25px;
        }
        .judul-laporan h3 {
            font-size: 12pt;
            text-transform: uppercase;
            text-decoration: underline;
            margin: 0;
            font-weight: bold;
        }
        .judul-laporan p {
            font-size: 11pt;
            margin: 5px 0 0 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th {
            background-color: #f2f2f2 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            padding: 8px 10px;
            font-size: 11pt;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }
        td {
            padding: 8px 10px;
            font-size: 11pt;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .tanda-tangan-container {
            margin-top: 50px;
            display: flex;
            justify-content: flex-end;
        }
        .tanda-tangan {
            text-align: center;
            width: 250px;
        }
        .tanda-tangan .jabatan {
            margin-bottom: 70px;
        }
        .tanda-tangan .nama {
            font-weight: bold;
            text-decoration: underline;
        }
        @media print {
            body {
                margin: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- Kop Surat -->
    <div class="kop-surat">
        <h1>Pemerintah Kabupaten / Desa</h1>
        <h2>Laporan Hasil Seleksi Penerima Bantuan Langsung Tunai (BLT)</h2>
        <p>Alamat Kantor Balai Desa, RT/RW, Kecamatan, Kabupaten, Kode Pos 12345</p>
    </div>

    <!-- Judul Laporan -->
    <div class="judul-laporan">
        <h3>Daftar Hasil Perangkingan SPK Metode SAW</h3>
        <p>Tahun Anggaran {{ date('Y') }}</p>
    </div>

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th style="width: 8%;">No</th>
                <th style="width: 20%;">NIK</th>
                <th>Nama Lengkap</th>
                <th>Alamat</th>
                <th style="width: 15%; text-align: center;">Skor Akhir (V)</th>
                <th style="width: 15%; text-align: center;">Kelayakan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($alternatifs as $index => $row)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $row['nik'] }}</td>
                <td>{{ $row['nama'] }}</td>
                <td>{{ $row['alamat'] }}</td>
                <td class="text-center font-bold">{{ number_format($row['skor_akhir'], 4, ',', '.') }}</td>
                <td class="text-center font-bold">{{ $row['status_kelayakan'] }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data warga hasil perhitungan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan -->
    <div class="tanda-tangan-container">
        <div class="tanda-tangan">
            <p>Ditetapkan di: Balai Desa</p>
            <p>Pada tanggal: {{ date('d F Y') }}</p>
            <p class="jabatan">Kepala Desa / Ketua Panitia</p>
            <p class="nama">............................................</p>
            <p class="nip">NIP. .....................................</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
