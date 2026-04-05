@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Page Title Row -->
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-800 leading-tight">Riwayat Aktivitas</h1>
                <p class="text-xs text-gray-500">Catatan semua aktivitas pengguna sistem</p>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="flex flex-wrap items-center gap-3 mb-5">

        <!-- Search -->
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
            </span>
            <input id="search-input" type="text" placeholder="Cari aktivitas atau pengguna..." class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all" oninput="applyFilters()">
        </div>

        <!-- Filter by action type -->
        <div class="relative">
            <select id="filter-type" onchange="applyFilters()" class="pl-4 pr-9 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all appearance-none cursor-pointer w-48">
                <option value="">Semua Aktivitas</option>
                <option value="login">Login</option>
                <option value="logout">Logout</option>
                <option value="tambah">Tambah Surat</option>
                <option value="edit">Edit Surat</option>
                <option value="hapus">Hapus Surat</option>
                <option value="lihat">Lihat Detail</option>
                <option value="unduh">Unduh File</option>
            </select>
            <span class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 9l6 6 6-6" stroke-linecap="round"/>
                </svg>
            </span>
        </div>

        <!-- Date filter -->
        <input id="date-filter" type="date" class="pl-5 pr-5 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all w-52" onchange="applyFilters()">

    </div>

    <!-- Activity Feed Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">

        <!-- Card Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                </svg>
                <h2 class="font-bold text-gray-800">Log Aktivitas</h2>
            </div>
            <span id="activity-count" class="text-xs font-semibold text-gray-500 bg-gray-100 px-3 py-1 rounded-full">0 Aktivitas</span>
        </div>

        <!-- Feed -->
        <div id="activity-feed" class="divide-y divide-gray-50 px-6 py-2"></div>

        <!-- Empty State -->
        <div id="empty-state" class="hidden py-16 text-center px-6">
            <div class="w-14 h-14 rounded-2xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
                <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <path d="M9 9h1M9 12h6M9 15h6M14 9h1"/>
                </svg>
            </div>
            <p class="text-gray-400 text-sm font-medium">Tidak ada aktivitas ditemukan.</p>
            <p class="text-gray-300 text-xs mt-1">Coba ubah filter pencarian.</p>
        </div>

        <!-- Pagination Footer -->
        <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-t border-gray-100">
            <p class="text-sm text-gray-500" id="pagination-info"></p>
            <div id="pagination-controls" class="flex items-center gap-1"></div>
        </div>

    </div>
</div>

