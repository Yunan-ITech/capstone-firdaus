<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test login functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = 'admin@klinikfirdaus.com';
        $password = 'password123';

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error('User tidak ditemukan!');
            return;
        }

        $this->info('User ditemukan:');
        $this->info('ID: ' . $user->id);
        $this->info('Name: ' . $user->name);
        $this->info('Email: ' . $user->email);
        $this->info('Password Hash: ' . $user->password);

        // Test password verification
        if (Hash::check($password, $user->password)) {
            $this->info('✅ Password verification berhasil!');
        } else {
            $this->error('❌ Password verification gagal!');
        }

        // Test Auth::attempt
        if (\Illuminate\Support\Facades\Auth::attempt(['email' => $email, 'password' => $password])) {
            $this->info('✅ Auth::attempt berhasil!');
        } else {
            $this->error('❌ Auth::attempt gagal!');
        }
    }
}
