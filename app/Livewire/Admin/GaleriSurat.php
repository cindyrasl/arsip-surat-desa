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

    public bool   $showPreview     = false;
    public ?array $previewData     = null;

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

    public function openPreview(int $id, string $type): void
    {
        if ($type === 'masuk') {
            $item = SuratMasuk::with('jenis')->findOrFail($id);
            $this->previewData = [
                'id'           => $item->id,
                'type'         => 'masuk',
                'nomor'        => $item->no_surat,
                'asal_tujuan'  => $item->asal_surat,
                'tanggal'      => $item->tanggal_surat ? Carbon::parse($item->tanggal_surat)->format('d/m/Y') : '-',
                'perihal'      => $item->perihal,
                'file_path'    => $item->file_path,
                'file_name'    => $item->file_path ? basename($item->file_path) : '-',
                'jenis'        => $item->jenis?->nama_jenis ?? 'Surat Masuk',
            ];
        } else {
            $item = SuratKeluar::with('jenis')->findOrFail($id);
            $this->previewData = [
                'id'           => $item->id,
                'type'         => 'keluar',
                'nomor'        => $item->no_surat,
                'asal_tujuan'  => $item->tujuan_surat,
                'tanggal'      => $item->tanggal_surat ? Carbon::parse($item->tanggal_surat)->format('d/m/Y') : '-',
                'perihal'      => $item->perihal,
                'file_path'    => $item->file_path,
                'file_name'    => $item->file_path ? basename($item->file_path) : '-',
                'jenis'        => $item->jenis?->nama_jenis ?? 'Surat Keluar',
            ];
        }

        $this->showPreview = true;
    }

    public function closePreview(): void
    {
        $this->showPreview = false;
        $this->previewData = null;
    }

    public function render()
    {
        // Query Surat Masuk
        $masukQuery = SuratMasuk::whereNotNull('file_path')
            ->when($this->search, function ($q) {
                $s = $this->search;
                $q->where('no_surat', 'like', "%{$s}%")
                  ->orWhere('asal_surat', 'like', "%{$s}%")
                  ->orWhere('perihal', 'like', "%{$s}%");
            })
            ->when($this->dateStart, fn($q) => $q->where('tanggal_surat', '>=', $this->dateStart))
            ->when($this->dateEnd, fn($q) => $q->where('tanggal_surat', '<=', $this->dateEnd));

        // Query Surat Keluar
        $keluarQuery = SuratKeluar::whereNotNull('file_path')
            ->when($this->search, function ($q) {
                $s = $this->search;
                $q->where('no_surat', 'like', "%{$s}%")
                  ->orWhere('tujuan_surat', 'like', "%{$s}%")
                  ->orWhere('perihal', 'like', "%{$s}%");
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