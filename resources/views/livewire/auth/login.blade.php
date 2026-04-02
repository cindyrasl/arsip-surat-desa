<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'Arsip Surat Digital - Kantor Desa Teluk Kapuas' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font (masih perlu external) --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Keyframe minimal (tidak bisa full Tailwind) --}}
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-[#f0f6fb] font-[Plus_Jakarta_Sans]">

<div class="w-full min-h-screen flex flex-col md:flex-row shadow-2xl overflow-hidden bg-white">

    {{-- LEFT PANEL --}}
    <div class="hidden md:flex flex-col items-center justify-center w-1/2 min-h-screen relative overflow-hidden bg-[#ffffff]">

        <div class="absolute w-[1550px] h-[1300px] bg-[#B9D8EF] rounded-full top-1/2 -translate-y-1/2 -left-[800px]"></div>
        <div class="absolute w-[1350px] h-[1200px] bg-[#90CEFB] rounded-full top-1/2 -translate-y-1/2 -left-[650px]"></div>
        <div class="absolute w-[1150px] h-[1000px] bg-[#4C83AC] rounded-full top-1/2 -translate-y-1/2 -left-[500px]"></div>

        <div class="flex flex-col items-center gap-6 relative z-50">
            <img
                src="{{ asset('logo.png') }}"
                class="w-96 xl:w-[420px] 2xl:w-[500px] drop-shadow-xl -translate-x-[80px]"
            >
        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="flex flex-col items-center justify-between w-full md:w-1/2 min-h-screen bg-white px-8 sm:px-16 xl:px-24 py-12">

        <div class="w-full flex flex-col items-center flex-1 justify-center">

            {{-- Logo --}}
            <div class="mb-5 animate-[fadeInUp_0.5s_ease]">
                <img src="{{ asset('logo_kantor.png') }}" class="h-24 w-24 object-contain drop-shadow-md">
            </div>

            {{-- Title --}}
            <div class="text-center mb-8 animate-[fadeInUp_0.5s_ease]">
                <h1 class="text-3xl xl:text-4xl font-extrabold text-[#2d6e9e]">
                    Arsip Surat Digital
                </h1>
                <h2 class="text-xl xl:text-2xl font-bold text-[#2d6e9e] mt-1">
                    Kantor Desa Teluk Kapuas
                </h2>
            </div>

            {{-- FORM --}}
            <form class="w-full space-y-5">

                {{-- Username --}}
                <div>
                    <label class="text-sm font-semibold text-gray-700">Username</label>
                    <input
                        type="text"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm
                               focus:outline-none focus:border-[#4a90b8] focus:ring-4 focus:ring-[#4a90b82e]"
                        placeholder="Masukkan username"
                    >
                </div>

                {{-- Password --}}
                <div>
                    <label class="text-sm font-semibold text-gray-700">Password</label>
                    <input
                        type="password"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm
                               focus:outline-none focus:border-[#4a90b8] focus:ring-4 focus:ring-[#4a90b82e]"
                        placeholder="Masukkan password"
                    >
                </div>

                {{-- Remember --}}
                <div class="flex justify-between items-center">
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" class="accent-[#4a90b8]">
                        Ingat saya
                    </label>
                    <a class="text-sm font-semibold text-[#4a90b8] hover:text-[#2d6e9e]">
                        Lupa password
                    </a>
                </div>

                {{-- Button --}}
                <button
                    class="w-full py-3.5 rounded-xl text-white font-bold
                           bg-gradient-to-br from-[#4a90b8] to-[#2d6e9e]
                           hover:from-[#3a7da8] hover:to-[#1e5a8a]
                           hover:shadow-lg transition"
                >
                    Masuk
                </button>

            </form>
        </div>

        <p class="text-xs text-gray-400">
            © {{ date('Y') }} Kantor Desa Teluk Kapuas
        </p>

    </div>
</div>

</body>