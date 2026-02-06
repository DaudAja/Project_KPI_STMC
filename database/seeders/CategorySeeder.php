<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Category::create([
            'nama_kategori' => 'Surat Keputusan',
            'jenis_kategori' => 'keluar',
            'instansi' => 'STMC',
            'kode_kategori' => 'SK',
            'format_nomor' => '{no}/{instansi}/{kode}/{bulan}/{tahun}'
        ]);

        \App\Models\Category::create([
            'nama_kategori' => 'Surat Internal Pusat',
            'jenis_kategori' => 'masuk',
            'instansi' => 'KTPS',
            'kode_kategori' => 'SI',
            'format_nomor' => '{no}/{instansi}/{kode}/{bulan}/{tahun}'
        ]);
    }
}
