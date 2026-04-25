<header class="bg-white border-b border-gray-200 px-4 md:px-6 py-3 flex items-center justify-between sticky top-0 z-10 shadow-sm">
    <!-- Mobile Burger Button -->
    <button @click="sidebarOpen = true" class="md:hidden w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors">
        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <div class="relative ml-auto">
        <button onclick="toggleDropdown()" class="flex items-center gap-3 hover:bg-gray-50 rounded-xl px-3 py-2 transition-all">
            <div class="text-right">
                <p class="text-sm font-bold text-gray-800 leading-tight">{{ Auth::user()->nama ?? 'User' }}</p>
                <p class="text-xs text-gray-500 leading-tight">{{ Auth::user()->jabatan ?? 'Pengguna' }}</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-primary-light overflow-hidden border-2 border-primary/30">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama) }}&background=4C83AC&color=fff&size=128&bold=true" 
                    alt="Profile" class="w-full h-full object-cover">
            </div>
            <svg id="dropdown-arrow" class="w-4 h-4 text-gray-500 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M6 9l6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <div id="dropdown-menu" class="dropdown-menu absolute right-0 top-full mt-1 w-48 bg-white rounded-xl shadow-lg border border-gray-100 z-50 overflow-hidden hidden">
            <button onclick="openProfileModal()" class="flex items-center gap-3 w-full px-4 py-3 text-sm text-gray-700 hover:bg-primary/10 transition-colors text-left">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Profil Saya</span>
            </button>
            <hr class="border-gray-100">
            
            <form action="{{ route('logout') }}" method="POST" class="block">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-sm text-red-500 hover:bg-red-50 transition-colors text-left">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>
</header>

<!-- modal profile -->
<livewire:auth.profile />

<script>
    // DROPDOWN
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdown-menu');
        const arrow = document.getElementById('dropdown-arrow');
        dropdown.classList.toggle('hidden');
        arrow.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
    }

    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('dropdown-menu');
        const isClickInside = event.target.closest('.relative');
        if (dropdown && !dropdown.classList.contains('hidden') && !isClickInside) {
            dropdown.classList.add('hidden');
            document.getElementById('dropdown-arrow').style.transform = 'rotate(0deg)';
        }
    });

    function openProfileModal() {
        document.getElementById('dropdown-menu').classList.add('hidden');
        document.getElementById('dropdown-arrow').style.transform = 'rotate(0deg)';
        
        const profileComponent = document.querySelector('[wire\\:id]');
        if (profileComponent) {
            const componentId = profileComponent.getAttribute('wire:id');
            Livewire.find(componentId).call('openModal');
        }
    }
</script>

<style>
    .dropdown-menu {
        transition: all 0.2s ease;
    }
    .dropdown-menu:not(.hidden) {
        animation: dropdownFadeIn 0.2s ease;
    }
    @keyframes dropdownFadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>