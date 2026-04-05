<!-- resources/views/livewire/admin/Laporan/index.blade.php -->

@extends('layouts.app')

@section('content')

{{-- ── Page Title Row ──────────────────────────────────────────────── --}}
<div class="flex items-center mb-5">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
            </svg>
        </div>
        <div>
            <h1 class="text-lg font-bold text-gray-800 leading-tight">Laporan</h1>
            <p class="text-xs text-gray-500">Kelola laporan arsip surat</p>
        </div>
    </div>
</div>

{{-- ── Filter Bar ───────────────────────────────────────────────────── --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-5 mb-4">
    <div class="flex flex-wrap items-end gap-4">

        {{-- Tanggal Surat (Dari) --}}
        <div class="flex-1 min-w-45">
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tanggal Surat (Dari)</label>
            <input id="date-start" type="date"
                class="w-full pl-4 pr-10 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                onchange="applyFilters()">
        </div>

        {{-- Tanggal Surat (Sampai) --}}
        <div class="flex-1 min-w-45">
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tanggal Surat (Sampai)</label>
            <input id="date-end" type="date"
                class="w-full pl-4 pr-10 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                onchange="applyFilters()">
        </div>

        {{-- Kategori Surat --}}
        <div class="flex-1 min-w-45">
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Kategori Surat</label>
            <div class="relative">
                <select id="filter-kategori" onchange="applyFilters()"
                    class="w-full pl-4 pr-9 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all appearance-none cursor-pointer">
                    <option value="">Semua Surat</option>
                    <option value="Surat Masuk">Surat Masuk</option>
                    <option value="Surat Keluar">Surat Keluar</option>
                </select>
                <span class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 9l6 6 6-6" stroke-linecap="round"/>
                    </svg>
                </span>
            </div>
        </div>

        {{-- Export Excel Button --}}
        <div class="shrink-0">
            <label class="block text-xs font-semibold text-transparent mb-1.5 select-none">Export</label>
            <button onclick="exportExcel()"
                class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors shadow-sm whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <path d="M7 8h10M7 12h10M7 16h6"/>
                    <path d="M16 14l2 2 2-2M18 16v-4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Export Excel
            </button>
        </div>
    </div>
</div>

{{-- ── Report Table Card ────────────────────────────────────────────── --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    {{-- Card Header --}}
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="5" y="2" width="14" height="20" rx="2"/><path d="M9 7h6M9 11h6M9 15h4"/>
            </svg>
            <h2 class="font-bold text-gray-800">Daftar Laporan Surat</h2>
        </div>
        <span id="report-count" class="text-xs font-semibold text-gray-500 bg-gray-100 px-3 py-1 rounded-full">0 Data</span>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-100  border-b border-gray-100">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide w-14">No</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Kategori Surat</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nomor Surat</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Perihal</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Jenis Surat</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal Dibuat</th>
                </tr>
            </thead>
            <tbody id="table-body" class="divide-y divide-gray-50"></tbody>
        </table>

        {{-- Empty State --}}
        <div id="empty-state" class="hidden py-16 text-center">
            <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <rect x="5" y="2" width="14" height="20" rx="2"/><path d="M9 7h6M9 11h6M9 15h4"/>
                </svg>
            </div>
            <p class="text-gray-400 text-sm font-medium">Tidak ada data laporan.</p>
            <p class="text-gray-300 text-xs mt-1">Coba ubah rentang tanggal atau kategori surat.</p>
        </div>
    </div>

    {{-- Pagination Footer --}}
    <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-t border-gray-100">
        <p class="text-sm text-gray-500" id="pagination-info"></p>
        <div id="pagination-controls" class="flex items-center gap-1"></div>
    </div>

</div>

{{-- ── Export Success Toast ─────────────────────────────────────────── --}}
<div id="toast" class="fixed bottom-6 right-6 z-50 hidden">
    <div class="flex items-center gap-3 bg-gray-900 text-white text-sm font-medium px-4 py-3 rounded-xl shadow-xl">
        <svg class="w-4 h-4 text-green-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span id="toast-msg"></span>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── DUMMY DATA (Hardcoded untuk testing tampilan) ──────────────────────
// Data dummy untuk laporan (gabungan Surat Masuk dan Surat Keluar)
const allData = [
    { id:1,  kategori:'Surat Masuk',  nomor:'001/SM/2026', perihal:'Pembuatan Surat Keterangan',     jenis:'Surat Keterangan',      tanggal:'2026-11-01T21:23:00' },
    { id:2,  kategori:'Surat Keluar', nomor:'001/SK/2026', perihal:'Surat Penugasan Perangkat Desa', jenis:'Surat Tugas Perangkat',  tanggal:'2026-11-01T21:23:00' },
    { id:3,  kategori:'Surat Masuk',  nomor:'002/SM/2026', perihal:'Permohonan Izin Keramaian',      jenis:'Surat Permohonan',       tanggal:'2026-10-28T09:00:00' },
    { id:4,  kategori:'Surat Keluar', nomor:'002/SK/2026', perihal:'Balasan Koordinasi Kecamatan',   jenis:'Surat Balasan',          tanggal:'2026-10-27T10:30:00' },
    { id:5,  kategori:'Surat Masuk',  nomor:'003/SM/2026', perihal:'Undangan Rapat Koordinasi',      jenis:'Surat Undangan',         tanggal:'2026-10-25T08:00:00' },
    { id:6,  kategori:'Surat Keluar', nomor:'003/SK/2026', perihal:'Pengumuman Jadwal Posyandu',     jenis:'Surat Pengumuman',       tanggal:'2026-10-24T11:00:00' },
    { id:7,  kategori:'Surat Masuk',  nomor:'004/SM/2026', perihal:'Surat Pemberitahuan Kegiatan',   jenis:'Surat Pemberitahuan',    tanggal:'2026-10-22T14:00:00' },
    { id:8,  kategori:'Surat Keluar', nomor:'004/SK/2026', perihal:'Laporan Realisasi APBDes',       jenis:'Surat Laporan',          tanggal:'2026-10-20T08:30:00' },
    { id:9,  kategori:'Surat Masuk',  nomor:'005/SM/2026', perihal:'Permohonan Data Penduduk',       jenis:'Surat Permohonan',       tanggal:'2026-10-19T10:00:00' },
    { id:10, kategori:'Surat Keluar', nomor:'005/SK/2026', perihal:'Rekomendasi Pinjaman Modal',     jenis:'Surat Rekomendasi',      tanggal:'2026-10-18T09:00:00' },
    { id:11, kategori:'Surat Masuk',  nomor:'006/SM/2026', perihal:'Surat Rekomendasi UMKM',         jenis:'Surat Rekomendasi',      tanggal:'2026-10-16T13:00:00' },
    { id:12, kategori:'Surat Keluar', nomor:'006/SK/2026', perihal:'Undangan HUT Kemerdekaan RI',    jenis:'Surat Undangan',         tanggal:'2026-10-14T08:00:00' },
];

// ── State ──────────────────────────────────────────────────────────────
let filtered    = [...allData];
let currentPage = 1;
const perPage   = 10;

// ── Helpers ────────────────────────────────────────────────────────────
function fmtDateTime(str) {
    if (!str) return '-';
    return new Date(str).toLocaleString('id-ID', {
        day: '2-digit', month: 'short', year: 'numeric',
        hour: '2-digit', minute: '2-digit'
    });
}

function dateOnly(str) { return str ? str.slice(0, 10) : ''; }

function kategoriStyle(kat) {
    if (kat === 'Surat Masuk')  return 'bg-blue-50 text-primary border border-blue-100';
    if (kat === 'Surat Keluar') return 'bg-amber-50 text-amber-600 border border-amber-100';
    return 'bg-gray-50 text-gray-500';
}

// ── Render Table ───────────────────────────────────────────────────────
function renderTable() {
    const tbody = document.getElementById('table-body');
    const empty = document.getElementById('empty-state');
    const info  = document.getElementById('pagination-info');
    const badge = document.getElementById('report-count');

    const total = filtered.length;
    const pages = Math.max(1, Math.ceil(total / perPage));
    if (currentPage > pages) currentPage = pages;
    const s     = (currentPage - 1) * perPage;
    const e     = Math.min(s + perPage, total);
    const slice = filtered.slice(s, e);

    badge.textContent = total + ' Data';

    if (!slice.length) {
        tbody.innerHTML = '';
        empty.classList.remove('hidden');
    } else {
        empty.classList.add('hidden');
        tbody.innerHTML = slice.map((r, i) => `
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-3.5 text-gray-400 text-sm text-center">${s + i + 1}</td>
                <td class="px-6 py-3.5">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold ${kategoriStyle(r.kategori)}">
                        ${r.kategori}
                    </span>
                </td>
                <td class="px-6 py-3.5 font-semibold text-gray-800 text-sm whitespace-nowrap">${r.nomor}</td>
                <td class="px-6 py-3.5 text-gray-700 text-sm">${r.perihal}</td>
                <td class="px-6 py-3.5 text-gray-600 text-sm">${r.jenis}</td>
                <td class="px-6 py-3.5 text-gray-500 text-sm whitespace-nowrap">${fmtDateTime(r.tanggal)}</td>
            </tr>
        `).join('');
    }

    if (total === 0) {
        info.innerHTML = 'Menampilkan <b>0</b> dari <b>0</b> data';
    } else {
        info.innerHTML = `Menampilkan <span class="font-semibold text-gray-700">${s+1}</span>–<span class="font-semibold text-gray-700">${e}</span> dari <span class="font-semibold text-gray-700">${total}</span> data`;
    }

    renderPagination(pages);
}

// ── Pagination ─────────────────────────────────────────────────────────
function renderPagination(pages) {
    const el = document.getElementById('pagination-controls');
    let h = '';
    h += `<button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 bg-white hover:bg-primary hover:text-white hover:border-primary disabled:opacity-40 disabled:cursor-not-allowed transition-all"
              onclick="gp(${currentPage-1})" ${currentPage<=1?'disabled':''}>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
          </button>`;
    let ps = Math.max(1, currentPage-2), pe = Math.min(pages, ps+4);
    ps = Math.max(1, pe-4);
    for (let p = ps; p <= pe; p++) {
        h += `<button class="w-8 h-8 flex items-center justify-center rounded-lg border text-sm font-semibold transition-all ${p===currentPage?'bg-primary text-white border-primary':'border-gray-200 bg-white text-gray-600 hover:bg-primary hover:text-white hover:border-primary'}"
                  onclick="gp(${p})">${p}</button>`;
    }
    h += `<button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 bg-white hover:bg-primary hover:text-white hover:border-primary disabled:opacity-40 disabled:cursor-not-allowed transition-all"
              onclick="gp(${currentPage+1})" ${currentPage>=pages?'disabled':''}>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
          </button>`;
    el.innerHTML = h;
}

function gp(p) {
    const pages = Math.ceil(filtered.length / perPage) || 1;
    if (p < 1 || p > pages) return;
    currentPage = p;
    renderTable();
}

// ── Filters ────────────────────────────────────────────────────────────
function applyFilters() {
    const ds  = document.getElementById('date-start').value;
    const de  = document.getElementById('date-end').value;
    const kat = document.getElementById('filter-kategori').value;

    filtered = allData.filter(r => {
        const d   = dateOnly(r.tanggal);
        const ms  = !ds  || d >= ds;
        const me  = !de  || d <= de;
        const mk  = !kat || r.kategori === kat;
        return ms && me && mk;
    });
    currentPage = 1;
    renderTable();
}

function clearFilters() {
    document.getElementById('date-start').value       = '';
    document.getElementById('date-end').value         = '';
    document.getElementById('filter-kategori').value  = '';
    filtered    = [...allData];
    currentPage = 1;
    renderTable();
}

// ── Export Excel ───────────────────────────────────────────────────────
function exportExcel() {
    if (!filtered.length) {
        showToast('Tidak ada data untuk diekspor.', false);
        return;
    }

    const headers = ['No', 'Kategori Surat', 'Nomor Surat', 'Perihal', 'Jenis Surat', 'Tanggal Dibuat'];
    const rows    = filtered.map((r, i) => [
        i + 1,
        r.kategori,
        r.nomor,
        r.perihal,
        r.jenis,
        fmtDateTime(r.tanggal),
    ]);

    const csv  = [headers, ...rows].map(row => row.map(v => `"${String(v).replace(/"/g, '""')}"`).join(',')).join('\n');
    const blob = new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8;' });
    const url  = URL.createObjectURL(blob);
    const a    = document.createElement('a');

    const ds  = document.getElementById('date-start').value || 'semua';
    const de  = document.getElementById('date-end').value   || 'semua';
    const kat = document.getElementById('filter-kategori').value || 'semua-surat';
    a.href     = url;
    a.download = `laporan-surat_${kat}_${ds}_sd_${de}.csv`;
    a.click();
    URL.revokeObjectURL(url);

    showToast(`Berhasil mengekspor ${filtered.length} data laporan.`, true);
}

// ── Toast Notification ─────────────────────────────────────────────────
function showToast(msg, success = true) {
    const toast   = document.getElementById('toast');
    const msgEl   = document.getElementById('toast-msg');
    const iconEl  = toast.querySelector('svg');

    msgEl.textContent = msg;
    iconEl.className  = `w-4 h-4 shrink-0 ${success ? 'text-green-400' : 'text-red-400'}`;
    iconEl.innerHTML  = success
        ? '<path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>'
        : '<path d="M6 18L18 6M6 6l12 12"/>';

    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 3500);
}

// ── Init ───────────────────────────────────────────────────────────────
renderTable();
</script>
@endpush