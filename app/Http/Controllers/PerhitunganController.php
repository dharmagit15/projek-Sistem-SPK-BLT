<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class PerhitunganController extends Controller
{
    public function index()
    {
        // 1. Mengambil data kriteria dan alternatif beserta relasi pivotnya
        $kriterias = Kriteria::all();
        $alternatifs = Alternatif::with('kriterias')->get();

        // Jika kriteria atau alternatif belum diinputkan, kirim array kosong agar view tidak crash
        if ($alternatifs->isEmpty() || $kriterias->isEmpty()) {
            return view('perhitungan.index', [
                'kriterias' => collect(),
                'hasilRanking' => []
            ]);
        }

        // 2. Mencari nilai Max (Benefit) dan Min (Cost) untuk setiap kriteria
        $matriksMaksMin = [];
        foreach ($kriterias as $kriteria) {
            $semuaNilai = [];
            foreach ($alternatifs as $alt) {
                $pivot = $alt->kriterias->where('id', $kriteria->id)->first();
                $semuaNilai[] = $pivot ? $pivot->pivot->nilai : 0;
            }

            $matriksMaksMin[$kriteria->id] = [
                'max' => count($semuaNilai) > 0 ? max($semuaNilai) : 1,
                'min' => count($semuaNilai) > 0 ? min($semuaNilai) : 1,
            ];
        }

        // 3. Proses Normalisasi dan Perhitungan Skor Akhir SAW
        $hasilRanking = [];

        foreach ($alternatifs as $alt) {
            $totalNilaiV = 0;
            $detailNormalisasi = [];
            $detailNilaiAsli = [];

            foreach ($kriterias as $kriteria) {
                $pivot = $alt->kriterias->where('id', $kriteria->id)->first();
                $nilaiAsli = $pivot ? $pivot->pivot->nilai : 0;

                $max = $matriksMaksMin[$kriteria->id]['max'];
                $min = $matriksMaksMin[$kriteria->id]['min'];

                // Rumus Normalisasi SAW
                if (strtolower($kriteria->jenis) == 'benefit') {
                    $nilaiNormalisasi = $max != 0 ? ($nilaiAsli / $max) : 0;
                } else { 
                    $nilaiNormalisasi = $nilaiAsli != 0 ? ($min / $nilaiAsli) : 0;
                }

                // Nilai Terbobot (Hasil Normalisasi x Bobot Kriteria)
                $nilaiTerbobot = $nilaiNormalisasi * $kriteria->bobot;
                $totalNilaiV += $nilaiTerbobot;

                // Simpan detail untuk ditampilkan di view jika dibutuhkan
                $detailNilaiAsli[$kriteria->id] = $nilaiAsli;
                $detailNormalisasi[$kriteria->id] = $nilaiNormalisasi;
            }

            // Memasukkan hasil kalkulasi lengkap ke array sesuai nama kolom database warga
            $hasilRanking[] = [
                'nik' => $alt->nik,
                'nama' => $alt->nama, 
                'alamat' => $alt->alamat,
                'status' => $alt->status,
                'detail_nilai_asli' => $detailNilaiAsli,
                'detail_normalisasi' => $detailNormalisasi,
                'skor_akhir' => $totalNilaiV
            ];
        }

        // 4. Mengurutkan (Ranking) dari skor tertinggi (V) ke terendah
        usort($hasilRanking, function ($a, $b) {
            return $b['skor_akhir'] <=> $a['skor_akhir'];
        });

        return view('perhitungan.index', compact('kriterias', 'hasilRanking'));
    }
}