<!-- views/livewire/admin/SuratKeluar/edit.blade.php  -->
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto fade-up">
    <!-- Judul Halaman -->
    <div class="flex items-center gap-3 mb-5 fade-up">
        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <div>
            <h1 class="text-lg font-bold text-gray-800 leading-tight">Edit Surat Keluar</h1>
            <p class="text-xs text-gray-500">Edit arsip surat keluar</p>
        </div>
    </div>

    <!-- Card Edit -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden fade-up2">
        <form class="p-6 space-y-5" onsubmit="updateData(event)">
            <input type="hidden" id="edit-id">
            
            <!-- Nomor surat, Asal surat, Jenis surat -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor Surat <span class="text-red-500">*</span></label>
                    <input type="text" id="nomor" name="nomor" 
                           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                           placeholder="001/SK/2026">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tujuan Surat <span class="text-red-500">*</span></label>
                    <input type="text" id="tujuan" name="tujuan" 
                           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                           placeholder="Dinas Pendidikan Kabupaten">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jenis Surat <span class="text-red-500">*</span></label>
                    <select id="jenis" name="jenis" class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                        <option value="">Pilih Jenis Surat</option>
                        <option value="Surat Undangan">Surat Undangan</option>
                        <option value="Surat Tugas">Surat Tugas</option>
                        <option value="Surat Edaran">Surat Edaran</option>
                        <option value="Surat Keputusan">Surat Keputusan</option>
                        <option value="Surat Permohonan">Surat Permohonan</option>
                    </select>
                </div>
            </div>

            <!-- Tanggal Surat, Tanggal Kirim, Lampiran -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Surat <span class="text-red-500">*</span></label>
                    <input type="date" id="tanggal_surat" name="tanggal_surat" 
                           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Kirim <span class="text-red-500">*</span></label>
                    <input type="date" id="tanggal_kirim" name="tanggal_kirim" 
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

            <!-- Pesan Error -->
            <div id="error-message" class="hidden text-red-500 text-sm font-medium">Harap isi semua kolom yang wajib diisi.</div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('suratkeluar.index') }}" 
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
let allData = [
    { id:1,  nomor:'001/SK/2026', tanggal_surat:'2026-11-01', tanggal_kirim:'2026-11-02', perihal:'Undangan Rapat Koordinasi',     tujuan:'Dinas Pendidikan Kabupaten',       keterangan:'Dikirim melalui pos', jenis:'Surat Undangan' },
    { id:2,  nomor:'002/SK/2026', tanggal_surat:'2026-10-28', tanggal_kirim:'2026-10-29', perihal:'Surat Tugas Verifikasi Lapangan',      tujuan:'Kecamatan Sungai Raya',       keterangan:'Segera ditindaklanjuti', jenis:'Surat Tugas' },
    { id:3,  nomor:'003/SK/2026', tanggal_surat:'2026-10-25', tanggal_kirim:'2026-10-26', perihal:'Permohonan Data Statistik',      tujuan:'BPS Provinsi Kalbar', keterangan:'Dibuat rangkap 2', jenis:'Surat Permohonan' },
    { id:4,  nomor:'004/SK/2026', tanggal_surat:'2026-10-22', tanggal_kirim:'2026-10-23', perihal:'Surat Pemberitahuan Kegiatan',   tujuan:'Dinas Sosial Kabupaten',           keterangan:'Diteruskan ke bidang', jenis:'Surat Edaran' },
    { id:5,  nomor:'005/SK/2026', tanggal_surat:'2026-10-19', tanggal_kirim:'2026-10-20', perihal:'Rekomendasi Izin Usaha',       tujuan:'Dinas Penanaman Modal',          keterangan:'Sedang diproses', jenis:'Surat Keputusan' },
    { id:6,  nomor:'006/SK/2026', tanggal_surat:'2026-10-16', tanggal_kirim:'2026-10-17', perihal:'Undangan Musyawarah Desa',         tujuan:'Seluruh Kepala Desa',         keterangan:'Dibuat undangan', jenis:'Surat Undangan' },
    { id:7,  nomor:'007/SK/2026', tanggal_surat:'2026-10-13', tanggal_kirim:'2026-10-14', perihal:'Surat Edaran Pilkades',    tujuan:'Panitia Pilkades',     keterangan:'Tembusan ke camat', jenis:'Surat Edaran' },
];

const urlParams = new URLSearchParams(window.location.search);
const mailId = parseInt(urlParams.get('id'));

function loadData() {
    const mail = allData.find(item => item.id === mailId);
    
    if (mail) {
        document.getElementById('edit-id').value = mail.id;
        document.getElementById('nomor').value = mail.nomor || '';
        document.getElementById('tujuan').value = mail.tujuan || '';
        document.getElementById('perihal').value = mail.perihal || '';
        document.getElementById('keterangan').value = mail.keterangan || '';
        document.getElementById('tanggal_surat').value = mail.tanggal_surat || '';
        document.getElementById('tanggal_kirim').value = mail.tanggal_kirim || '';
        document.getElementById('current-file').innerHTML = `File saat ini: Surat_Keluar_${mail.nomor}.pdf`;
        
        if (mail.jenis) {
            document.getElementById('jenis').value = mail.jenis;
        }
    } else {
        alert('Data tidak ditemukan!');
        window.location.href = '{{ route("suratkeluar.index") }}';
    }
}

function updateData(event) {
    event.preventDefault();
    
    const id = parseInt(document.getElementById('edit-id').value);
    const nomor = document.getElementById('nomor').value.trim();
    const tujuan = document.getElementById('tujuan').value.trim();
    const jenis = document.getElementById('jenis').value;
    const tanggalSurat = document.getElementById('tanggal_surat').value;
    const tanggalKirim = document.getElementById('tanggal_kirim').value;
    const perihal = document.getElementById('perihal').value.trim();
    
    if (!nomor || !tujuan || !jenis || !tanggalSurat || !tanggalKirim || !perihal) {
        document.getElementById('error-message').classList.remove('hidden');
        setTimeout(() => {
            document.getElementById('error-message').classList.add('hidden');
        }, 3000);
        return;
    }
    
    document.getElementById('error-message').classList.add('hidden');
    
    const index = allData.findIndex(item => item.id === id);
    
    if (index !== -1) {
        allData[index] = {
            ...allData[index],
            nomor: nomor,
            tujuan: tujuan,
            jenis: jenis,
            tanggal_surat: tanggalSurat,
            tanggal_kirim: tanggalKirim,
            perihal: perihal,
            keterangan: document.getElementById('keterangan').value
        };
        
        localStorage.setItem('suratKeluarUpdated', JSON.stringify({
            id: id,
            data: allData[index]
        }));
        
        alert('Data berhasil diupdate!');
        window.location.href = '{{ route("suratkeluar.index") }}';
    } else {
        alert('Data tidak ditemukan!');
    }
}

if (mailId) {
    loadData();
} else {
    alert('ID tidak ditemukan!');
    window.location.href = '{{ route("suratkeluar.index") }}';
}

window.addEventListener('storage', function(e) {
    if (e.key === 'suratKeluarUpdated') {
        const updated = JSON.parse(e.newValue);
        const index = allData.findIndex(item => item.id === updated.id);
        if (index !== -1) {
            allData[index] = updated.data;
        }
    }
});
</script>

<style>
    .fade-up { animation: fadeUp 0.35s ease forwards; }
    .fade-up2 { animation: fadeUp 0.35s ease 0.1s forwards; opacity: 0; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
</style>
@endsection