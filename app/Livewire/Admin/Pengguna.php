<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Pengguna extends Component
{
    use WithPagination;

    public string $search     = '';
    public bool   $showModal  = false;
    public bool   $showDelete = false;
    public ?int   $editId     = null;
    public ?int   $deleteId   = null;

    // Form fields
    public string $nama     = '';
    public string $username = '';
    public string $email    = '';
    public string $jabatan  = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function updatedSearch(): void { $this->resetPage(); }

    protected function rules(): array
    {
        $passwordRules = $this->editId
            ? 'nullable|string|min:8|confirmed'
            : 'required|string|min:8|confirmed';

        return [
            'nama'                 => 'required|string|max:100',
            'username'             => 'required|string|max:50|unique:users,username' . ($this->editId ? ",{$this->editId}" : ''),
            'email'                => 'required|email|unique:users,email' . ($this->editId ? ",{$this->editId}" : ''),
            'jabatan'              => 'nullable|string|max:100',
            'password'             => $passwordRules,
            'password_confirmation'=> $this->editId ? 'nullable' : 'required',
        ];
    }

    protected $messages = [
        'nama.required'     => 'Nama wajib diisi.',
        'username.required' => 'Username wajib diisi.',
        'username.unique'   => 'Username sudah digunakan.',
        'email.required'    => 'Email wajib diisi.',
        'email.unique'      => 'Email sudah digunakan.',
        'password.required' => 'Password wajib diisi.',
        'password.min'      => 'Password minimal 8 karakter.',
        'password.confirmed'=> 'Konfirmasi password tidak cocok.',
    ];

    // ── Modal Tambah / Edit ──────────────────────────────────────────

    public function openAddModal(): void
    {
        $this->resetForm();
        $this->editId    = null;
        $this->showModal = true;
    }

    public function openEditModal(int $id): void
    {
        $user = User::findOrFail($id);
        $this->editId   = $id;
        $this->nama     = $user->nama;
        $this->username = $user->username;
        $this->email    = $user->email;
        $this->jabatan  = $user->jabatan ?? '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'nama'    => $this->nama,
            'username'=> $this->username,
            'email'   => $this->email,
            'jabatan' => $this->jabatan,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->editId) {
            User::findOrFail($this->editId)->update($data);
            session()->flash('success', 'Pengguna berhasil diupdate.');
        } else {
            User::create($data);
            session()->flash('success', 'Pengguna berhasil ditambahkan.');
        }

        $this->closeModal();
        $this->resetPage();
    }

    // ── Modal Hapus ──────────────────────────────────────────────────

    public function openDelete(int $id): void
    {
        $this->deleteId   = $id;
        $this->showDelete = true;
    }

    public function closeDelete(): void
    {
        $this->deleteId   = null;
        $this->showDelete = false;
    }

    public function confirmDelete(): void
    {
        if (!$this->deleteId) return;
        User::findOrFail($this->deleteId)->delete();
        session()->flash('success', 'Pengguna berhasil dihapus.');
        $this->closeDelete();
        $this->resetPage();
    }

    // ── Helpers ──────────────────────────────────────────────────────

    private function resetForm(): void
    {
        $this->reset(['nama', 'username', 'email', 'jabatan', 'password', 'password_confirmation', 'editId']);
        $this->resetValidation();
    }

    public function render()
    {
        $pengguna = User::when($this->search, function ($query) {
                $q = $this->search;
                $query->where('nama',     'like', "%{$q}%")
                      ->orWhere('username','like', "%{$q}%")
                      ->orWhere('email',   'like', "%{$q}%")
                      ->orWhere('jabatan', 'like', "%{$q}%");
            })
            ->orderBy('nama')
            ->paginate(10);

        return view('livewire.admin.Pengguna.index', compact('pengguna'))
            ->layout('layouts.app');
    }
}
