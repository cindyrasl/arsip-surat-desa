<div class="max-w-7xl mx-auto">
    <!-- Judul Halaman -->
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-800 leading-tight">Detail Surat Masuk</h1>
                <p class="text-xs text-gray-500">Lihat informasi detail surat masuk</p>
            </div>
        </div>

        <!-- Tombol kembali -->
        <a href="{{ route('suratmasuk.index') }}"
            class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M19 12H5M12 5l-7 7 7 7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">
        <!-- Informasi Surat -->
        <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="font-bold text-gray-800">Informasi Surat</h2>
            </div>
            <div class="divide-y divide-gray-50">
                <div class="flex items-start gap-4 px-6 py-4">
                    <span class="w-36 text-sm text-gray-400 font-medium shrink-0">Nomor Surat</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $surat->no_surat }}</span>
                </div>
                <div class="flex items-start gap-4 px-6 py-4">
                    <span class="w-36 text-sm text-gray-400 font-medium shrink-0">Tanggal Surat</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $surat->tanggal_surat?->format('m/d/Y') ?? '-' }}</span>
                </div>
                <div class="flex items-start gap-4 px-6 py-4">
                    <span class="w-36 text-sm text-gray-400 font-medium shrink-0">Tanggal Diterima</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $surat->tanggal_diterima?->format('m/d/Y - H:i') ?? '-' }} WIB</span>
                </div>
                <div class="flex items-start gap-4 px-6 py-4">
                    <span class="w-36 text-sm text-gray-400 font-medium shrink-0">Asal Surat</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $surat->asal_surat }}</span>
                </div>
                <div class="flex items-start gap-4 px-6 py-4">
                    <span class="w-36 text-sm text-gray-400 font-medium shrink-0">Jenis Surat</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $surat->jenis?->nama_jenis ?? '-' }}</span>
                </div>
                <div class="flex items-start gap-4 px-6 py-4">
                    <span class="w-36 text-sm text-gray-400 font-medium shrink-0">Perihal</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $surat->perihal }}</span>
                </div>
                <div class="flex items-start gap-4 px-6 py-4">
                    <span class="w-36 text-sm text-gray-400 font-medium shrink-0">Keterangan</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $surat->keterangan ?: '-' }}</span>
                </div>
                <div class="flex items-start gap-4 px-6 py-4">
                    <span class="w-36 text-sm text-gray-400 font-medium shrink-0">Dibuat Oleh</span>
                    <span class="text-sm font-semibold text-gray-800">
                        {{ $surat->user?->nama ?? '-' }}
                        @if($surat->user?->jabatan)
                            <span class="text-gray-400 font-normal">- {{ $surat->user->jabatan }}</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- File Surat -->
        <div class="lg:col-span-2 flex">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col w-full">
                <div class="flex-1 flex flex-col items-center justify-center">
                    <div class="w-24 h-24 rounded-2xl bg-blue-50 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            <path d="M13 3v5a1 1 0 001 1h5" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <!-- Nama File -->
                    <p class="text-base font-bold text-gray-800 mb-1 text-center">
                        {{ $surat->file_path ? basename($surat->file_path) : 'Tidak ada file' }}
                    </p>

                    <!-- Metadata File -->
                    @if($surat->file_path)
                        <div class="flex items-center justify-center gap-2 text-xs text-gray-400 mb-6">
                            <span class="inline-flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/>
                                </svg>
                                {{ strtoupper(pathinfo($surat->file_path, PATHINFO_EXTENSION)) }}
                            </span>
                        </div>

                        <!-- Tombol Download -->
                        <a href="{{ asset('storage/' . $surat->file_path) }}" download
                            class="w-full flex items-center justify-center gap-2 bg-primary hover:bg-primary-dark text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 4v12M8 12l4 4 4-4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Download Lampiran
                        </a>
                    @else
                        <p class="text-sm text-gray-400 text-center">Tidak ada lampiran tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>