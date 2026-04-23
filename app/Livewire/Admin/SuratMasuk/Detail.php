<?php

namespace App\Livewire\Admin\SuratMasuk;

use App\Models\SuratMasuk;
use Livewire\Component;

class Detail extends Component
{
    public SuratMasuk $surat;

    public function mount(int $id)
    {
        $this->surat = SuratMasuk::with(['jenis', 'user'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.admin.SuratMasuk.detail', [
            'surat' => $this->surat,
        ])->layout('layouts.app');
    }
}
