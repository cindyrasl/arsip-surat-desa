<header class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-end sticky top-0 z-10 shadow-sm">
    <div class="relative">
        <button onclick="toggleDropdown()" class="flex items-center gap-3 hover:bg-gray-50 rounded-xl px-3 py-2 transition-all">
            <div class="text-right">
                <p class="text-sm font-bold text-gray-800 leading-tight">Barbara Palvin</p>
                <p class="text-xs text-gray-500 leading-tight">Admin</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-primary-light overflow-hidden border-2 border-primary/30">
                <img src="{{ asset('profil.jpg') }}" alt="Profile" class="w-full h-full object-cover" onerror="this.style.display='none'">
            </div>
            <svg id="dropdown-arrow" class="w-4 h-4 text-gray-500 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M6 9l6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <div id="dropdown-menu" class="dropdown-menu absolute right-0 top-full mt-1 w-44 bg-white rounded-xl shadow-lg border border-gray-100 z-50 overflow-hidden hidden">
            <hr class="border-gray-100">
            <a href="#" onclick="logout()" class="flex items-center gap-2 px-4 py-3 text-sm text-red-500 hover:bg-red-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Keluar
            </a>
        </div>
    </div>
</header>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdown-menu');
        const arrow = document.getElementById('dropdown-arrow');
        
        dropdown.classList.toggle('hidden');
        arrow.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
    }

    function logout() {
        // Konfirmasi logout dengan custom confirm
        const confirmLogout = confirm('Apakah Anda yakin ingin keluar dari sistem?');
        
        if (confirmLogout) {
            // Redirect ke halaman login
            window.location.href = '/';
        }
    }

    // Menutup dropdown saat klik di luar
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('dropdown-menu');
        const isClickInside = event.target.closest('.relative');
        
        if (dropdown && !dropdown.classList.contains('hidden') && !isClickInside) {
            dropdown.classList.add('hidden');
            document.getElementById('dropdown-arrow').style.transform = 'rotate(0deg)';
        }
    });
</script>

<style>
    .dropdown-menu {
        transition: all 0.2s ease;
    }
    
    .dropdown-menu:not(.hidden) {
        animation: dropdownFadeIn 0.2s ease;
    }
    
    @keyframes dropdownFadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>