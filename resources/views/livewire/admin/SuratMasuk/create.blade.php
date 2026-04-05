<!-- views/livewire/admin/SuratMasuk/create.blade.php  -->

@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto fade-up">
    {{-- Page Title --}}
    <div class="flex items-center gap-3 mb-5 fade-up">
        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <div>
            <h1 class="text-lg font-bold text-gray-800 leading-tight">Tambah Surat Masuk</h1>
            <p class="text-xs text-gray-500">Tambah arsip surat masuk baru</p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden fade-up2">
        <form class="p-6 space-y-5" onsubmit="saveData(event)">
            {{-- Row 1: Mail Number, Sender, Mail Type --}}
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
                        <option value="Biasa">Surat Keterangan Usaha</option>
                        <option value="Penting">Surat Tugas Perangkat</option>
                        <option value="Rahasia">Surat Undangan Musdes</option>
                        <option value="Kilat">Surat Permohonan Dana</option>
                    </select>
                </div>
            </div>

            {{-- Row 2: Mail Date, Received Date, File Upload --}}
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
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Lampiran (PDF/Word, max 10MB) <span class="text-red-500">*</span></label>
                    <input type="file" id="lampiran" name="lampiran" accept=".pdf,.doc,.docx" 
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                </div>
            </div>

            {{-- Row 3: Subject --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Perihal <span class="text-red-500">*</span></label>
                <input type="text" id="perihal" name="perihal" 
                       class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                       placeholder="Isi perihal surat">
            </div>

            {{-- Row 4: Description --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan</label>
                <textarea id="keterangan" name="keterangan" rows="4" 
                          class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all resize-none"
                          placeholder="Keterangan tambahan (opsional)"></textarea>
            </div>

            {{-- Error Message --}}
            <div id="error-message" class="hidden text-red-500 text-sm font-medium">Harap isi semua kolom yang wajib diisi.</div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('suratmasuk.index') }}" 
                   class="px-6 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-primary hover:bg-primary-dark rounded-xl transition-colors shadow-sm">
                    Simpan Surat
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function saveData(event) {
    event.preventDefault();
    
    const nomor = document.getElementById('nomor').value.trim();
    const asal = document.getElementById('asal').value.trim();
    const jenis = document.getElementById('jenis').value;
    const tanggalSurat = document.getElementById('tanggal_surat').value;
    const tanggalTerima = document.getElementById('tanggal_terima').value;
    const perihal = document.getElementById('perihal').value.trim();
    
    if (!nomor || !asal || !jenis || !tanggalSurat || !tanggalTerima || !perihal) {
        document.getElementById('error-message').classList.remove('hidden');
        return;
    }
    
    document.getElementById('error-message').classList.add('hidden');
    
    // Get existing data from localStorage or use empty array
    let existingData = JSON.parse(localStorage.getItem('suratMasuk') || '[]');
    
    // Get the highest ID
    let maxId = existingData.length > 0 ? Math.max(...existingData.map(item => item.id)) : 0;
    
    const newData = {
        id: maxId + 1,
        nomor: nomor,
        asal: asal,
        jenis: jenis,
        tanggal_surat: tanggalSurat,
        tanggal_terima: tanggalTerima,
        perihal: perihal,
        keterangan: document.getElementById('keterangan').value,
        lampiran: document.getElementById('lampiran').files[0]?.name || null
    };
    
    existingData.unshift(newData);
    localStorage.setItem('suratMasuk', JSON.stringify(existingData));
    
    alert('Data berhasil disimpan!');
    window.location.href = '{{ route("suratmasuk.index") }}';
}
</script>

<style>
    .fade-up { animation: fadeUp 0.35s ease forwards; }
    .fade-up2 { animation: fadeUp 0.35s ease 0.1s forwards; opacity: 0; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
</style>
@endsection