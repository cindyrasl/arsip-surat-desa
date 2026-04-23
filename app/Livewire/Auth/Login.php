<?php

namespace App\Livewire\Auth;

use App\Models\RiwayatAktivitas;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $username = '';
    public string $password = '';
    public bool $remember   = false;

    protected $rules = [
        'username' => 'required|string',
        'password' => 'required|string|min:6',
    ];

    protected $messages = [
        'username.required' => 'Username wajib diisi.',
        'password.required' => 'Password wajib diisi.',
        'password.min'      => 'Password minimal 6 karakter.',
    ];

    public function login()
    {
        $this->validate();

        $credentials = [
            'username' => $this->username,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            $user = Auth::user();

            // Update last_login_at & last_login_ip
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => request()->ip(),
            ]);

            // Catat riwayat login
            RiwayatAktivitas::create([
                'user_id'    => $user->id,
                'aktivitas'  => 'login',
                'deskripsi'  => "User {$user->username} berhasil login.",
                'logged_at'  => now(),
            ]);

            session()->regenerate();

            return redirect()->route('dashboard');
        }

        $this->addError('username', 'Username atau password salah.');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.auth');
    }
}
