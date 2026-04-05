<!-- admin/JenisSurat/index.blade.php -->

@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="flex items-center gap-3 mb-5">
        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
            </svg>
        </div>
        <div>
            <h1 class="text-lg font-bold text-gray-800 leading-tight">Jenis Surat</h1>
            <p class="text-xs text-gray-500">Kelola jenis-jenis surat yang dapat dibuat</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="flex flex-wrap items-center gap-3 mb-5">
        <!-- Search -->
        <div class="relative w-1/2">
            <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
            </span>
            <input id="search-input" type="text" placeholder="Cari jenis surat..."
                class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                oninput="applyFilters()">
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <!-- Card Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-800">Daftar Jenis Surat</h2>
            <button onclick="openAddModal()"
                class="flex items-center gap-2 bg-primary hover:bg-primary-dark text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" stroke-linecap="round"/>
                </svg>
                Tambah Jenis Surat
            </button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-100">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide w-14">No</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide">Nama Jenis Surat</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide">Keterangan</th>
                        <th class="text-center px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody id="table-body" class="divide-y divide-gray-50"></tbody>
            </table>
            <div id="empty-state" class="hidden py-16 text-center">
                <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M3 7h5l2 3h11v9a1 1 0 01-1 1H4a1 1 0 01-1-1V7z"/>
                    <path d="M3 7V5a1 1 0 011-1h4l2 3"/>
                </svg>
                <p class="text-gray-400 text-sm font-medium">Tidak ada jenis surat yang tersedia.</p>
            </div>
        </div>

        <!-- Pagination Footer -->
        <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-t border-gray-100">
            <p class="text-sm text-gray-500" id="pagination-info"></p>
            <div id="pagination-controls" class="flex items-center gap-1"></div>
        </div>
    </div>

    <!-- ============= ADD / EDIT MODAL ============= -->
    <div id="modal-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 7h5l2 3h11v9a1 1 0 01-1 1H4a1 1 0 01-1-1V7z"/>
                            <path d="M3 7V5a1 1 0 011-1h4l2 3"/>
                        </svg>
                    </div>
                    <h3 id="modal-title" class="font-bold text-gray-800">Tambah Jenis Surat</h3>
                </div>
                <button onclick="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="px-6 py-5 space-y-4">
                <input type="hidden" id="edit-id">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Jenis Surat <span class="text-red-500">*</span></label>
                    <input id="form-nama" type="text" placeholder="Contoh: Surat Keterangan Usaha"
                        class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan</label>
                    <textarea id="form-keterangan" rows="3" placeholder="Keterangan tambahan (opsional)"
                        class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all resize-none"></textarea>
                </div>
                <p id="form-error" class="hidden text-red-500 text-sm font-medium">Harap isi nama jenis surat.</p>
            </div>
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100">
                <button onclick="closeModal()" class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">Cancel</button>
                <button onclick="saveForm()" class="px-5 py-2.5 text-sm font-semibold bg-primary hover:bg-primary-dark text-white rounded-xl transition-colors shadow-sm">Simpan</button>
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
            <h3 class="font-bold text-gray-800 mb-1">Hapus Jenis Surat?</h3>
            <p class="text-sm text-gray-500 mb-6">Data jenis surat akan dihapus secara permanen dan tidak dapat dipulihkan.</p>
            <div class="flex gap-3">
                <button onclick="closeDelete()" class="flex-1 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Batal</button>
                <button onclick="confirmDelete()" class="flex-1 py-2.5 text-sm font-semibold bg-red-500 hover:bg-red-600 text-white rounded-xl transition-colors">Hapus</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
// ── Dummy Data ──────────────────────────────────────────────────────
let allData = [
    { id:1,  nama:'Surat Keterangan Usaha',       keterangan:'Digunakan untuk warga yang ingin membuat usaha' },
    { id:2,  nama:'Surat Tugas Perangkat',        keterangan:'Surat penugasan untuk perangkat desa' },
    { id:3,  nama:'Surat Undangan Musdes',        keterangan:'Undangan untuk musyawarah desa' },
    { id:4,  nama:'Surat Permohonan Dana',        keterangan:'Permohonan bantuan dana desa' },
    { id:5,  nama:'Surat Domisili',               keterangan:'Surat keterangan domisili penduduk' },
    { id:6,  nama:'Surat Kematian',               keterangan:'Surat keterangan kematian' },
    { id:7,  nama:'Surat Kelahiran',              keterangan:'Surat keterangan kelahiran' },
    { id:8,  nama:'Surat Pindah Penduduk',        keterangan:'Surat keterangan pindah penduduk' },
];
let nextId = 9;

