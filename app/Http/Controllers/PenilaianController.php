<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    // Menampilkan semua warga untuk diisi nilainya
    public function index()
    {
        $alternatifs = Alternatif::with('kriterias')->get();
        return view('penilaian.index', compact('alternatifs'));
    }

    // Menampilkan Form Input Nilai Kriteria untuk warga tertentu
    public function create($id)
    {
        $warga = Alternatif::findOrFail($id);
        $kriterias = Kriteria::all();
        
        // Ambil nilai yang sudah diinput sebelumnya (jika ada)
        $nilaiWarga = $warga->kriterias->pluck('pivot.nilai', 'id')->toArray();

        return view('penilaian.create', compact('warga', 'kriterias', 'nilaiWarga'));
    }

    // Menyimpan atau memperbarui nilai kriteria ke tabel pivot alternatif_kriteria
    public function store(Request $request, $id)
    {
        $warga = Alternatif::findOrFail($id);
        
        $syncData = [];
        foreach ($request->nilai as $kriteriaId => $nilai) {
            $syncData[$kriteriaId] = ['nilai' => $nilai ?? 0];
        }

        // Fungsi sync() otomatis mengisi/mengupdate tabel alternatif_kriteria
        $warga->kriterias()->sync($syncData);

        return redirect()->route('penilaian.index')->with('success', 'Nilai kriteria warga berhasil disimpan!');
    }
}