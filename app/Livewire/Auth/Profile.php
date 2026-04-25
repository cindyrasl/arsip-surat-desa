<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $profile_photo;
    public $old_password = '';
    public $new_password = '';
    public $new_password_confirmation = '';

    #[On('open-profile-modal')] 
    public function openModal()
    {
        $this->showModal = true;
        $this->reset(['old_password', 'new_password', 'new_password_confirmation', 'profile_photo']);
        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function updatePassword()
    {
        $this->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($this->old_password, $user->password)) {
            session()->flash('profile_error', 'Password lama tidak sesuai!');
            return;
        }

        $user->password = Hash::make($this->new_password);
        $user->save();

        $this->reset(['old_password', 'new_password', 'new_password_confirmation']);
        session()->flash('profile_success', 'Password berhasil diubah!');
    }

    public function updatePhoto()
    {
        $this->validate([
            'profile_photo' => 'required|image|max:2048',
        ]);

        $user = auth()->user();

        if ($user->profile_photo && \Storage::disk('public')->exists($user->profile_photo)) {
            \Storage::disk('public')->delete($user->profile_photo);
        }

        $path = $this->profile_photo->store('profiles', 'public');
        $user->profile_photo = $path;
        $user->save();

        $this->reset('profile_photo');
        session()->flash('profile_success', 'Foto profil berhasil diperbarui!');
    }

    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.profile');
    }
}