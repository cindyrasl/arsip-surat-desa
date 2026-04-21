<!-- resources/views/livewire/admin/GaleriSurat/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Page Title -->
    <div class="flex items-center mb-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-800 leading-tight">Galeri Surat</h1>
                <p class="text-xs text-gray-500">Kelola file arsip surat</p>
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
                    <input id="search-input" type="text" placeholder="Cari nomor surat, asal, atau perihal..." class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all" oninput="applyFilters()">
                </div>
            </div>

            <!-- Tanggal Surat (Dari) -->
            <div class="flex-2 min-w-45">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tanggal Surat (Dari)</label>
                <input id="date-start" type="date" class="w-full pl-4 pr-5 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all" onchange="applyFilters()">
            </div>

            <!-- Tanggal Surat (Sampai) -->
            <div class="flex-2 min-w-45">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tanggal Surat (Sampai)</label>
                <input id="date-end" type="date" class="w-full pl-4 pr-5 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all" onchange="applyFilters()">
            </div>

            <!-- Kategori Surat -->
            <div class="flex-2 min-w-45">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Kategori Surat</label>
                <div class="relative">
                    <select id="kategori-filter" onchange="applyFilters()" class="w-full pl-4 pr-9 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all appearance-none cursor-pointer">
                        <option value="all">Semua Surat</option>
                        <option value="masuk">Surat Masuk</option>
                        <option value="keluar">Surat Keluar</option>
                    </select>
                    <span class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M6 9l6 6 6-6" stroke-linecap="round"/>
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">

        <!-- Card Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 7h5l2 3h11v9a1 1 0 01-1 1H4a1 1 0 01-1-1V7z"/><path d="M3 7V5a1 1 0 011-1h4l2 3"/>
                </svg>
                <h2 class="font-bold text-gray-800">Koleksi File Surat</h2>
            </div>
            <span id="file-count-badge" class="text-xs font-semibold text-gray-500 bg-gray-100 px-3 py-1 rounded-full">0 File</span>
        </div>

        <!-- Grid - 5 kolom di desktop -->
        <div class="p-6">
            <div id="gallery-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
                <!-- Cards rendered by JS -->
            </div>

            <!-- Empty State -->
            <div id="empty-state" class="hidden py-16 text-center">
                <svg class="w-14 h-14 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/>
                </svg>
                <p class="text-gray-400 text-sm font-medium">Tidak ada file ditemukan.</p>
                <p class="text-gray-300 text-xs mt-1">Coba ubah kata kunci atau rentang tanggal.</p>
            </div>
        </div>

        <!-- Pagination Footer -->
        <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-t border-gray-100">
            <p class="text-sm text-gray-500" id="pagination-info"></p>
            <div id="pagination-controls" class="flex items-center gap-1"></div>
        </div>
    </div>
</div>

