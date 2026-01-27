<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nama_lengkap' => 'Admin STMC',
            'email' => 'admin@stmc.com',
            'no_telepon' => '08123456789',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        User::create([
            'nama_lengkap' => 'Parma',
            'email' => 'x',
            'no_telepon' => '082196031870',
            'password' => Hash::make('parma123'),
            'role' => 'user',
            'status' => 'active',
        ]);
    }
}
