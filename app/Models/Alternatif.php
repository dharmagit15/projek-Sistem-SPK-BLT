<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    use HasFactory;

    protected $table = 'alternatifs';

    protected $fillable = ['user_id', 'nik', 'nama', 'alamat', 'no_telp', 'status', 'foto_ktp'];

    /**
     * Relasi ke User pengaju pendaftaran
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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