<!-- views/livewire/admin/SuratMasuk/edit.blade.php  -->
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Judul Halaman -->
    <div class="flex items-center gap-3 mb-5 transition-all duration-300 ease-out translate-y-0 opacity-100">
        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <div>
            <h1 class="text-lg font-bold text-gray-800 leading-tight">Edit Surat Masuk</h1>
            <p class="text-xs text-gray-500">Edit arsip surat masuk</p>
        </div>
    </div>

    <!-- Card Edit -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form class="p-6 space-y-5" onsubmit="updateData(event)">
            <input type="hidden" id="edit-id">
            
            <!-- Nomor surat, Asal surat, Jenis surat -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor Surat <span class="text-red-500">*</span></label>
                    <input type="text" id="nomor" name="nomor" 
                           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                           placeholder="001/SM/2026">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Asal Surat <span class="text-red-500">*</span></label>
                    <input type="text" id="asal" name="asal" 
                           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                           placeholder="Dinas Pendidikan">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jenis Surat <span class="text-red-500">*</span></label>
                    <select id="jenis" name="jenis" class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                        <option value="">Pilih Jenis Surat</option>
                        <option value="Surat Masuk Biasa">Surat Masuk Biasa</option>
                        <option value="Surat Masuk Penting">Surat Masuk Penting</option>
                        <option value="Surat Masuk Rahasia">Surat Masuk Rahasia</option>
                        <option value="Surat Masuk Kilat">Surat Masuk Kilat</option>
                    </select>
                </div>
            </div>

            <!-- Tanggal Surat, Tanggal Diterima, Lampiran FIle-->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Surat <span class="text-red-500">*</span></label>
                    <input type="date" id="tanggal_surat" name="tanggal_surat" 
                           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Diterima <span class="text-red-500">*</span></label>
                    <input type="date" id="tanggal_terima" name="tanggal_terima" 
                           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Lampiran (PDF/Word, max 10MB)</label>
                    <input type="file" id="lampiran" name="lampiran" accept=".pdf,.doc,.docx" 
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    <p id="current-file" class="text-xs text-gray-500 mt-1"></p>
                </div>
            </div>

            <!-- Perihal -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Perihal <span class="text-red-500">*</span></label>
                <input type="text" id="perihal" name="perihal" 
                       class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                       placeholder="Isi perihal surat">
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan</label>
                <textarea id="keterangan" name="keterangan" rows="4" 
                          class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all resize-none"
                          placeholder="Keterangan tambahan (opsional)"></textarea>
            </div>

            <!-- Error Message -->
            <div id="error-message" class="hidden text-red-500 text-sm font-medium">Harap isi semua kolom yang wajib diisi.</div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('suratmasuk.index') }}" 
                   class="px-6 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-primary hover:bg-primary-dark rounded-xl transition-colors shadow-sm">
                    Update Surat
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Data dummy
let allData = [
    { id:1,  nomor:'001/SM/2026', tanggal:'2026-11-01', perihal:'Pembuatan Surat Keterangan',     asal:'Dinas Kebudayaan',       keterangan:'Dibuat disposisi ke bagian umum' },
    { id:2,  nomor:'002/SM/2026', tanggal:'2026-10-28', perihal:'Permohonan Izin Keramaian',      asal:'Dinas Pariwisata',       keterangan:'Segera ditindaklanjuti' },
    { id:3,  nomor:'003/SM/2026', tanggal:'2026-10-25', perihal:'Undangan Rapat Koordinasi',      asal:'Kecamatan Teluk Kapuas', keterangan:'Dibuat disposisi' },
    { id:4,  nomor:'004/SM/2026', tanggal:'2026-10-22', perihal:'Surat Pemberitahuan Kegiatan',   asal:'Dinas Sosial',           keterangan:'Diteruskan ke kabid' },
    { id:5,  nomor:'005/SM/2026', tanggal:'2026-10-19', perihal:'Permohonan Data Penduduk',       asal:'BPS Kubu Raya',          keterangan:'Sedang diproses' },
    { id:6,  nomor:'006/SM/2026', tanggal:'2026-10-16', perihal:'Surat Rekomendasi UMKM',         asal:'Dinas Koperasi',         keterangan:'Dibuat disposisi' },
    { id:7,  nomor:'007/SM/2026', tanggal:'2026-10-13', perihal:'Laporan Keamanan Lingkungan',    asal:'Polsek Sungai Raya',     keterangan:'Tembusan ke camat' },
    { id:8,  nomor:'008/SM/2026', tanggal:'2026-10-10', perihal:'Permohonan Surat Domisili',      asal:'Warga Desa',             keterangan:'Dibuat disposisi' },
    { id:9,  nomor:'009/SM/2026', tanggal:'2026-10-07', perihal:'Undangan Musyawarah Desa',       asal:'Kecamatan Teluk Kapuas', keterangan:'Dihadiri sekdes' },
    { id:10, nomor:'010/SM/2026', tanggal:'2026-10-04', perihal:'Permohonan Pengantar Nikah',     asal:'KUA Kubu Raya',          keterangan:'Lengkap berkasnya' },
    { id:11, nomor:'011/SM/2026', tanggal:'2026-10-01', perihal:'Surat Edaran Pilkades',          asal:'Dinas PMD',              keterangan:'Disebarkan ke seluruh desa' },
];

