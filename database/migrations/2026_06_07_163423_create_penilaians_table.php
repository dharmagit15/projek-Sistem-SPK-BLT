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
    Schema::create('penilaians', function (Blueprint $table) {
        $table->id();
        
        // Relasi ke tabel alternatifs (Warga)
        $table->foreignId('alternatif_id')->constrained('alternatifs')->cascadeOnDelete();
        
        // Relasi ke tabel kriterias
        $table->foreignId('kriteria_id')->constrained('kriterias')->cascadeOnDelete();
        
        // Kolom untuk menyimpan angka nilai inputannya
        $table->float('nilai'); 
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
