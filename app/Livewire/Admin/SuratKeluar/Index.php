<?php

namespace App\Livewire\Admin\SuratKeluar;

use App\Models\RiwayatAktivitas;
use App\Models\SuratKeluar;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search    = '';
    public string $dateStart = '';
    public string $dateEnd   = '';
    public string $sortOrder = 'desc';
    public ?int   $deleteId  = null;

    protected $queryString = [
        'search'    => ['except' => ''],
        'dateStart' => ['except' => ''],
        'dateEnd'   => ['except' => ''],
        'sortOrder' => ['except' => 'desc'],
    ];

    public function updatedSearch():    void { $this->resetPage(); }
    public function updatedDateStart(): void { $this->resetPage(); }
    public function updatedDateEnd():   void { $this->resetPage(); }

    public function toggleSort(): void
    {
        $this->sortOrder = $this->sortOrder === 'desc' ? 'asc' : 'desc';
        $this->resetPage();
    }

    public function openDelete(int $id): void
    {
        $this->deleteId = $id;
        $this->dispatch('open-delete-modal');
    }

    public function closeDelete(): void
    {
        $this->deleteId = null;
        $this->dispatch('close-delete-modal');
    }

    public function confirmDelete(): void
    {
        if (!$this->deleteId) return;

        $surat = SuratKeluar::findOrFail($this->deleteId);

        RiwayatAktivitas::create([
            'user_id'        => Auth::id(),
            'surat_keluar_id'=> $surat->id,
            'aktivitas'      => 'hapus',
            'deskripsi'      => "Menghapus surat keluar: {$surat->no_surat}",
            'logged_at'      => now(),
        ]);

        $surat->delete(); // SoftDelete

        $this->closeDelete();
        session()->flash('success', 'Surat keluar berhasil dihapus.');
    }

    public function render()
    {
        $suratKeluar = SuratKeluar::with(['jenis', 'user'])
            ->when($this->search, function ($query) {
                $query->whereFullText(['no_surat', 'tujuan_surat', 'perihal'], $this->search);
            })
            ->when($this->dateStart, fn($query) =>
                $query->where('tanggal_dikirim', '>=', $this->dateStart)
            )
            ->when($this->dateEnd, fn($query) =>
                $query->where('tanggal_dikirim', '<=', $this->dateEnd)
            )
            ->orderBy('tanggal_dikirim', $this->sortOrder)
            ->paginate(10);

        return view('livewire.admin.SuratKeluar.index', compact('suratKeluar'))
            ->layout('layouts.app');
    }
}
