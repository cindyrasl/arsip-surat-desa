{{-- resources/views/livewire/admin/GaleriSurat/index.blade.php --}}
<div>
    <div class="max-w-7xl mx-auto">
        <!-- Page Title -->
        <div class="flex items-center mb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-800 leading-tight">Galeri Surat</h1>
                    <p class="text-xs text-gray-500">Kelola file arsip surat</p>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-5 mb-4">
            <div class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-50">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Pencarian</label>
                    <input type="text" wire:model.live="search" placeholder="Cari nomor surat..." class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30">
                </div>
                <div class="flex-2 min-w-45">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Kategori Surat</label>
                    <select wire:model.live="kategori" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 cursor-pointer">
                        <option value="all">Semua Surat</option>
                        <option value="masuk">Surat Masuk</option>
                        <option value="keluar">Surat Keluar</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Gallery Grid -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 7h5l2 3h11v9a1 1 0 01-1 1H4a1 1 0 01-1-1V7z"/><path d="M3 7V5a1 1 0 011-1h4l2 3"/>
                    </svg>
                    <h2 class="font-bold text-gray-800">Koleksi File Surat</h2>
                </div>
                <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-3 py-1 rounded-full">{{ $totalFiles }} File</span>
            </div>

            <div class="p-6">
                @if($files->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
                        @foreach($files as $file)
                            @php
                                $ext = strtolower(pathinfo($file['file_path'], PATHINFO_EXTENSION));
                            @endphp

                            <div class="bg-gray-50 border border-gray-100 rounded-2xl overflow-hidden flex flex-col hover:-translate-y-1 hover:shadow-lg transition-all duration-200 cursor-pointer" 
                                 onclick="window.open('{{ asset('storage/' . $file['file_path']) }}', '_blank')">
                                
                                <!-- ICON AREA -->
                                <div class="relative flex flex-col items-center justify-center py-10 px-4 flex-1 min-h-40">
                                    
                                    <!-- PDF -->
                                    @if($ext === 'pdf')
                                        <div class="w-20 h-20 rounded-2xl bg-white border border-white shadow-sm flex items-center justify-center mb-3">
                                            <svg class="w-11 h-11 text-red-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                <path d="M13 3v5a1 1 0 001 1h5"/>
                                            </svg>
                                        </div>
                                        <span class="text-xs font-bold text-red-500 tracking-widest">PDF</span>

                                    <!-- WORD -->
                                    @elseif(in_array($ext, ['doc', 'docx']))
                                        <div class="w-20 h-20 rounded-2xl bg-white border border-white shadow-sm flex items-center justify-center mb-3">
                                            <svg class="w-11 h-11 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                <path d="M8 7h8M8 11h8M8 15h5"/>
                                            </svg>
                                        </div>
                                        <span class="text-xs font-bold text-blue-500 tracking-widest">{{ strtoupper($ext) }}</span>

                                    <!-- GAMBAR -->
                                    @elseif(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                        <div class="w-20 h-20 rounded-2xl bg-white border border-white shadow-sm flex items-center justify-center mb-3">
                                            <svg class="w-11 h-11 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                                <path d="M21 15l-5-5L5 21"/>
                                            </svg>
                                        </div>
                                        <span class="text-xs font-bold text-gray-400 tracking-widest">{{ strtoupper($ext) }}</span>

                                    <!-- LAINNYA -->
                                    @else
                                        <div class="w-20 h-20 rounded-2xl bg-white border border-white shadow-sm flex items-center justify-center mb-3">
                                            <svg class="w-11 h-11 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <span class="text-xs font-bold text-gray-400 tracking-widest">FILE</span>
                                    @endif
                                </div>

                                <!-- INFO CARD -->
                                <div class="px-3 py-3 bg-white border-t border-gray-100 flex flex-col gap-1.5">
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full 
                                        {{ $file['kategori'] === 'masuk' 
                                            ? 'bg-indigo-100 text-indigo-600 border border-indigo-200' 
                                            : 'bg-yellow-100 text-yellow-600 border border-yellow-200' }}">
                                        {{ $file['kategori'] === 'masuk' ? 'Surat Masuk' : 'Surat Keluar' }}
                                    </span>
                                    <p class="text-xs font-bold text-gray-800 truncate">{{ $file['no_surat'] }}</p>
                                    <div class="flex items-center gap-1 text-gray-400">
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                                            <path d="M3 9h18"/>
                                        </svg>
                                        <span class="text-xs truncate">{{ $file['pihak'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-gray-400">
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                                            <path d="M16 2v4M8 2v4M3 10h18"/>
                                        </svg>
                                        <span class="text-xs">{{ \Carbon\Carbon::parse($file['tanggal_surat'])->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6">
                        {{ $files->links() }}
                    </div>
                @else
                    <div class="py-16 text-center">
                        <svg class="w-14 h-14 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/>
                        </svg>
                        <p class="text-gray-400 text-sm font-medium">Tidak ada file ditemukan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>