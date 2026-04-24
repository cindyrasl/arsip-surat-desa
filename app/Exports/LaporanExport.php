<?php

namespace App\Exports;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $jenis;
    protected $dateStart;
    protected $dateEnd;

    public function __construct($jenis, $dateStart, $dateEnd)
    {
        $this->jenis = $jenis;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
    }

    public function collection()
    {
        $allData = collect();

        if ($this->jenis === 'all' || $this->jenis === 'masuk') {
            $masuk = SuratMasuk::with('jenis')
                ->whereBetween('tanggal_surat', [$this->dateStart, $this->dateEnd])
                ->get()
                ->map(function($item) {
                    return [
                        'kategori' => 'Surat Masuk',
                        'no_surat' => $item->no_surat,
                        'perihal' => $item->perihal,
                        'jenis_surat' => $item->jenis?->nama_jenis ?? '-',
                        'asal_tujuan' => $item->asal_surat,
                        'tanggal_surat' => $item->tanggal_surat?->format('d/m/Y'),
                    ];
                });
            $allData = $allData->merge($masuk);
        }

        if ($this->jenis === 'all' || $this->jenis === 'keluar') {
            $keluar = SuratKeluar::with('jenis')
                ->whereBetween('tanggal_surat', [$this->dateStart, $this->dateEnd])
                ->get()
                ->map(function($item) {
                    return [
                        'kategori' => 'Surat Keluar',
                        'no_surat' => $item->no_surat,
                        'perihal' => $item->perihal,
                        'jenis_surat' => $item->jenis?->nama_jenis ?? '-',
                        'asal_tujuan' => $item->tujuan_surat,
                        'tanggal_surat' => $item->tanggal_surat?->format('d/m/Y'),
                    ];
                });
            $allData = $allData->merge($keluar);
        }

        return $allData->sortByDesc('tanggal_surat')->values();
    }

    public function headings(): array
    {
        return [
            'Kategori Surat',
            'Nomor Surat',
            'Perihal',
            'Jenis Surat',
            'Asal/Tujuan',
            'Tanggal Surat',
        ];
    }

    public function map($row): array
    {
        return [
            $row['kategori'],
            $row['no_surat'],
            $row['perihal'],
            $row['jenis_surat'],
            $row['asal_tujuan'],
            $row['tanggal_surat'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E5E7EB']]],
        ];
    }
}