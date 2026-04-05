<!-- views/livewire/admin/SuratKeluar/detail.blade.php  -->
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Judul Halaman -->
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-800 leading-tight">Detail Surat Keluar</h1>
                <p class="text-xs text-gray-500">Lihat informasi detail surat keluar</p>
            </div>
        </div>

        <!-- Tombol kembali -->
        <a href="{{ route('suratkeluar.index') }}"
            class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M19 12H5M12 5l-7 7 7 7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">
       <!-- Informasi Surat -->
        <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="font-bold text-gray-800">Informasi Surat</h2>
            </div>
            <div class="divide-y divide-gray-50" id="detail-content">
                <!-- Data diisi JavaScript -->
            </div>
        </div>

        <!-- File Surat -->
        <div class="lg:col-span-2 flex">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col w-full">
                <div class="flex-1 flex flex-col items-center justify-center">
                    <div class="w-24 h-24 rounded-2xl bg-blue-50 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            <path d="M13 3v5a1 1 0 001 1h5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    
                    <!-- Nama File -->
                    <p class="text-base font-bold text-gray-800 mb-1 text-center" id="file-name">-</p>
                    
                    <!-- Metadata File -->
                    <div class="flex items-center justify-center gap-2 text-xs text-gray-400 mb-6" id="file-meta">
                        <!-- Metadata akan diisi JS -->
                    </div>
                    
                    <!-- Tombol Download -->
                    <button onclick="alert('File akan dibuka. Implementasikan sesuai kebutuhan Anda.')"
                        class="w-full flex items-center justify-center gap-2 bg-primary hover:bg-primary-dark text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 4v12M8 12l4 4 4-4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Download Lampiran
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Data dummy 
const allData = [
    { id:1,  nomor:'001/SK/2026', tanggal_surat:'2026-11-01', tanggal_kirim:'2026-11-02', perihal:'Undangan Rapat Koordinasi',     tujuan:'Dinas Pendidikan Kabupaten',       keterangan:'Dikirim melalui pos', jenis:'Surat Undangan' },
    { id:2,  nomor:'002/SK/2026', tanggal_surat:'2026-10-28', tanggal_kirim:'2026-10-29', perihal:'Surat Tugas Verifikasi Lapangan',      tujuan:'Kecamatan Sungai Raya',       keterangan:'Segera ditindaklanjuti', jenis:'Surat Tugas' },
    { id:3,  nomor:'003/SK/2026', tanggal_surat:'2026-10-25', tanggal_kirim:'2026-10-26', perihal:'Permohonan Data Statistik',      tujuan:'BPS Provinsi Kalbar', keterangan:'Dibuat rangkap 2', jenis:'Surat Permohonan' },
    { id:4,  nomor:'004/SK/2026', tanggal_surat:'2026-10-22', tanggal_kirim:'2026-10-23', perihal:'Surat Pemberitahuan Kegiatan',   tujuan:'Dinas Sosial Kabupaten',           keterangan:'Diteruskan ke bidang', jenis:'Surat Edaran' },
    { id:5,  nomor:'005/SK/2026', tanggal_surat:'2026-10-19', tanggal_kirim:'2026-10-20', perihal:'Rekomendasi Izin Usaha',       tujuan:'Dinas Penanaman Modal',          keterangan:'Sedang diproses', jenis:'Surat Keputusan' },
    { id:6,  nomor:'006/SK/2026', tanggal_surat:'2026-10-16', tanggal_kirim:'2026-10-17', perihal:'Undangan Musyawarah Desa',         tujuan:'Seluruh Kepala Desa',         keterangan:'Dibuat undangan', jenis:'Surat Undangan' },
    { id:7,  nomor:'007/SK/2026', tanggal_surat:'2026-10-13', tanggal_kirim:'2026-10-14', perihal:'Surat Edaran Pilkades',    tujuan:'Panitia Pilkades',     keterangan:'Tembusan ke camat', jenis:'Surat Edaran' },
];

function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', { day:'2-digit', month:'long', year:'numeric' });
}

const urlParams = new URLSearchParams(window.location.search);
const mailId = parseInt(urlParams.get('id'));

function loadDetailData() {
    const mail = allData.find(item => item.id === mailId);
    
    if (mail) {
        const detailContent = document.getElementById('detail-content');
        detailContent.innerHTML = `
            <div class="flex items-start gap-4 px-6 py-4">
                <span class="w-36 text-sm text-gray-400 font-medium shrink-0">Nomor Surat</span>
                <span class="text-sm font-semibold text-gray-800">${mail.nomor}</span>
            </div>
            <div class="flex items-start gap-4 px-6 py-4">
                <span class="w-36 text-sm text-gray-400 font-medium shrink-0">Tanggal Surat</span>
                <span class="text-sm font-semibold text-gray-800">${formatDate(mail.tanggal_surat)}</span>
            </div>
            <div class="flex items-start gap-4 px-6 py-4">
                <span class="w-36 text-sm text-gray-400 font-medium shrink-0">Tanggal Kirim</span>
                <span class="text-sm font-semibold text-gray-800">${formatDate(mail.tanggal_kirim)}</span>
            </div>
            <div class="flex items-start gap-4 px-6 py-4">
                <span class="w-36 text-sm text-gray-400 font-medium shrink-0">Tujuan Surat</span>
                <span class="text-sm font-semibold text-gray-800">${mail.tujuan}</span>
            </div>
            <div class="flex items-start gap-4 px-6 py-4">
                <span class="w-36 text-sm text-gray-400 font-medium shrink-0">Jenis Surat</span>
                <span class="text-sm font-semibold text-gray-800">${mail.jenis || 'Surat Keluar'}</span>
            </div>
            <div class="flex items-start gap-4 px-6 py-4">
                <span class="w-36 text-sm text-gray-400 font-medium shrink-0">Perihal</span>
                <span class="text-sm font-semibold text-gray-800">${mail.perihal}</span>
            </div>
            <div class="flex items-start gap-4 px-6 py-4">
                <span class="w-36 text-sm text-gray-400 font-medium shrink-0">Keterangan</span>
                <span class="text-sm font-semibold text-gray-800">${mail.keterangan || '-'}</span>
            </div>
            <div class="flex items-start gap-4 px-6 py-4">
                <span class="w-36 text-sm text-gray-400 font-medium shrink-0">Dibuat Oleh</span>
                <span class="text-sm font-semibold text-gray-800">Barbara Palvin - Admin</span>
            </div>
        `;
        
        document.getElementById('file-name').innerHTML = `Surat_Keluar_${mail.nomor}.pdf`;
        document.getElementById('file-meta').innerHTML = `
            <span class="inline-flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <path d="M3 9h18"/>
                </svg>
                PDF
            </span>
            <span>•</span>
            <span class="inline-flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 6v6l4 2"/>
                </svg>
                156 KB
            </span>
        `;
    } else {
        const detailContent = document.getElementById('detail-content');
        detailContent.innerHTML = `
            <div class="flex items-start gap-4 px-6 py-4">
                <div class="w-full text-center text-red-500 py-8">
                    Data tidak ditemukan!
                </div>
            </div>
        `;
    }
}

if (mailId) {
    loadDetailData();
} else {
    alert('ID tidak ditemukan!');
    window.location.href = '{{ route("suratkeluar.index") }}';
}
</script>
@endsection