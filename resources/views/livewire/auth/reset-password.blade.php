<div>
    <div class="w-full min-h-screen flex flex-col md:flex-row shadow-2xl overflow-hidden bg-white">

        <!-- LEFT PANEL -->
        <div class="hidden md:flex flex-col items-center justify-center w-1/2 min-h-screen relative overflow-hidden bg-[#ffffff]">
            <div class="absolute w-387.5 h-325 bg-[#B9D8EF] rounded-full top-1/2 -translate-y-1/2 -left-200"></div>
            <div class="absolute w-337.5 h-300 bg-[#90CEFB] rounded-full top-1/2 -translate-y-1/2 -left-162.5"></div>
            <div class="absolute w-287.5 h-250 bg-[#4C83AC] rounded-full top-1/2 -translate-y-1/2 -left-125"></div>
            <div class="flex flex-col items-center gap-6 relative z-50">
                <img src="{{ asset('logo.png') }}" class="w-96 xl:w-105 2xl:w-125 drop-shadow-xl -translate-x-20">
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="flex flex-col items-center justify-between w-full md:w-1/2 min-h-screen bg-white px-8 sm:px-16 xl:px-24 py-12">
            <div class="w-full flex flex-col items-center flex-1 justify-center max-w-sm mx-auto">

                <!-- Logo -->
                <div class="mb-5">
                    <img src="{{ asset('logo_kantor.png') }}" class="h-24 w-24 object-contain drop-shadow-md">
                </div>

                <!-- Title -->
                <div class="text-center mb-8">
                    <h1 class="text-2xl xl:text-3xl font-extrabold text-[#2d6e9e]">Reset Password</h1>
                    <p class="text-sm text-gray-500 mt-2">Silakan masukkan password baru Anda.</p>
                </div>

                <!-- Form Livewire -->
                <form wire:submit.prevent="resetPassword" class="w-full space-y-5">
                    
                    <!-- Email (readonly) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                        <input type="email" wire:model="email"
                            class="input-field w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-100 text-sm"
                            readonly>
                        @error('email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Password Baru <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <input id="password" type="password" wire:model="password"
                                placeholder="Minimal 8 karakter"
                                class="input-field w-full px-4 pr-12 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm @error('password') error @enderror">
                            <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#4a90b8] cursor-pointer">
                                <svg id="eye-icon-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Konfirmasi Password <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <input id="password_confirmation" type="password" wire:model="password_confirmation"
                                placeholder="Ulangi password baru"
                                class="input-field w-full px-4 pr-12 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm @error('password_confirmation') error @enderror">
                            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#4a90b8] cursor-pointer">
                                <svg id="eye-icon-confirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        @error('password')
                            {{-- Error "confirmed" muncul di sini --}}
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div>
                        <button type="submit" wire:loading.attr="disabled"
                            class="btn-primary w-full py-3.5 rounded-xl text-white font-bold text-sm cursor-pointer">
                            <span wire:loading.remove>Reset Password</span>
                            <span wire:loading>Menyimpan...</span>
                        </button>
                    </div>
                </form>

                <!-- Back to Login -->
                <div class="mt-3 w-full">
                    <a href="{{ route('login') }}"
                        class="btn-secondary w-full py-3.5 rounded-xl font-semibold text-sm flex items-center justify-center gap-2 bg-white">
                        Kembali ke Halaman Login
                    </a>
                </div>

            </div>

            <!-- Footer -->
            <p class="text-xs text-gray-400 mt-8">
                © {{ date('Y') }} Kantor Desa Teluk Kapuas
            </p>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const iconId = inputId === 'password' ? 'eye-icon-password' : 'eye-icon-confirm';
        const eyeIcon = document.getElementById(iconId);

        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
        } else {
            input.type = 'password';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
        }
    }
</script>

<style>
    .input-field:focus {
        outline: none;
        border-color: #4a90b8;
        box-shadow: 0 0 0 4px rgba(74,144,184,0.15);
    }
    .input-field.error {
        border-color: #ef4444;
        box-shadow: 0 0 0 4px rgba(239,68,68,0.12);
    }
    .btn-primary {
        background: linear-gradient(135deg, #4a90b8 0%, #2d6e9e 100%);
        transition: all 0.2s ease;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #3a7da8 0%, #1e5a8a 100%);
        box-shadow: 0 8px 24px rgba(45,110,158,0.35);
    }
    .btn-secondary {
        transition: all 0.2s ease;
        border: 1.5px solid #4a90b8;
        color: #4a90b8;
    }
    .btn-secondary:hover {
        background-color: #f0f6fb;
    }
</style>