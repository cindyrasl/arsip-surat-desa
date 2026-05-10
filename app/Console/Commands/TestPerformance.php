<?php

namespace App\Console\Commands;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\JenisSurat;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestPerformance extends Command
{
    protected $signature = 'test:performance {--insert=1000 : Jumlah data dummy yang akan diinsert}';
    protected $description = 'Test database performance untuk Surat Masuk, Surat Keluar, dan Galeri Surat';

    public function handle()
    {
        $insertCount = (int) $this->option('insert');
        
        // Ambil ID jenis surat yang benar-benar ada
        $jenisIds = JenisSurat::pluck('id')->toArray();
        $userId = User::first()?->id ?? 1;
        
        if (empty($jenisIds)) {
            $this->error('Tidak ada data jenis surat. Jalankan seeder dulu!');
            return Command::FAILURE;
        }
        
        $this->info('╔══════════════════════════════════════════════════════════════╗');
        $this->info('║           PERFORMANCE TEST - ARSIP SURAT DESA                ║');
        $this->info('╚══════════════════════════════════════════════════════════════╝');
        $this->newLine();
        
        // ==================== INSERT DATA DUMMY ====================
        $this->info("📝 MENYIAPKAN DATA UJI...");
        $this->info("Jenis surat tersedia: " . implode(', ', $jenisIds));
        
        // Insert data Surat Masuk
        $this->insertSuratMasuk($jenisIds, $userId, $insertCount);
        
        // Insert data Surat Keluar
        $this->insertSuratKeluar($jenisIds, $userId, $insertCount);
        
        // ==================== TEST PERFORMANCE ====================
        $this->newLine();
        $this->info("╔══════════════════════════════════════════════════════════════╗");
        $this->info("║                    HASIL PERFORMANCE TEST                    ║");
        $this->info("╚══════════════════════════════════════════════════════════════╝");
        $this->newLine();
        
        $results = [];
        
        // TEST 1: SURAT MASUK (Versi sebelumnya - tanpa optimasi)
        $this->info("📁 SURAT MASUK (Sebelum Optimasi - SELECT *)");
        $results['sm_before'] = $this->testSuratMasukBefore();
        
        // TEST 2: SURAT MASUK (Versi teroptimasi - dengan select minimal)
        $this->info("📁 SURAT MASUK (Sesudah Optimasi - SELECT minimal)");
        $results['sm_after'] = $this->testSuratMasukAfter();
        
        // TEST 3: SURAT KELUAR (Sebelum optimasi)
        $this->info("📤 SURAT KELUAR (Sebelum Optimasi - SELECT *)");
        $results['sk_before'] = $this->testSuratKeluarBefore();
        
        // TEST 4: SURAT KELUAR (Sesudah optimasi)
        $this->info("📤 SURAT KELUAR (Sesudah Optimasi - SELECT minimal)");
        $results['sk_after'] = $this->testSuratKeluarAfter();
        
        // TEST 5: GALERI SURAT (Query untuk galeri - tampilkan file list)
        $this->info("🖼️ GALERI SURAT (Query untuk menampilkan file)");
        $results['gallery'] = $this->testGaleriSurat();
        
        // ==================== RINGKASAN ====================
        $this->newLine();
        $this->info("╔══════════════════════════════════════════════════════════════╗");
        $this->info("║                       RINGKASAN PERFORMANCE                  ║");
        $this->info("╚══════════════════════════════════════════════════════════════╝");
        
        $this->table(
            ['Menu / Halaman', 'Versi Query', 'Waktu (ms)', 'Status', 'Improvement'],
            [
                ['Surat Masuk', 'SELECT * (Before)', $results['sm_before']['pagination'], 
                 $results['sm_before']['pagination'] > 300 ? '🟡 Sedang' : ($results['sm_before']['pagination'] > 500 ? '🔴 Lambat' : '🟢 Cepat'),
                 '-'],
                
                ['Surat Masuk', 'SELECT minimal (After)', $results['sm_after']['pagination'],
                 $results['sm_after']['pagination'] > 300 ? '🟡 Sedang' : ($results['sm_after']['pagination'] > 500 ? '🔴 Lambat' : '🟢 Cepat'),
                 $this->getImprovement($results['sm_before']['pagination'], $results['sm_after']['pagination'])],
                
                ['Surat Keluar', 'SELECT * (Before)', $results['sk_before']['pagination'],
                 $results['sk_before']['pagination'] > 300 ? '🟡 Sedang' : ($results['sk_before']['pagination'] > 500 ? '🔴 Lambat' : '🟢 Cepat'),
                 '-'],
                
                ['Surat Keluar', 'SELECT minimal (After)', $results['sk_after']['pagination'],
                 $results['sk_after']['pagination'] > 300 ? '🟡 Sedang' : ($results['sk_after']['pagination'] > 500 ? '🔴 Lambat' : '🟢 Cepat'),
                 $this->getImprovement($results['sk_before']['pagination'], $results['sk_after']['pagination'])],
                
                ['Galeri Surat', 'File listing query', $results['gallery']['time'],
                 $results['gallery']['time'] > 300 ? '🟡 Sedang' : ($results['gallery']['time'] > 500 ? '🔴 Lambat' : '🟢 Cepat'),
                 '-'],
            ]
        );
        
        // Test Search dan Filter
        $this->newLine();
        $this->info("📊 DETAIL QUERY LAINNYA (Surat Masuk - Versi Optimasi):");
        $this->table(
            ['Jenis Query', 'Waktu (ms)', 'Status'],
            [
                ['Search LIKE (keyword: Instansi)', $results['sm_after']['search'], 
                 $results['sm_after']['search'] > 200 ? '🟡 Sedang' : '🟢 Cepat'],
                ['Filter Tanggal (2026)', $results['sm_after']['filter'], 
                 $results['sm_after']['filter'] > 200 ? '🟡 Sedang' : '🟢 Cepat'],
                ['Raw Query (Baseline)', $results['sm_after']['baseline'], 
                 $results['sm_after']['baseline'] > 100 ? '🟡 Sedang' : '🟢 Cepat'],
            ]
        );
        
        // ==================== KESIMPULAN ====================
        $this->newLine();
        $this->info("🎯 KESIMPULAN AKHIR:");
        
        $smGood = $results['sm_after']['pagination'] < 300;
        $skGood = $results['sk_after']['pagination'] < 300;
        $galleryGood = $results['gallery']['time'] < 300;
        
        if ($smGood && $skGood && $galleryGood) {
            $this->info("✅✅✅ PERFORMANCE SANGAT BAIK! Semua halaman mampu menangani {$insertCount}+ data dengan cepat.");
            $this->info("   - Surat Masuk: {$results['sm_after']['pagination']} ms");
            $this->info("   - Surat Keluar: {$results['sk_after']['pagination']} ms");
            $this->info("   - Galeri Surat: {$results['gallery']['time']} ms");
        } elseif ($smGood && $skGood) {
            $this->info("✅ PERFORMANCE BAIK. Surat Masuk dan Surat Keluar sudah optimal.");
            $this->warn("⚠️ Galeri Surat perlu perhatian: {$results['gallery']['time']} ms");
        } else {
            $this->warn("⚠️ Masih ada halaman yang perlu dioptimasi.");
            if (!$smGood) $this->warn("   - Surat Masuk: {$results['sm_after']['pagination']} ms (target <300ms)");
            if (!$skGood) $this->warn("   - Surat Keluar: {$results['sk_after']['pagination']} ms (target <300ms)");
        }
        
        // Informasi jumlah data
        $this->newLine();
        $this->info("📊 STATISTIK DATA:");
        $this->line("   - Total Surat Masuk: " . SuratMasuk::count() . " record");
        $this->line("   - Total Surat Keluar: " . SuratKeluar::count() . " record");
        
        return Command::SUCCESS;
    }
    
