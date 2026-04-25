<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class Profile extends Component
{
    public $showModal = false;
    public $nama = '';
    public $jabatan = '';
    public $email = '';
    public $old_password = '';
    public $new_password = '';
    public $new_password_confirmation = '';

    #[On('open-profile-modal')] 
    public function openModal()
    {
        $user = auth()->user();
        $this->nama = $user->nama;
        $this->jabatan = $user->jabatan ?? '';
        $this->email = $user->email;
        $this->showModal = true;
        $this->reset(['old_password', 'new_password', 'new_password_confirmation']);
        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function updateProfile()
    {
        $user = auth()->user();

        $rules = [
            'nama'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        ];

        // Password opsional
        if ($this->old_password || $this->new_password || $this->new_password_confirmation) {
            $rules['old_password'] = 'required';
            $rules['new_password'] = 'required|min:8|confirmed';
        }

        $this->validate($rules);

        // Update info dasar
        $user->nama = $this->nama;
        $user->jabatan = $this->jabatan;
        $user->email = $this->email;

        // Update password jika diisi
        if ($this->old_password) {
            if (!Hash::check($this->old_password, $user->password)) {
                session()->flash('profile_error', 'Password lama tidak sesuai!');
                return;
            }
            $user->password = Hash::make($this->new_password);
        }

        $user->save();

        $this->reset(['old_password', 'new_password', 'new_password_confirmation']);
        session()->flash('profile_success', 'Profil berhasil diperbarui!');
        
        // Refresh header
        $this->js('setTimeout(() => window.location.reload(), 500)');
    }

    public function render()
    {
        return view('livewire.auth.profile');
    }
}