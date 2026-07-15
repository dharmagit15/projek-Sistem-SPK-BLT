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
        // Parameter query dinamis juga bisa ditangkap di sini untuk menyaring data PDF nantinya
        $search = $request->input('search');
        $status = $request->input('status');

        return "Fungsi cetak PDF akan mengeksekusi stream dokumen berdasarkan filter pencarian.";
    }
}