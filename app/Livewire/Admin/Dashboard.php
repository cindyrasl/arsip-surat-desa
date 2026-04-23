<?php

namespace App\Livewire\Admin;

use App\Models\JenisSurat;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    // Statistik
    public int $totalSuratMasuk  = 0;
    public int $totalSuratKeluar = 0;
    public int $totalPengguna    = 0;
    public int $totalJenisSurat  = 0;

    // Data terbaru
    public $suratMasukTerbaru;
    public $suratKeluarTerbaru;

    public function mount()
    {
        $this->totalSuratMasuk  = SuratMasuk::count();
        $this->totalSuratKeluar = SuratKeluar::count();
        $this->totalPengguna    = User::count();
        $this->totalJenisSurat  = JenisSurat::count();

        $this->suratMasukTerbaru = SuratMasuk::with('jenis')
            ->latest()
            ->take(5)
            ->get();

        $this->suratKeluarTerbaru = SuratKeluar::with('jenis')
            ->latest()
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('layouts.app');
    }
}
