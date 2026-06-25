<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria; // Pastikan Model Kriteria di-import
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data dasar dari database
        $kriterias = Kriteria::all();
        $wargas = Alternatif::all();

        if ($wargas->isEmpty() || $kriterias->isEmpty()) {
            return view('laporan.index', [
                'alternatifs' => new LengthAwarePaginator([], 0, 10),
                'totalAlternatif' => 0,
                'statusLayak' => 0,
                'statusTidakLayak' => 0,
                'rataRataSkor' => 0
            ]);
        }

        // ==========================================
        // 2. PROSES KALKULASI RIIL (LOGIKA SPK SAW)
        // ==========================================
        
        // Cari Nilai Max/Min untuk pembagi Normalisasi
        $minMax = [];
        foreach ($kriterias as $k) {
            // Ambil seluruh nilai alternatif untuk kriteria ini
            $nilaiWarga = $wargas->map(function($w) use ($k) {
                // Sesuaikan 'detail_nilai_asli' atau relasi tabel nilai Anda di sini
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

            // === PERBAIKAN DI SINI: Tambahkan kolom yang dibutuhkan oleh view Blade ===
            $hasilRanking[] = [
                'id'               => $warga->id,
                'nik'              => $warga->nik,
                'nama'             => $warga->nama,
                'alamat'           => $warga->alamat,    // <-- Ambil data alamat asli
                'no_telp'          => $warga->no_telp,   // <-- Ambil data nomor telepon asli
                'created_at'       => $warga->created_at, // <-- Ambil data timestamp pendaftaran asli
                'skor_akhir'       => $skorAkhir,
                'status_kelayakan' => $statusKelayakan
            ];
        }

        // Urutkan berdasarkan tanggal pendaftaran terbaru (Bukan berdasarkan skor SPK)
        usort($hasilRanking, function ($a, $b) {
            return strtotime($b['created_at']) <=> strtotime($a['created_at']);
        });

        // ==========================================
        // 3. HITUNG RINGKASAN STATISTIK DARI HASIL RIIL
        // ==========================================
        $collectionRanking = collect($hasilRanking);
        $totalAlternatif = $collectionRanking->count();
        $statusLayak     = $collectionRanking->where('status_kelayakan', 'LAYAK')->count();
        $statusTidakLayak = $collectionRanking->where('status_kelayakan', 'TIDAK LAYAK')->count();
        $rataRataSkor    = $totalAlternatif > 0 ? $collectionRanking->avg('skor_akhir') : 0;

        // ==========================================
        // 4. MANUAL PAGINATION UNTUK ARRAY HASIL SPK
        // ==========================================
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentItems = array_slice($hasilRanking, ($currentPage - 1) * $perPage, $perPage);
        
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
            'rataRataSkor'
        ));
    }

    public function cetakPdf()
    {
        // Logika stream PDF rill Anda nantinya akan ditempatkan di sini
        return "Fungsi cetak PDF akan mengeksekusi stream dokumen.";
    }
}