<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Mengambil total jumlah data dari database
        $totalKriteria = Kriteria::count();
        $totalAlternatif = Alternatif::count();
        $totalUser = User::count();

        // 2. Mengambil semua data kriteria untuk ditampilkan di tabel dashboard
        $daftarKriteria = Kriteria::all();

        // 3. Mengambil data alternatif terbaru untuk log aktivitas
        $recentAlternatifs = Alternatif::latest()->take(4)->get();

        // 4. Mengirimkan data ke view dashboard/index.blade.php
        return view('dashboard.index', compact('totalKriteria', 'totalAlternatif', 'totalUser', 'daftarKriteria', 'recentAlternatifs'));
    }
}