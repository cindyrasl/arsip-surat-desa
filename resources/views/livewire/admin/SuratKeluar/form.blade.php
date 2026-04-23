<div class="max-w-7xl mx-auto fade-up">
    <!-- Judul Halaman Dinamis -->
    <div class="flex items-center gap-3 mb-5 fade-up">
        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
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
            <!-- Error Summary -->
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-red-700 font-medium">Mohon periksa kembali form berikut:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Nomor Surat, Tujuan Surat, Jenis Surat -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nomor Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="nomor" 
                           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all @error('nomor') border-red-500 @enderror" 
                           placeholder="001/SK/2026">
                    @error('nomor') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Tujuan Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="tujuan" 
                           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all @error('tujuan') border-red-500 @enderror" 
                           placeholder="Dinas Pendidikan Kabupaten">
                    @error('tujuan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Jenis Surat <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="jenis_id" 
                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all @error('jenis_id') border-red-500 @enderror">
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
                           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all @error('tanggal_surat') border-red-500 @enderror">
                    @error('tanggal_surat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Tanggal Kirim <span class="text-red-500">*</span>
                    </label>
                    <input type="date" wire:model="tanggal_kirim" 
                           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all @error('tanggal_kirim') border-red-500 @enderror">
                    @error('tanggal_kirim') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Lampiran (PDF/Word, max 10MB) 
                        @if(!$isEdit)<span class="text-red-500">*</span>@endif
                    </label>
                    <input type="file" wire:model="lampiran" accept=".pdf,.doc,.docx" 
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 @error('lampiran') border-red-500 @enderror">
                    
                    @if($lampiran)
                        <p class="text-xs text-green-600 mt-1">
                            File baru: {{ $lampiran->getClientOriginalName() }}
                        </p>
                    @endif
                    
                    @if($isEdit && $oldLampiran && !$lampiran)
                        <p class="text-xs text-gray-500 mt-1">
                            File saat ini: {{ basename($oldLampiran) }}
                        </p>
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
                       class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all @error('perihal') border-red-500 @enderror" 
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
                <button type="button" wire:click="cancel" 
                        class="px-6 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit" wire:loading.attr="disabled"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-primary hover:bg-primary-dark rounded-xl transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                    {{ $isEdit ? 'Update Surat' : 'Simpan Surat' }}
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .fade-up { animation: fadeUp 0.35s ease forwards; }
    .fade-up2 { animation: fadeUp 0.35s ease 0.1s forwards; opacity: 0; }
    @keyframes fadeUp { 
        from { opacity:0; transform:translateY(10px); } 
        to { opacity:1; transform:translateY(0); } 
    }
</style>