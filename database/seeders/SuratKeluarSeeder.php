<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuratKeluar;
use App\Models\JenisSurat;
use App\Models\User;
use Carbon\Carbon;


class SuratKeluarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisIds = JenisSurat::pluck('id_jenis')->toArray();
        $userIds = User::pluck('id_user')->toArray();

        if (empty($jenisIds) || empty($userIds)) {
            $this->command->warn('Seeder SuratKeluar: Pastikan JenisSurat dan User sudah di-seed terlebih dahulu!');
            return;
        }

        $suratKeluar = [
            [
                'no_surat' => '001/SK/2026',
                'tujuan_surat' => 'Dinas Kesehatan Kabupaten',
                'perihal' => 'Pengiriman Data Kesehatan Masyarakat',
                'tanggal_surat' => '2026-01-17',
                'tanggal_dikirim' => '2026-01-18',
                'keterangan' => 'Dikirim melalui kurir desa',
            ],
            [
                'no_surat' => '002/SK/2026',
                'tujuan_surat' => 'Kecamatan Teluk Kapuas',
                'perihal' => 'Laporan Kegiatan Desa',
                'tanggal_surat' => '2026-01-22',
                'tanggal_dikirim' => '2026-01-23',
                'keterangan' => null,
            ],
            [
                'no_surat' => '003/SK/2026',
                'tujuan_surat' => 'Dinas Sosial',
                'perihal' => 'Pengajuan Bantuan Sosial',
                'tanggal_surat' => '2026-02-07',
                'tanggal_dikirim' => '2026-02-08',
                'keterangan' => 'Dengan hormat, kami ajukan',
            ],
        ];

        foreach ($suratKeluar as $index => $surat) {
            SuratKeluar::firstOrCreate(
                ['no_surat' => $surat['no_surat']], // Cek berdasarkan no_surat agar tidak duplikat
                [
                    'id_jenis' => $jenisIds[array_rand($jenisIds)],
                    'id_user' => $userIds[array_rand($userIds)],
                    'tujuan_surat' => $surat['tujuan_surat'],
                    'perihal' => $surat['perihal'],
                    'tanggal_surat' => $surat['tanggal_surat'],
                    'tanggal_dikirim' => $surat['tanggal_dikirim'],
                    'keterangan' => $surat['keterangan'],
                    'file_path' => 'dummy/surat-keluar/dummy.pdf', // Path dummy
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}
