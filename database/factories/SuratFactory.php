<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Category;
use App\Models\Surat;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Surat>
 */
class SuratFactory extends Factory
{
    protected $model = Surat::class;

    public function definition(): array
    {

        return [
            // Mengambil ID User secara acak dari yang sudah ada
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),

            // Mengambil ID Kategori secara acak
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),

            // Membuat format nomor surat dummy
            'nomor_surat' => $this->faker->unique()->bothify('###/STMC/??/2026'),

            // Membuat perihal surat dummy (bahasa Indonesia)
            'nama_surat' => $this->faker->sentence(4),

            // Tanggal acak dalam 1 tahun terakhir
            'tanggal_surat' => $this->faker->date(),

            // Nama file dummy
            'foto_bukti' => 'dummy_file.pdf',
        ];
    }
}
