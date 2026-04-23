<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reset Kata Sandi - Arsip Surat Digital Kantor Desa Teluk Kapuas</title>
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

        /* Password wrapper untuk toggle */
        .password-wrapper {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            color: #9ca3af;
            transition: color 0.2s;
        }
        .toggle-password:hover {
            color: #4a90b8;
        }
        .toggle-password svg {
            width: 18px;
            height: 18px;
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

        <!-- ══════════════════════════
             LEFT PANEL (SAMA PERSIS DENGAN LOGIN)
        ══════════════════════════ -->
        <div class="hidden md:flex flex-col items-center justify-center w-1/2 min-h-screen relative overflow-hidden bg-[#ffffff]">

            <!-- Decorative blobs -->
            <div class="absolute w-387.5 h-325 bg-[#B9D8EF] rounded-full top-1/2 -translate-y-1/2 -left-200"></div>
            <div class="absolute w-337.5 h-300 bg-[#90CEFB] rounded-full top-1/2 -translate-y-1/2 -left-162.5"></div>
            <div class="absolute w-287.5 h-250 bg-[#4C83AC] rounded-full top-1/2 -translate-y-1/2 -left-125"></div>

            <!-- Logo / Illustration area (sama dengan login) -->
            <div class="flex flex-col items-center gap-6 relative z-50">
                <img src="{{ asset('logo.png') }}" class="w-96 xl:w-105 2xl:w-125 drop-shadow-xl -translate-x-20">
            </div>
        </div>

        <!-- ══════════════════════════
             RIGHT PANEL (form reset password)
        ══════════════════════════ -->
        <div class="flex flex-col items-center justify-between w-full md:w-1/2 min-h-screen bg-white px-8 sm:px-16 xl:px-24 py-12">

            <div class="w-full flex flex-col items-center flex-1 justify-center max-w-sm mx-auto">

                <!-- Logo Kantor (sama dengan login) -->
                <div class="mb-5 animate-[fadeInUp_0.5s_ease]">
                    <img src="{{ asset('logo_kantor.png') }}" class="h-24 w-24 object-contain drop-shadow-md">
                </div>

                <!-- ── FORM STATE (default) ── -->
                <div id="form-state" class="w-full">

                    <!-- Title -->
                    <div class="text-center mb-8 animate-[fadeInUp_0.5s_ease_0.1s]">
                        <h1 class="text-2xl xl:text-3xl font-extrabold text-[#2d6e9e]">Reset Password</h1>
                        <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                            Silakan masukkan password baru Anda.
                        </p>
                    </div>

                    <!-- Token hidden -->
                    <input type="hidden" name="token" value="{{ $token ?? '' }}">
                    <input type="hidden" name="email" value="{{ $email ?? '' }}">

                    <!-- Form -->
                    <form method="POST" action="{{ route('password.update') }}" class="w-full space-y-5">
                        @csrf

                        <!-- Email -->
                        <div class="animate-[fadeInUp_0.5s_ease_0.14s]">
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
                                    oninput="clearError('email')"
                                    autocomplete="email"
                                    value="{{ $email ?? '' }}">
                            </div>
                            <p id="email-error" class="hidden mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span id="email-error-text"></span>
                            </p>
                        </div>

                        <!-- Password Baru -->
                        <div class="animate-[fadeInUp_0.5s_ease_0.18s]">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Password Baru <span class="text-red-400">*</span>
                            </label>
                            <div class="password-wrapper">
                                <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <input id="password" type="password" name="password"
                                    placeholder="Masukkan password baru (min. 8 karakter)"
                                    class="input-field w-full pl-10 pr-12 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm transition-all"
                                    oninput="clearError('password')"
                                    autocomplete="new-password">
                                <button type="button" onclick="togglePassword('password')" class="toggle-password">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <p id="password-error" class="hidden mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span id="password-error-text"></span>
                            </p>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="animate-[fadeInUp_0.5s_ease_0.22s]">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Konfirmasi Password <span class="text-red-400">*</span>
                            </label>
                            <div class="password-wrapper">
                                <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                    placeholder="Konfirmasi password baru"
                                    class="input-field w-full pl-10 pr-12 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm transition-all"
                                    oninput="clearError('password_confirmation')"
                                    autocomplete="new-password">
                                <button type="button" onclick="togglePassword('password_confirmation')" class="toggle-password">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <p id="password_confirmation-error" class="hidden mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span id="password_confirmation-error-text"></span>
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="animate-[fadeInUp_0.5s_ease_0.26s]">
                            <button type="submit" id="submit-btn"
                                class="btn-primary w-full py-3.5 rounded-xl text-white font-bold text-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Reset Password
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

                <!-- ── SUCCESS STATE ── -->
                <div id="success-state" class="w-full hidden scale-in">

                    <!-- Success icon -->
                    <div class="flex flex-col items-center text-center mb-8">
                        <div class="w-20 h-20 rounded-full bg-green-50 border-4 border-green-100 flex items-center justify-center mb-4 shadow-md">
                            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-[#2d6e9e] mb-2">Password Berhasil Diubah!</h2>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            Password Anda telah berhasil diubah.
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            Silakan login dengan password baru Anda.
                        </p>
                    </div>

                    <!-- Back to Login -->
                    <div class="space-y-3">
                        <a href="{{ url('/') }}"
                            class="btn-primary w-full py-3 rounded-xl text-white font-semibold text-sm flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Login Sekarang
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
        // Toggle password visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const wrapper = input.parentElement;
            const button = wrapper.querySelector('.toggle-password');
            const svg = button.querySelector('svg');

            if (input.type === 'password') {
                input.type = 'text';
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
            } else {
                input.type = 'password';
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
            }
        }

        // Clear error for specific field
        function clearError(field) {
            const input = document.getElementById(field);
            const errBox = document.getElementById(`${field}-error`);
            if (errBox) {
                errBox.classList.add('hidden');
                errBox.classList.remove('flex');
            }
            input.classList.remove('error');

            // Untuk password confirmation, cek kesesuaian
            if (field === 'password' || field === 'password_confirmation') {
                checkPasswordMatch();
            }
        }

        // Check if passwords match
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;
            const confirmInput = document.getElementById('password_confirmation');
            const confirmErrBox = document.getElementById('password_confirmation-error');
            const confirmErrText = document.getElementById('password_confirmation-error-text');

            if (confirm !== '' && password !== confirm) {
                confirmInput.classList.add('error');
                confirmErrText.textContent = 'Password tidak cocok dengan password baru';
                confirmErrBox.classList.remove('hidden');
                confirmErrBox.classList.add('flex');
                return false;
            } else if (confirm !== '' && password === confirm) {
                confirmInput.classList.remove('error');
                confirmErrBox.classList.add('hidden');
                confirmErrBox.classList.remove('flex');
                return true;
            }
            return true;
        }

        // Main submit handler
        function handleSubmit(e) {
            e.preventDefault();

            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;

            let isValid = true;

            // Validate email
            if (!email) {
                showError('email', 'Email wajib diisi.');
                isValid = false;
            } else if (!isValidEmail(email)) {
                showError('email', 'Format email tidak valid. Contoh: nama@mail.com');
                isValid = false;
            }

            // Validate password
            if (!password) {
                showError('password', 'Password baru wajib diisi.');
                isValid = false;
            } else if (password.length < 8) {
                showError('password', 'Password minimal 8 karakter.');
                isValid = false;
            }

            // Validate confirmation
            if (!confirm) {
                showError('password_confirmation', 'Konfirmasi password wajib diisi.');
                isValid = false;
            } else if (password !== confirm) {
                showError('password_confirmation', 'Password tidak cocok dengan password baru.');
                isValid = false;
            }

            if (!isValid) return;

            // Loading state
            const btn = document.getElementById('submit-btn');
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" fill="currentColor" opacity="0.3"/>
                    <path d="M12 4a8 8 0 018 8h4C24 5.373 18.627 0 12 0v4z" fill="currentColor"/>
                </svg>
                Memproses...`;

            // Simulate API call (frontend dummy)
            setTimeout(() => {
                document.getElementById('form-state').classList.add('hidden');
                document.getElementById('success-state').classList.remove('hidden');
                document.getElementById('success-state').classList.add('scale-in');
            }, 1500);
        }

        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        function showError(field, msg) {
            const input = document.getElementById(field);
            const errBox = document.getElementById(`${field}-error`);
            const errText = document.getElementById(`${field}-error-text`);
            input.classList.add('error');
            errText.textContent = msg;
            errBox.classList.remove('hidden');
            errBox.classList.add('flex');
        }
    </script>

</body>
</html>