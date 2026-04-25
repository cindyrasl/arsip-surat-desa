<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lupa Kata Sandi - Arsip Surat Digital Kantor Desa Teluk Kapuas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Input focus glow */
        .input-field:focus {
            outline: none;
            border-color: #4a90b8;
            box-shadow: 0 0 0 4px rgba(74,144,184,0.15);
        }
        .input-field.error {
            border-color: #ef4444;
            box-shadow: 0 0 0 4px rgba(239,68,68,0.12);
        }
        .input-field.success {
            border-color: #22c55e;
            box-shadow: 0 0 0 4px rgba(34,197,94,0.12);
        }

        /* Gradient button */
        .btn-primary {
            background: linear-gradient(135deg, #4a90b8 0%, #2d6e9e 100%);
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #3a7da8 0%, #1e5a8a 100%);
            box-shadow: 0 8px 24px rgba(45,110,158,0.35);
            transform: translateY(-1px);
        }
        .btn-primary:active { transform: translateY(0); }

        .btn-secondary {
            transition: all 0.2s ease;
            border: 1.5px solid #4a90b8;
            color: #4a90b8;
        }
        .btn-secondary:hover {
            background-color: #f0f6fb;
            transform: translateY(-1px);
        }

        /* Success card slide-in */
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.93); }
            to   { opacity: 1; transform: scale(1); }
        }
        .scale-in { animation: scaleIn 0.35s ease both; }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-[#f0f6fb] font-[Plus_Jakarta_Sans]">

    <div class="w-full min-h-screen flex flex-col md:flex-row shadow-2xl overflow-hidden bg-white">

        <!-- LEFT PANEL -->
        <div class="hidden md:flex flex-col items-center justify-center w-1/2 min-h-screen relative overflow-hidden bg-[#ffffff]">

            <!-- Decorative blobs -->
            <div class="absolute w-387.5 h-325 bg-[#B9D8EF] rounded-full top-1/2 -translate-y-1/2 -left-200"></div>
            <div class="absolute w-337.5 h-300 bg-[#90CEFB] rounded-full top-1/2 -translate-y-1/2 -left-162.5"></div>
            <div class="absolute w-287.5 h-250 bg-[#4C83AC] rounded-full top-1/2 -translate-y-1/2 -left-125"></div>

            <!-- Logo / Illustration -->
            <div class="flex flex-col items-center gap-6 relative z-50">
                <img src="{{ asset('logo.png') }}" class="w-96 xl:w-105 2xl:w-125 drop-shadow-xl -translate-x-20">
                <!-- <a href="http://www.freepik.com">Designed by macrovector / Freepik</a> -->
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="flex flex-col items-center justify-between w-full md:w-1/2 min-h-screen bg-white px-8 sm:px-16 xl:px-24 py-12">

            <div class="w-full flex flex-col items-center flex-1 justify-center max-w-sm mx-auto">

                <!-- Logo Kantor -->
                <div class="mb-5 animate-[fadeInUp_0.5s_ease]">
                    <img src="{{ asset('logo_kantor.png') }}" class="h-24 w-24 object-contain drop-shadow-md">
                </div>

                <!-- FORM STATE -->
                <div id="form-state" class="w-full">

                    <!-- Title -->
                    <div class="text-center mb-8 animate-[fadeInUp_0.5s_ease_0.1s]">
                        <h1 class="text-2xl xl:text-3xl font-extrabold text-[#2d6e9e]">Lupa Password?</h1>
                        <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                            Masukkan alamat email Anda dan kami akan mengirimkan<br class="hidden sm:block">
                            link untuk mengatur ulang password Anda.
                        </p>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('password.email') }}" class="w-full space-y-5">
                        @csrf

                        <!-- Email -->
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
                                <input id="email" type="email" name="email"
                                    placeholder="contoh: emailanda@gmail.com"
                                    class="input-field w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm transition-all"
                                    oninput="clearError()"
                                    autocomplete="email">
                            </div>
                            <p id="email-error" class="hidden mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span id="email-error-text"></span>
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="animate-[fadeInUp_0.5s_ease_0.26s]">
                            <button type="submit" id="submit-btn"
                                class="btn-primary w-full py-3.5 rounded-xl text-white font-bold text-sm flex items-center justify-center gap-2 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-linecap="round"/>
                                </svg>
                                Kirim Link Reset Password
                            </button>
                        </div>

                    </form>

                    <!-- Back to Login -->
                    <div class="mt-3 animate-[fadeInUp_0.5s_ease_0.34s]">
                        <a href="{{ url('/') }}"
                            class="btn-secondary w-full py-3.5 rounded-xl font-semibold text-sm flex items-center justify-center gap-2 bg-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path d="M19 12H5M12 5l-7 7 7 7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Kembali ke Halaman Login
                        </a>
                    </div>

                </div>

                <!-- SUCCESS STATE -->
                <div id="success-state" class="w-full hidden scale-in">

                    <!-- Success icon -->
                    <div class="flex flex-col items-center text-center mb-8">
                        <div class="w-20 h-20 rounded-full bg-green-50 border-4 border-green-100 flex items-center justify-center mb-4 shadow-md">
                            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-[#2d6e9e] mb-2">Email Terkirim!</h2>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            Kami telah mengirimkan instruksi pengaturan ulang kata sandi ke:
                        </p>
                        <div class="mt-2 px-4 py-2 bg-[#f0f6fb] rounded-xl border border-[#B9D8EF] inline-flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#4C83AC]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span id="sent-email" class="text-sm font-semibold text-[#2d6e9e]"></span>
                        </div>
                    </div>

                    <!-- Info card -->
                    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 mb-5 text-left">
                        <p class="text-xs font-semibold text-[#2d6e9e] mb-2 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/>
                            </svg>
                            Langkah selanjutnya:
                        </p>
                        <ol class="text-xs text-gray-600 space-y-1 list-none pl-0">
                            <li class="flex items-start gap-2">
                                <span class="w-4 h-4 rounded-full bg-[#4C83AC] text-white text-xs flex items-center justify-center shrink-0 mt-0.5 font-bold">1</span>
                                Buka kotak masuk email Anda
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-4 h-4 rounded-full bg-[#4C83AC] text-white text-xs flex items-center justify-center shrink-0 mt-0.5 font-bold">2</span>
                                Klik tautan yang dikirimkan (berlaku 60 menit)
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-4 h-4 rounded-full bg-[#4C83AC] text-white text-xs flex items-center justify-center shrink-0 mt-0.5 font-bold">3</span>
                                Buat kata sandi baru yang kuat
                            </li>
                        </ol>
                    </div>

                    <!-- Resend / Back buttons -->
                    <div class="space-y-3">
                        <button onclick="resendEmail()"
                            class="btn-primary w-full py-3 rounded-xl text-white font-semibold text-sm flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span id="resend-text">Kirim Ulang Email</span>
                        </button>

                        <a href="{{ url('/') }}"
                            class="btn-secondary w-full py-3 rounded-xl font-semibold text-sm flex items-center justify-center gap-2 bg-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path d="M19 12H5M12 5l-7 7 7 7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Kembali ke Halaman Login
                        </a>
                    </div>

                </div>

            </div>

            <!-- Footer -->
            <p class="text-xs text-gray-400 mt-8">
                © {{ date('Y') }} Kantor Desa Teluk Kapuas
            </p>

        </div>
    </div>

    <script>
        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        function showError(msg) {
            const input   = document.getElementById('email');
            const errBox  = document.getElementById('email-error');
            const errText = document.getElementById('email-error-text');
            input.classList.add('error');
            input.classList.remove('success');
            errText.textContent = msg;
            errBox.classList.remove('hidden');
            errBox.classList.add('flex');
        }

        function clearError() {
            const input  = document.getElementById('email');
            const errBox = document.getElementById('email-error');
            input.classList.remove('error');
            errBox.classList.add('hidden');
            errBox.classList.remove('flex');

            if (isValidEmail(input.value.trim())) {
                input.classList.add('success');
            } else {
                input.classList.remove('success');
            }
        }

        // ── Resend with cooldown ──────────────────────────────────────────
        let resendCooldown = 0;
        let resendTimer    = null;

        function resendEmail() {
            if (resendCooldown > 0) return;

            const btn  = document.querySelector('#success-state button');
            const text = document.getElementById('resend-text');

            resendCooldown = 60;
            text.textContent = `Kirim Ulang (${resendCooldown}s)`;
            btn.disabled     = true;
            btn.style.opacity = '0.7';

            resendTimer = setInterval(() => {
                resendCooldown--;
                if (resendCooldown <= 0) {
                    clearInterval(resendTimer);
                    text.textContent  = 'Kirim Ulang Email';
                    btn.disabled      = false;
                    btn.style.opacity = '1';
                } else {
                    text.textContent = `Kirim Ulang (${resendCooldown}s)`;
                }
            }, 1000);
        }
    </script>

</body>
</html>