<div class="max-w-7xl mx-auto">
    <!-- Page Title -->
    <div class="flex items-center mb-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
            </svg>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-800 leading-tight">Surat Keluar</h1>
                <p class="text-xs text-gray-500">Kelola arsip surat keluar</p>
            </div>
        </div>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-5 mb-4">
        <div class="flex flex-wrap items-end gap-4">
            <!-- Search -->
            <div class="flex-1 min-w-50">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Pencarian</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                        </svg>
                    </span>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Cari nomor surat, perihal, atau tujuan surat..."
                        class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                </div>
            </div>

            <!-- Tanggal (Dari) -->
            <div class="flex-2 min-w-45">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tanggal (Dari)</label>
                <input type="date" wire:model.live="dateStart"
                    class="w-full pl-4 pr-5 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
            </div>

            <!-- Tanggal (Sampai) -->
            <div class="flex-2 min-w-45">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tanggal (Sampai)</label>
                <input type="date" wire:model.live="dateEnd"
                    class="w-full pl-4 pr-5 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
            </div>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div wire:loading wire:target="search, dateStart, dateEnd" 
        style="width: 100%; text-align: center; padding-top: 6rem; padding-bottom: 5rem;">
        <div style="display: inline-block; text-align: center;">
            <svg class="animate-spin w-10 h-10 text-primary mb-4" style="margin: 0 auto;" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
            </svg>
            <br>
            <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">Memuat data...</span>
        </div>
    </div>

    <!-- Table Card -->
    <div wire:loading.remove wire:target="search, dateStart, dateEnd">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h2 class="font-bold text-gray-800">Daftar Surat Keluar</h2>
                <a href="{{ route('suratkeluar.create') }}"
                    class="flex items-center gap-2 bg-primary hover:bg-primary-dark text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M12 5v14M5 12h14" stroke-linecap="round"/>
                    </svg>
                    Tambah Surat Keluar
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100 border-b border-gray-100">
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide w-14">No</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide">Nomor Surat</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide">
                                <div class="flex items-center gap-2 cursor-pointer group" wire:click="toggleSort">
                                    <span>Tanggal Dikeluarkan</span>
                                    <div class="flex flex-col">
                                        <svg class="w-3 h-3 -mb-1 {{ $sortOrder === 'asc' ? 'text-primary' : 'text-gray-400' }} group-hover:text-gray-600 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 5l4 5H6l4-5z"/>
                                        </svg>
                                        <svg class="w-3 h-3 {{ $sortOrder === 'desc' ? 'text-primary' : 'text-gray-400' }} group-hover:text-gray-600 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 15l-4-5h8l-4 5z"/>
                                        </svg>
                                    </div>
                                </div>
                            </th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide">Perihal</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide">Tujuan Surat</th>
                            <th class="text-center px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($suratKeluar as $i => $surat)
                            <tr class="hover:bg-gray-100 transition-colors">
                                <td class="px-6 py-3.5 text-gray-400 text-center text-sm">{{ $suratKeluar->firstItem() + $i }}</td>
                                <td class="px-6 py-3.5 font-semibold text-gray-800 text-sm whitespace-nowrap">{{ $surat->no_surat }}</td>
                                <td class="px-6 py-3.5 text-gray-600 text-sm whitespace-nowrap">{{ $surat->tanggal_dikirim?->format('m/d/Y') ?? '-' }}</td>
                                <td class="px-6 py-3.5 text-gray-700 text-sm">{{ $surat->perihal }}</td>
                                <td class="px-6 py-3.5 text-gray-600 text-sm">{{ $surat->tujuan_surat }}</td>
                                <td class="px-6 py-3.5">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('suratkeluar.detail', $surat->id) }}" title="Lihat Detail"
                                            class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 flex items-center justify-center transition-colors">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('suratkeluar.edit', $surat->id) }}" title="Edit"
                                            class="w-8 h-8 rounded-lg bg-amber-50 hover:bg-amber-100 flex items-center justify-center transition-colors">
                                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                                <path d="M17.586 3.586a2 2 0 012.828 2.828L12 15l-4 1 1-4 8.586-8.414z"/>
                                            </svg>
                                        </a>
                                        <button wire:click="openDelete({{ $surat->id }})" title="Hapus"
                                            class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 flex items-center justify-center transition-colors">
                                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center">
                                    <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-gray-400 text-sm font-medium">Tidak ada data surat keluar.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-t border-gray-100">
                <p class="text-sm text-gray-500">
                    @if($suratKeluar->total() > 0)
                        Menampilkan <span class="font-semibold text-gray-700">{{ $suratKeluar->firstItem() }}</span> -
                        <span class="font-semibold text-gray-700">{{ $suratKeluar->lastItem() }}</span> dari
                        <span class="font-semibold text-gray-700">{{ $suratKeluar->total() }}</span> data
                    @else
                        Menampilkan <b>0</b> data
                    @endif
                </p>
                <div class="flex items-center gap-1">
                    {{ $suratKeluar->links('vendor.pagination.simple-tailwind') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    @if($deleteId)
    <div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
            <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-800 mb-1">Hapus Surat?</h3>
            <p class="text-sm text-gray-500 mb-6">Data surat akan dihapus secara permanen dan tidak dapat dipulihkan.</p>
            <div class="flex gap-3">
                <button wire:click="closeDelete" class="flex-1 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Batal</button>
                <button wire:click="confirmDelete" wire:loading.attr="disabled" class="flex-1 py-2.5 text-sm font-semibold bg-red-500 hover:bg-red-600 text-white rounded-xl transition-colors">Hapus</button>
            </div>
        </div>
    </div>
    @endif
</div>