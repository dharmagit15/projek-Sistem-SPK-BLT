<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kriteria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Bersihkan data user & kriteria lama
        DB::table('alternatif_kriteria')->delete();
        Kriteria::query()->delete();
        User::query()->delete();

        // 2. Buat Akun Admin Default
        User::create([
            'name' => 'Admin SPK BLT',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // 3. Buat Akun User Biasa Default
        User::create([
            'name' => 'Warga Calon Penerima',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // 4. Suntik Kriteria Baku SPK BLT Realistis (Total Bobot = 1.0)
        Kriteria::create([
            'kode' => 'C1',
            'nama' => 'Penghasilan Kepala Keluarga',
            'jenis' => 'Cost',
            'bobot' => 0.30,
        ]);

        Kriteria::create([
            'kode' => 'C2',
            'nama' => 'Jumlah Tanggungan',
            'jenis' => 'Benefit',
            'bobot' => 0.25,
        ]);

        Kriteria::create([
            'kode' => 'C3',
            'nama' => 'Kondisi Rumah',
            'jenis' => 'Benefit',
            'bobot' => 0.25,
        ]);

        Kriteria::create([
            'kode' => 'C4',
            'nama' => 'Daya Listrik',
            'jenis' => 'Cost',
            'bobot' => 0.20,
        ]);
    }
}
