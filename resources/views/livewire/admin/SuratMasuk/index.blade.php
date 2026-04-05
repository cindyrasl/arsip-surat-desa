<!-- resources/views/livewire/admin/SuratMasuk/index.blade.php -->
@extends('layouts.app')
@section('content')

<div class="max-w-7xl mx-auto">

    <!-- Page Title Row -->
    <div class="flex items-center mb-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
            </svg>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-800 leading-tight">Surat Masuk</h1>
                <p class="text-xs text-gray-500">Kelola arsip surat masuk</p>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-5 mb-4">
        <div class="flex flex-wrap items-end gap-4">

            <!-- Search / Pencarian -->
            <div class="flex-1 min-w-50">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Pencarian</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                        </svg>
                    </span>
                    <input id="search-input" type="text" placeholder="Cari nomor surat, perihal, atau asal surat..."
                        class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                        oninput="applyFilters()">
                </div>
            </div>

            <!-- Tanggal Surat (Dari) -->
            <div class="flex-2 min-w-45">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tanggal Surat (Dari)</label>
                <input id="date-start" type="date"
                    class="w-full pl-4 pr-5 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                    onchange="applyFilters()">
            </div>

            <!-- Tanggal Surat (Sampai) -->
            <div class="flex-2 min-w-45">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tanggal Surat (Sampai)</label>
                <input id="date-end" type="date"
                    class="w-full pl-4 pr-5 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                    onchange="applyFilters()">
            </div>
        </div>
    </div>
</div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <!-- Card Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-800">Daftar Surat Masuk</h2>
            <a href="{{ route('suratmasuk.create') }}"
                class="flex items-center gap-2 bg-primary hover:bg-primary-dark text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" stroke-linecap="round"/>
                </svg>
                Tambah Surat Masuk
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-100">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide w-14">No</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide">Nomor Surat</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide">
                            <div class="flex items-center gap-2 cursor-pointer group" onclick="toggleSort()">
                                <span>Tanggal Terima</span>
                                <div class="flex flex-col">
                                    <svg id="sort-asc" class="w-3 h-3 -mb-1 text-gray-400 group-hover:text-gray-600 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 5l4 5H6l4-5z"/>
                                    </svg>
                                    <svg id="sort-desc" class="w-3 h-3 text-gray-400 group-hover:text-gray-600 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 15l-4-5h8l-4 5z"/>
                                    </svg>
                                </div>
                            </div>
                        </th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide">Perihal</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide">Asal Surat</th>
                        <th class="text-center px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody id="table-body" class="divide-y divide-gray-50"></tbody>
            </table>
            <div id="empty-state" class="hidden py-16 text-center">
                <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <p class="text-gray-400 text-sm font-medium">Tidak ada data surat masuk.</p>
            </div>
        </div>

        <!-- Pagination Footer -->
        <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-t border-gray-100">
            <p class="text-sm text-gray-500" id="pagination-info"></p>
            <div id="pagination-controls" class="flex items-center gap-1"></div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="delete-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center" onclick="event.stopPropagation()">
            <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-800 mb-1">Hapus Surat?</h3>
            <p class="text-sm text-gray-500 mb-6">Data surat akan dihapus secara permanen dan tidak dapat dipulihkan.</p>
            <div class="flex gap-3">
                <button onclick="closeDelete()" class="flex-1 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Batal</button>
                <button onclick="confirmDelete()" class="flex-1 py-2.5 text-sm font-semibold bg-red-500 hover:bg-red-600 text-white rounded-xl transition-colors">Hapus</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
