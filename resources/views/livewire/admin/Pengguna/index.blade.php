<!-- admin/Pengguna/index.blade.php -->
@extends('layouts.app')
@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Title  -->
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-800 leading-tight">Pengguna</h1>
                <p class="text-xs text-gray-500">Kelola pengguna sistem</p>
            </div>
        </div>
    </div>

    <!-- Filter Bar  -->
    <div class="flex flex-wrap items-center gap-3 mb-5">
        <!-- Search -->
        <div class="relative flex-1 min-w-50">
            <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
            </span>
            <input id="search-input" type="text" placeholder="Cari username, nama, jabatan, atau email..." class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all" oninput="applyFilters()">
        </div>
    </div>

    <!-- Card Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <!-- Card Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-800">Daftar Nama Pengguna</h2>
            <button onclick="openAddModal()" class="flex items-center gap-2 bg-primary hover:bg-primary-dark text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" stroke-linecap="round"/>
                </svg>
                Tambah Pengguna
            </button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-100">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide w-14">No</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Username</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Jabatan</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal Dibuat</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Terakhir Login</th>
                        <th class="text-center px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody id="table-body" class="divide-y divide-gray-50"></tbody>
            </table>
        </div>

        <!-- Empty State -->
        <div id="empty-state" class="hidden py-16 text-center">
            <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
            </div>
            <p class="text-gray-400 text-sm font-medium">Tidak ada pengguna ditemukan.</p>
        </div>

        <!-- Pagination Footer -->
        <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-t border-gray-100">
            <p class="text-sm text-gray-500" id="pagination-info"></p>
            <div id="pagination-controls" class="flex items-center gap-1"></div>
        </div>
    </div>
</div>

