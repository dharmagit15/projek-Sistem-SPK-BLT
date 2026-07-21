<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria; 
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data dasar dan parameter query dinamis
        $search = $request->input('search');
        $status = $request->input('status'); // Mengambil filter status kelayakan (LAYAK/TIDAK LAYAK)
        $perPage = (int) $request->input('per_page', 10); // Menentukan limit halaman dinamis

        $kriterias = Kriteria::all();
        $wargas = Alternatif::all();

        if ($wargas->isEmpty() || $kriterias->isEmpty()) {
            return view('laporan.index', [
                'alternatifs' => new LengthAwarePaginator([], 0, $perPage),
                'totalAlternatif' => 0,
                'statusLayak' => 0,
                'statusTidakLayak' => 0,
                'rataRataSkor' => 0,
                'search' => $search,
                'status' => $status,
                'perPage' => $perPage
            ]);
        }

        // ==========================================
        // 2. PROSES KALKULASI RIIL (LOGIKA SPK SAW)
        // ==========================================
        
        // Cari Nilai Max/Min untuk pembagi Normalisasi
        $minMax = [];
        foreach ($kriterias as $k) {
            $nilaiWarga = $wargas->map(function($w) use ($k) {
                return $w->detail_nilai_asli[$k->id] ?? 0; 
            })->toArray();

            $minMax[$k->id] = [
                'max' => !empty($nilaiWarga) ? max($nilaiWarga) : 1,
                'min' => !empty($nilaiWarga) ? min($nilaiWarga) : 1,
            ];
        }

        // Hitung Skor Akhir Per Alternatif
        $hasilRanking = [];
        foreach ($wargas as $warga) {
            $skorAkhir = 0;

            foreach ($kriterias as $k) {
                $nilaiAsli = $warga->detail_nilai_asli[$k->id] ?? 0;
                $bobot = $k->bobot / 100; 

                // Rumus Normalisasi SAW (Benefit / Cost)
                if (trim(strtolower($k->jenis)) == 'benefit') {
                    $r = $minMax[$k->id]['max'] > 0 ? ($nilaiAsli / $minMax[$k->id]['max']) : 0;
                } else { // Cost
                    $r = $nilaiAsli > 0 ? ($minMax[$k->id]['min'] / $nilaiAsli) : 0;
                }

                $skorAkhir += ($r * $bobot);
            }

            // Tentukan status kelayakan berdasarkan threshold skor akhir
            $statusKelayakan = ($skorAkhir >= 0.65) ? 'LAYAK' : 'TIDAK LAYAK';

            $hasilRanking[] = [
                'id'               => $warga->id,
                'nik'              => $warga->nik,
                'nama'             => $warga->nama,
                'alamat'           => $warga->alamat,    
                'no_telp'          => $warga->no_telp,   
                'status'           => $warga->status, // Mengambil status verifikasi asli jika view membutuhkan
                'created_at'       => $warga->created_at, 
                'skor_akhir'       => $skorAkhir,
                'status_kelayakan' => $statusKelayakan
            ];
        }

        // ==========================================
        // 3. PROSES FILTER & PENCARIAN DINAMIS (COLLECTION)
        // ==========================================
        $collectionRanking = collect($hasilRanking);

        // Filter 1: Berdasarkan teks input Pencarian (NIK, Nama, Alamat)
        if (!empty($search)) {
            $collectionRanking = $collectionRanking->filter(function ($item) use ($search) {
                return false !== stripos($item['nik'], $search) || 
                       false !== stripos($item['nama'], $search) || 
                       false !== stripos($item['alamat'], $search);
            });
        }

        // Filter 2: Berdasarkan Status Kelayakan/Verifikasi
        if (!empty($status)) {
            $collectionRanking = $collectionRanking->filter(function ($item) use ($status) {
                // Mencocokkan input status filter dengan hasil SPK atau status dari database
                return $item['status_kelayakan'] === strtoupper($status) || 
                       $item['status'] === $status;
            });
        }

        // Urutkan berdasarkan tanggal pendaftaran terbaru
        $sortedRanking = $collectionRanking->sortByDesc(function ($item) {
            return strtotime($item['created_at']);
        })->values()->all();

        // ==========================================
        // 4. HITUNG RINGKASAN STATISTIK DARI HASIL FILTER
        // ==========================================
        $totalAlternatif = count($sortedRanking);
        $statusLayak     = collect($sortedRanking)->where('status_kelayakan', 'LAYAK')->count();
        $statusTidakLayak = collect($sortedRanking)->where('status_kelayakan', 'TIDAK LAYAK')->count();
        $rataRataSkor    = $totalAlternatif > 0 ? collect($sortedRanking)->avg('skor_akhir') : 0;

        // ==========================================
        // 5. MANUAL PAGINATION UNTUK ARRAY HASIL FILTER
        // ==========================================
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = array_slice($sortedRanking, ($currentPage - 1) * $perPage, $perPage);
        
        $alternatifs = new LengthAwarePaginator(
            $currentItems, 
            $totalAlternatif, 
            $perPage, 
            $currentPage, 
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('laporan.index', compact(
            'alternatifs', 
            'totalAlternatif', 
            'statusLayak', 
            'statusTidakLayak', 
            'rataRataSkor',
            'search',
            'status',
            'perPage'
        ));
    }

    public function cetakPdf(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $kriterias = Kriteria::all();
        $wargas = Alternatif::all();

        if ($wargas->isEmpty() || $kriterias->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data untuk dicetak.');
        }

        // Cari Nilai Max/Min untuk pembagi Normalisasi
        $minMax = [];
        foreach ($kriterias as $k) {
            $nilaiWarga = $wargas->map(function($w) use ($k) {
                return $w->detail_nilai_asli[$k->id] ?? 0; 
            })->toArray();

            $minMax[$k->id] = [
                'max' => !empty($nilaiWarga) ? max($nilaiWarga) : 1,
                'min' => !empty($nilaiWarga) ? min($nilaiWarga) : 1,
            ];
        }

        // Hitung Skor Akhir Per Alternatif
        $hasilRanking = [];
        foreach ($wargas as $warga) {
            $skorAkhir = 0;
            foreach ($kriterias as $k) {
                $nilaiAsli = $warga->detail_nilai_asli[$k->id] ?? 0;
                $bobot = $k->bobot / 100;

                if (trim(strtolower($k->jenis)) == 'benefit') {
                    $r = $minMax[$k->id]['max'] > 0 ? ($nilaiAsli / $minMax[$k->id]['max']) : 0;
                } else {
                    $r = $nilaiAsli > 0 ? ($minMax[$k->id]['min'] / $nilaiAsli) : 0;
                }
                $skorAkhir += ($r * $bobot);
            }
            $statusKelayakan = ($skorAkhir >= 0.65) ? 'LAYAK' : 'TIDAK LAYAK';

            $hasilRanking[] = [
                'nik'              => $warga->nik,
                'nama'             => $warga->nama,
                'alamat'           => $warga->alamat,    
                'no_telp'          => $warga->no_telp,   
                'status'           => $warga->status, 
                'created_at'       => $warga->created_at, 
                'skor_akhir'       => $skorAkhir,
                'status_kelayakan' => $statusKelayakan
            ];
        }

        $collectionRanking = collect($hasilRanking);

        if (!empty($search)) {
            $collectionRanking = $collectionRanking->filter(function ($item) use ($search) {
                return false !== stripos($item['nik'], $search) || 
                       false !== stripos($item['nama'], $search) || 
                       false !== stripos($item['alamat'], $search);
            });
        }

        if (!empty($status)) {
            $collectionRanking = $collectionRanking->filter(function ($item) use ($status) {
                return $item['status_kelayakan'] === strtoupper($status) || 
                       $item['status'] === $status;
            });
        }

        // Urutkan berdasarkan skor tertinggi ke terendah
        $alternatifs = $collectionRanking->sortByDesc('skor_akhir')->values()->all();

        return view('laporan.print', compact('alternatifs'));
    }

    public function exportExcel(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $kriterias = Kriteria::all();
        $wargas = Alternatif::all();

        if ($wargas->isEmpty() || $kriterias->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data untuk diexport.');
        }

        $minMax = [];
        foreach ($kriterias as $k) {
            $nilaiWarga = $wargas->map(function($w) use ($k) {
                return $w->detail_nilai_asli[$k->id] ?? 0; 
            })->toArray();

            $minMax[$k->id] = [
                'max' => !empty($nilaiWarga) ? max($nilaiWarga) : 1,
                'min' => !empty($nilaiWarga) ? min($nilaiWarga) : 1,
            ];
        }

        $hasilRanking = [];
        foreach ($wargas as $warga) {
            $skorAkhir = 0;
            foreach ($kriterias as $k) {
                $nilaiAsli = $warga->detail_nilai_asli[$k->id] ?? 0;
                $bobot = $k->bobot / 100;

                if (trim(strtolower($k->jenis)) == 'benefit') {
                    $r = $minMax[$k->id]['max'] > 0 ? ($nilaiAsli / $minMax[$k->id]['max']) : 0;
                } else {
                    $r = $nilaiAsli > 0 ? ($minMax[$k->id]['min'] / $nilaiAsli) : 0;
                }
                $skorAkhir += ($r * $bobot);
            }
            $statusKelayakan = ($skorAkhir >= 0.65) ? 'LAYAK' : 'TIDAK LAYAK';

            $hasilRanking[] = [
                'nik'              => $warga->nik,
                'nama'             => $warga->nama,
                'alamat'           => $warga->alamat,    
                'no_telp'          => $warga->no_telp,   
                'status'           => $warga->status, 
                'created_at'       => $warga->created_at, 
                'skor_akhir'       => $skorAkhir,
                'status_kelayakan' => $statusKelayakan
            ];
        }

        $collectionRanking = collect($hasilRanking);

        if (!empty($search)) {
            $collectionRanking = $collectionRanking->filter(function ($item) use ($search) {
                return false !== stripos($item['nik'], $search) || 
                       false !== stripos($item['nama'], $search) || 
                       false !== stripos($item['alamat'], $search);
            });
        }

        if (!empty($status)) {
            $collectionRanking = $collectionRanking->filter(function ($item) use ($status) {
                return $item['status_kelayakan'] === strtoupper($status) || 
                       $item['status'] === $status;
            });
        }

        $alternatifs = $collectionRanking->sortByDesc('skor_akhir')->values()->all();

        $fileName = 'laporan_penerima_blt_' . date('Y-m-d') . '.xls';
        
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        
        echo "<table border='1'>";
        echo "<thead>
                <tr>
                    <th colspan='8' style='font-size:16px; font-weight:bold; text-align:center; padding:10px 0;'>LAPORAN HASIL SELEKSI PENERIMA BANTUAN DIRECT TUNAI (BLT)</th>
                </tr>
                <tr>
                    <th colspan='8' style='font-size:12px; text-align:center; padding-bottom:10px;'>Tahun Anggaran " . date('Y') . "</th>
                </tr>
                <tr style='background-color:#f2f2f2; font-weight:bold;'>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama Lengkap</th>
                    <th>Alamat</th>
                    <th>No. Telp</th>
                    <th>Status Verifikasi</th>
                    <th>Skor Akhir (V)</th>
                    <th>Kelayakan SPK</th>
                </tr>
              </thead>";
        echo "<tbody>";
        foreach ($alternatifs as $index => $row) {
            $no = $index + 1;
            echo "<tr>";
            echo "<td>$no</td>";
            echo "<td>'{$row['nik']}</td>";
            echo "<td>{$row['nama']}</td>";
            echo "<td>{$row['alamat']}</td>";
            echo "<td>{$row['no_telp']}</td>";
            echo "<td>{$row['status']}</td>";
            echo "<td>" . number_format($row['skor_akhir'], 4, ',', '.') . "</td>";
            echo "<td>{$row['status_kelayakan']}</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        exit;
    }
}