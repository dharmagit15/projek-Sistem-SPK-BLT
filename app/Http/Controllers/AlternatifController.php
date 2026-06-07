<?php

    namespace App\Http\Controllers;

    use App\Models\Alternatif;
    use Illuminate\Http\Request;

    class AlternatifController extends Controller
    {
        // 1. Menampilkan halaman index utama (tabel data)
        public function index()
        {
            // Menggunakan DB::table sementara agar membypass kendala join global scope table perhitungan yang belum ada
            $alternatifs = \DB::table('alternatifs')->orderBy('id', 'desc')->paginate(10);

            return view('alternatif.index', compact('alternatifs'));
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
                'nik'     => 'required|numeric|digits:16|unique:alternatifs,nik',
                'nama'    => 'required|string|max:255',
                'alamat'  => 'required|string',
                'no_telp' => 'required|string|max:20',
                'status'  => 'required|in:Terverifikasi,Review,Ditolak',
            ], [
                'nik.required' => 'NIK wajib diisi.',
                'nik.digits'   => 'NIK harus tepat berukuran 16 digit.',
                'nik.unique'   => 'NIK ini sudah terdaftar di sistem.',
                'nama.required' => 'Nama Kepala Keluarga wajib diisi.',
            ]);

            Alternatif::create([
                'nik'     => $request->nik,
                'nama'    => $request->nama,
                'alamat'  => $request->alamat,
                'no_telp' => $request->no_telp,
                'status'  => $request->status,
            ]);

            return redirect()->route('alternatif.index')->with('success', 'Data warga berhasil ditambahkan!');
        }

        // 4. Menghapus data alternatif warga
        public function destroy($id)
        {
            $warga = Alternatif::findOrFail($id);
            $warga->delete();

            return redirect()->route('alternatif.index')->with('success', 'Data warga berhasil dihapus.');
        }

        // 5. Menampilkan halaman form edit beserta data warga yang dipilih
        public function edit($id)
        {
            // Cari data warga berdasarkan id, jika tidak ditemukan otomatis memicu error 404
            $warga = Alternatif::findOrFail($id); 
            
            return view('alternatif.edit', compact('warga'));
        }

        // 6. Menyimpan perubahan data warga ke database
        public function update(Request $request, $id)
        {
            $warga = Alternatif::findOrFail($id);

            $request->validate([
                'nik'     => 'required|numeric|digits:16|unique:alternatifs,nik,' . $warga->id,
                'nama'    => 'required|string|max:255',
                'alamat'  => 'required|string',
                'no_telp' => 'required|string|max:20',
                'status'  => 'required|in:Terverifikasi,Review,Ditolak',
            ], [
                'nik.required' => 'NIK wajib diisi.',
                'nik.digits'   => 'NIK harus tepat berukuran 16 digit.',
                'nik.unique'   => 'NIK ini sudah digunakan oleh warga lain.',
                'nama.required' => 'Nama Kepala Keluarga wajib diisi.',
            ]);

            $warga->update([
                'nik'     => $request->nik,
                'nama'    => $request->nama,
                'alamat'  => $request->alamat,
                'no_telp' => $request->no_telp,
                'status'  => $request->status,
            ]);

            return redirect()->route('alternatif.index')->with('success', 'Data warga berhasil diperbarui!');
        }
    }