<div>
    @if($showModal)
    <div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click.self="closeModal">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl" @click.stop="">
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

                <!-- Foto + Info -->
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div class="flex flex-col items-center">
                        <div class="w-28 h-28 rounded-full bg-primary-light overflow-hidden border-4 border-primary/30">
                            <img src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->nama) . '&background=6366f1&color=fff&size=128' }}" 
                                 alt="Profile" class="w-full h-full object-cover">
                        </div>
                        <input type="file" wire:model="profile_photo" accept="image/*" class="mt-2 text-xs">
                        @if($profile_photo)
                            <button wire:click="updatePhoto" class="mt-2 text-xs text-primary font-semibold">Simpan Foto</button>
                        @endif
                    </div>
                    <div class="space-y-3">
                        <input type="text" value="{{ Auth::user()->nama }}" class="w-full px-4 py-2.5 text-sm border rounded-xl bg-gray-50" readonly disabled>
                        <input type="text" value="{{ Auth::user()->jabatan ?? '-' }}" class="w-full px-4 py-2.5 text-sm border rounded-xl bg-gray-50" readonly disabled>
                        <input type="text" value="{{ Auth::user()->email }}" class="w-full px-4 py-2.5 text-sm border rounded-xl bg-gray-50" readonly disabled>
                    </div>
                </div>

                <!-- Ubah Password -->
                <div class="border-t border-gray-100 pt-4">
                    <h4 class="text-sm font-bold text-gray-700 mb-3">Ubah Password</h4>
                    <div class="space-y-3">
                        <input type="password" wire:model="old_password" placeholder="Password lama" class="w-full px-4 py-2.5 text-sm border rounded-xl">
                        @error('old_password') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                        <input type="password" wire:model="new_password" placeholder="Password baru (min. 6 karakter)" class="w-full px-4 py-2.5 text-sm border rounded-xl">
                        @error('new_password') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                        <input type="password" wire:model="new_password_confirmation" placeholder="Konfirmasi password baru" class="w-full px-4 py-2.5 text-sm border rounded-xl">
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100">
                <button wire:click="closeModal" class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">Batal</button>
                <button wire:click="updatePassword" wire:loading.attr="disabled" class="px-5 py-2.5 text-sm font-semibold bg-primary hover:bg-primary-dark text-white rounded-xl transition-colors shadow-sm">
                    <span wire:loading.remove wire:target="updatePassword">Simpan Perubahan</span>
                    <span wire:loading wire:target="updatePassword">Menyimpan...</span>
                </button>
            </div>
        </div>
    </div>
    @endif
</div>