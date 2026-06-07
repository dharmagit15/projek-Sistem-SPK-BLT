<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alternatif_kriteria', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel alternatifs (id warga)
            $table->foreignId('alternatif_id')->constrained('alternatifs')->onDelete('cascade');
            // Menghubungkan ke tabel kriterias
            $table->foreignId('kriteria_id')->constrained('kriterias')->onDelete('cascade');
            // Menyimpan nilai angka (misal: 80, 4, 3.5, dll)
            $table->float('nilai'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alternatif_kriteria');
    }
};
