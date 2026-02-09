<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kategori Eksternal Keluar
        Category::create([
            'nama_kategori' => 'Surat Keluar Eksternal (ST)',
            'jenis' => 'keluar',
            'sifat' => 'external',
            'kode_kategori' => 'EXT',
            'format_nomor' => '{no}/Ext/ST/KK.00.01.01/{bulan}-{tahun}'
        ]);

        // 2. Kategori Internal Keluar
        Category::create([
            'nama_kategori' => 'Surat Keluar Internal (Memo)',
            'jenis' => 'keluar',
            'sifat' => 'internal',
            'kode_kategori' => 'INT',
            'format_nomor' => '{no}/Int/22.00/{bulan}-{tahun}'
        ]);

        // 3. Contoh Kategori Surat Masuk (Umum)
        Category::create([
            'nama_kategori' => 'Surat Masuk Umum',
            'jenis' => 'masuk',
            'sifat' => 'external',
            'kode_kategori' => 'IN',
            'format_nomor' => 'MANUAL' // Untuk surat masuk biasanya diinput manual
        ]);
    }
}
