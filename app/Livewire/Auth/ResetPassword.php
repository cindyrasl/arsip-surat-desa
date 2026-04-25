<?php

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;

class ResetPassword extends Component
{
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected $rules = [
        'token'                 => 'required',
        'email'                 => 'required|email',
        'password'              => 'required|string|min:8|confirmed',
        'password_confirmation' => 'required',
    ];

    protected $messages = [
        'email.required'    => 'Email wajib diisi.',
        'email.email'       => 'Format email tidak valid.',
        'password.required' => 'Password baru wajib diisi.',
        'password.min'      => 'Password minimal 8 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ];

    public function mount($token = null)
    {
        $this->token = $token ?? request()->route('token');
        $this->email = request()->query('email', '');
    }

    public function resetPassword()
    {
        $this->validate();

        $status = Password::reset(
            [
                'email'                 => $this->email,
                'password'              => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token'                 => $this->token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('status', __($status));
            return redirect()->route('login');
        }

        $this->addError('email', __($status));
    }

    public function render()
    {
        return view('livewire.auth.reset-password')->layout('layouts.auth');
    }
}