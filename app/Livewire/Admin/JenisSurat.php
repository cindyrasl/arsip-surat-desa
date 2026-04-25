<?php

namespace App\Livewire\Admin;

use App\Models\JenisSurat as JenisSuratModel;
use Livewire\Component;
use Livewire\WithPagination;

class JenisSurat extends Component
{
    use WithPagination;

    public string  $search      = '';
    public bool    $showModal   = false;
    public bool    $showDelete  = false;
    public ?int    $editId      = null;
    public ?int    $deleteId    = null;

    // Form fields
    public string $nama_jenis  = '';
    public string $keterangan  = '';

    protected $rules = [
        'nama_jenis'  => 'required|string|max:150',
        'keterangan'  => 'nullable|string|max:500',
    ];

    protected $messages = [
        'nama_jenis.required' => 'Nama jenis surat wajib diisi.',
        'nama_jenis.max'      => 'Nama jenis surat maksimal 150 karakter.',
    ];

    public function updatedSearch(): void { $this->resetPage(); }

    // ── Modal Tambah / Edit ──────────────────────────────────────────

    public function openAddModal(): void
    {
        $this->resetForm();
        $this->editId    = null;
        $this->showModal = true;
    }

    public function openEditModal(int $id): void
    {
        $jenis = JenisSuratModel::findOrFail($id);
        $this->editId     = $id;
        $this->nama_jenis = $jenis->nama_jenis;
        $this->keterangan = $jenis->keterangan ?? '';
        $this->showModal  = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function save(): void
    {
        $this->validate();

        if ($this->editId) {
            JenisSuratModel::findOrFail($this->editId)->update([
                'nama_jenis'  => $this->nama_jenis,
                'keterangan'  => $this->keterangan,
            ]);
            session()->flash('success', 'Jenis surat berhasil diupdate.');
        } else {
            JenisSuratModel::create([
                'nama_jenis'  => $this->nama_jenis,
                'keterangan'  => $this->keterangan,
            ]);
            session()->flash('success', 'Jenis surat berhasil ditambahkan.');
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
        try {
            JenisSuratModel::findOrFail($this->deleteId)->delete();
            session()->flash('success', 'Jenis surat berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash('error', 'Gagal menghapus! Data ini masih digunakan pada dokumen surat.');
        }
        $this->closeDelete();
        $this->resetPage();
    }

    // ── Helpers ──────────────────────────────────────────────────────

    private function resetForm(): void
    {
        $this->reset(['nama_jenis', 'keterangan', 'editId']);
        $this->resetValidation();
    }

    public function render()
    {
        $jenisSurat = JenisSuratModel::when($this->search, function ($query) {
                $q = $this->search;
                $query->where('nama_jenis', 'like', "%{$q}%")
                      ->orWhere('keterangan', 'like', "%{$q}%");
            })
            ->orderBy('nama_jenis')
            ->paginate(10);

        return view('livewire.admin.JenisSurat.index', compact('jenisSurat'))
            ->layout('layouts.app');
    }
}
