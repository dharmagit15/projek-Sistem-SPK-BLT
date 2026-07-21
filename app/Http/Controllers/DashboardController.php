<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;
use App\Models\Alternatif;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Mengambil total jumlah data dari database
        $totalKriteria = Kriteria::count();
        $totalAlternatif = Alternatif::count();

        // 2. Hitung persentase alternatif yang sudah dinilai (Lengkap terisi kriteria)
        $alternatifDinilai = 0;
        $persentaseDinilai = 0;

        if ($totalAlternatif > 0 && $totalKriteria > 0) {
            $alternatifDinilai = Alternatif::has('kriterias', '>=', $totalKriteria)->count();
            $persentaseDinilai = round(($alternatifDinilai / $totalAlternatif) * 100);
        } elseif ($totalAlternatif > 0) {
            $alternatifDinilai = Alternatif::has('kriterias')->count();
            $persentaseDinilai = round(($alternatifDinilai / $totalAlternatif) * 100);
        }

        // 3. Mengambil semua data kriteria untuk ditampilkan di tabel dashboard
        $daftarKriteria = Kriteria::all();

        // 4. Mengambil data alternatif terbaru untuk log aktivitas
        $recentAlternatifs = Alternatif::latest()->take(4)->get();

        // 5. Mengirimkan data ke view dashboard/index.blade.php
        return view('dashboard.index', compact(
            'totalKriteria',
            'totalAlternatif',
            'alternatifDinilai',
            'persentaseDinilai',
            'daftarKriteria',
            'recentAlternatifs'
        ));
    }
}