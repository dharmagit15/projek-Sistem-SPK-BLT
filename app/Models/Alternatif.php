<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    use HasFactory;

    protected $table = 'alternatifs';

    protected $fillable = ['nik', 'nama', 'alamat', 'no_telp', 'status', 'foto_ktp'];

    /**
     * Relasi Many-to-Many ke Kriteria melalui tabel pivot alternatif_kriteria
     * JANGAN DIHAPUS: Fungsi ini yang menghubungkan data nilai kriteria ke alternatif warga!
     */
    public function kriterias()
    {
        return $this->belongsToMany(Kriteria::class, 'alternatif_kriteria')
                    ->withPivot('nilai')
                    ->withTimestamps();
    }
}