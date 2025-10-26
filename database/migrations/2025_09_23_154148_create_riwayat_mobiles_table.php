<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_riwayat_mobiles_table.php
    public function up(): void
    {
        Schema::create('riwayat_mobiles', function (Blueprint $table) {
            $table->id();
            $table->string('gambar_path')->nullable();
            $table->string('nama_file');
            $table->string('hasil_prediksi');
            $table->string('kepercayaan');
            $table->float('durasi_pengujian', 8, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_mobiles');
    }
};
