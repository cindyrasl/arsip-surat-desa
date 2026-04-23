<div class="max-w-7xl mx-auto">

    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-800 leading-tight">Riwayat Aktivitas</h1>
                <p class="text-xs text-gray-500">Catatan semua aktivitas pengguna sistem</p>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3 mb-5">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
            </span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari aktivitas atau pengguna..."
                class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
        </div>

        <div class="relative">
            <select wire:model.live="filterAktivitas" class="pl-4 pr-9 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all appearance-none cursor-pointer w-48">
                <option value="">Semua Aktivitas</option>
                <option value="login">Login</option>
                <option value="logout">Logout</option>
                <option value="tambah">Tambah Surat</option>
                <option value="edit">Edit Surat</option>
                <option value="hapus">Hapus Surat</option>
            </select>
            <span class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6" stroke-linecap="round"/></svg>
            </span>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                <h2 class="font-bold text-gray-800">Log Aktivitas</h2>
            </div>
            <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-3 py-1 rounded-full">{{ $riwayat->total() }} Aktivitas</span>
        </div>

        <div class="divide-y divide-gray-50 px-6 py-2">
            @forelse($riwayat as $log)
                @php
                    $badgeClasses = [
                        'login'  => 'bg-blue-100 text-blue-700',
                        'logout' => 'bg-amber-100 text-amber-700',
                        'tambah' => 'bg-green-100 text-green-700',
                        'edit'   => 'bg-orange-100 text-orange-700',
                        'hapus'  => 'bg-red-100 text-red-700',
                    ];
                    $badgeClass = $badgeClasses[$log->aktivitas] ?? 'bg-gray-100 text-gray-600';
                    $initial = strtoupper(substr($log->user?->nama ?? 'U', 0, 1));
                    $colors = ['bg-blue-100 text-blue-600','bg-green-100 text-green-600','bg-amber-100 text-amber-600','bg-purple-100 text-purple-600'];
                    $colorIdx = crc32($log->user?->nama ?? '') % count($colors);
                    $avColor = $colors[abs($colorIdx)];
                @endphp
                <div class="flex items-start gap-4 py-3 px-3 -mx-3 rounded-xl hover:bg-sky-50 transition-colors duration-150">
                    <div class="flex flex-col items-center flex-shrink-0">
                        <div class="w-9 h-9 rounded-xl {{ $avColor }} flex items-center justify-center font-bold text-sm flex-shrink-0 shadow-sm">
                            {{ $initial }}
                        </div>
                    </div>
                    <div class="flex-1 min-w-0 pb-1">
                        <div class="flex flex-wrap items-center gap-2 mb-0.5">
                            <span class="text-sm font-bold text-gray-800">{{ $log->user?->nama ?? 'Unknown' }}</span>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                {{ ucfirst($log->aktivitas) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $log->deskripsi }}</p>
                        <div class="flex items-center gap-1.5 mt-1.5">
                            <svg class="w-3 h-3 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            <span class="text-xs text-gray-400">{{ $log->logged_at?->format('d/m/Y H:i') }} WIB</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-16 text-center px-6">
                    <div class="w-14 h-14 rounded-2xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 9h1M9 12h6M9 15h6M14 9h1"/></svg>
                    </div>
                    <p class="text-gray-400 text-sm font-medium">Tidak ada aktivitas ditemukan.</p>
                    <p class="text-gray-300 text-xs mt-1">Coba ubah filter pencarian.</p>
                </div>
            @endforelse
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-t border-gray-100">
            <p class="text-sm text-gray-500">
                @if($riwayat->total() > 0)
                    Menampilkan <span class="font-semibold text-gray-700">{{ $riwayat->firstItem() }}</span>–<span class="font-semibold text-gray-700">{{ $riwayat->lastItem() }}</span> dari <span class="font-semibold text-gray-700">{{ $riwayat->total() }}</span> aktivitas
                @else Menampilkan <b>0</b> aktivitas @endif
            </p>
            <div class="flex items-center gap-1">{{ $riwayat->links('vendor.pagination.simple-tailwind') }}</div>
        </div>
    </div>
</div>