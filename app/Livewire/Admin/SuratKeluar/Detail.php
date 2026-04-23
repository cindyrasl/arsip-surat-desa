<?php

namespace App\Livewire\Admin\SuratKeluar;

use App\Models\SuratKeluar;
use Livewire\Component;

class Detail extends Component
{
    public SuratKeluar $surat;

    public function mount(int $id)
    {
        $this->surat = SuratKeluar::with(['jenis', 'user'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.admin.SuratKeluar.detail', [
            'surat' => $this->surat,
        ])->layout('layouts.app');
    }
}
