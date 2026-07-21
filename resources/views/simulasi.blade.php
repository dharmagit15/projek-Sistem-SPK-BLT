<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Simulasi Penerima BLT</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: { 
                    colors: {
                        "primary": "#00236f",
                        "on-primary": "#ffffff",
                        "primary-fixed": "#dce1ff",
                        "surface": "#f8f9ff",
                        "on-surface": "#0b1c30",
                        "outline-variant": "#c5c5d3",
                        "on-surface-variant": "#444651",
                        "secondary-container": "#6cf8bb",
                        "on-secondary-container": "#00714d",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                    },
                    spacing: { "margin-desktop": "32px", "container-max": "1440px" }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-surface text-on-surface font-[Inter] antialiased min-h-screen flex flex-col">

    <x-public-header />

    <main class="flex-grow pt-24 pb-16 px-4">
        <div class="max-w-2xl mx-auto bg-white border border-outline-variant rounded-3xl shadow-sm overflow-hidden">
            
            <div class="p-8 bg-gradient-to-br from-primary to-[#1e3a8a] text-on-primary">
                <div class="flex items-center gap-3 mb-2">
                    <span class="material-symbols-outlined p-2 bg-white/10 rounded-xl">fact_check</span>
                    <h1 class="text-2xl font-bold tracking-tight">Simulasi Penerima Bantuan Langsung Tunai</h1>
                </div>
                <p class="text-white/80 text-sm">Silakan isi 5 kriteria kondisi sosial-ekonomi di bawah ini untuk melihat hasil simulasi.</p>
            </div>

            <div class="p-8 space-y-5">
                
                <div>
                    <label class="block font-bold text-on-surface mb-1.5 flex items-center gap-1.5 text-sm">
                        <span class="material-symbols-outlined text-primary text-sm">payments</span> C1. Pendapatan Bulanan Rumah Tangga
                    </label>
                    <select id="kriteria-pendapatan" class="w-full rounded-xl border-outline-variant focus:border-primary focus:ring-primary p-3 bg-surface text-sm">
                        <option value="100">Sangat Rendah ( < Rp 1.000.000 )</option>
                        <option value="75">Rendah ( Rp 1.000.000 - Rp 2.000.000 )</option>
                        <option value="50">Sedang ( Rp 2.000.001 - Rp 3.500.000 )</option>
                        <option value="25">Tinggi ( > Rp 3.500.000 )</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-on-surface mb-1.5 flex items-center gap-1.5 text-sm">
                        <span class="material-symbols-outlined text-primary text-sm">bolt</span> C2. Daya Listrik Rumah Tinggal
                    </label>
                    <select id="kriteria-listrik" class="w-full rounded-xl border-outline-variant focus:border-primary focus:ring-primary p-3 bg-surface text-sm">
                        <option value="100">Non-PLN / Menumpang Tetangga</option>
                        <option value="75">450 VA</option>
                        <option value="50">900 VA</option>
                        <option value="25">>= 1300 VA</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-on-surface mb-1.5 flex items-center gap-1.5 text-sm">
                        <span class="material-symbols-outlined text-primary text-sm">family_restroom</span> C3. Jumlah Tanggungan Keluarga
                    </label>
                    <select id="kriteria-tanggungan" class="w-full rounded-xl border-outline-variant focus:border-primary focus:ring-primary p-3 bg-surface text-sm">
                        <option value="100">Banyak ( Lebih dari 4 Orang )</option>
                        <option value="75">Cukup ( 3 - 4 Orang )</option>
                        <option value="50">Sedikit ( 1 - 2 Orang )</option>
                        <option value="25">Tidak Ada Tanggungan</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-on-surface mb-1.5 flex items-center gap-1.5 text-sm">
                        <span class="material-symbols-outlined text-primary text-sm">home_work</span> C4. Kondisi Fisik Rumah
                    </label>
                    <select id="kriteria-rumah" class="w-full rounded-xl border-outline-variant focus:border-primary focus:ring-primary p-3 bg-surface text-sm">
                        <option value="100">Tidak Layak (Dinding bambu/papan, lantai tanah)</option>
                        <option value="75">Kurang Layak (Semi permanen, pengerjaan seadanya)</option>
                        <option value="50">Cukup Layak (Permanen, kondisi dinding/atap standar)</option>
                        <option value="25">Sangat Layak (Mewah / Kokoh prima)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-on-surface mb-1.5 flex items-center gap-1.5 text-sm">
                        <span class="material-symbols-outlined text-primary text-sm">work</span> C5. Status Pekerjaan Kepala Keluarga
                    </label>
                    <select id="kriteria-pekerjaan" class="w-full rounded-xl border-outline-variant focus:border-primary focus:ring-primary p-3 bg-surface text-sm">
                        <option value="100">Tidak Bekerja / Lansia / Disabilitas</option>
                        <option value="75">Buruh Harian Lepas / Serabutan</option>
                        <option value="50">Petani / Pedagang Kecil / Wiraswasta Mandiri</option>
                        <option value="25">Karyawan Swasta Tetap / PNS / BUMN</option>
                    </select>
                </div>

                <button id="btn-hitung" class="w-full bg-primary text-on-primary py-4 rounded-xl font-semibold hover:opacity-95 transition-all flex items-center justify-center gap-2 mt-4 shadow-sm">
                    <span class="material-symbols-outlined">analytics</span>
                    <span>Proses & Hitung Hasil</span>
                </button>

                <div id="box-hasil" class="hidden border border-outline-variant rounded-2xl p-6 bg-surface space-y-4 transition-all">
                    <div class="text-center py-2 border-b border-outline-variant/50">
                        <div class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Skor Hasil Perhitungan (SAW)</div>
                        <div id="text-skor" class="text-4xl font-extrabold text-primary my-1">0%</div>
                    </div>
                    
                    <div id="alert-status" class="p-4 rounded-xl flex items-start gap-3">
                        <span id="alert-icon" class="material-symbols-outlined mt-0.5"></span>
                        <div>
                            <div id="alert-title" class="font-bold text-sm"></div>
                            <div id="alert-desc" class="text-xs mt-0.5 opacity-90"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('btn-hitung').addEventListener('click', function() {
            // 1. Mengambil nilai dari 5 kriteria baru
            const c1 = parseFloat(document.getElementById('kriteria-pendapatan').value);
            const c2 = parseFloat(document.getElementById('kriteria-listrik').value);
            const c3 = parseFloat(document.getElementById('kriteria-tanggungan').value);
            const c4 = parseFloat(document.getElementById('kriteria-rumah').value);
            const c5 = parseFloat(document.getElementById('kriteria-pekerjaan').value);

            // 2. Alokasi Pembobotan Metode SAW (Total pas 1.0 / 100%)
            // Pendapatan(30%), Listrik(15%), Tanggungan(20%), Rumah(20%), Pekerjaan(15%)
            const totalSkor = Math.round(
                (c1 * 0.30) + 
                (c2 * 0.15) + 
                (c3 * 0.20) + 
                (c4 * 0.20) + 
                (c5 * 0.15)
            );

            // 3. Menyiapkan elemen penampil data
            const boxHasil = document.getElementById('box-hasil');
            const textSkor = document.getElementById('text-skor');
            const alertStatus = document.getElementById('alert-status');
            const alertIcon = document.getElementById('alert-icon');
            const alertTitle = document.getElementById('alert-title');
            const alertDesc = document.getElementById('alert-desc');

            // Cetak total skor dalam persentase
            textSkor.innerText = totalSkor + "%";

            // 4. Klasifikasi Kelayakan Hasil Akhir
            if (totalSkor >= 75) {
                alertStatus.className = "p-4 rounded-xl flex items-start gap-3 bg-secondary-container text-on-secondary-container";
                alertIcon.innerText = "verified_user";
                alertTitle.innerText = "Peluang Lolos: SANGAT TINGGI";
                alertDesc.innerText = "Kondisi ekonomi Anda termasuk dalam prioritas utama sistem untuk diprioritaskan menerima BLT.";
            } else if (totalSkor >= 50) {
                alertStatus.className = "p-4 rounded-xl flex items-start gap-3 bg-primary-fixed text-primary";
                alertIcon.innerText = "info";
                alertTitle.innerText = "Peluang Lolos: SEDANG / CUKUP";
                alertDesc.innerText = "Data Anda memenuhi syarat dasar. Kelayakan akhir bergantung pada ketersediaan kuota kuantum bansos desa.";
            } else {
                alertStatus.className = "p-4 rounded-xl flex items-start gap-3 bg-error-container text-on-error-container";
                alertIcon.innerText = "gpp_maybe";
                alertTitle.innerText = "Peluang Lolos: RENDAH";
                alertDesc.innerText = "Maaf, tingkat urgensi ekonomi dari data simulasi Anda berada di bawah batas target utama penerima bantuan.";
            }

            // Tampilkan kotak hasil dengan smooth scroll
            boxHasil.classList.remove('hidden');
            boxHasil.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });
    </script>
</body>
</html>