<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria; 
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data dasar dan parameter query dinamis
        $search = $request->input('search');
        $status = $request->input('status'); // Mengambil filter status kelayakan (LAYAK/TIDAK LAYAK)
        $perPage = (int) $request->input('per_page', 10); // Menentukan limit halaman dinamis

        $kriterias = Kriteria::all();
        $wargas = Alternatif::with('kriterias')->get();

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
                $pivot = $w->kriterias->where('id', $k->id)->first();
                return $pivot ? (float)$pivot->pivot->nilai : 0.0;
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
                $pivot = $warga->kriterias->where('id', $k->id)->first();
                $nilaiAsli = $pivot ? (float)$pivot->pivot->nilai : 0.0;
                $bobot = (float)$k->bobot; 

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

        // Urutkan berdasarkan Skor Akhir tertinggi (Ranking)
        $sortedRanking = $collectionRanking->sortByDesc('skor_akhir')->values()->all();

        // ==========================================
        // 4. HITUNG RINGKASAN STATISTIK DARI HASIL FILTER
        // ==========================================
        $totalAlternatif = count($sortedRanking);
        $statusTerverifikasi = collect($sortedRanking)->where('status', 'Terverifikasi')->count();
        $statusReview        = collect($sortedRanking)->where('status', 'Review')->count();
        $statusDitolak       = collect($sortedRanking)->where('status', 'Ditolak')->count();
        $rataRataSkor        = $totalAlternatif > 0 ? collect($sortedRanking)->avg('skor_akhir') : 0;

        // ==========================================
        // 5. MANUAL PAGINATION UNTUK ARRAY HASIL FILTER
        // ==========================================
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = array_slice($sortedRanking, ($currentPage - 1) * $perPage, $perPage);
        
        // Cast array items to objects to prevent "Cannot access property on array" error in Blade view
        $currentItems = array_map(function ($item) {
            return (object) $item;
        }, $currentItems);
        
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
            'statusTerverifikasi', 
            'statusReview', 
            'statusDitolak', 
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
        $wargas = Alternatif::with('kriterias')->get();

        if ($wargas->isEmpty() || $kriterias->isEmpty()) {
            $alternatifs = [];
            $pdf = Pdf::loadView('laporan.cetak', compact('alternatifs'));
            return $pdf->stream('laporan_spk_blt_' . date('Y') . '.pdf');
        }

        // Cari Nilai Max/Min untuk pembagi Normalisasi
        $minMax = [];
        foreach ($kriterias as $k) {
            $nilaiWarga = $wargas->map(function($w) use ($k) {
                $pivot = $w->kriterias->where('id', $k->id)->first();
                return $pivot ? (float)$pivot->pivot->nilai : 0.0;
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
                $pivot = $warga->kriterias->where('id', $k->id)->first();
                $nilaiAsli = $pivot ? (float)$pivot->pivot->nilai : 0.0;
                $bobot = (float)$k->bobot; 

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
                'status'           => $warga->status, 
                'created_at'       => $warga->created_at, 
                'skor_akhir'       => $skorAkhir,
                'status_kelayakan' => $statusKelayakan
            ];
        }

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
                return $item['status_kelayakan'] === strtoupper($status) || 
                       $item['status'] === $status;
            });
        }

        // Urutkan berdasarkan Skor Akhir tertinggi (Ranking)
        $sortedRanking = $collectionRanking->sortByDesc('skor_akhir')->values()->all();

        // Cast to object for view
        $alternatifs = array_map(function ($item) {
            return (object) $item;
        }, $sortedRanking);

        $pdf = Pdf::loadView('laporan.cetak', compact('alternatifs'));
        return $pdf->stream('laporan_spk_blt_' . date('Y') . '.pdf');
    }
}