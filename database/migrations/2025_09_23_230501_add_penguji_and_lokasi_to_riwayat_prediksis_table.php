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
        Schema::table('riwayat_prediksis', function (Blueprint $table) {
            // Menambahkan kolom baru setelah kolom 'model_ai'
            $table->string('nama_penguji')->nullable()->after('model_ai');
            $table->string('lokasi_pengujian')->nullable()->after('nama_penguji');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_prediksis', function (Blueprint $table) {
            //
        });
    }
};
