<?php

namespace App\Livewire\Admin\SuratMasuk;

use App\Models\RiwayatAktivitas;
use App\Models\SuratMasuk;
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

    // Delete state
    public ?int $deleteId = null;

    protected $queryString = [
        'search'    => ['except' => ''],
        'dateStart' => ['except' => ''],
        'dateEnd'   => ['except' => ''],
        'sortOrder' => ['except' => 'desc'],
    ];

    // Reset halaman jika filter berubah
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

        $surat = SuratMasuk::findOrFail($this->deleteId);

        RiwayatAktivitas::create([
            'user_id'       => Auth::id(),
            'surat_masuk_id'=> $surat->id,
            'aktivitas'     => 'hapus',
            'deskripsi'     => "Menghapus surat masuk: {$surat->no_surat}",
            'logged_at'     => now(),
        ]);

        $surat->delete(); // SoftDelete

        $this->closeDelete();
        session()->flash('success', 'Surat masuk berhasil dihapus.');
    }

    public function render()
    {
        $suratMasuk = SuratMasuk::with(['jenis', 'user'])
            ->when($this->search, function ($query) {
                $q = $this->search;
                $query->where(function ($q2) use ($q) {
                    $q2->where('no_surat',   'like', "%{$q}%")
                       ->orWhere('asal_surat', 'like', "%{$q}%")
                       ->orWhere('perihal',    'like', "%{$q}%");
                });
            })
            ->when($this->dateStart, fn($query) =>
                $query->where('tanggal_diterima', '>=', $this->dateStart)
            )
            ->when($this->dateEnd, fn($query) =>
                $query->where('tanggal_diterima', '<=', $this->dateEnd)
            )
            ->orderBy('tanggal_diterima', $this->sortOrder)
            ->paginate(10);

        return view('livewire.admin.SuratMasuk.index', compact('suratMasuk'))
            ->layout('layouts.app');
    }
}