<!-- Add / Edit Modal -->
<div id="modal-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md" onclick="event.stopPropagation()">

        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                    </svg>
                </div>
                <h3 id="modal-title" class="font-bold text-gray-800">Tambah Pengguna</h3>
            </div>
            <button onclick="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="px-6 py-5 space-y-4">
            <input type="hidden" id="edit-id">

            <!-- Username -->
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    Username <span class="text-red-400">*</span>
                </label>
                <input id="form-username" type="text" placeholder="Contoh: barbarapalvin" class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                <p id="err-username" class="hidden mt-1 text-xs text-red-500"></p>
            </div>

            <!-- Nama Lengkap -->
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    Nama Lengkap <span class="text-red-400">*</span>
                </label>
                <input id="form-nama" type="text" placeholder="Nama lengkap pengguna" class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                <p id="err-nama" class="hidden mt-1 text-xs text-red-500"></p>
            </div>

            <!-- Jabatan -->
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    Jabatan <span class="text-red-400">*</span>
                </label>
                <input id="form-jabatan" type="text" placeholder="Contoh: Kepala Desa, Sekretaris, Bendahara" class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                <p id="err-jabatan" class="hidden mt-1 text-xs text-red-500"></p>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    Email <span class="text-red-400">*</span>
                </label>
                <input id="form-email" type="email" placeholder="contoh: email@domain.com" class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                <p id="err-email" class="hidden mt-1 text-xs text-red-500"></p>
            </div>

            <!-- Password (hanya untuk tambah) -->
            <div id="password-field">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    Password <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <input id="form-password" type="password" placeholder="Min. 8 karakter, huruf, angka &amp; simbol" class="w-full px-3 py-2.5 pr-10 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                    <button type="button" onclick="togglePassword('form-password', 'eye-pass')" class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600">
                        <svg id="eye-pass" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <!-- Password strength meter -->
                <div class="mt-2 space-y-1">
                    <div class="flex gap-1">
                        <div id="str-1" class="h-1 flex-1 rounded-full bg-gray-100 transition-colors duration-300"></div>
                        <div id="str-2" class="h-1 flex-1 rounded-full bg-gray-100 transition-colors duration-300"></div>
                        <div id="str-3" class="h-1 flex-1 rounded-full bg-gray-100 transition-colors duration-300"></div>
                        <div id="str-4" class="h-1 flex-1 rounded-full bg-gray-100 transition-colors duration-300"></div>
                    </div>
                    <p id="str-label" class="text-xs text-gray-400"></p>
                </div>
                <p id="err-password" class="hidden mt-1 text-xs text-red-500"></p>
            </div>

            <!-- Confirm Password (hanya untuk tambah) -->
            <div id="confirm-field">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    Konfirmasi Password <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <input id="form-confirm" type="password" placeholder="Ulangi password" class="w-full px-3 py-2.5 pr-10 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                    <button type="button" onclick="togglePassword('form-confirm', 'eye-confirm')" class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600">
                        <svg id="eye-confirm" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <p id="err-confirm" class="hidden mt-1 text-xs text-red-500"></p>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100">
            <button onclick="closeModal()" class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">
                Batal
            </button>
            <button onclick="saveForm()" class="px-5 py-2.5 text-sm font-semibold bg-primary hover:bg-primary-dark text-white rounded-xl transition-colors shadow-sm">
                Simpan
            </button>
        </div>
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
        <h3 class="font-bold text-gray-800 mb-1">Hapus Pengguna?</h3>
        <p class="text-sm text-gray-500 mb-1">Akun <span id="delete-name" class="font-semibold text-gray-700"></span> akan dihapus secara permanen.</p>
        <p class="text-xs text-gray-400 mb-6">Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex gap-3">
            <button onclick="closeDelete()" class="flex-1 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                Batal
            </button>
            <button onclick="confirmDelete()" class="flex-1 py-2.5 text-sm font-semibold bg-red-500 hover:bg-red-600 text-white rounded-xl transition-colors">
                Hapus
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── DUMMY DATA ──────────────────────────────────────────────────────
let allData = [
    { id:1, username:'barbarap4lvin', nama:'Barbara Palvin', jabatan:'Kepala Desa', email:'barbara@desa.com', dibuat:'2026-11-01T21:23:00', last_login:'2026-12-10T09:30:00' },
    { id:2, username:'aswedqa',       nama:'Louise',         jabatan:'Sekretaris', email:'louise@desa.com', dibuat:'2026-11-01T21:23:00', last_login:'2026-12-09T14:15:00' },
    { id:3, username:'rahmat_ds',     nama:'Rahmat Setiawan', jabatan:'Bendahara', email:'rahmat@desa.com', dibuat:'2026-11-05T08:00:00', last_login:'2026-12-08T11:00:00' },
    { id:4, username:'siti_r',        nama:'Siti Rahayu',    jabatan:'Staff Administrasi', email:'siti@desa.com', dibuat:'2026-11-08T09:30:00', last_login:'2026-12-07T08:45:00' },
    { id:5, username:'ahmad_fz',      nama:'Ahmad Fauzi',    jabatan:'Staff Pelayanan', email:'ahmad@desa.com', dibuat:'2026-11-10T10:00:00', last_login:'2026-12-06T16:20:00' },
    { id:6, username:'dian_s',        nama:'Dian Sastro',    jabatan:'Staff Umum', email:'dian@desa.com', dibuat:'2026-11-12T11:00:00', last_login:'2026-12-05T10:00:00' },
    { id:7, username:'budi_gunawan',  nama:'Budi Gunawan',   jabatan:'Kepala Urusan', email:'budi@desa.com', dibuat:'2026-11-15T08:30:00', last_login:'2026-12-04T13:30:00' },
];
let nextId = 8;

// ── State ──────────────────────────────────────────────────────────────
let currentPage  = 1;
const perPage    = 10;
let filtered     = [...allData];
let deleteTarget = null;
let isEditMode   = false;

// ── Helpers ────────────────────────────────────────────────────────────
function fmtDateTime(str) {
    if (!str) return '-';
    return new Date(str).toLocaleString('id-ID', {
        day:'2-digit', month:'short', year:'numeric',
        hour:'2-digit', minute:'2-digit'
    });
}

