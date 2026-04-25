<!-- sidebar.blade -->

<!-- Mobile Overlay -->
<div x-show="sidebarOpen" 
     x-transition.opacity
     @click="sidebarOpen = false"
     class="fixed inset-0 bg-black/50 z-40 md:hidden"
     style="display: none;"></div>

<!-- Sidebar -->
<aside id="sidebar" 
       class="w-64 bg-white min-h-screen flex flex-col fixed top-0 left-0 bottom-0 z-50 shadow-lg transition-transform duration-300 md:translate-x-0 -translate-x-full"
       :class="{ 'translate-x-0': sidebarOpen }"
       x-cloak>

    <!-- Logo -->
    <div class="px-5 py-5">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 shrink-0">
                <img src="{{ asset('logo_kantor.png') }}" class="h-27 w-24 object-contain drop-shadow-md">
            </div>
            <div>
                <p class="text-primary font-800 text-base font-extrabold leading-tight mb-1">Arsip Surat Digital</p>
                <p class="text-primary text-xs leading-tight">Kantor Desa Teluk Kapuas</p>
            </div>
        </div>
        <hr class="mt-4 border-gray-200">
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-3 pb-4 space-y-1">

        @php
            $currentRoute = Route::currentRouteName();
        @endphp

        <a href="{{ route('dashboard') }}" 
           @click="sidebarOpen = false"
           class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ $currentRoute == 'dashboard' ? 'active bg-primary text-white' : 'text-gray-600 hover:bg-primary/15 hover:text-primary' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>
            Beranda
        </a>

        <a href="{{ route('suratmasuk.index') }}" 
           @click="sidebarOpen = false"
           class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ $currentRoute == 'suratmasuk.index' ? 'active bg-primary text-white' : 'text-gray-600 hover:bg-primary/15 hover:text-primary' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
            </svg>
            Surat Masuk
        </a>

        <a href="{{ route('suratkeluar.index') }}" 
           @click="sidebarOpen = false"
           class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ $currentRoute == 'suratkeluar.index' ? 'active bg-primary text-white' : 'text-gray-600 hover:bg-primary/15 hover:text-primary' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
            </svg>
            Surat Keluar
        </a>

        <a href="{{ route('galerisurat.index') }}" 
           @click="sidebarOpen = false"
           class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('galerisurat.index') ? 'active bg-primary text-white' : 'text-gray-600 hover:bg-primary/15 hover:text-primary' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
            Galeri Surat
        </a>

        <a href="{{ route('jenissurat.index') }}" 
           @click="sidebarOpen = false"
           class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('jenissurat.index') ? 'active bg-primary text-white' : 'text-gray-600 hover:bg-primary/15 hover:text-primary' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
            </svg>
            Jenis Surat
        </a>

        <a href="{{ route('pengguna.index') }}" 
            @click="sidebarOpen = false"
            class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('pengguna.index') ? 'active bg-primary text-white' : 'text-gray-600 hover:bg-primary/15 hover:text-primary' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
            Pengguna
        </a>

        <a href="{{ route('laporan.index') }}" 
           @click="sidebarOpen = false"
           class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('laporan.index') ? 'active bg-primary text-white' : 'text-gray-600 hover:bg-primary/15 hover:text-primary' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
            </svg>
            Laporan
        </a>

        <a href="{{ route('riwayataktivitas.index') }}" 
           @click="sidebarOpen = false"
           class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('riwayataktivitas.index') ? 'active bg-primary text-white' : 'text-gray-600 hover:bg-primary/15 hover:text-primary' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            Riwayat Aktivitas
        </a>
    </nav>
</aside>