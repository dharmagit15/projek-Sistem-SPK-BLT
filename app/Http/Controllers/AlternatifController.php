<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <= INI YANG HARUS DITAMBAHKAN AGAR TIDAK MERAH

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

    // 2. Menampilkan formulir tambah data warga (beserta kriteria)
    public function create()
    {
        $kriterias = Kriteria::orderBy('id', 'asc')->get();

        return view('alternatif.create', compact('kriterias'));
    }

    // 3. Menyimpan data warga baru ke database beserta nilai kriterianya
    public function store(Request $request)
    {
        $kriterias = Kriteria::all();

        $rules = [
            'nik'      => 'required|numeric|digits:16|unique:alternatifs,nik',
            'nama'     => 'required|string|max:255',
            'alamat'   => 'required|string',
            'no_telp'  => 'required|string|max:20',
            'status'   => 'required|in:Terverifikasi,Review,Ditolak',
            'foto_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        $messages = [
            'nik.required'   => 'NIK wajib diisi.',
            'nik.digits'     => 'NIK harus tepat berukuran 16 digit.',
            'nik.unique'     => 'NIK ini sudah terdaftar di sistem.',
            'nama.required'  => 'Nama Kepala Keluarga wajib diisi.',
            'foto_ktp.image' => 'File yang diunggah harus berupa gambar.',
            'foto_ktp.mimes' => 'Format foto KTP harus JPG, JPEG, atau PNG.',
            'foto_ktp.max'   => 'Ukuran foto KTP maksimal 2MB.',
        ];

        if ($kriterias->count() > 0) {
            $rules['nilai'] = 'nullable|array';
            foreach ($kriterias as $k) {
                $rules["nilai.{$k->id}"] = 'nullable|numeric';
            }
        }

        $request->validate($rules, $messages);

        // Simpan file foto KTP jika diunggah
        $fotoPath = null;
        if ($request->hasFile('foto_ktp')) {
            $fotoPath = $request->file('foto_ktp')->store('foto-ktp', 'public');
        }

        $alternatif = Alternatif::create([
            'nik'      => $request->nik,
            'nama'     => $request->nama,
            'alamat'   => $request->alamat,
            'no_telp'  => $request->no_telp,
            'status'   => $request->status,
            'foto_ktp' => $fotoPath,
        ]);

        if ($request->has('nilai') && is_array($request->nilai)) {
            $syncData = [];
            foreach ($request->nilai as $kriteriaId => $nilaiVal) {
                if ($nilaiVal !== null && $nilaiVal !== '') {
                    $syncData[$kriteriaId] = ['nilai' => (float)$nilaiVal];
                }
            }
            $alternatif->kriterias()->sync($syncData);
        }

        return redirect()->route('alternatif.index')->with('success', 'Data warga & nilai kriteria berhasil ditambahkan!');
    }

    // 3a. Menampilkan form pendaftaran SPK BLT bagi pengguna terautentikasi (1 akun = 1 pendaftaran)
    public function publicCreate()
    {
        // Cek jika akun yang sedang login sudah pernah mendaftar
        $existing = Alternatif::where('user_id', auth()->id())->first();
        if ($existing) {
            return redirect()->route('user.pendaftaran.show', $existing->id)
                ->with('info', 'Akun Anda sudah pernah mengirimkan data pendaftaran SPK BLT.');
        }

        // Ambil kriteria secara dinamis dari database (otomatis menyesuaikan jika ada kriteria baru)
        $kriterias = Kriteria::orderBy('id', 'asc')->get();

        return view('alternatif.public.create', compact('kriterias'));
    }

    // 3b. Menyimpan pendaftaran pengguna beserta nilai kriteria yang diisi
    public function publicStore(Request $request)
    {
        // Cek ganda agar user tidak bisa double submit via POST
        $existing = Alternatif::where('user_id', auth()->id())->first();
        if ($existing) {
            return redirect()->route('user.pendaftaran.show', $existing->id)
                ->with('info', 'Akun Anda sudah pernah mendaftar.');
        }

        $kriterias = Kriteria::all();

        $rules = [
            'nik'      => 'required|numeric|digits:16|unique:alternatifs,nik',
            'nama'     => 'required|string|max:255',
            'alamat'   => 'required|string',
            'no_telp'  => 'required|string|max:20',
            'foto_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        $messages = [
            'nik.required'   => 'NIK wajib diisi.',
            'nik.digits'     => 'NIK harus tepat berukuran 16 digit.',
            'nik.unique'     => 'NIK ini sudah terdaftar di sistem.',
            'nama.required'  => 'Nama Kepala Keluarga wajib diisi.',
            'foto_ktp.image' => 'File yang diunggah harus berupa gambar.',
            'foto_ktp.mimes' => 'Format foto KTP harus JPG, JPEG, atau PNG.',
            'foto_ktp.max'   => 'Ukuran foto KTP maksimal 2MB.',
        ];

        // Aturan validasi dinamis untuk setiap kriteria yang ada di database
        if ($kriterias->count() > 0) {
            $rules['nilai'] = 'required|array';
            foreach ($kriterias as $k) {
                $rules["nilai.{$k->id}"] = 'required|numeric';
                $messages["nilai.{$k->id}.required"] = "Nilai untuk kriteria '{$k->nama}' ({$k->kode}) wajib diisi.";
                $messages["nilai.{$k->id}.numeric"]  = "Nilai untuk kriteria '{$k->nama}' harus berupa angka.";
            }
        }

        $request->validate($rules, $messages);

        $fotoPath = null;
        if ($request->hasFile('foto_ktp')) {
            $fotoPath = $request->file('foto_ktp')->store('foto-ktp', 'public');
        }

        $alternatif = Alternatif::create([
            'user_id'  => auth()->id(),
            'nik'      => $request->nik,
            'nama'     => $request->nama,
            'alamat'   => $request->alamat,
            'no_telp'  => $request->no_telp,
            'status'   => 'Review',
            'foto_ktp' => $fotoPath,
        ]);

        // Simpan/Integrasikan nilai kriteria ke tabel pivot alternatif_kriteria
        if ($request->has('nilai') && is_array($request->nilai)) {
            $syncData = [];
            foreach ($request->nilai as $kriteriaId => $nilaiVal) {
                $syncData[$kriteriaId] = ['nilai' => (float)$nilaiVal];
            }
            $alternatif->kriterias()->sync($syncData);
        }

        return redirect()->route('user.pendaftaran.show', $alternatif->id)
            ->with('success', 'Data pendaftaran SPK BLT & kriteria berhasil dikirim.');
    }

    // 3c. Menampilkan ringkasan hasil pengajuan user beserta nilai kriterianya
    public function publicShow($id)
    {
        $alternatif = Alternatif::with('kriterias')->findOrFail($id);

        return view('alternatif.public.show', compact('alternatif'));
    }

    // 3d. Menampilkan riwayat pendaftaran pengguna (spesifik untuk user login)
    public function publicIndex()
    {
        $alternatifs = Alternatif::with('kriterias')
            ->where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->get();

        return view('alternatif.public.index', compact('alternatifs'));
    }

    // 4. Menghapus data alternatif warga
    public function destroy($id)
    {
        $warga = Alternatif::findOrFail($id);

        // Hapus file foto KTP dari storage jika ada (SUDAH BERSIH DARI BACKSLASH)
        if ($warga->foto_ktp && Storage::disk('public')->exists($warga->foto_ktp)) {
            Storage::disk('public')->delete($warga->foto_ktp);
        }

        $warga->delete();

        return redirect()->route('alternatif.index')->with('success', 'Data warga berhasil dihapus.');
    }

    // 5. Menampilkan halaman form edit beserta data warga & nilai kriteria
    public function edit($id)
    {
        $warga = Alternatif::with('kriterias')->findOrFail($id); 
        $kriterias = Kriteria::orderBy('id', 'asc')->get();
        $nilaiWarga = $warga->kriterias->pluck('pivot.nilai', 'id')->toArray();
        
        return view('alternatif.edit', compact('warga', 'kriterias', 'nilaiWarga'));
    }

    // 6. Menyimpan perubahan data warga & nilai kriteria ke database
    public function update(Request $request, $id)
    {
        $warga = Alternatif::findOrFail($id);
        $kriterias = Kriteria::all();

        $rules = [
            'nik'      => 'required|numeric|digits:16|unique:alternatifs,nik,' . $warga->id,
            'nama'     => 'required|string|max:255',
            'alamat'   => 'required|string',
            'no_telp'  => 'required|string|max:20',
            'status'   => 'required|in:Terverifikasi,Review,Ditolak',
            'foto_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        $messages = [
            'nik.required'   => 'NIK wajib diisi.',
            'nik.digits'     => 'NIK harus tepat berukuran 16 digit.',
            'nik.unique'     => 'NIK ini sudah digunakan oleh warga lain.',
            'nama.required'  => 'Nama Kepala Keluarga wajib diisi.',
            'foto_ktp.image' => 'File yang diunggah harus berupa gambar.',
            'foto_ktp.mimes' => 'Format foto KTP harus JPG, JPEG, atau PNG.',
            'foto_ktp.max'   => 'Ukuran foto KTP maksimal 2MB.',
        ];

        if ($kriterias->count() > 0) {
            $rules['nilai'] = 'nullable|array';
            foreach ($kriterias as $k) {
                $rules["nilai.{$k->id}"] = 'nullable|numeric';
            }
        }

        $request->validate($rules, $messages);

        $fotoPath = $warga->foto_ktp;

        if ($request->hasFile('foto_ktp')) {
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
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

        if ($request->has('nilai') && is_array($request->nilai)) {
            $syncData = [];
            foreach ($request->nilai as $kriteriaId => $nilaiVal) {
                if ($nilaiVal !== null && $nilaiVal !== '') {
                    $syncData[$kriteriaId] = ['nilai' => (float)$nilaiVal];
                }
            }
            $warga->kriterias()->sync($syncData);
        }

        return redirect()->route('alternatif.index')->with('success', 'Data warga & nilai kriteria berhasil diperbarui!');
    }
}