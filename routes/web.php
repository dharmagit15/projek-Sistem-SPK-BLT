<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SawController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\DashboardController;


// =========================================================================
// 1. RUTE PUBLIK / LANDING PAGE (Bisa diakses siapa saja tanpa login)
// =========================================================================
Route::get('/', function () {
    return view('welcome'); // Menggunakan tampilan CivicAssist SPK baru
})->name('landing');

// PINDAH KE SINI: Supaya tombol "Simulasi BLT" di depan bisa langsung diklik oleh siapa saja
Route::get('/simulasi', function () {
    return view('simulasi');
})->name('user.simulasi');

// =========================================================================
// 2. RUTE KHUSUS PENGGUNA BIASA (Wajib Login)
// =========================================================================
Route::middleware(['auth'])->group(function () {

    // Rute pendaftaran SPK BLT untuk pengguna (wajib login)
    Route::get('/pendaftaran-blt/riwayat', [AlternatifController::class, 'publicIndex'])->name('user.pendaftaran.index');
    Route::get('/pendaftaran-blt', [AlternatifController::class, 'publicCreate'])->name('user.pendaftaran.create');
    Route::post('/pendaftaran-blt', [AlternatifController::class, 'publicStore'])->name('user.pendaftaran.store');
    Route::get('/pendaftaran-blt/{id}', [AlternatifController::class, 'publicShow'])->name('user.pendaftaran.show');

});


// =========================================================================
// 3. RUTE KHUSUS ADMIN (Wajib Login & Wajib Role Admin)
// =========================================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Rute Dashboard Admin (URL: /admin/dashboard)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Kelola Alternatif (URL: /admin/alternatif)
    Route::resource('alternatif', AlternatifController::class);

    // Kelola Kriteria (URL: /admin/kriteria)
    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
    Route::get('/kriteria/create', [KriteriaController::class, 'create'])->name('kriteria.create');
    Route::post('/kriteria', [KriteriaController::class, 'store'])->name('kriteria.store');
    Route::get('/kriteria/{id}/edit', [KriteriaController::class, 'edit'])->name('kriteria.edit');
    Route::put('/kriteria/{id}', [KriteriaController::class, 'update'])->name('kriteria.update');
    Route::delete('/kriteria/{id}', [KriteriaController::class, 'destroy'])->name('kriteria.destroy');

    // Penilaian & Perhitungan SAW (URL: /admin/penilaian & /admin/perhitungan)
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::get('/penilaian/input/{id}', [SawController::class, 'formNilai'])->name('penilaian.create');
    Route::post('/penilaian/store/{id}', [SawController::class, 'simpanNilai'])->name('penilaian.store');
    Route::get('/perhitungan', [SawController::class, 'hitungSaw'])->name('perhitungan.index');

    // Laporan (URL: /admin/laporan)
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak-pdf', [LaporanController::class, 'cetakPdf'])->name('laporan.pdf');

    // BARIS SIMULASI YANG SALAH TEMPAT DI SINI SUDAH DIHAPUS
});


// ... route lainnya ...

Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('laporan.index');

// TAMBAHKAN DUA BARIS INI:
Route::get('/admin/laporan/excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');
Route::get('/admin/laporan/pdf', [LaporanController::class, 'cetakPdf'])->name('laporan.pdf');
// =========================================================================
// 4. RUTE OTENTIKASI (Laravel Breeze: Login, Register, Logout, dll)
// =========================================================================
require __DIR__.'/auth.php';