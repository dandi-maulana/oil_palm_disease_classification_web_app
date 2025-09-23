<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/xxxx_xx_xx_xxxxxx_create_riwayat_prediksis_table.php
    public function up(): void
    {
        Schema::create('riwayat_prediksis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_file');
            $table->string('hasil_prediksi');
            $table->string('kepercayaan');
            $table->string('lokasi_dataset');
            $table->string('model_ai');
            $table->timestamp('waktu_sebelum_uji');
            $table->timestamp('waktu_sesudah_uji')->nullable();
            $table->float('durasi_pengujian', 8, 4)->nullable(); // Dalam detik
            $table->timestamps();
        });
    }
};
