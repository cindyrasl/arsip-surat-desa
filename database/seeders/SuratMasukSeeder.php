<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuratMasuk;
use App\Models\JenisSurat;
use App\Models\User;
use Carbon\Carbon;

class SuratMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisIds = JenisSurat::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        if (!$jenisIds || !$userIds) {
            $this->command->warn('Seeder gagal: jenis_surat / users kosong');
            return;
        }

        $suratMasuk = [
            [
                'no_surat' => '001/SM/2026',
                'asal_surat' => 'Dinas Kesehatan Kabupaten',
                'perihal' => 'Permohonan Data Kesehatan Masyarakat',
                'tanggal_surat' => '2026-01-15',
                'tanggal_diterima' => '2026-01-16',
                'keterangan' => 'Diterima oleh Sekretaris Desa',
            ],
            [
                'no_surat' => '002/SM/2026',
                'asal_surat' => 'Kecamatan Teluk Kapuas',
                'perihal' => 'Undangan Rapat Koordinasi Desa',
                'tanggal_surat' => '2026-01-20',
                'tanggal_diterima' => '2026-01-21',
                'keterangan' => 'Rapat di Kantor Camat',
            ],
            [
                'no_surat' => '003/SM/2026',
                'asal_surat' => 'Dinas Sosial',
                'perihal' => 'Pemberitahuan Bantuan Sosial Tunai',
                'tanggal_surat' => '2026-02-05',
                'tanggal_diterima' => '2026-02-06',
                'keterangan' => null,
            ],
        ];

        foreach ($suratMasuk as $surat) {
            SuratMasuk::firstOrCreate(
                ['no_surat' => $surat['no_surat']],
                [
                    'jenis_id' => $jenisIds[array_rand($jenisIds)],
                    'user_id' => $userIds[array_rand($userIds)],
                    'asal_surat' => $surat['asal_surat'],
                    'perihal' => $surat['perihal'],
                    'tanggal_surat' => $surat['tanggal_surat'],
                    'tanggal_diterima' => $surat['tanggal_diterima'],
                    'keterangan' => $surat['keterangan'],
                    'file_path' => 'storage/uploads/surat-masuk/' . $surat['no_surat'] . '.pdf',
                ]
            );
        }
    }
}