<!-- File Preview Modal  -->
<div id="preview-modal" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden flex-col">

    <!-- Modal Header -->
    <div class="flex items-center justify-between px-6 py-3 bg-gray-900/95 border-b border-white/10 shrink-0">
        <div class="flex items-center gap-3">
            <div id="modal-icon" class="w-8 h-8 rounded-lg flex items-center justify-center"></div>
            <div>
                <p id="modal-filename" class="text-sm font-semibold text-white"></p>
                <p id="modal-meta" class="text-xs text-gray-400"></p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="downloadFile()" class="flex items-center gap-1.5 px-3 py-2 text-xs font-semibold bg-primary hover:bg-primary-dark text-white rounded-lg transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 4v12M8 12l4 4 4-4"/>
                </svg>
                Download
            </button>
            <button onclick="closePreview()" class="flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-gray-300 hover:text-white hover:bg-white/10 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Tutup
            </button>
        </div>
    </div>

    <!-- Modal Body -->
    <div class="flex-1 overflow-hidden flex items-center justify-center bg-gray-800">
        <iframe id="preview-iframe" src="" class="w-full h-full border-0 hidden" title="File Preview"></iframe>

        <!-- Fallback / File viewer -->
        <div id="preview-fallback" class="w-full h-full overflow-auto flex items-center justify-center p-6">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden">
                <div class="px-8 py-6 bg-primary text-center">
                    <p class="text-blue-100 text-xs uppercase tracking-widest mb-1">Kantor Desa Teluk Kapuas</p>
                    <h1 class="text-white text-base font-bold">DOKUMEN ARSIP SURAT</h1>
                </div>
                <div class="px-10 py-8 space-y-4 text-sm text-gray-700 leading-relaxed">
                    <p><strong>Nomor Surat:</strong> <span id="fb-nomor"></span></p>
                    <p><strong>Asal/Tujuan:</strong> <span id="fb-asal"></span></p>
                    <p><strong>Tanggal:</strong> <span id="fb-tanggal"></span></p>
                    <p><strong>Perihal:</strong> <span id="fb-perihal"></span></p>
                    <hr class="border-gray-100">
                    <p class="text-gray-500 text-xs italic">Pratinjau dokumen simulasi.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center py-2 bg-gray-900/90 border-t border-white/5 shrink-0">
        <p class="text-xs text-gray-500">Tekan <kbd class="px-1.5 py-0.5 bg-gray-700 text-gray-300 rounded text-xs">Esc</kbd> untuk menutup</p>
    </div>
</div>

<script>
// ── Dummy Data 
const allFiles = [
    { id:1,  nomor:'001/SM/2025', asal:'Disporapar',         tanggal:'2025-11-25', perihal:'Undangan Rapat',              tipe:'DOCX', kategori:'masuk',  file:'' },
    { id:2,  nomor:'002/SM/2025', asal:'Dinas Sosial',       tanggal:'2025-11-20', perihal:'Pemberitahuan Kegiatan',      tipe:'PNG',  kategori:'masuk',  file:'' },
    { id:3,  nomor:'001/SK/2025', asal:'Kec. Sungai Raya',   tanggal:'2025-11-18', perihal:'Surat Tugas Perangkat',       tipe:'PDF',  kategori:'keluar', file:'' },
    { id:4,  nomor:'003/SM/2025', asal:'BPS Kubu Raya',      tanggal:'2025-11-15', perihal:'Permohonan Data Penduduk',    tipe:'DOCX', kategori:'masuk',  file:'' },
    { id:5,  nomor:'002/SK/2025', asal:'Dinkes Kubu Raya',   tanggal:'2025-11-10', perihal:'Laporan Kesehatan',           tipe:'PDF',  kategori:'keluar', file:'' },
    { id:6,  nomor:'004/SM/2025', asal:'Polsek Sungai Raya', tanggal:'2025-11-08', perihal:'Laporan Keamanan',            tipe:'PDF',  kategori:'masuk',  file:'' },
    { id:7,  nomor:'003/SK/2025', asal:'Warga Desa',         tanggal:'2025-11-05', perihal:'Surat Keterangan Usaha',      tipe:'DOCX', kategori:'keluar', file:'' },
    { id:8,  nomor:'005/SM/2025', asal:'Dinas PMD',          tanggal:'2025-10-30', perihal:'Surat Edaran Pilkades',      tipe:'PDF',  kategori:'masuk',  file:'' },
    { id:9,  nomor:'006/SM/2025', asal:'Notaris Pontianak',  tanggal:'2025-10-25', perihal:'Legalisasi Dokumen',          tipe:'DOCX', kategori:'masuk',  file:'' },
    { id:10, nomor:'004/SK/2025', asal:'KUA Kubu Raya',      tanggal:'2025-10-22', perihal:'Pengantar Nikah',             tipe:'PDF',  kategori:'keluar', file:'' },
    { id:11, nomor:'007/SM/2025', asal:'BPBD Kalbar',        tanggal:'2025-10-18', perihal:'Bantuan Bencana',             tipe:'PDF',  kategori:'masuk',  file:'' },
];

// State 
let filtered     = [...allFiles];
let currentPage  = 1;
const perPage    = 10; 
let activeFile   = null;

