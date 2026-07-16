<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    // 1. Menampilkan halaman index utama menggunakan Eloquent Model
    public function index(Request $request)
    {
        // Ambil parameter dari query string (?search=...&status=...&per_page=...)
        $search  = $request->input('search');
        $status  = $request->input('status');
        $perPage = $request->input('per_page', 10);

        $alternatifs = Alternatif::query()
            // QUERY DINAMIS: klausa where hanya ditambahkan jika $search terisi
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nik', 'like', "%{$search}%")
                      ->orWhere('nama', 'like', "%{$search}%")
                      ->orWhere('alamat', 'like', "%{$search}%");
                });
            })
            // QUERY DINAMIS: filter status hanya diterapkan jika dipilih
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString(); // pertahankan ?search=..&status=.. saat pindah halaman

        return view('alternatif.index', compact('alternatifs', 'search', 'status', 'perPage'));
    }

    // 2. Menampilkan formulir tambah data warga
    public function create()
    {
        return view('alternatif.create');
    }

    // 3. Menyimpan data warga baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nik'      => 'required|numeric|digits:16|unique:alternatifs,nik',
            'nama'     => 'required|string|max:255',
            'alamat'   => 'required|string',
            'no_telp'  => 'required|string|max:20',
            'status'   => 'required|in:Terverifikasi,Review,Ditolak',
            'foto_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits'   => 'NIK harus tepat berukuran 16 digit.',
            'nik.unique'   => 'NIK ini sudah terdaftar di sistem.',
            'nama.required' => 'Nama Kepala Keluarga wajib diisi.',
            'foto_ktp.image' => 'File yang diunggah harus berupa gambar.',
            'foto_ktp.mimes'  => 'Format foto KTP harus JPG, JPEG, atau PNG.',
            'foto_ktp.max'    => 'Ukuran foto KTP maksimal 2MB.',
        ]);

        // Simpan file foto KTP jika diunggah
        $fotoPath = null;
        if ($request->hasFile('foto_ktp')) {
            $fotoPath = $request->file('foto_ktp')->store('foto-ktp', 'public');
        }

        Alternatif::create([
            'nik'      => $request->nik,
            'nama'     => $request->nama,
            'alamat'   => $request->alamat,
            'no_telp'  => $request->no_telp,
            'status'   => $request->status,
            'foto_ktp' => $fotoPath,
        ]);

        return redirect()->route('alternatif.index')->with('success', 'Data warga berhasil ditambahkan!');
    }

    // 3a. Menampilkan form pendaftaran SPK BLT publik
    public function publicCreate()
    {
        return view('alternatif.public-create');
    }

    // 3b. Menyimpan pendaftaran spesial pengguna umum (hanya submit, tanpa edit)
    public function publicStore(Request $request)
    {
        $request->validate([
            'nik'      => 'required|numeric|digits:16|unique:alternatifs,nik',
            'nama'     => 'required|string|max:255',
            'alamat'   => 'required|string',
            'no_telp'  => 'required|string|max:20',
            'foto_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits'   => 'NIK harus tepat berukuran 16 digit.',
            'nik.unique'   => 'NIK ini sudah terdaftar di sistem.',
            'nama.required' => 'Nama Kepala Keluarga wajib diisi.',
            'foto_ktp.image' => 'File yang diunggah harus berupa gambar.',
            'foto_ktp.mimes'  => 'Format foto KTP harus JPG, JPEG, atau PNG.',
            'foto_ktp.max'    => 'Ukuran foto KTP maksimal 2MB.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_ktp')) {
            $fotoPath = $request->file('foto_ktp')->store('foto-ktp', 'public');
        }

        $alternatif = Alternatif::create([
            'nik'      => $request->nik,
            'nama'     => $request->nama,
            'alamat'   => $request->alamat,
            'no_telp'  => $request->no_telp,
            'status'   => 'Review',
            'foto_ktp' => $fotoPath,
        ]);

        return redirect()->route('user.pendaftaran.show', $alternatif->id)
            ->with('success', 'Data pendaftaran SPK BLT berhasil dikirim.');
    }

    // 3c. Menampilkan ringkasan read-only hasil pengajuan user
    public function publicShow($id)
    {
        $alternatif = Alternatif::findOrFail($id);

        return view('alternatif.public-show', compact('alternatif'));
    }

    // 4. Menghapus data alternatif warga
    public function destroy($id)
    {
        $warga = Alternatif::findOrFail($id);

        // Hapus file foto KTP dari storage jika ada
        if ($warga->foto_ktp && \Storage::disk('public')->exists($warga->foto_ktp)) {
            \Storage::disk('public')->delete($warga->foto_ktp);
        }

        $warga->delete();

        return redirect()->route('alternatif.index')->with('success', 'Data warga berhasil dihapus.');
    }

    // 5. Menampilkan halaman form edit beserta data warga yang dipilih
    public function edit($id)
    {
        $warga = Alternatif::findOrFail($id); 
        
        return view('alternatif.edit', compact('warga'));
    }

    // 6. Menyimpan perubahan data warga ke database
    public function update(Request $request, $id)
    {
        $warga = Alternatif::findOrFail($id);

        $request->validate([
            'nik'      => 'required|numeric|digits:16|unique:alternatifs,nik,' . $warga->id,
            'nama'     => 'required|string|max:255',
            'alamat'   => 'required|string',
            'no_telp'  => 'required|string|max:20',
            'status'   => 'required|in:Terverifikasi,Review,Ditolak',
            'foto_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits'   => 'NIK harus tepat berukuran 16 digit.',
            'nik.unique'   => 'NIK ini sudah digunakan oleh warga lain.',
            'nama.required' => 'Nama Kepala Keluarga wajib diisi.',
            'foto_ktp.image' => 'File yang diunggah harus berupa gambar.',
            'foto_ktp.mimes'  => 'Format foto KTP harus JPG, JPEG, atau PNG.',
            'foto_ktp.max'    => 'Ukuran foto KTP maksimal 2MB.',
        ]);

        $fotoPath = $warga->foto_ktp;

        // Jika ada foto baru diunggah, hapus foto lama lalu simpan yang baru
        if ($request->hasFile('foto_ktp')) {
            if ($fotoPath && \Storage::disk('public')->exists($fotoPath)) {
                \Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto_ktp')->store('foto-ktp', 'public');
        }

        $warga->update([
            'nik'      => $request->nik,
            'nama'     => $request->nama,
            'alamat'   => $request->alamat,
            'no_telp'  => $request->no_telp,
            'status'   => $request->status,
            'foto_ktp' => $fotoPath,
        ]);

        return redirect()->route('alternatif.index')->with('success', 'Data warga berhasil diperbarui!');
    }
}