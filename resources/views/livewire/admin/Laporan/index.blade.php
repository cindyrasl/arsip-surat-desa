<div>
    <div class="max-w-7xl mx-auto">
        <!-- Page Title -->
        <div class="flex items-center mb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-800 leading-tight">Laporan</h1>
                    <p class="text-xs text-gray-500">Kelola laporan arsip surat</p>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-5 mb-4">
            <div class="flex flex-wrap items-end gap-4">
                <!-- Tanggal Surat (Dari) -->
                <div class="flex-1 min-w-45">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tanggal Surat (Dari)</label>
                    <input type="date" wire:model.live="dateStart"
                        class="w-full pl-4 pr-5 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all cursor-pointer">
                </div>

                <!-- Tanggal Surat (Sampai) -->
                <div class="flex-1 min-w-45">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tanggal Surat (Sampai)</label>
                    <input type="date" wire:model.live="dateEnd"
                        class="w-full pl-4 pr-5 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all cursor-pointer">
                </div>

                <!-- Kategori Surat -->
                <div class="flex-1 min-w-45">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Kategori Surat</label>
                    <div class="relative">
                        <select wire:model.live="jenis" class="w-full pl-4 pr-9 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all appearance-none cursor-pointer">
                            <option value="all">Semua Surat</option>
                            <option value="masuk">Surat Masuk</option>
                            <option value="keluar">Surat Keluar</option>
                        </select>
                        <span class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M6 9l6 6 6-6" stroke-linecap="round"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Export Excel Button -->
                <div class="shrink-0">
                    <label class="block text-xs font-semibold text-transparent mb-1.5 select-none">Export</label>
                    <button wire:click="exportExcel" 
                        @if(!$dateStart || !$dateEnd)
                            disabled
                            class="flex items-center gap-2 bg-gray-300 cursor-not-allowed text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors shadow-sm whitespace-nowrap"
                        @else
                            class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors shadow-sm whitespace-nowrap"
                        @endif
                        title="{{ (!$dateStart || !$dateEnd) ? 'Pilih rentang tanggal terlebih dahulu' : 'Export ke Excel' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <path d="M7 8h10M7 12h10M7 16h6"/>
                            <path d="M16 14l2 2 2-2M18 16v-4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Export Excel
                    </button>
                </div>
            </div>
        </div>

        <!-- Report Table Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Card Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="5" y="2" width="14" height="20" rx="2"/><path d="M9 7h6M9 11h6M9 15h4"/>
                    </svg>
                    <h2 class="font-bold text-gray-800">Daftar Laporan Surat</h2>
                </div>
                <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-3 py-1 rounded-full">{{ $dataLaporan->total() }} Data</span>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100 border-b border-gray-100">
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide w-14">No</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Kategori Surat</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nomor Surat</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Perihal</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Jenis Surat</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal Surat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @php $no = ($dataLaporan->currentPage() - 1) * $dataLaporan->perPage() + 1; @endphp
                        @forelse($dataLaporan as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-3.5 text-gray-400 text-sm text-center">{{ $no++ }}</td>
                                <td class="px-6 py-3.5">
                                    @if($item['kategori'] === 'masuk')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-sky-100 text-sky-600 border border-sky-200">
                                            Surat Masuk
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-teal-100 text-teal-600 border border-teal-200">
                                            Surat Keluar
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-3.5 font-semibold text-gray-800 text-sm whitespace-nowrap">{{ $item['no_surat'] }}</td>
                                <td class="px-6 py-3.5 text-gray-700 text-sm">{{ $item['perihal'] }}</td>
                                <td class="px-6 py-3.5 text-gray-600 text-sm">{{ $item['jenis_surat'] }}</td>
                                <td class="px-6 py-3.5 text-gray-500 text-sm whitespace-nowrap">{{ \Carbon\Carbon::parse($item['tanggal_surat'])->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center">
                                    <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <rect x="5" y="2" width="14" height="20" rx="2"/><path d="M9 7h6M9 11h6M9 15h4"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-400 text-sm font-medium">Tidak ada data laporan.</p>
                                    <p class="text-gray-300 text-xs mt-1">Coba ubah rentang tanggal atau kategori surat.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-t border-gray-100">
                <p class="text-sm text-gray-500">
                    Menampilkan {{ $dataLaporan->firstItem() ?? 0 }} - {{ $dataLaporan->lastItem() ?? 0 }} dari {{ $dataLaporan->total() }} data
                </p>
                <div>
                    {{ $dataLaporan->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div x-data="{ show: false, message: '', type: 'success' }" 
        x-on:show-toast.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
        x-show="show"
        x-cloak
        class="fixed bottom-6 right-6 z-50">
        <div class="flex items-center gap-3 text-white text-sm font-medium px-4 py-3 rounded-xl shadow-xl"
            :class="type === 'error' ? 'bg-red-600' : 'bg-gray-900'">
            <svg x-show="type === 'success'" class="w-4 h-4 text-green-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <svg x-show="type === 'error'" class="w-4 h-4 text-red-300 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span x-text="message"></span>
        </div>
    </div>
</div>