// Helpers 
function fmtDate(str) {
    if (!str) return '-';
    return new Date(str).toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' });
}

// File-type config: icon color, bg, label
function fileConfig(tipe) {
    if (tipe === 'PDF')  return { bg:'bg-white-50',  icon:'text-red-500',  label:'PDF',  ext:'.pdf' };
    if (tipe === 'DOCX') return { bg:'bg-white-50', icon:'text-blue-500', label:'DOCX', ext:'.docx' };
    if (tipe === 'PNG') return { bg:'bg-white-50', icon:'text-gray-500', label:'PNG', ext:'.png' };
    return { bg:'bg-gray-50', icon:'text-gray-400', label:tipe, ext:'' };
}

// Render Gallery 
function renderGallery() {
    const grid   = document.getElementById('gallery-grid');
    const empty  = document.getElementById('empty-state');
    const info   = document.getElementById('pagination-info');
    const badge  = document.getElementById('file-count-badge');

    const total  = filtered.length;
    const pages  = Math.max(1, Math.ceil(total / perPage));
    if (currentPage > pages) currentPage = pages;
    const s      = (currentPage - 1) * perPage;
    const e      = Math.min(s + perPage, total);
    const slice  = filtered.slice(s, e);

    badge.textContent = total + ' File';

    if (!slice.length) {
        grid.innerHTML = '';
        empty.classList.remove('hidden');
    } else {
        empty.classList.add('hidden');
        grid.innerHTML = slice.map(f => {
            const cfg  = fileConfig(f.tipe);
            const cat  = f.kategori === 'masuk'
                ? '<span class="bg-indigo-100 text-indigo-600 border border-indigo-200 text-xs font-semibold px-2 py-0.5 rounded-full">Surat Masuk</span>'
                : '<span class="bg-yellow-100 text-yellow-600 border border-yellow-200 text-xs font-semibold px-2 py-0.5 rounded-full">Surat Keluar</span>';
            return `
            <div class="bg-gray-50 border border-gray-100 rounded-2xl overflow-hidden flex flex-col hover:-translate-y-1 hover:shadow-lg transition-all duration-200 cursor-pointer" onclick="openPreview(${f.id})">

                <!-- Thumbnail area -->
                <div class="relative flex flex-col items-center justify-center py-10 px-4 ${cfg.bg} flex-1 min-h-[160px]">
                    <!-- File icon -->
                    <div class="w-20 h-20 rounded-2xl ${cfg.bg} border border-white shadow-sm flex items-center justify-center mb-3">
                        <svg class="w-11 h-11 ${cfg.icon}" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            <path d="M13 3v5a1 1 0 001 1h5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <span class="text-xs font-bold ${cfg.icon} tracking-widest">${cfg.label}</span>

                    <!-- Hover overlay -->
                    <div class="absolute inset-0 bg-primary/10 flex items-center justify-center rounded-t-none opacity-0 hover:opacity-100 transition-opacity duration-200">
                        <div class="bg-white/95 shadow-lg rounded-xl px-3 py-1.5 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <span class="text-xs font-semibold text-primary">Lihat File</span>
                        </div>
                    </div>
                </div>

                <!-- Info area -->
                <div class="px-3 py-3 bg-white border-t border-gray-100 flex flex-col gap-1.5">
                    ${cat}
                    <p class="text-xs font-bold text-gray-800 truncate">${f.nomor}</p>
                    <div class="flex items-center gap-1 text-gray-400">
                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <path d="M3 9h18"/>
                        </svg>
                        <span class="text-xs truncate">${f.asal}</span>
                    </div>
                    <div class="flex items-center gap-1 text-gray-400">
                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <path d="M16 2v4M8 2v4M3 10h18"/>
                        </svg>
                        <span class="text-xs">${fmtDate(f.tanggal)}</span>
                    </div>
                </div>

            </div>`;
        }).join('');
    }

    // Pagination info
    if (total === 0) {
        info.innerHTML = 'Menampilkan <b>0</b> - <b>0</b> dari <b>0</b> data';
    } else {
        info.innerHTML = `Menampilkan <span class="font-semibold text-gray-700">${s+1}</span> - <span class="font-semibold text-gray-700">${e}</span> dari <span class="font-semibold text-gray-700">${total}</span> data`;
    }

    renderPagination(pages);
}

