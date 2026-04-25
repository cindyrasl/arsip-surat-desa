<div>
    @if($showModal)
    <div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl">
            <!-- Header Modal -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Pengaturan Profil</h3>
                </div>
                <button wire:click="closeModal" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Body -->
            <div class="px-6 py-5">
                @if(session('profile_success'))
                    <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl">{{ session('profile_success') }}</div>
                @endif
                @if(session('profile_error'))
                    <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl">{{ session('profile_error') }}</div>
                @endif

                <!-- ROW 1: Info Profil (Editable) -->
                <div class="mb-6">
                    <h4 class="text-sm font-bold text-gray-700 mb-3">Informasi Profil</h4>
                    <div class="space-y-3">
                        <!-- Nama -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Lengkap <span class="text-red-400">*</span></label>
                            <input type="text" wire:model="nama" placeholder="Nama lengkap"
                                class="w-full px-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:border-[#4a90b8] focus:ring-4 focus:ring-[#4a90b82e] @error('nama') error @enderror">
                            @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <!-- Jabatan -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Jabatan</label>
                            <input type="text" wire:model="jabatan" placeholder="Contoh: Kepala Desa"
                                class="w-full px-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:border-[#4a90b8] focus:ring-4 focus:ring-[#4a90b82e]">
                        </div>
                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Email <span class="text-red-400">*</span></label>
                            <input type="email" wire:model="email" placeholder="contoh: email@domain.com"
                                class="w-full px-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:border-[#4a90b8] focus:ring-4 focus:ring-[#4a90b82e] @error('email') error @enderror">
                            @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- ROW 2: Ubah Password (Opsional) -->
                <div class="border-t border-gray-100 pt-4">
                    <h4 class="text-sm font-bold text-gray-700 mb-3">Ubah Password (opsional)</h4>
                    <p class="text-xs text-gray-400 mb-3">Kosongkan jika tidak ingin mengubah password.</p>
                    <div class="space-y-3">
                        <div class="relative">
                            <input type="password" wire:model="old_password" id="old-password" placeholder="Password lama" 
                                class="w-full px-4 py-2.5 text-sm border rounded-xl pr-10 focus:outline-none focus:border-[#4a90b8] focus:ring-4 focus:ring-[#4a90b82e] @error('old_password') error @enderror">
                            <button type="button" onclick="togglePass('old-password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg id="eye-old-password" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                        @error('old_password') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                        
                        <div class="relative">
                            <input type="password" wire:model="new_password" id="new-password" placeholder="Password baru (min. 8 karakter)" 
                                class="w-full px-4 py-2.5 text-sm border rounded-xl pr-10 focus:outline-none focus:border-[#4a90b8] focus:ring-4 focus:ring-[#4a90b82e] @error('new_password') error @enderror">
                            <button type="button" onclick="togglePass('new-password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg id="eye-new-password" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                        @error('new_password') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                        
                        <div class="relative">
                            <input type="password" wire:model="new_password_confirmation" id="confirm-password" placeholder="Konfirmasi password baru" 
                                class="w-full px-4 py-2.5 text-sm border rounded-xl pr-10 focus:outline-none focus:border-[#4a90b8] focus:ring-4 focus:ring-[#4a90b82e]">
                            <button type="button" onclick="togglePass('confirm-password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg id="eye-confirm-password" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100">
                <button wire:click="closeModal" class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">Batal</button>
                <button wire:click="updateProfile" wire:loading.attr="disabled" class="px-5 py-2.5 text-sm font-semibold bg-primary hover:bg-primary-dark text-white rounded-xl transition-colors shadow-sm">
                    <span wire:loading.remove wire:target="updateProfile">Simpan Perubahan</span>
                    <span wire:loading wire:target="updateProfile">Menyimpan...</span>
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    function togglePass(id) {
        const input = document.getElementById(id);
        const icon = document.getElementById('eye-' + id);
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
        }
    }
</script>