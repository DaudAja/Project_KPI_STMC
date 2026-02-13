<?php

namespace Database\Seeders;

use App\Models\Surat;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
        ]);

        User::factory()->create(
            [
                'nama_lengkap' => 'Admin STMC',
                'email' => 'admin@test.com',
                'status' => 'active',
            ]
        );

        Surat::factory(50)->create();
    }
}
