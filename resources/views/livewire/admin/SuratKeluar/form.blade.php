<div class="max-w-7xl mx-auto fade-up">
    <!-- Judul Halaman Dinamis -->
    <div class="flex items-center gap-3 mb-5 fade-up">
        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
            </svg>
        </div>
        <div>
            <h1 class="text-lg font-bold text-gray-800 leading-tight">
                {{ $isEdit ? 'Edit Surat Keluar' : 'Tambah Surat Keluar' }}
            </h1>
            <p class="text-xs text-gray-500">
                {{ $isEdit ? 'Edit arsip surat keluar' : 'Tambah arsip surat keluar baru' }}
            </p>
        </div>
    </div>

    <!-- Alert Session -->
    @if(session()->has('success'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg fade-up2">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg fade-up2">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span class="text-red-700">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Kartu Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden fade-up2">
        <form wire:submit.prevent="save" class="p-6 space-y-5">
            <!-- Nomor Surat, Tujuan Surat, Jenis Surat -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nomor Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="nomor"
                           class="w-full px-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all @error('nomor') border-red-500 @enderror"
                           placeholder="001/SK/2026">
                    @error('nomor') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Tujuan Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="tujuan"
                           class="w-full px-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all @error('tujuan') border-red-500 @enderror"
                           placeholder="Dinas Pendidikan Kab. Kubu Raya">
                    @error('tujuan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Jenis Surat <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="jenis_id"
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all @error('jenis_id') border-red-500 @enderror">
                        <option value="">Pilih Jenis Surat</option>
                        @foreach($jenisSuratOptions as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                        @endforeach
                    </select>
                    @error('jenis_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Tanggal Surat, Tanggal Kirim, Lampiran -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Tanggal Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="date" wire:model="tanggal_surat"
                           class="w-full px-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all @error('tanggal_surat') border-red-500 @enderror">
                    @error('tanggal_surat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Kirim</label>
                    <input type="date" wire:model="tanggal_kirim"
                           class="w-full px-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Lampiran (Gambar/WORD/PDF - max 10MB)
                        @if(!$isEdit)<span class="text-red-500">*</span>@endif
                    </label>
                    <input type="file" wire:model="lampiran" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                           class="w-full px-3 py-2 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 @error('lampiran') border-red-500 @enderror" 
                           onchange="validasiUkuran(this)">

                    <!-- Popup Validasi file -->
                    <div id="file-error-popup-sm" class="fixed top-6 right-6 z-50 hidden">
                        <div class="bg-white rounded-2xl shadow-xl border border-red-100 w-full max-w-sm p-5">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-gray-800">File Terlalu Besar</h4>
                                    <p class="text-xs text-gray-500 mt-1">Maksimal 10MB. Silakan pilih file lain.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($lampiran)
                        <p class="text-xs text-green-600 mt-1">File baru: {{ $lampiran->getClientOriginalName() }}</p>
                    @endif

                    @if($isEdit && $oldLampiran && !$lampiran)
                        <p class="text-xs text-gray-500 mt-1">File saat ini: {{ basename($oldLampiran) }}</p>
                    @endif

                    @error('lampiran') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Perihal -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Perihal <span class="text-red-500">*</span>
                </label>
                <input type="text" wire:model="perihal"
                       class="w-full px-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all @error('perihal') border-red-500 @enderror"
                       placeholder="Isi perihal surat">
                @error('perihal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan</label>
                <textarea wire:model="keterangan" rows="4"
                          class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all resize-none"
                          placeholder="Keterangan tambahan (opsional)"></textarea>
            </div>

            <!-- Loading Indicator -->
            <div wire:loading wire:target="save" class="text-primary text-sm">
                <svg class="inline animate-spin h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Menyimpan data...
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('suratkeluar.index') }}"
                        class="px-6 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                    Batal
                </a>
                <button type="submit" wire:loading.attr="disabled"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-primary hover:bg-primary-dark rounded-xl transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                    {{ $isEdit ? 'Update Surat' : 'Simpan Surat' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function validasiUkuran(input) {
        const maxSize = 10 * 1024 * 1024;
        const popup = document.getElementById('file-error-popup-sm');
        
        if (input.files[0] && input.files[0].size > maxSize) {
            input.value = '';
            popup.classList.remove('hidden');
        } else if (input.files[0]) {
            // File valid, sembunyikan popup
            popup.classList.add('hidden');
        }
    }
</script>

<style>
    .fade-up { animation: fadeUp 0.35s ease forwards; }
    .fade-up2 { animation: fadeUp 0.35s ease 0.1s forwards; opacity: 0; }
    @keyframes fadeUp {
        from { opacity:0; transform:translateY(10px); }
        to { opacity:1; transform:translateY(0); }
    }
</style>