// ── State ─────────────────────────────────────────────────────────
let currentPage = 1;
let perPage = 10;
let filtered = [...allData];
let deleteTarget = null;

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
            <tr class="border-b border-gray-50">
                <td class="px-6 py-3.5 text-gray-400 text-center text-sm">${s + i + 1}</td>
                <td class="px-6 py-3.5 font-semibold text-gray-800 text-sm">${escapeHtml(r.nama)}</td>
                <td class="px-6 py-3.5 text-gray-600 text-sm">${escapeHtml(r.keterangan) || '-'}</td>
                <td class="px-6 py-3.5">
                    <div class="flex items-center justify-center gap-2">
                        <button onclick="openEditModal(${r.id})" title="Edit"
                            class="w-8 h-8 rounded-lg bg-amber-50 hover:bg-amber-100 flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                <path d="M17.586 3.586a2 2 0 012.828 2.828L12 15l-4 1 1-4 8.586-8.414z"/>
                            </svg>
                        </button>
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
    h += `<button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 bg-white transition-all duration-150 hover:bg-primary hover:text-white hover:border-primary disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-gray-500 disabled:hover:border-gray-200"
              onclick="gp(${currentPage-1})" ${currentPage<=1?'disabled':''}>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
          </button>`;

    let ps = Math.max(1, currentPage-2);
    let pe = Math.min(pages, ps+4);
    ps = Math.max(1, pe-4);

    for (let p = ps; p <= pe; p++) {
        h += `<button class="w-8 h-8 flex items-center justify-center rounded-lg border text-sm font-semibold transition-all duration-150 ${p===currentPage ? 'bg-primary text-white border-primary' : 'border-gray-200 bg-white text-gray-600 hover:bg-primary hover:text-white hover:border-primary'}"
                  onclick="gp(${p})">${p}</button>`;
    }

    h += `<button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 bg-white transition-all duration-150 hover:bg-primary hover:text-white hover:border-primary disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-gray-500 disabled:hover:border-gray-200"
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

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ── Filters ───────────────────────────────────────────────────────
function applyFilters() {
    const q = document.getElementById('search-input').value.toLowerCase();
    filtered = allData.filter(r => {
        const mq = !q || r.nama.toLowerCase().includes(q) || (r.keterangan && r.keterangan.toLowerCase().includes(q));
        return mq;
    });
    currentPage = 1;
    renderTable();
}

// ── Add/Edit Modal ────────────────────────────────────────────────
function openAddModal() {
    document.getElementById('modal-title').textContent = 'Tambah Jenis Surat';
    document.getElementById('edit-id').value = '';
    document.getElementById('form-nama').value = '';
    document.getElementById('form-keterangan').value = '';
    document.getElementById('form-error').classList.add('hidden');
    
    const modal = document.getElementById('modal-overlay');
    modal.style.display = 'flex';
    modal.classList.remove('hidden');
}

function openEditModal(id) {
    const r = allData.find(x => x.id === id);
    if (!r) return;
    
    document.getElementById('modal-title').textContent = 'Edit Jenis Surat';
    document.getElementById('edit-id').value = r.id;
    document.getElementById('form-nama').value = r.nama;
    document.getElementById('form-keterangan').value = r.keterangan || '';
    document.getElementById('form-error').classList.add('hidden');
    
    const modal = document.getElementById('modal-overlay');
    modal.style.display = 'flex';
    modal.classList.remove('hidden');
}

function closeModal() {
    const modal = document.getElementById('modal-overlay');
    modal.style.display = 'none';
    modal.classList.add('hidden');
}

function saveForm() {
    const nama = document.getElementById('form-nama').value.trim();
    const keterangan = document.getElementById('form-keterangan').value.trim();
    const editId = document.getElementById('edit-id').value;
    const errEl = document.getElementById('form-error');

    if (!nama) {
        errEl.classList.remove('hidden');
        return;
    }
    errEl.classList.add('hidden');

    if (editId) {
        const idx = allData.findIndex(r => r.id === parseInt(editId));
        if (idx !== -1) {
            allData[idx] = { ...allData[idx], nama: nama, keterangan: keterangan };
        }
    } else {
        allData.push({ id: nextId++, nama: nama, keterangan: keterangan });
    }

    applyFilters();
    closeModal();
}

// ── Delete Modal ──────────────────────────────────────────────────
function openDelete(id) {
    deleteTarget = id;
    const modal = document.getElementById('delete-overlay');
    modal.style.display = 'flex';
    modal.classList.remove('hidden');
}

function closeDelete() {
    deleteTarget = null;
    const modal = document.getElementById('delete-overlay');
    modal.style.display = 'none';
    modal.classList.add('hidden');
}

function confirmDelete() {
    allData = allData.filter(r => r.id !== deleteTarget);
    closeDelete();
    applyFilters();
}

// ── Close modal on outside click ─────────────────────────────────
document.getElementById('modal-overlay').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
document.getElementById('delete-overlay').addEventListener('click', function(e) {
    if (e.target === this) closeDelete();
});

// ── Init ──────────────────────────────────────────────────────────
renderTable();
</script>
@endpush