<script>
// ── Dummy Data 
const allActivities = [
    // --- 2026-12-05 ---
    { id:1,  user:'Barbara Palvin', initial:'B', waktu:'2026-12-05 08:02:00', tipe:'login',   pesan:'masuk ke sistem' },
    { id:2,  user:'Barbara Palvin', initial:'B', waktu:'2026-12-05 08:15:00', tipe:'tambah',  pesan:'menambahkan surat masuk <strong>001/SM/2026</strong> dari Dinas Kesehatan' },
    { id:3,  user:'Ahmad Fauzi',    initial:'A', waktu:'2026-12-05 08:45:00', tipe:'login',   pesan:'masuk ke sistem' },
    { id:4,  user:'Ahmad Fauzi',    initial:'A', waktu:'2026-12-05 09:00:00', tipe:'lihat',   pesan:'melihat detail surat masuk <strong>001/SM/2026</strong>' },
    { id:5,  user:'Barbara Palvin', initial:'B', waktu:'2026-12-05 09:30:00', tipe:'tambah',  pesan:'menambahkan surat keluar <strong>001/SK/2026</strong> ke Kecamatan Teluk Kapuas' },
    { id:6,  user:'Ahmad Fauzi',    initial:'A', waktu:'2026-12-05 10:15:00', tipe:'edit',    pesan:'mengedit surat masuk <strong>001/SM/2026</strong> — memperbarui perihal' },
    { id:7,  user:'Siti Rahayu',    initial:'S', waktu:'2026-12-05 10:45:00', tipe:'login',   pesan:'masuk ke sistem' },
    { id:11, user:'Siti Rahayu',    initial:'S', waktu:'2026-12-05 13:15:00', tipe:'lihat',   pesan:'melihat galeri surat bulan November 2026' },
    { id:12, user:'Barbara Palvin', initial:'B', waktu:'2026-12-05 14:00:00', tipe:'hapus',   pesan:'menghapus surat keluar <strong>003/SK/2025</strong>' },
    // --- 2026-12-04 ---
    { id:15, user:'Ahmad Fauzi',    initial:'A', waktu:'2026-12-04 07:55:00', tipe:'login',   pesan:'masuk ke sistem' },
    { id:18, user:'Barbara Palvin', initial:'B', waktu:'2026-12-04 09:00:00', tipe:'edit',    pesan:'mengedit surat masuk <strong>002/SM/2026</strong> — memperbarui asal surat' },
    { id:19, user:'Ahmad Fauzi',    initial:'A', waktu:'2026-12-04 10:30:00', tipe:'unduh',   pesan:'mengunduh file surat masuk <strong>003/SM/2026</strong>' },
    { id:20, user:'Siti Rahayu',    initial:'S', waktu:'2026-12-04 11:00:00', tipe:'login',   pesan:'masuk ke sistem' },
    { id:21, user:'Siti Rahayu',    initial:'S', waktu:'2026-12-04 11:30:00', tipe:'lihat',   pesan:'melihat detail surat keluar <strong>001/SK/2026</strong>' },
    { id:22, user:'Barbara Palvin', initial:'B', waktu:'2026-12-04 13:45:00', tipe:'tambah',  pesan:'menambahkan surat keluar <strong>002/SK/2026</strong> ke Dinas Sosial' },
    { id:23, user:'Ahmad Fauzi',    initial:'A', waktu:'2026-12-04 14:00:00', tipe:'logout',  pesan:'keluar dari sistem' },
    // --- 2026-12-03 ---
    { id:26, user:'Barbara Palvin', initial:'B', waktu:'2026-12-03 08:00:00', tipe:'login',   pesan:'masuk ke sistem' },
    { id:27, user:'Barbara Palvin', initial:'B', waktu:'2026-12-03 08:20:00', tipe:'tambah',  pesan:'menambahkan surat masuk <strong>004/SM/2026</strong> dari Polsek Sungai Raya' },
    { id:28, user:'Ahmad Fauzi',    initial:'A', waktu:'2026-12-03 09:00:00', tipe:'login',   pesan:'masuk ke sistem' },
    { id:29, user:'Ahmad Fauzi',    initial:'A', waktu:'2026-12-03 09:30:00', tipe:'hapus',   pesan:'menghapus surat masuk <strong>009/SM/2025</strong>' },
    { id:31, user:'Siti Rahayu',    initial:'S', waktu:'2026-12-03 10:20:00', tipe:'unduh',   pesan:'mengunduh file surat keluar <strong>002/SK/2026</strong>' },
    { id:32, user:'Barbara Palvin', initial:'B', waktu:'2026-12-03 13:00:00', tipe:'edit',    pesan:'mengedit surat keluar <strong>002/SK/2026</strong> — memperbarui keterangan' },
    { id:33, user:'Ahmad Fauzi',    initial:'A', waktu:'2026-12-03 14:30:00', tipe:'lihat',   pesan:'melihat laporan surat bulan November 2026' },
    { id:34, user:'Siti Rahayu',    initial:'S', waktu:'2026-12-03 15:00:00', tipe:'logout',  pesan:'keluar dari sistem' },
    { id:35, user:'Ahmad Fauzi',    initial:'A', waktu:'2026-12-03 16:00:00', tipe:'logout',  pesan:'keluar dari sistem' },
];

