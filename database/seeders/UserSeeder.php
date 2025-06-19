<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus user yang sudah ada untuk menghindari duplikasi
        User::where('email', 'admin@klinikfirdaus.com')->delete();
        
        // Buat user admin baru
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@klinikfirdaus.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $this->command->info('User admin berhasil dibuat: admin@klinikfirdaus.com / password123');
    }
} 