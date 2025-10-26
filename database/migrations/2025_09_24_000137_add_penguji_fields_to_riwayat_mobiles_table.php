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
        Schema::table('riwayat_mobiles', function (Blueprint $table) {
            $table->string('nama_penguji')->nullable()->after('kepercayaan');
            $table->string('lokasi_pengujian')->nullable()->after('nama_penguji');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_mobiles', function (Blueprint $table) {
            //
        });
    }
};