// State 
let filtered    = [...allActivities];
let currentPage = 1;
const perPage   = 15;

// Helpers 
function fmtDate(str) {
    return new Date(str).toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long', year:'numeric' });
}
function fmtTime(str) {
    return new Date(str).toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
}
function dayKey(str) { return str.slice(0, 10); }

// Action icon SVG per type
function actionIcon(tipe) {
    const icons = {
        login:  `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3" stroke-linecap="round" stroke-linejoin="round"/></svg>`,
        logout: `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 16l4-4-4-4M21 12H9M13 3H5a2 2 0 00-2 2v14a2 2 0 002 2h8" stroke-linecap="round" stroke-linejoin="round"/></svg>`,
        tambah: `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>`,
        edit:   `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/><path d="M17.586 3.586a2 2 0 012.828 2.828L12 15l-4 1 1-4 8.586-8.414z"/></svg>`,
        hapus:  `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6" stroke-linecap="round" stroke-linejoin="round"/></svg>`,
        lihat:  `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`,
        unduh:  `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 4v12M8 12l4 4 4-4" stroke-linecap="round" stroke-linejoin="round"/></svg>`,
    };
    return icons[tipe] || icons['lihat'];
}

function actionLabel(tipe) {
    const labels = { login:'Login', logout:'Logout', tambah:'Tambah', edit:'Edit', hapus:'Hapus', lihat:'Lihat', unduh:'Unduh' };
    return labels[tipe] || tipe;
}

// Get badge color class based on action type
function getBadgeClass(tipe) {
    const classes = {
        login:  'bg-blue-100 text-blue-700',
        logout: 'bg-amber-100 text-amber-700',
        tambah: 'bg-green-100 text-green-700',
        edit:   'bg-orange-100 text-orange-700',
        hapus:  'bg-red-100 text-red-700',
        lihat:  'bg-gray-100 text-gray-600',
        unduh:  'bg-purple-100 text-purple-700',
    };
    return classes[tipe] || 'bg-gray-100 text-gray-600';
}

function avatarColor(name) {
    const colors = [
        'bg-blue-100 text-blue-600',
        'bg-green-100 text-green-600',
        'bg-amber-100 text-amber-600',
        'bg-purple-100 text-purple-600',
        'bg-rose-100 text-rose-600',
        'bg-teal-100 text-teal-600',
    ];
    let hash = 0;
    for (let i = 0; i < name.length; i++) hash += name.charCodeAt(i);
    return colors[hash % colors.length];
}

