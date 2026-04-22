<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisSurat;

class JenisSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisSurat = [
            ['nama_jenis' => 'Surat Keputusan', 'keterangan' => 'Surat keputusan dari kepala desa'],
            ['nama_jenis' => 'Surat Edaran', 'keterangan' => 'Edaran resmi untuk warga/instansi'],
            ['nama_jenis' => 'Surat Undangan', 'keterangan' => 'Undangan rapat atau acara'],
            ['nama_jenis' => 'Surat Tugas', 'keterangan' => 'Penugasan untuk pegawai'],
            ['nama_jenis' => 'Surat Keterangan', 'keterangan' => 'Surat keterangan domisili, usaha, dll'],
            ['nama_jenis' => 'Nota Dinas', 'keterangan' => 'Komunikasi internal antar bagian'],
            ['nama_jenis' => 'Surat Dinas', 'keterangan' => 'Surat resmi antar instansi'],
            ['nama_jenis' => 'Laporan', 'keterangan' => 'Laporan kegiatan atau keuangan'],
        ];

        foreach ($jenisSurat as $jenis) {
            JenisSurat::firstOrCreate($jenis);
        }
    }
}