// ── Render Table ───────────────────────────────────────────────────────
function renderTable() {
    const tbody = document.getElementById('table-body');
    const empty = document.getElementById('empty-state');
    const info  = document.getElementById('pagination-info');

    const total = filtered.length;
    const pages = Math.max(1, Math.ceil(total / perPage));
    if (currentPage > pages) currentPage = pages;
    const s     = (currentPage - 1) * perPage;
    const e     = Math.min(s + perPage, total);
    const slice = filtered.slice(s, e);

    if (!slice.length) {
        tbody.innerHTML = '';
        empty.classList.remove('hidden');
    } else {
        empty.classList.add('hidden');
        tbody.innerHTML = slice.map((r, i) => `
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-3.5 text-gray-400 text-sm">${s + i + 1}</td>
                <td class="px-6 py-3.5">
                    <span class="text-sm font-semibold text-gray-700">${escapeHtml(r.username)}</span>
                </td>
                <td class="px-6 py-3.5 text-sm text-gray-700">${escapeHtml(r.nama)}</td>
                <td class="px-6 py-3.5 text-sm text-gray-700">${escapeHtml(r.jabatan)}</td>
                <td class="px-6 py-3.5 text-sm text-gray-700">${escapeHtml(r.email)}</td>
                <td class="px-6 py-3.5 text-sm text-gray-500 whitespace-nowrap">${fmtDateTime(r.dibuat)}</td>
                <td class="px-6 py-3.5 text-sm text-gray-500 whitespace-nowrap">${fmtDateTime(r.last_login)}</td>
                <td class="px-6 py-3.5">
                    <div class="flex items-center justify-center gap-2">
                        <button onclick="openEditModal(${r.id})" title="Edit" class="w-8 h-8 rounded-lg bg-amber-50 hover:bg-amber-100 flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                <path d="M17.586 3.586a2 2 0 012.828 2.828L12 15l-4 1 1-4 8.586-8.414z"/>
                            </svg>
                        </button>
                        <button onclick="openDelete(${r.id})" title="Hapus" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 flex items-center justify-center transition-colors">
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
        info.innerHTML = 'Menampilkan <b>0</b> dari <b>0</b> data';
    } else {
        info.innerHTML = `Menampilkan <span class="font-semibold text-gray-700">${s+1}</span>–<span class="font-semibold text-gray-700">${e}</span> dari <span class="font-semibold text-gray-700">${total}</span> data`;
    }

    renderPagination(pages);
}

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

// ── Pagination ─────────────────────────────────────────────────────────
function renderPagination(pages) {
    const el = document.getElementById('pagination-controls');
    if (!el) return;
    let h = '';
    h += `<button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 bg-white hover:bg-primary hover:text-white hover:border-primary disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-gray-500 transition-all" onclick="gp(${currentPage-1})" ${currentPage<=1?'disabled':''}>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
          </button>`;
    let ps = Math.max(1, currentPage-2), pe = Math.min(pages, ps+4);
    ps = Math.max(1, pe-4);
    for (let p = ps; p <= pe; p++) {
        h += `<button class="w-8 h-8 flex items-center justify-center rounded-lg border text-sm font-semibold transition-all ${p===currentPage?'bg-primary text-white border-primary':'border-gray-200 bg-white text-gray-600 hover:bg-primary hover:text-white hover:border-primary'}" onclick="gp(${p})">${p}</button>`;
    }
    h += `<button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 bg-white hover:bg-primary hover:text-white hover:border-primary disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-gray-500 transition-all" onclick="gp(${currentPage+1})" ${currentPage>=pages?'disabled':''}>
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
    const q = document.getElementById('search-input').value.toLowerCase();
    filtered = allData.filter(r => {
        const mq = !q || r.username.toLowerCase().includes(q) || r.nama.toLowerCase().includes(q) || r.jabatan.toLowerCase().includes(q) || r.email.toLowerCase().includes(q);
        return mq;
    });
    currentPage = 1;
    renderTable();
}

// ── Password Helpers 
function togglePassword(inputId, eyeId) {
    const passwordInput = document.getElementById(inputId);
    const eyeIcon = document.getElementById(eyeId);
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
    } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
    }
}

function checkStrength(pw) {
    let score = 0;
    if (pw.length >= 8)          score++;
    if (/[a-zA-Z]/.test(pw))    score++;
    if (/[0-9]/.test(pw))       score++;
    if (/[^a-zA-Z0-9]/.test(pw)) score++;
    return score;
}

// ── Clear / Reset form errors 
function clearErrors() {
    const errorIds = ['err-username','err-nama','err-jabatan','err-email','err-password','err-confirm'];
    errorIds.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.classList.add('hidden');
            el.textContent = '';
        }
    });
    // Reset strength bars
    for (let i = 1; i <= 4; i++) {
        const el = document.getElementById(`str-${i}`);
        if (el) el.className = 'h-1 flex-1 rounded-full bg-gray-100 transition-colors duration-300';
    }
    const strLabel = document.getElementById('str-label');
    if (strLabel) strLabel.textContent = '';
}