// Render
function renderFeed() {
    const feed   = document.getElementById('activity-feed');
    const empty  = document.getElementById('empty-state');
    const info   = document.getElementById('pagination-info');
    const count  = document.getElementById('activity-count');

    const total  = filtered.length;
    const pages  = Math.max(1, Math.ceil(total / perPage));
    if (currentPage > pages) currentPage = pages;
    const s      = (currentPage - 1) * perPage;
    const e      = Math.min(s + perPage, total);
    const slice  = filtered.slice(s, e);

    count.textContent = total + ' Aktivitas';

    if (!slice.length) {
        feed.innerHTML = '';
        empty.classList.remove('hidden');
    } else {
        empty.classList.add('hidden');

        const groups = {};
        slice.forEach(a => {
            const key = dayKey(a.waktu);
            if (!groups[key]) groups[key] = [];
            groups[key].push(a);
        });

        let html = '';
        Object.keys(groups).sort((a,b) => b.localeCompare(a)).forEach(day => {
            // Day divider
            html += `<div class="flex items-center gap-2.5 text-gray-400 text-xs font-semibold uppercase tracking-wide py-4 pb-2">
                        <span class="flex-1 h-px bg-gray-200"></span>
                        <span>${fmtDate(day + 'T00:00:00')}</span>
                        <span class="flex-1 h-px bg-gray-200"></span>
                     </div>`;

            groups[day].forEach((a, idx) => {
                const avColor = avatarColor(a.user);
                const badgeClass = getBadgeClass(a.tipe);
                const isLast  = idx === groups[day].length - 1;
                // Activity row 
                html += `
                <div class="flex items-start gap-4 py-3 px-3 -mx-3 rounded-xl hover:bg-sky-50 transition-colors duration-150">
                    <div class="flex flex-col items-center flex-shrink-0">
                        <div class="w-9 h-9 rounded-xl ${avColor} flex items-center justify-center font-bold text-sm flex-shrink-0 shadow-sm">
                            ${a.initial}
                        </div>
                        ${!isLast ? `<div class="w-px flex-1 bg-gray-100 mt-2 min-h-[20px]"></div>` : ''}
                    </div>
                    <div class="flex-1 min-w-0 pb-1">
                        <div class="flex flex-wrap items-center gap-2 mb-0.5">
                            <span class="text-sm font-bold text-gray-800">${a.user}</span>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold ${badgeClass}">
                                ${actionIcon(a.tipe)}
                                ${actionLabel(a.tipe)}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">${a.pesan}</p>
                        <div class="flex items-center gap-1.5 mt-1.5">
                            <svg class="w-3 h-3 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                            </svg>
                            <span class="text-xs text-gray-400">${fmtTime(a.waktu)} WIB</span>
                        </div>
                    </div>
                </div>`;
            });
        });

        feed.innerHTML = html;
    }

    if (total === 0) {
        info.innerHTML = 'Menampilkan <b>0</b> dari <b>0</b> aktivitas';
    } else {
        info.innerHTML = `Menampilkan <span class="font-semibold text-gray-700">${s+1}</span>–<span class="font-semibold text-gray-700">${e}</span> dari <span class="font-semibold text-gray-700">${total}</span> aktivitas`;
    }

    renderPagination(pages);
}

function renderPagination(pages) {
    const el = document.getElementById('pagination-controls');
    let h = '';

    h += `<button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 bg-white transition-all duration-150 hover:bg-primary hover:text-white hover:border-primary disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-gray-500 disabled:hover:border-gray-200" onclick="gp(${currentPage-1})" ${currentPage<=1?'disabled':''}>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
          </button>`;

    let ps = Math.max(1, currentPage-2);
    let pe = Math.min(pages, ps+4);
    ps = Math.max(1, pe-4);
    for (let p = ps; p <= pe; p++) {
        h += `<button class="w-8 h-8 flex items-center justify-center rounded-lg border text-sm font-semibold transition-all duration-150 ${p===currentPage?'bg-primary text-white border-primary':'bg-white text-gray-600 border-gray-200 hover:bg-primary hover:text-white hover:border-primary'}" onclick="gp(${p})">${p}</button>`;
    }

    h += `<button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 bg-white transition-all duration-150 hover:bg-primary hover:text-white hover:border-primary disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-gray-500 disabled:hover:border-gray-200" onclick="gp(${currentPage+1})" ${currentPage>=pages?'disabled':''}>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
          </button>`;

    el.innerHTML = h;
}

function gp(p) {
    const pages = Math.ceil(filtered.length / perPage) || 1;
    if (p < 1 || p > pages) return;
    currentPage = p;
    renderFeed();
    document.getElementById('activity-feed').scrollIntoView({ behavior:'smooth', block:'start' });
}

// Filters 
function applyFilters() {
    const q    = document.getElementById('search-input').value.toLowerCase();
    const type = document.getElementById('filter-type').value;
    const date = document.getElementById('date-filter').value;

    filtered = allActivities.filter(a => {
        const mq = !q    || a.user.toLowerCase().includes(q) || a.pesan.toLowerCase().includes(q);
        const mt = !type || a.tipe === type;
        const md = !date || dayKey(a.waktu) === date;
        return mq && mt && md;
    });
    currentPage = 1;
    renderFeed();
}

// Init 
renderFeed();
</script>
@endsection