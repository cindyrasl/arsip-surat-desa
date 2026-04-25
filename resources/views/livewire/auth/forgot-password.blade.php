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

        <div class="flex flex-col items-center justify-between w-full md:w-1/2 min-h-screen bg-white px-8 sm:px-16 xl:px-24 py-12 mx-auto">
            <div class="w-full flex flex-col items-center flex-1 justify-center max-w-sm mx-auto">

                <!-- Logo Kantor -->
                <div class="mb-5 animate-[fadeInUp_0.5s_ease]">
                    <img src="{{ asset('logo_kantor.png') }}" class="h-24 w-24 object-contain drop-shadow-md">
                </div>

                <!-- Title -->
                <div class="text-center mb-8 animate-[fadeInUp_0.5s_ease_0.1s]">
                    <h1 class="text-2xl xl:text-3xl font-extrabold text-[#2d6e9e]">Lupa Password?</h1>
                    <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                        Masukkan alamat email Anda dan kami akan mengirimkan<br class="hidden sm:block">
                        link untuk mengatur ulang password Anda.
                    </p>
                </div>

                <!-- Status message -->
                @if(session('status'))
                    <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl w-full">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Form -->
                <form wire:submit.prevent="sendResetLink" class="w-full space-y-5">
                    <div class="animate-[fadeInUp_0.5s_ease_0.18s]">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Email <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <input type="email" wire:model="email"
                                placeholder="contoh: emailanda@gmail.com"
                                class="input-field w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm transition-all"
                                autocomplete="email">
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="animate-[fadeInUp_0.5s_ease_0.26s]">
                        <button type="submit" wire:loading.attr="disabled"
                            class="btn-primary w-full py-3.5 rounded-xl text-white font-bold text-sm flex items-center justify-center gap-2 cursor-pointer">
                            <span wire:loading.remove>Kirim Link Reset Password</span>
                            <span wire:loading>Mengirim...</span>
                        </button>
                    </div>
                </form>

                <!-- Back to Login -->
                <div class="mt-3 w-full animate-[fadeInUp_0.5s_ease_0.34s]">
                    <a href="{{ route('login') }}"
                        class="btn-secondary w-full py-3.5 rounded-xl font-semibold text-sm flex items-center justify-center gap-2 bg-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M19 12H5M12 5l-7 7 7 7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
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
        transform: translateY(-1px);
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