<?php

namespace App\Livewire\Admin;

use App\Models\RiwayatAktivitas as RiwayatAktivitasModel;
use Livewire\Component;
use Livewire\WithPagination;

class RiwayatAktivitas extends Component
{
    use WithPagination;

    public string $filterAktivitas = '';
    public string $search          = '';

    protected $queryString = [
        'filterAktivitas' => ['except' => ''],
        'search'          => ['except' => ''],
    ];

    public function updatedFilterAktivitas(): void { $this->resetPage(); }
    public function updatedSearch():          void { $this->resetPage(); }

    public function render()
    {
        $riwayat = RiwayatAktivitasModel::with('user')
            ->when($this->filterAktivitas, fn($q) =>
                $q->where('aktivitas', $this->filterAktivitas)
            )
            ->when($this->search, function ($query) {
                $s = $this->search;
                $query->where(function ($q2) use ($s) {
                    $q2->where('deskripsi', 'like', "%{$s}%")
                       ->orWhereHas('user', fn($uq) =>
                           $uq->where('nama', 'like', "%{$s}%")
                              ->orWhere('username', 'like', "%{$s}%")
                       );
                });
            })
            ->orderByDesc('logged_at')
            ->paginate(10);

        return view('livewire.admin.RiwayatAktivitas.index', compact('riwayat'))
            ->layout('layouts.app');
    }
}
