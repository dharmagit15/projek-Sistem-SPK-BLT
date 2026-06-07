<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;   // Pastikan ini ditambahkan agar Controller kenal dengan tabel Kriteria
use App\Models\Alternatif; // Pastikan ini ditambahkan agar Controller kenal dengan tabel Alternatif

class PerhitunganController extends Controller
{
    public function index()
    {
        // 1. Ambil data kriteria (Pastikan nama variabelnya $kriterias)
        $kriterias = Kriteria::orderBy('id', 'ASC')->get(); 
        
        // 2. Ambil data warga (Pastikan nama variabelnya $alternatifs)
        $alternatifs = Alternatif::all();

        // 3. Lempar variabel ke view (Namanya harus persis tanpa tanda $)
        return view('perhitungan.index', compact('kriterias', 'alternatifs'));
    }
}