// ── Dummy Data 
let allData = [
    { id:1,  nomor:'001/SM/2026', tanggal:'2026-11-01', perihal:'Pembuatan Surat Keterangan',     asal:'Dinas Kebudayaan',       keterangan:'' },
    { id:2,  nomor:'002/SM/2026', tanggal:'2026-10-28', perihal:'Permohonan Izin Keramaian',      asal:'Dinas Pariwisata',       keterangan:'' },
    { id:3,  nomor:'003/SM/2026', tanggal:'2026-10-25', perihal:'Undangan Rapat Koordinasi',      asal:'Kecamatan Teluk Kapuas', keterangan:'' },
    { id:4,  nomor:'004/SM/2026', tanggal:'2026-10-22', perihal:'Surat Pemberitahuan Kegiatan',   asal:'Dinas Sosial',           keterangan:'' },
    { id:5,  nomor:'005/SM/2026', tanggal:'2026-10-19', perihal:'Permohonan Data Penduduk',       asal:'BPS Kubu Raya',          keterangan:'' },
    { id:6,  nomor:'006/SM/2026', tanggal:'2026-10-16', perihal:'Surat Rekomendasi UMKM',         asal:'Dinas Koperasi',         keterangan:'' },
    { id:7,  nomor:'007/SM/2026', tanggal:'2026-10-13', perihal:'Laporan Keamanan Lingkungan',    asal:'Polsek Sungai Raya',     keterangan:'' },
    { id:8,  nomor:'008/SM/2026', tanggal:'2026-10-10', perihal:'Permohonan Surat Domisili',      asal:'Warga Desa',             keterangan:'' },
    { id:9,  nomor:'009/SM/2026', tanggal:'2026-10-07', perihal:'Undangan Musyawarah Desa',       asal:'Kecamatan Teluk Kapuas', keterangan:'' },
    { id:10, nomor:'010/SM/2026', tanggal:'2026-10-04', perihal:'Permohonan Pengantar Nikah',     asal:'KUA Kubu Raya',          keterangan:'' },
    { id:11, nomor:'011/SM/2026', tanggal:'2026-10-01', perihal:'Surat Edaran Pilkades',          asal:'Dinas PMD',              keterangan:'' },
];
let nextId = 21;

// ── State ─────────────────────────────────────────────────────────
let currentPage = 1;
let perPage = 10;
let filtered = [...allData];
let deleteTarget = null;
let sortOrder = 'desc'; 

// ── Helpers ───────────────────────────────────────────────────────
function fmt(str) {
    if (!str) return '-';
    return new Date(str).toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' });
}

// ── Sort Function ─────────────────────────────────────────────────
function applySort() {
    filtered.sort((a, b) => {
        const dateA = new Date(a.tanggal);
        const dateB = new Date(b.tanggal);
        
        if (sortOrder === 'desc') {
            return dateB - dateA; // Terbaru ke terlama
        } else {
            return dateA - dateB; // Terlama ke terbaru
        }
    });
}

function updateSortIcons() {
    const ascIcon = document.getElementById('sort-asc');
    const descIcon = document.getElementById('sort-desc');
    
    if (sortOrder === 'asc') {
        ascIcon.classList.add('text-primary');
        ascIcon.classList.remove('text-gray-400');
        descIcon.classList.remove('text-primary');
        descIcon.classList.add('text-gray-400');
    } else {
        descIcon.classList.add('text-primary');
        descIcon.classList.remove('text-gray-400');
        ascIcon.classList.remove('text-primary');
        ascIcon.classList.add('text-gray-400');
    }
}

function toggleSort() {
    sortOrder = sortOrder === 'desc' ? 'asc' : 'desc';
    updateSortIcons();
    applyFilters(); // Re-apply filters which will re-sort the data
}

// ── Render ────────────────────────────────────────────────────────
function renderTable() {
    const tbody = document.getElementById('table-body');
    const empty = document.getElementById('empty-state');
    const info  = document.getElementById('pagination-info');
    const total = filtered.length;
    const pages = Math.max(1, Math.ceil(total / perPage));
    if (currentPage > pages) currentPage = pages;
    const s = (currentPage - 1) * perPage;
    const e = Math.min(s + perPage, total);
    const slice = filtered.slice(s, e);

    if (!slice.length) {
        tbody.innerHTML = '';
        empty.classList.remove('hidden');
    } else {
        empty.classList.add('hidden');
        tbody.innerHTML = slice.map((r, i) => `
            <tr class="hover:bg-gray-100 transition-colors">
                <td class="px-6 py-3.5 text-gray-400 text-center text-sm">${s + i + 1}</td>
                <td class="px-6 py-3.5 font-semibold text-gray-800 text-sm whitespace-nowrap">${r.nomor}</td>
                <td class="px-6 py-3.5 text-gray-600 text-sm whitespace-nowrap">${fmt(r.tanggal)}</td>
                <td class="px-6 py-3.5 text-gray-700 text-sm">${r.perihal}</td>
                <td class="px-6 py-3.5 text-gray-600 text-sm">${r.asal}</td>
                <td class="px-6 py-3.5">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('suratmasuk.detail') }}?id=${r.id}" title="Lihat Detail"
                            class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                        <a href="{{ route('suratmasuk.edit') }}?id=${r.id}" title="Edit"
                            class="w-8 h-8 rounded-lg bg-amber-50 hover:bg-amber-100 flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                <path d="M17.586 3.586a2 2 0 012.828 2.828L12 15l-4 1 1-4 8.586-8.414z"/>
                            </svg>
                        </a>
                        <button onclick="openDelete(${r.id})" title="Hapus"
                            class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                 </td>
               </tr>
        `).join('');
    }

    if (total === 0) {
        info.innerHTML = 'Menampilkan <b>0</b> - <b>0</b> dari <b>0</b> data';
    } else {
        info.innerHTML = `Menampilkan <span class="font-semibold text-gray-700">${s+1}</span> - <span class="font-semibold text-gray-700">${e}</span> dari <span class="font-semibold text-gray-700">${total}</span> data`;
    }

    renderPagination(pages);
}

