<!-- app.blade -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Digital - Kantor Desa Teluk Kapuas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4C83AC',
                        'primary-dark': '#3a6a8f',
                        'primary-light': '#ddeaf4',
                        sidebar: '#1e3a50',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; font-variant-ligatures: no-common-ligatures; }

        /* Sidebar active item - PENTING! */
        .nav-item { transition: all 0.2s ease; }
        .nav-item:hover { background-color: rgba(76,131,172,0.15); color: #4C83AC; }
        .nav-item.active { background-color: #4C83AC; color: #ffffff; }
        .nav-item.active svg { color: #ffffff; }

        /* Card hover */
        .stat-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(76,131,172,0.15); }

        /* Mail row hover */
        .mail-row { transition: background-color 0.15s ease; }
        .mail-row:hover { background-color: #f0f7fc; }

        /* Dropdown */
        .dropdown-menu { display: none; }
        .dropdown-menu.open { display: block; }

        /* Sidebar scroll */
        #sidebar { overflow-y: auto; scrollbar-width: thin; scrollbar-color: rgba(76,131,172,0.3) transparent; }

        /* Modal styles */
        #modal-overlay, #delete-overlay {
            display: none;
        }

        #modal-overlay.flex, #delete-overlay.flex {
            display: flex !important;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">

    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col ml-64 min-h-screen">

        @include('layouts.header')

        <main class="flex-1 p-6 bg-gray-50">
            @yield('content')
        </main>

        <footer class="bg-white border-t border-gray-100 text-center py-4">
            <p class="text-xs text-gray-400">© 2026 - Arsip Surat Digital Kantor Desa Teluk Kapuas. All rights reserved</p>
        </footer>

    </div>

    <!-- JavaScript Global -->
    <script>
        // Fungsi untuk active state sidebar
        function setActive(el, key) {
            document.querySelectorAll('.nav-item').forEach(n => {
                n.classList.remove('active');
                n.classList.add('text-gray-600');
            });
            el.classList.add('active');
            el.classList.remove('text-gray-600');
        }

        function setActiveByKey(key) {
            const map = { masuk: 1, keluar: 2, galeri: 3, jenis: 4, laporan: 5, pengguna: 6, riwayat: 7 };
            const items = document.querySelectorAll('.nav-item');
            const idx   = map[key];
            if (idx !== undefined) {
                setActive(items[idx], key);
                items[idx].click();
            }
        }

        // Fungsi untuk dropdown profile
        function toggleDropdown() {
            const menu   = document.getElementById('dropdown-menu');
            const arrow  = document.getElementById('dropdown-arrow');
            const isOpen = menu?.classList.contains('open');
            if (menu) {
                menu.classList.toggle('open', !isOpen);
                if (arrow) arrow.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const btn  = e.target.closest('button[onclick="toggleDropdown()"]');
            const menu = document.getElementById('dropdown-menu');
            if (!btn && menu?.classList.contains('open')) {
                menu.classList.remove('open');
                const arrow = document.getElementById('dropdown-arrow');
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            }
        });

        // Set active menu berdasarkan URL saat ini
        document.addEventListener('DOMContentLoaded', function() {
            const currentUrl = window.location.pathname;
            document.querySelectorAll('.nav-item').forEach(item => {
                const href = item.getAttribute('href');
                if (href && href !== '#' && currentUrl === href) {
                    item.classList.add('active');
                    item.classList.remove('text-gray-600');
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>