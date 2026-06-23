<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;

class KriteriaController extends Controller
{
    // Menampilkan Halaman Tabel Kriteria
    public function index()
    {
        $kriterias = Kriteria::paginate(10);
        return view('kriteria.kriteria', compact('kriterias'));
    }

    // Mengarahkan ke halaman resources/views/kriteria/create.blade.php
    public function create()
    {
        return view('kriteria.create');
    }

    // Memproses Penyimpanan Data Kriteria Baru
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:kriterias,kode',
            'nama' => 'required',
            'jenis' => 'required|in:Benefit,Cost',
            'bobot' => 'required|numeric|between:0,1',
        ]);

        Kriteria::create($request->except('_token'));
        
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan!');
    }

    // Mengarahkan ke halaman resources/views/kriteria/edit.blade.php
    public function edit($id)
    {
        // PERBAIKAN TYPO: Mengubah $kcriteria menjadi $kcriteria agar sinkron dengan compact()
        $kriteria = Kriteria::findOrFail($id); 
        return view('kriteria.edit', compact('kriteria')); // PERBAIKAN VIEW: pastikan foldernya 'kriteria.edit' bukan 'kcriteria.edit'
    }

    // Memproses Pembaruan Data Kriteria Lama
    public function update(Request $request, $id)
    {
        $kcriteria = Kriteria::findOrFail($id);

        $request->validate([
            'kode' => 'required|unique:kriterias,kode,' . $id,
            'nama' => 'required',
            'jenis' => 'required|in:Benefit,Cost',
            'bobot' => 'required|numeric|between:0,1',
        ]);

        $kcriteria->update($request->except(['_token', '_method']));
        
        return redirect()->route('kriteria.index')->with('info', 'Kriteria berhasil diperbarui!');
    }

    // Memproses Penghapusan Data Kriteria
    public function destroy($id)
    {
        $kcriteria = Kriteria::findOrFail($id);
        $kcriteria->delete();
        
        return redirect()->route('kriteria.index')->with('danger', 'Kriteria berhasil dihapus!');
    }
}