    /**
     * Insert data dummy surat masuk
     */
    private function insertSuratMasuk($jenisIds, $userId, $count)
    {
        $this->info("\n📥 Inserting {$count} data Surat Masuk...");
        $existingCount = SuratMasuk::count();
        
        for ($i = 1; $i <= $count; $i++) {
            DB::table('surat_masuk')->insert([
                'jenis_id' => $jenisIds[array_rand($jenisIds)],
                'user_id' => $userId,
                'no_surat' => "SM/TEST/{$i}/2026",
                'asal_surat' => "Instansi " . fake()->company(),
                'perihal' => "Perihal surat masuk nomor {$i}",
                'tanggal_surat' => fake()->date(),
                'tanggal_diterima' => fake()->dateTime(),
                'file_path' => 'uploads/surat-masuk/test_' . $i . '.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            if ($i % 100 == 0) {
                $this->info("   ✓ Surat Masuk: {$i}/{$count}");
            }
        }
        $this->info("   ✅ Selesai! Total: " . SuratMasuk::count() . " record (+{$count})");
    }
    
    /**
     * Insert data dummy surat keluar
     */
    private function insertSuratKeluar($jenisIds, $userId, $count)
    {
        $this->info("\n📤 Inserting {$count} data Surat Keluar...");
        $existingCount = SuratKeluar::count();
        
        for ($i = 1; $i <= $count; $i++) {
            DB::table('surat_keluar')->insert([
                'jenis_id' => $jenisIds[array_rand($jenisIds)],
                'user_id' => $userId,
                'no_surat' => "SK/TEST/{$i}/2026",
                'tujuan_surat' => "Instansi " . fake()->company(),
                'perihal' => "Perihal surat keluar nomor {$i}",
                'tanggal_surat' => fake()->date(),
                'tanggal_dikirim' => fake()->dateTime(),
                'file_path' => 'uploads/surat-keluar/test_' . $i . '.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            if ($i % 100 == 0) {
                $this->info("   ✓ Surat Keluar: {$i}/{$count}");
            }
        }
        $this->info("   ✅ Selesai! Total: " . SuratKeluar::count() . " record (+{$count})");
    }
    
    /**
     * Test Surat Masuk - Sebelum optimasi (SELECT *)
     */
    private function testSuratMasukBefore()
    {
        // Pagination dengan relasi
        $start = microtime(true);
        $data = SuratMasuk::with(['jenis', 'user'])->paginate(20);
        $end = microtime(true);
        $pagination = round(($end - $start) * 1000, 2);
        $this->line("   📄 Pagination: {$pagination} ms");
        
        // Search
        $start = microtime(true);
        $data = SuratMasuk::where('asal_surat', 'like', '%Instansi%')->paginate(10);
        $end = microtime(true);
        $search = round(($end - $start) * 1000, 2);
        
        // Filter
        $start = microtime(true);
        $data = SuratMasuk::whereDate('tanggal_diterima', '>=', '2026-01-01')
            ->whereDate('tanggal_diterima', '<=', '2026-12-31')
            ->paginate(20);
        $end = microtime(true);
        $filter = round(($end - $start) * 1000, 2);
        
        // Baseline
        $start = microtime(true);
        $data = DB::table('surat_masuk')->paginate(20);
        $end = microtime(true);
        $baseline = round(($end - $start) * 1000, 2);
        
        return [
            'pagination' => $pagination,
            'search' => $search,
            'filter' => $filter,
            'baseline' => $baseline,
        ];
    }
    
    /**
     * Test Surat Masuk - Setelah optimasi (SELECT minimal)
     */
    private function testSuratMasukAfter()
    {
        // Pagination dengan relasi dan select minimal
        $start = microtime(true);
        $data = SuratMasuk::select(['id', 'no_surat', 'asal_surat', 'perihal', 'tanggal_diterima', 'jenis_id', 'user_id'])
            ->with(['jenis:id,nama_jenis', 'user:id,nama'])
            ->paginate(20);
        $end = microtime(true);
        $pagination = round(($end - $start) * 1000, 2);
        $this->line("   📄 Pagination (optimized): {$pagination} ms");
        
        // Search
        $start = microtime(true);
        $data = SuratMasuk::select(['id', 'no_surat', 'asal_surat', 'perihal', 'tanggal_diterima'])
            ->where('asal_surat', 'like', '%Instansi%')
            ->paginate(10);
        $end = microtime(true);
        $search = round(($end - $start) * 1000, 2);
        
        // Filter
        $start = microtime(true);
        $data = SuratMasuk::select(['id', 'no_surat', 'asal_surat', 'perihal', 'tanggal_diterima'])
            ->whereDate('tanggal_diterima', '>=', '2026-01-01')
            ->whereDate('tanggal_diterima', '<=', '2026-12-31')
            ->paginate(20);
        $end = microtime(true);
        $filter = round(($end - $start) * 1000, 2);
        
        // Baseline
        $start = microtime(true);
        $data = DB::table('surat_masuk')->select(['id', 'no_surat', 'asal_surat', 'perihal'])->paginate(20);
        $end = microtime(true);
        $baseline = round(($end - $start) * 1000, 2);
        
        return [
            'pagination' => $pagination,
            'search' => $search,
            'filter' => $filter,
            'baseline' => $baseline,
        ];
    }
    
    /**
     * Test Surat Keluar - Sebelum optimasi (SELECT *)
     */
    private function testSuratKeluarBefore()
    {
        $start = microtime(true);
        $data = SuratKeluar::with(['jenis', 'user'])->paginate(20);
        $end = microtime(true);
        $pagination = round(($end - $start) * 1000, 2);
        $this->line("   📄 Pagination: {$pagination} ms");
        
        return ['pagination' => $pagination, 'search' => 0, 'filter' => 0, 'baseline' => 0];
    }
    
    /**
     * Test Surat Keluar - Setelah optimasi (SELECT minimal)
     */
    private function testSuratKeluarAfter()
    {
        $start = microtime(true);
        $data = SuratKeluar::select(['id', 'no_surat', 'tujuan_surat', 'perihal', 'tanggal_dikirim', 'jenis_id', 'user_id'])
            ->with(['jenis:id,nama_jenis', 'user:id,nama'])
            ->paginate(20);
        $end = microtime(true);
        $pagination = round(($end - $start) * 1000, 2);
        $this->line("   📄 Pagination (optimized): {$pagination} ms");
        
        return ['pagination' => $pagination, 'search' => 0, 'filter' => 0, 'baseline' => 0];
    }
    
    /**
     * Test Galeri Surat (query untuk menampilkan file-file yang ada)
     */
    private function testGaleriSurat()
    {
        // Simulasi query galeri - mengambil file dari surat masuk dan keluar
        $start = microtime(true);
        
        $suratMasukFiles = DB::table('surat_masuk')
            ->select('no_surat', 'file_path', 'created_at', 'asal_surat')
            ->where('file_path', 'like', '%.pdf%')
            ->orWhere('file_path', 'like', '%.jpg%')
            ->limit(50)
            ->get();
            
        $suratKeluarFiles = DB::table('surat_keluar')
            ->select('no_surat', 'file_path', 'created_at', 'tujuan_surat')
            ->where('file_path', 'like', '%.pdf%')
            ->orWhere('file_path', 'like', '%.jpg%')
            ->limit(50)
            ->get();
        
        // Gabungkan kedua collection
        $allFiles = collect($suratMasukFiles)->merge($suratKeluarFiles);
        
        $end = microtime(true);
        $time = round(($end - $start) * 1000, 2);
        
        $this->line("   🖼️ Galeri query: {$time} ms (total " . count($allFiles) . " file terdeteksi)");
        
        return ['time' => $time, 'count' => count($allFiles)];
    }
    
    /**
     * Hitung persentase peningkatan performa
     */
    private function getImprovement($before, $after)
    {
        if ($before <= 0) return 'N/A';
        $improvement = round((($before - $after) / $before) * 100, 0);
        if ($improvement > 0) {
            return "⬇️ {$improvement}% lebih cepat";
        } elseif ($improvement < 0) {
            return "⬆️ " . abs($improvement) . "% lebih lambat";
        }
        return "=";
    }
}