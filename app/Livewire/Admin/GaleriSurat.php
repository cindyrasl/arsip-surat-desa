<?php

namespace App\Livewire\Admin;

use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class GaleriSurat extends Component
{
    use WithPagination;

    public string $search          = '';
    public string $dateStart       = '';
    public string $dateEnd         = '';
    public string $kategori        = 'all';

    protected $queryString = [
        'search'    => ['except' => ''],
        'dateStart' => ['except' => ''],
        'dateEnd'   => ['except' => ''],
        'kategori'  => ['except' => 'all'],
    ];

    public function updatedSearch():    void { $this->resetPage(); }
    public function updatedDateStart(): void { $this->resetPage(); }
    public function updatedDateEnd():   void { $this->resetPage(); }
    public function updatedKategori():  void { $this->resetPage(); }
    
    public function render()
    {
        // Query Surat Masuk
        $masukQuery = SuratMasuk::whereNotNull('file_path')
            ->when($this->search, function ($q) {
                $q->whereFullText(['no_surat', 'asal_surat', 'perihal'], $this->search);
            })
            ->when($this->dateStart, fn($q) => $q->where('tanggal_surat', '>=', $this->dateStart))
            ->when($this->dateEnd, fn($q) => $q->where('tanggal_surat', '<=', $this->dateEnd));

        // Query Surat Keluar
        $keluarQuery = SuratKeluar::whereNotNull('file_path')
            ->when($this->search, function ($q) {
                $q->whereFullText(['no_surat', 'tujuan_surat', 'perihal'], $this->search);
            })
            ->when($this->dateStart, fn($q) => $q->where('tanggal_surat', '>=', $this->dateStart))
            ->when($this->dateEnd, fn($q) => $q->where('tanggal_surat', '<=', $this->dateEnd));

        // Ambil data sebagai array (bukan object) agar tidak error
        $masukItems = collect();
        $keluarItems = collect();

        if ($this->kategori === 'all' || $this->kategori === 'masuk') {
            $masukItems = $masukQuery->latest('tanggal_surat')->get()->map(function($item) {
                return [
                    'id'            => $item->id,
                    'no_surat'      => $item->no_surat,
                    'pihak'         => $item->asal_surat,
                    'perihal'       => $item->perihal,
                    'tanggal_surat' => $item->tanggal_surat,
                    'file_path'     => $item->file_path,
                    'kategori'      => 'masuk',
                ];
            });
        }

        if ($this->kategori === 'all' || $this->kategori === 'keluar') {
            $keluarItems = $keluarQuery->latest('tanggal_surat')->get()->map(function($item) {
                return [
                    'id'            => $item->id,
                    'no_surat'      => $item->no_surat,
                    'pihak'         => $item->tujuan_surat,
                    'perihal'       => $item->perihal,
                    'tanggal_surat' => $item->tanggal_surat,
                    'file_path'     => $item->file_path,
                    'kategori'      => 'keluar',
                ];
            });
        }

        // Gabungkan dan urutkan
        $allFiles = $masukItems->merge($keluarItems)
            ->sortByDesc('tanggal_surat')
            ->values();

        // Pagination manual
        $perPage = 12;
        $currentPage = $this->getPage();
        $total = $allFiles->count();
        $slice = $allFiles->forPage($currentPage, $perPage);

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $slice,
            $total,
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('livewire.admin.GaleriSurat.index', [
            'files'      => $paginator,
            'totalFiles' => $total,
        ])->layout('layouts.app');
    }
}