function renderPagination(pages) {
    const el = document.getElementById('pagination-controls');
    let h = '';
    h += `<button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 bg-white hover:bg-primary hover:text-white hover:border-primary disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-gray-500 transition-all"
              onclick="gp(${currentPage-1})" ${currentPage<=1?'disabled':''}>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
          </button>`;

    let ps = Math.max(1, currentPage-2);
    let pe = Math.min(pages, ps+4);
    ps = Math.max(1, pe-4);

    for (let p = ps; p <= pe; p++) {
        h += `<button class="w-8 h-8 flex items-center justify-center rounded-lg border text-sm font-semibold transition-all ${p===currentPage ? 'bg-primary text-white border-primary' : 'border-gray-200 bg-white text-gray-600 hover:bg-primary hover:text-white hover:border-primary'}"
                  onclick="gp(${p})">${p}</button>`;
    }

    h += `<button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 bg-white hover:bg-primary hover:text-white hover:border-primary disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-gray-500 transition-all"
              onclick="gp(${currentPage+1})" ${currentPage>=pages?'disabled':''}>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
          </button>`;

    el.innerHTML = h;
}

function gp(p) {
    const pages = Math.ceil(filtered.length/perPage)||1;
    if (p < 1 || p > pages) return;
    currentPage = p;
    renderTable();
}

// ── Filters ───────────────────────────────────────────────────────
function applyFilters() {
    const q  = document.getElementById('search-input').value.toLowerCase();
    const ds = document.getElementById('date-start').value;
    const de = document.getElementById('date-end').value;
    
    filtered = allData.filter(r => {
        const mq = !q || r.nomor.toLowerCase().includes(q) || r.perihal.toLowerCase().includes(q) || r.asal.toLowerCase().includes(q);
        const ms = !ds || r.tanggal >= ds;
        const me = !de || r.tanggal <= de;
        return mq && ms && me;
    });
    
    // Apply sorting after filtering
    applySort();
    
    currentPage = 1;
    renderTable();
}

// ── Delete Modal ──────────────────────────────────────────────────
function openDelete(id) { 
    deleteTarget = id; 
    document.getElementById('delete-overlay').classList.remove('hidden');
    document.getElementById('delete-overlay').classList.add('flex');
}
function closeDelete() { 
    deleteTarget = null; 
    document.getElementById('delete-overlay').classList.add('hidden');
    document.getElementById('delete-overlay').classList.remove('flex');
}
function confirmDelete() {
    allData = allData.filter(r => r.id !== deleteTarget);
    closeDelete();
    applyFilters();
}

// Sinkronisasi data dari localStorage jika ada update dari halaman edit
function syncDataFromStorage() {
    const updated = localStorage.getItem('suratMasukUpdated');
    if (updated) {
        const { id, data } = JSON.parse(updated);
        const index = allData.findIndex(item => item.id === id);
        if (index !== -1) {
            allData[index] = data;
            applyFilters(); // Refresh tampilan
        }
        localStorage.removeItem('suratMasukUpdated'); // Hapus setelah sync
    }
}

// Panggil sync saat halaman dimuat
syncDataFromStorage();

// Listen untuk storage events
window.addEventListener('storage', function(e) {
    if (e.key === 'suratMasukUpdated') {
        syncDataFromStorage();
    }
});

// ── Init ──────────────────────────────────────────────────────────
updateSortIcons();
applySort();
renderTable();
</script>
@endpush