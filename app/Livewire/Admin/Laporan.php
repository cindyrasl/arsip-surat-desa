<?php

namespace App\Livewire\Admin;

use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Laporan extends Component
{
    use WithPagination;

    public string $jenis = 'all';
    public string $dateStart = '';
    public string $dateEnd = '';

    public function updatedJenis() { $this->resetPage(); }
    public function updatedDateStart() { $this->resetPage(); }
    public function updatedDateEnd() { $this->resetPage(); }

    public function exportExcel(): void
    {
        // Cek apakah rentang tanggal sudah dipilih
        if (!$this->dateStart || !$this->dateEnd) {
            $this->dispatch('show-toast', message: 'Pilih rentang tanggal terlebih dahulu!');
            return;
        }

        $this->dispatch('show-toast', message: 'Fitur export Excel sedang dalam pengembangan');
    }

    public function getDataLaporanProperty()
    {
        $allData = collect();

        if ($this->jenis === 'all' || $this->jenis === 'masuk') {
            $query = SuratMasuk::with('jenis');
            
            // Filter hanya jika tanggal diisi
            if ($this->dateStart && $this->dateEnd) {
                $query->whereBetween('tanggal_surat', [$this->dateStart, $this->dateEnd]);
            }
            
            $masuk = $query->get()->map(function($item) {
                return [
                    'id' => $item->id,
                    'kategori' => 'masuk',
                    'no_surat' => $item->no_surat,
                    'perihal' => $item->perihal,
                    'jenis_surat' => $item->jenis?->nama_jenis ?? '-',
                    'tanggal_surat' => $item->tanggal_surat,
                ];
            });
            $allData = $allData->merge($masuk);
        }

        if ($this->jenis === 'all' || $this->jenis === 'keluar') {
            $query = SuratKeluar::with('jenis');
            
            // Filter hanya jika tanggal diisi
            if ($this->dateStart && $this->dateEnd) {
                $query->whereBetween('tanggal_surat', [$this->dateStart, $this->dateEnd]);
            }
            
            $keluar = $query->get()->map(function($item) {
                return [
                    'id' => $item->id,
                    'kategori' => 'keluar',
                    'no_surat' => $item->no_surat,
                    'perihal' => $item->perihal,
                    'jenis_surat' => $item->jenis?->nama_jenis ?? '-',
                    'tanggal_surat' => $item->tanggal_surat,
                ];
            });
            $allData = $allData->merge($keluar);
        }

        $allData = $allData->sortByDesc('tanggal_surat')->values();

        return $this->paginateCollection($allData, 10);
    }

    private function paginateCollection($collection, $perPage = 10)
    {
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->values();
        
        return new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );
    }

    public function render()
    {
        return view('livewire.admin.Laporan.index', [
            'dataLaporan' => $this->dataLaporan,
        ])->layout('layouts.app');
    }
}