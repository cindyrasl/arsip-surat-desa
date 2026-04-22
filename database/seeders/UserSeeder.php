<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User untuk Kepala Desa
        User::firstOrCreate(
            ['email' => 'kepaladesa@desa.com'],
            [
                'nama' => 'Slamet Riyadi',
                'username' => 'kepala_desa',
                'password' => Hash::make('password123'),
                'jabatan' => 'Kepala Desa',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'operator@desa.com'],
            [
                'nama' => 'Admin Sistem',
                'username' => 'admin',
                'password' => Hash::make('password123'),
                'jabatan' => 'Operator Sistem',
                'foto' => null,
            ]
        );
    }
}