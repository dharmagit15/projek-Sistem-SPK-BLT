<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('alternatifs', function (Blueprint $table) {
            $table->double('skor_akhir', 8, 4)->default(0)->after('status');
            $table->string('status_kelayakan', 50)->default('TIDAK LAYAK')->after('skor_akhir');
        });
    }

    public function down()
    {
        Schema::table('alternatifs', function (Blueprint $table) {
            $table->dropColumn(['skor_akhir', 'status_kelayakan']);
        });
    }
};