// Get data from URL parameter
const urlParams = new URLSearchParams(window.location.search);
const mailId = parseInt(urlParams.get('id'));

function loadData() {
    const mail = allData.find(item => item.id === mailId);
    
    if (mail) {
        document.getElementById('edit-id').value = mail.id;
        document.getElementById('nomor').value = mail.nomor || '';
        document.getElementById('asal').value = mail.asal || '';
        document.getElementById('perihal').value = mail.perihal || '';
        document.getElementById('keterangan').value = mail.keterangan || '';
        document.getElementById('tanggal_surat').value = mail.tanggal || '';
        document.getElementById('tanggal_terima').value = mail.tanggal || '';
        document.getElementById('current-file').innerHTML = `File saat ini: Surat_${mail.nomor}.pdf`;
        
        // Set jenis surat default
        document.getElementById('jenis').value = 'Surat Masuk Biasa';
    } else {
        alert('Data tidak ditemukan!');
        window.location.href = '{{ route("suratmasuk.index") }}';
    }
}

function updateData(event) {
    event.preventDefault();
    
    const id = parseInt(document.getElementById('edit-id').value);
    const nomor = document.getElementById('nomor').value.trim();
    const asal = document.getElementById('asal').value.trim();
    const jenis = document.getElementById('jenis').value;
    const tanggalSurat = document.getElementById('tanggal_surat').value;
    const tanggalTerima = document.getElementById('tanggal_terima').value;
    const perihal = document.getElementById('perihal').value.trim();
    
    if (!nomor || !asal || !jenis || !tanggalSurat || !tanggalTerima || !perihal) {
        document.getElementById('error-message').classList.remove('hidden');
        setTimeout(() => {
            document.getElementById('error-message').classList.add('hidden');
        }, 3000);
        return;
    }
    
    document.getElementById('error-message').classList.add('hidden');
    
    // Update data di array allData
    const index = allData.findIndex(item => item.id === id);
    
    if (index !== -1) {
        allData[index] = {
            ...allData[index],
            nomor: nomor,
            asal: asal,
            tanggal: tanggalSurat,
            perihal: perihal,
            keterangan: document.getElementById('keterangan').value
        };
        
        // Simpan ke localStorage jika diperlukan untuk komunikasi antar halaman
        localStorage.setItem('suratMasukUpdated', JSON.stringify({
            id: id,
            data: allData[index]
        }));
        
        alert('Data berhasil diupdate!');
        window.location.href = '{{ route("suratmasuk.index") }}';
    } else {
        alert('Data tidak ditemukan!');
    }
}

// Load data when page loads
if (mailId) {
    loadData();
} else {
    alert('ID tidak ditemukan!');
    window.location.href = '{{ route("suratmasuk.index") }}';
}

// Listen for storage events 
window.addEventListener('storage', function(e) {
    if (e.key === 'suratMasukUpdated') {
        const updated = JSON.parse(e.newValue);
        const index = allData.findIndex(item => item.id === updated.id);
        if (index !== -1) {
            allData[index] = updated.data;
        }
    }
});
</script>
@endsection