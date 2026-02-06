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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori'); // Contoh: Surat Tugas
            $table->enum('jenis_kategori', ['masuk', 'keluar']); // Jenis: masuk atau keluar
            $table->string('instansi');      // Contoh: STMC atau KANTORPUSAT
            $table->string('kode_kategori'); // Contoh: ST atau SI
            $table->string('format_nomor');  // Contoh: {no}/{instansi}/{kode}/{bulan}/{tahun}
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
