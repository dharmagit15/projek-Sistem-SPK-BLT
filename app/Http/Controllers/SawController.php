<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class SawController extends Controller
{
    /**
     * Menghitung Metode SAW Sesuai Rumus Baku Matriks R dan V
     */
    public function hitungSaw()
    {
        $kriterias = Kriteria::all();
        $alternatifs = Alternatif::with('kriterias')->get();

        // Antisipasi jika data masih kosong agar halaman view tidak crash
        if ($alternatifs->isEmpty() || $kriterias->isEmpty()) {
            return view('perhitungan.index', [
                'kriterias' => collect(),
                'hasilRanking' => []
            ]);
        }

        // TAHAP 1: Menentukan Nilai Max & Min global per Kriteria (Pembagi rumus R)
        $matriksMaksMin = [];
        foreach ($kriterias as $kcriteria) {
            $semuaNilai = [];
            foreach ($alternatifs as $alt) {
                $pivot = $alt->kriterias->where('id', $kcriteria->id)->first();
                $semuaNilai[] = $pivot ? (float)$pivot->pivot->nilai : 0.0;
            }

            // Cari Max dan Min murni tanpa mengabaikan nilai apa pun
            $nilaiMax = count($semuaNilai) > 0 ? max($semuaNilai) : 1;
            $nilaiMin = count($semuaNilai) > 0 ? min($semuaNilai) : 1;

            $matriksMaksMin[$kcriteria->id] = [
                'max' => $nilaiMax,
                'min' => $nilaiMin,
            ];
        }

        // TAHAP 2 & 3: Penerapan Rumus Rij (Normalisasi) dan Vi (Skor Akhir Preferensi)
        $hasilRanking = [];

        foreach ($alternatifs as $alt) {
            $totalNilaiV = 0; 
            $detailNormalisasi = [];
            $detailNilaiAsli = [];
            $arrRumus = []; // Reset penampung teks rumus per alternatif

            foreach ($kriterias as $kcriteria) {
                $pivot = $alt->kriterias->where('id', $kcriteria->id)->first();
                $nilaiAsli = $pivot ? (float)$pivot->pivot->nilai : 0.0;

                $maxGlobal = $matriksMaksMin[$kcriteria->id]['max'];    
                $minGlobal = $matriksMaksMin[$kcriteria->id]['min'];

                $nilaiNormalisasi = 0;

                // Logika pembagian normalisasi matriks (R) sesuai jenis kriteria
                if (strtolower($kcriteria->jenis) == 'benefit' || strtolower($kcriteria->jenis) == 'benefit ') {
                    // Rumus Benefit: R_ij = X_ij / Max(X)
                    $nilaiNormalisasi = $maxGlobal > 0 ? ($nilaiAsli / $maxGlobal) : 0;
                } else {
                    // Rumus Cost: R_ij = Min(X) / X_ij
                    $nilaiNormalisasi = $nilaiAsli > 0 ? ($minGlobal / $nilaiAsli) : 0;
                }

                // Hitung nilai terbobot berdasarkan nilai normalisasi murni (menjaga akurasi desimal)
                $bobotKriteria = (float)$kcriteria->bobot;
                $nilaiTerbobot = $nilaiNormalisasi * $bobotKriteria;
                $totalNilaiV += $nilaiTerbobot;

                // Simpan nilai asli dan nilai normalisasi (dengan format 3 desimal sesuai tabel dokumen)
                $detailNilaiAsli[$kcriteria->id] = $nilaiAsli;
                $detailNormalisasi[$kcriteria->id] = number_format($nilaiNormalisasi, 3, '.', '');
            
                // MEMBENTUK STRUKTUR TEKS RUMUS: (Bobot)(Nilai_Normalisasi) -> Contoh: (0.30)(0.533)
                $arrRumus[] = "(" . number_format($bobotKriteria, 2, ',', '.') . ")(" . number_format($nilaiNormalisasi, 3, ',', '.') . ")";
            } // Akhir kriteria loop

            // Gabungkan runtunan pecahan rumus menjadi satu baris teks utuh menggunakan tanda pemisah +
            $stringRumus = implode(" + ", $arrRumus);

            $hasilRanking[] = [
                'id'                 => $alt->id,
                'nik'                => $alt->nik,
                'nama'               => $alt->nama,
                'alamat'             => $alt->alamat,
                'status'             => $alt->status,
                'detail_nilai_asli'  => $detailNilaiAsli,
                'detail_normalisasi' => $detailNormalisasi,
                'teks_rumus'         => $stringRumus, // Dikirim langsung ke blade view
                'skor_akhir'         => $totalNilaiV
            ];
        } // Akhir alternatif loop

        // TAHAP 4: Urutkan posisi data berdasarkan Skor Akhir Preferensi (Tertinggi ke Terendah)
        usort($hasilRanking, function ($a, $b) {
            return $b['skor_akhir'] <=> $a['skor_akhir'];
        });

        return view('perhitungan.index', compact('kriterias', 'hasilRanking'));
    }

    /**
     * TAMPILAN FORM: Membuka panel input parameter nilai warga
     */
    public function formNilai($id)
    {
        $warga = Alternatif::findOrFail($id);
        $kriterias = Kriteria::all();
        $nilaiWarga = $warga->kriterias->pluck('pivot.nilai', 'id')->toArray();

        return view('perhitungan.input_nilai', compact('warga', 'kriterias', 'nilaiWarga'));
    }

    /**
     * PROSES STORE: Sinkronisasi data ke tabel pivot alternatif_kriteria
     */
/**
 * PROSES STORE: Sinkronisasi data ke tabel pivot alternatif_kriteria
 */
    public function simpanNilai(Request $request, $id)
    {
        $warga = Alternatif::findOrFail($id);
        
        $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'required|numeric'
        ]);

        $syncData = [];
        foreach ($request->nilai as $kriteriaId => $nilai) {
            $syncData[$kriteriaId] = ['nilai' => $nilai];
        }

        $warga->kriterias()->sync($syncData);

        // PERBAIKAN: Gunakan route() agar Laravel otomatis menyesuaikan dengan prefix admin
        return redirect()->route('perhitungan.index')
                        ->with('success', 'Nilai kriteria warga berhasil diintegrasikan!');
    }
}