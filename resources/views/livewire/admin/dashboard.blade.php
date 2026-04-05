@extends('layouts.app')
@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Heading -->
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>
        </div>
        <div>
            <h1 class="text-lg font-bold text-gray-800 leading-tight">Beranda Admin</h1>
            <p class="text-xs text-gray-500">Statistik manajemen surat</p>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

        <div class="stat-card bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 text-[#4C83AC]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 font-medium">Total Surat Masuk</p>
            <p class="text-3xl font-extrabold text-gray-800 mt-1">142</p>
        </div>

        <div class="stat-card bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 text-[#4C83AC]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 font-medium">Total Surat Keluar</p>
            <p class="text-3xl font-extrabold text-gray-800 mt-1">92</p>
        </div>

        <div class="stat-card bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 text-[#4C83AC]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 font-medium">Total Galeri Surat</p>
            <p class="text-3xl font-extrabold text-gray-800 mt-1">234</p>
        </div>

        <div class="stat-card bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 text-[#4C83AC]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 font-medium">Total Pengguna</p>
            <p class="text-3xl font-extrabold text-gray-800 mt-1">7</p>
        </div>
    </div>

    <!-- Recent Mail Tables -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h2 class="font-bold text-gray-800 text-sm">Surat Masuk Terbaru</h2>
                <a href="{{ route('suratmasuk.index') }}" class="text-xs font-semibold text-primary hover:text-primary-dark transition-colors">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-gray-50" id="table-masuk"></div>
            <div id="empty-masuk" class="hidden px-5 py-8 text-center text-gray-400 text-sm">Belum ada data surat masuk.</div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h2 class="font-bold text-gray-800 text-sm">Surat Keluar Terbaru</h2>
                <a href="{{ route('suratkeluar.index') }}" class="text-xs font-semibold text-primary hover:text-primary-dark transition-colors">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-gray-50" id="table-keluar"></div>
            <div id="empty-keluar" class="hidden px-5 py-8 text-center text-gray-400 text-sm">Belum ada data surat keluar.</div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    // Data dummy untuk tabel
    const suratMasuk = [
        { nomor: '001/SM/2026', perihal: 'Pembuatan Surat Keterangan', tanggal: '17 Okt 2026' },
        { nomor: '002/SM/2026', perihal: 'Permohonan Izin Keramaian', tanggal: '16 Okt 2026' },
        { nomor: '003/SM/2026', perihal: 'Undangan Rapat Koordinasi', tanggal: '15 Okt 2026' },
        { nomor: '004/SM/2026', perihal: 'Surat Pemberitahuan Kegiatan', tanggal: '14 Okt 2026' },
        { nomor: '005/SM/2026', perihal: 'Permohonan Data Penduduk', tanggal: '13 Okt 2026' },
    ];

    const suratKeluar = [
        { nomor: '001/SK/2026', perihal: 'Pembuatan Surat Keterangan', tanggal: '17 Okt 2026' },
        { nomor: '002/SK/2026', perihal: 'Surat Balasan Koordinasi', tanggal: '16 Okt 2026' },
        { nomor: '003/SK/2026', perihal: 'Pengumuman Jadwal Posyandu', tanggal: '15 Okt 2026' },
        { nomor: '004/SK/2026', perihal: 'Surat Tugas Perangkat Desa', tanggal: '14 Okt 2026' },
        { nomor: '005/SK/2026', perihal: 'Pemberitahuan Dana Bansos', tanggal: '13 Okt 2026' },
    ];

    // SVG Icon untuk Surat Masuk
    const suratMasukIcon = `
        <svg class="w-4 h-4 text-[#4C83AC]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            <path d="M3 8l9 6 9-6" stroke-linecap="round"/>
        </svg>
    `;

    // SVG Icon untuk Surat Keluar
    const suratKeluarIcon = `
        <svg class="w-4 h-4 text-[#4C83AC]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
        </svg>
    `;

    function renderMailTable(data, containerId, emptyId, type) {
        const container = document.getElementById(containerId);
        const empty = document.getElementById(emptyId);

        if (!data.length) {
            if (empty) empty.classList.remove('hidden');
            return;
        }

        if (empty) empty.classList.add('hidden');

        const iconSvg = type === 'masuk' ? suratMasukIcon : suratKeluarIcon;

        container.innerHTML = data.map(item => `
            <div class="flex items-center gap-4 px-5 py-3 cursor-pointer hover:bg-gray-50 transition-colors">
                <div class="w-9 h-9 rounded-lg bg-blue-50 flex-shrink-0 flex items-center justify-center">
                    ${iconSvg}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-gray-700 truncate">${item.nomor}</p>
                    <p class="text-xs text-gray-500 truncate">${item.perihal}</p>
                </div>
                <div class="flex-shrink-0">
                    <span class="text-xs text-gray-400">${item.tanggal}</span>
                </div>
            </div>
        `).join('');
    }

    // Render tabel
    renderMailTable(suratMasuk, 'table-masuk', 'empty-masuk', 'masuk');
    renderMailTable(suratKeluar, 'table-keluar', 'empty-keluar', 'keluar');
</script>
@endpush