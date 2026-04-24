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

    <!-- Flash Message -->
    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

        <div class="stat-card bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 rounded-xl bg-sky-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 text-sky-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 font-medium">Total Surat Masuk</p>
            <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalSuratMasuk }}</p>
        </div>

        <div class="stat-card bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 rounded-xl bg-teal-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 text-teal-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 font-medium">Total Surat Keluar</p>
            <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalSuratKeluar }}</p>
        </div>

        <div class="stat-card bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 rounded-xl bg-orange-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 text-orange-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 font-medium">Total Jenis Surat</p>
            <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalJenisSurat }}</p>
        </div>

        <div class="stat-card bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 rounded-xl bg-rose-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 text-rose-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 font-medium">Total Pengguna</p>
            <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalPengguna }}</p>
        </div>
    </div>

    <!-- Recent Mail Tables -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h2 class="font-bold text-gray-800 text-sm">Surat Masuk Terbaru</h2>
                <a href="{{ route('suratmasuk.index') }}" class="text-xs font-semibold text-primary hover:text-primary-dark transition-colors">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($suratMasukTerbaru as $surat)
                    <div class="flex items-center gap-4 px-5 py-3 cursor-pointer hover:bg-gray-50 transition-colors">
                        <div class="w-9 h-9 rounded-lg bg-sky-100 shrink-0 flex items-center justify-center">
                            <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-gray-700 truncate">{{ $surat->no_surat }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $surat->perihal }}</p>
                        </div>
                        <div class="shrink-0">
                            <span class="text-xs text-gray-400">{{ $surat->tanggal_surat?->format('d/m/Y') ?? '-' }}</span>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-8 text-center text-gray-400 text-sm">Belum ada data surat masuk.</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h2 class="font-bold text-gray-800 text-sm">Surat Keluar Terbaru</h2>
                <a href="{{ route('suratkeluar.index') }}" class="text-xs font-semibold text-primary hover:text-primary-dark transition-colors">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($suratKeluarTerbaru as $surat)
                    <div class="flex items-center gap-4 px-5 py-3 cursor-pointer hover:bg-gray-50 transition-colors">
                        <div class="w-9 h-9 rounded-lg bg-teal-100 shrink-0 flex items-center justify-center">
                            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-gray-700 truncate">{{ $surat->no_surat }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $surat->perihal }}</p>
                        </div>
                        <div class="shrink-0">
                            <span class="text-xs text-gray-400">{{ $surat->tanggal_surat?->format('d/m/Y') ?? '-' }}</span>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-8 text-center text-gray-400 text-sm">Belum ada data surat keluar.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>