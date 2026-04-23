<div class="min-h-screen flex items-center justify-center bg-[#f0f6fb] font-[Plus_Jakarta_Sans]">
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
            <div class="w-full flex flex-col items-center flex-1 justify-center">
                <!-- Logo -->
                <div class="mb-5 animate-[fadeInUp_0.5s_ease]">
                    <img src="{{ asset('logo_kantor.png') }}" class="h-24 w-24 object-contain drop-shadow-md">
                </div>

                <!-- Title -->
                <div class="text-center mb-8 animate-[fadeInUp_0.5s_ease]">
                    <h1 class="text-3xl xl:text-4xl font-extrabold text-[#2d6e9e]">
                        Arsip Surat Digital
                    </h1>
                    <h2 class="text-xl xl:text-2xl font-bold text-[#2d6e9e] mt-1">
                        Kantor Desa Teluk Kapuas
                    </h2>
                </div>

                <!-- FORM -->
                <form wire:submit.prevent="login" class="w-full space-y-5">
                    @if($errors->has('username'))
                        <div class="px-4 py-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl">
                            {{ $errors->first('username') }}
                        </div>
                    @endif

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Username</label>
                        <input type="text" wire:model.blur="username"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:border-[#4a90b8] focus:ring-4 focus:ring-[#4a90b82e] @error('username') border-red-400 @enderror"
                            placeholder="Masukkan username" autocomplete="username">
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Password</label>
                        <div class="relative">
                            <input id="password" type="password" wire:model.blur="password"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:border-[#4a90b8] focus:ring-4 focus:ring-[#4a90b82e] @error('password') border-red-400 @enderror"
                                placeholder="Masukkan password" autocomplete="current-password">
                            <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#4a90b8]">
                                <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <label class="flex items-center gap-2 text-sm text-gray-600">
                            <input type="checkbox" wire:model="remember" class="accent-[#4a90b8]">
                            Ingat saya
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm font-semibold text-[#4a90b8] hover:text-[#2d6e9e]">
                            Lupa password?
                        </a>
                    </div>

                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full py-3.5 rounded-xl text-white font-bold bg-linear-to-br from-[#4a90b8] to-[#2d6e9e] hover:from-[#3a7da8] hover:to-[#1e5a8a] hover:shadow-lg transition disabled:opacity-60">
                        <span wire:loading.remove>Masuk</span>
                        <span wire:loading>Sedang masuk...</span>
                    </button>
                </form>
            </div>

            <p class="text-xs text-gray-400">
                © {{ date('Y') }} Kantor Desa Teluk Kapuas
            </p>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
        }
    }
</script>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(18px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-\[fadeInUp_0\.5s_ease\] {
        animation: fadeInUp 0.5s ease forwards;
    }
</style>