function showError(fieldId, msg) {
    const el = document.getElementById(fieldId);
    if (el) {
        el.textContent = msg;
        el.classList.remove('hidden');
    }
}

function setFieldError(inputId, hasError) {
    const el = document.getElementById(inputId);
    if (el) {
        if (hasError) {
            el.classList.add('border-red-400', 'focus:ring-red-200', 'focus:border-red-400');
            el.classList.remove('border-gray-200');
        } else {
            el.classList.remove('border-red-400', 'focus:ring-red-200', 'focus:border-red-400');
            el.classList.add('border-gray-200');
        }
    }
}

// ── Add Modal 
function openAddModal() {
    isEditMode = false;
    document.getElementById('modal-title').textContent = 'Tambah Pengguna';
    document.getElementById('edit-id').value = '';
    document.getElementById('form-username').value = '';
    document.getElementById('form-nama').value = '';
    document.getElementById('form-jabatan').value = '';
    document.getElementById('form-email').value = '';
    document.getElementById('form-password').value = '';
    document.getElementById('form-confirm').value = '';
    document.getElementById('form-username').disabled = false;

    // Tampilkan field password dan confirm untuk mode tambah
    const passwordField = document.getElementById('password-field');
    const confirmField = document.getElementById('confirm-field');
    if (passwordField) passwordField.style.display = 'block';
    if (confirmField) confirmField.style.display = 'block';

    clearErrors();
    showModal();
}

// ── Edit Modal ─────────────────────────────────────────────────────────
function openEditModal(id) {
    const r = allData.find(x => x.id === id);
    if (!r) return;
    isEditMode = true;
    document.getElementById('modal-title').textContent = 'Edit Pengguna';
    document.getElementById('edit-id').value = r.id;
    document.getElementById('form-username').value = r.username;
    document.getElementById('form-nama').value = r.nama;
    document.getElementById('form-jabatan').value = r.jabatan;
    document.getElementById('form-email').value = r.email;
    document.getElementById('form-password').value = '';
    document.getElementById('form-confirm').value = '';
    document.getElementById('form-username').disabled = true; // readonly

    // Sembunyikan field password dan confirm untuk mode edit
    const passwordField = document.getElementById('password-field');
    const confirmField = document.getElementById('confirm-field');
    if (passwordField) passwordField.style.display = 'none';
    if (confirmField) confirmField.style.display = 'none';

    clearErrors();
    showModal();
}

