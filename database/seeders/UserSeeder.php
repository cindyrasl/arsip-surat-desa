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
        $users = [
            [
                'nama' => 'Admin Sistem',
                'username' => 'admin',
                'email' => 'admin@desa.com',
                'password' => Hash::make('password123'),
                'jabatan' => 'Operator Sistem',
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']], // Cek berdasarkan email agar tidak duplikat
                $user // Jika belum ada, buat dengan data lengkap
            );
        }
    }
}