<div>
<div class="max-w-7xl mx-auto">
    <div class="flex items-center gap-3 mb-5">
        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
            </svg>
        </div>
        <div>
            <h1 class="text-lg font-bold text-gray-800 leading-tight">Jenis Surat</h1>
            <p class="text-xs text-gray-500">Kelola jenis-jenis surat yang dapat dibuat</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl">{{ session('success') }}</div>
    @endif

    <div class="flex flex-wrap items-center gap-3 mb-5">
        <div class="relative flex-1 min-w-[200px]">
            <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
            </span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari jenis surat..."
                class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 px-4 md:px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-800">Daftar Jenis Surat</h2>
            <button wire:click="openAddModal" class="flex items-center justify-center gap-2 bg-primary hover:bg-primary-dark text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14" stroke-linecap="round"/></svg>
                Tambah Jenis Surat
            </button>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-100">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide w-14">No</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide">Nama Jenis Surat</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide">Keterangan</th>
                        <th class="text-center px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($jenisSurat as $i => $jenis)
                        <tr class="border-b border-gray-50">
                            <td class="px-6 py-3.5 text-gray-400 text-center text-sm">{{ $jenisSurat->firstItem() + $i }}</td>
                            <td class="px-6 py-3.5 font-semibold text-gray-800 text-sm">{{ $jenis->nama_jenis }}</td>
                            <td class="px-6 py-3.5 text-gray-600 text-sm">{{ $jenis->keterangan ?: '-' }}</td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="openEditModal({{ $jenis->id }})" title="Edit" class="w-8 h-8 rounded-lg bg-amber-50 hover:bg-amber-100 flex items-center justify-center transition-colors">
                                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/><path d="M17.586 3.586a2 2 0 012.828 2.828L12 15l-4 1 1-4 8.586-8.414z"/></svg>
                                    </button>
                                    <button wire:click="openDelete({{ $jenis->id }})" title="Hapus" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 flex items-center justify-center transition-colors">
                                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-16 text-center text-gray-400 text-sm">Tidak ada jenis surat yang tersedia.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden divide-y divide-gray-100">
            @forelse($jenisSurat as $i => $jenis)
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <p class="text-xs text-gray-500 mb-1">Nama Jenis Surat</p>
                            <p class="font-bold text-gray-800 text-sm">{{ $jenis->nama_jenis }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-1">Keterangan</p>
                        <p class="text-sm text-gray-700">{{ $jenis->keterangan ?: '-' }}</p>
                    </div>

                    <div class="flex gap-2">
                        <button wire:click="openEditModal({{ $jenis->id }})"
                            class="flex-1 flex items-center justify-center gap-2 px-3 py-2.5 bg-amber-50 hover:bg-amber-100 text-amber-600 text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                <path d="M17.586 3.586a2 2 0 012.828 2.828L12 15l-4 1 1-4 8.586-8.414z"/>
                            </svg>
                            Edit
                        </button>
                        <button wire:click="openDelete({{ $jenis->id }})"
                            class="px-3 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="py-16 text-center">
                    <p class="text-gray-400 text-sm font-medium">Tidak ada jenis surat yang tersedia.</p>
                </div>
            @endforelse
        </div>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 px-4 md:px-6 py-4 border-t border-gray-100">
            <p class="text-sm text-gray-500 text-center md:text-left">
                @if($jenisSurat->total() > 0)
                    Menampilkan <span class="font-semibold text-gray-700">{{ $jenisSurat->firstItem() }}</span> - <span class="font-semibold text-gray-700">{{ $jenisSurat->lastItem() }}</span> dari <span class="font-semibold text-gray-700">{{ $jenisSurat->total() }}</span> data
                @else Menampilkan <b>0</b> data @endif
            </p>
            <div class="flex items-center justify-center gap-1">{{ $jenisSurat->links('vendor.pagination.simple-tailwind') }}</div>
        </div>
    </div>
</div>

@if($showModal)
<div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 7h5l2 3h11v9a1 1 0 01-1 1H4a1 1 0 01-1-1V7z"/><path d="M3 7V5a1 1 0 011-1h4l2 3"/></svg>
                </div>
                <h3 class="font-bold text-gray-800">{{ $editId ? 'Edit' : 'Tambah' }} Jenis Surat</h3>
            </div>
            <button wire:click="closeModal" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="px-6 py-5 space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Jenis Surat <span class="text-red-500">*</span></label>
                <input type="text" wire:model="nama_jenis" placeholder="Contoh: Surat Keterangan Usaha"
                    class="w-full px-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all @error('nama_jenis') border-red-400 @enderror">
                @error('nama_jenis') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan</label>
                <textarea wire:model="keterangan" rows="3" placeholder="Keterangan tambahan (opsional)"
                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all resize-none"></textarea>
            </div>
        </div>
        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100">
            <button wire:click="closeModal" class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">Batal</button>
            <button wire:click="save" wire:loading.attr="disabled" class="px-5 py-2.5 text-sm font-semibold bg-primary hover:bg-primary-dark text-white rounded-xl transition-colors shadow-sm">
                <span wire:loading.remove wire:target="save">Simpan</span>
                <span wire:loading wire:target="save">Menyimpan...</span>
            </button>
        </div>
    </div>
</div>
@endif

@if($showDelete)
<div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
        <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <h3 class="font-bold text-gray-800 mb-1">Hapus Jenis Surat?</h3>
        <p class="text-sm text-gray-500 mb-6">Data jenis surat akan dihapus secara permanen dan tidak dapat dipulihkan.</p>
        <div class="flex gap-3">
            <button wire:click="closeDelete" class="flex-1 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Batal</button>
            <button wire:click="confirmDelete" class="flex-1 py-2.5 text-sm font-semibold bg-red-500 hover:bg-red-600 text-white rounded-xl transition-colors">Hapus</button>
        </div>
    </div>
</div>
@endif
</div>