function showModal() {
    const overlay = document.getElementById('modal-overlay');
    if (overlay) {
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal() {
    const overlay = document.getElementById('modal-overlay');
    if (overlay) {
        overlay.classList.add('hidden');
        overlay.classList.remove('flex');
        document.body.style.overflow = '';
    }
}

// ── Save Form ──────────────────────────────────────────────────────────
function saveForm() {
    clearErrors();

    const username = document.getElementById('form-username').value.trim();
    const nama = document.getElementById('form-nama').value.trim();
    const jabatan = document.getElementById('form-jabatan').value.trim();
    const email = document.getElementById('form-email').value.trim();
    const password = document.getElementById('form-password').value;
    const confirm = document.getElementById('form-confirm').value;
    const editId = document.getElementById('edit-id').value;
    let valid = true;

    // Username
    if (!username) {
        showError('err-username', 'Username wajib diisi.');
        setFieldError('form-username', true);
        valid = false;
    } else if (username.length < 3) {
        showError('err-username', 'Username minimal 3 karakter.');
        setFieldError('form-username', true);
        valid = false;
    } else {
        const dup = allData.find(r => r.username === username && r.id !== parseInt(editId));
        if (dup) {
            showError('err-username', 'Username sudah digunakan.');
            setFieldError('form-username', true);
            valid = false;
        } else {
            setFieldError('form-username', false);
        }
    }

    // Nama
    if (!nama) {
        showError('err-nama', 'Nama lengkap wajib diisi.');
        setFieldError('form-nama', true);
        valid = false;
    } else {
        setFieldError('form-nama', false);
    }

    // Jabatan
    if (!jabatan) {
        showError('err-jabatan', 'Jabatan wajib diisi.');
        setFieldError('form-jabatan', true);
        valid = false;
    } else {
        setFieldError('form-jabatan', false);
    }

    // Email
    if (!email) {
        showError('err-email', 'Email wajib diisi.');
        setFieldError('form-email', true);
        valid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        showError('err-email', 'Format email tidak valid.');
        setFieldError('form-email', true);
        valid = false;
    } else {
        const dup = allData.find(r => r.email === email && r.id !== parseInt(editId));
        if (dup) {
            showError('err-email', 'Email sudah digunakan.');
            setFieldError('form-email', true);
            valid = false;
        } else {
            setFieldError('form-email', false);
        }
    }

    // Password validation (hanya untuk mode tambah)
    if (!isEditMode) {
        if (!password) {
            showError('err-password', 'Password wajib diisi.');
            setFieldError('form-password', true);
            valid = false;
        } else if (password.length < 8) {
            showError('err-password', 'Password minimal 8 karakter.');
            setFieldError('form-password', true);
            valid = false;
        } else if (!/[a-zA-Z]/.test(password)) {
            showError('err-password', 'Password harus mengandung huruf.');
            setFieldError('form-password', true);
            valid = false;
        } else if (!/[0-9]/.test(password)) {
            showError('err-password', 'Password harus mengandung angka.');
            setFieldError('form-password', true);
            valid = false;
        } else if (!/[^a-zA-Z0-9]/.test(password)) {
            showError('err-password', 'Password harus mengandung simbol.');
            setFieldError('form-password', true);
            valid = false;
        } else {
            setFieldError('form-password', false);
        }

        // Confirm password
        if (password !== confirm) {
            showError('err-confirm', 'Konfirmasi password tidak cocok.');
            setFieldError('form-confirm', true);
            valid = false;
        } else {
            setFieldError('form-confirm', false);
        }
    }

    if (!valid) return;

    // Generate random last_login timestamp dummy
    const randomDate = new Date();
    randomDate.setDate(randomDate.getDate() - Math.floor(Math.random() * 30));
    randomDate.setHours(Math.floor(Math.random() * 24), Math.floor(Math.random() * 60));

    if (editId) {
        const idx = allData.findIndex(r => r.id === parseInt(editId));
        if (idx !== -1) {
            allData[idx] = { ...allData[idx], username, nama, jabatan, email };
        }
    } else {
        allData.unshift({
            id: nextId++,
            username,
            nama,
            jabatan,
            email,
            dibuat: new Date().toISOString(),
            last_login: randomDate.toISOString()
        });
    }

    applyFilters();
    closeModal();
}

// ── Delete Modal ───────────────────────────────────────────────────────
function openDelete(id) {
    const r = allData.find(x => x.id === id);
    if (!r) return;
    deleteTarget = id;
    const deleteName = document.getElementById('delete-name');
    if (deleteName) deleteName.textContent = r.nama + ' (' + r.username + ')';
    const overlay = document.getElementById('delete-overlay');
    if (overlay) {
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
}

function closeDelete() {
    deleteTarget = null;
    const overlay = document.getElementById('delete-overlay');
    if (overlay) {
        overlay.classList.add('hidden');
        overlay.classList.remove('flex');
        document.body.style.overflow = '';
    }
}

function confirmDelete() {
    allData = allData.filter(r => r.id !== deleteTarget);
    closeDelete();
    applyFilters();
}

// ── Close on backdrop / Escape ─────────────────────────────────────────
const modalOverlay = document.getElementById('modal-overlay');
if (modalOverlay) {
    modalOverlay.addEventListener('click', function(e) { if(e.target === this) closeModal(); });
}
const deleteOverlay = document.getElementById('delete-overlay');
if (deleteOverlay) {
    deleteOverlay.addEventListener('click', function(e) { if(e.target === this) closeDelete(); });
}
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeModal(); closeDelete(); }
});

// ── Password strength listener ─────────────────────────────────────────
const passwordInput = document.getElementById('form-password');
if (passwordInput) {
    passwordInput.addEventListener('input', function() {
        const pw = this.value;
        const score = checkStrength(pw);
        const bars = ['str-1', 'str-2', 'str-3', 'str-4'];
        const colors = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-500'];
        const labels = ['', 'Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'];
        bars.forEach((id, idx) => {
            const el = document.getElementById(id);
            if (el) {
                el.className = `h-1 flex-1 rounded-full transition-colors duration-300 ${idx < score ? colors[score-1] : 'bg-gray-100'}`;
            }
        });
        const strLabel = document.getElementById('str-label');
        if (strLabel) strLabel.textContent = pw.length ? labels[score] : '';
    });
}

// ── Init 
renderTable();
</script>
@endpush