// Pagination
function renderPagination(pages) {
    const el = document.getElementById('pagination-controls');
    let h = '';

    h += `<button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 bg-white hover:bg-primary hover:text-white hover:border-primary disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-gray-500 transition-all" onclick="gp(${currentPage-1})" ${currentPage<=1?'disabled':''}>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
          </button>`;

    let ps = Math.max(1, currentPage-2);
    let pe = Math.min(pages, ps+4);
    ps = Math.max(1, pe-4);
    for (let p = ps; p <= pe; p++) {
        h += `<button class="w-8 h-8 flex items-center justify-center rounded-lg border text-sm font-semibold transition-all ${p===currentPage ? 'bg-primary text-white border-primary' : 'border-gray-200 bg-white text-gray-600 hover:bg-primary hover:text-white hover:border-primary'}" onclick="gp(${p})">${p}</button>`;
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
    renderGallery();
    document.getElementById('gallery-grid').scrollIntoView({ behavior:'smooth', block:'start' });
}

// Filters 
function applyFilters() {
    const q  = document.getElementById('search-input').value.toLowerCase();
    const ds = document.getElementById('date-start').value;
    const de = document.getElementById('date-end').value;
    const kategori = document.getElementById('kategori-filter').value;
    
    filtered = allFiles.filter(f => {
        const mq = !q || f.nomor.toLowerCase().includes(q) || f.asal.toLowerCase().includes(q) || f.perihal.toLowerCase().includes(q);
        const ms = !ds || f.tanggal >= ds;
        const me = !de || f.tanggal <= de;
        const mk = kategori === 'all' || f.kategori === kategori;
        return mq && ms && me && mk;
    });
    currentPage = 1;
    renderGallery();
}

// Preview Modal 
function openPreview(id) {
    const f = allFiles.find(x => x.id === id);
    if (!f) return;
    activeFile = f;

    const cfg     = fileConfig(f.tipe);
    const modal   = document.getElementById('preview-modal');
    const iframe  = document.getElementById('preview-iframe');
    const fallback= document.getElementById('preview-fallback');

    document.getElementById('modal-filename').textContent = f.nomor + cfg.ext;
    document.getElementById('modal-meta').textContent     = f.tipe + ' • ' + fmtDate(f.tanggal);

    const iconEl = document.getElementById('modal-icon');
    iconEl.className = `w-8 h-8 rounded-lg flex items-center justify-center ${cfg.bg}`;
    iconEl.innerHTML = `<svg class="w-4 h-4 ${cfg.icon}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
    </svg>`;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';

    if (f.file) {
        iframe.src = f.file;
        iframe.classList.remove('hidden');
        fallback.classList.add('hidden');
    } else {
        iframe.classList.add('hidden');
        fallback.classList.remove('hidden');
        document.getElementById('fb-nomor').textContent   = f.nomor;
        document.getElementById('fb-asal').textContent    = f.asal;
        document.getElementById('fb-tanggal').textContent = fmtDate(f.tanggal);
        document.getElementById('fb-perihal').textContent = f.perihal;
    }
}

function closePreview() {
    const modal  = document.getElementById('preview-modal');
    const iframe = document.getElementById('preview-iframe');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    iframe.src = '';
    activeFile = null;
    document.body.style.overflow = '';
}

function downloadFile() {
    if (!activeFile) return;
    if (activeFile.file) {
        const a = document.createElement('a');
        a.href     = activeFile.file;
        a.download = activeFile.nomor + fileConfig(activeFile.tipe).ext;
        a.target   = '_blank';
        a.click();
    } else {
        alert('Demo: File belum tersedia. Silahkan upload file terlebih dahulu.');
    }
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closePreview(); });
document.getElementById('preview-modal').addEventListener('click', function(e) {
    if (e.target === this) closePreview();
});

renderGallery();
</script>
@endsection