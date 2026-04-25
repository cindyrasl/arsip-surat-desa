<?php

namespace App\Livewire\Admin\SuratMasuk;

use App\Models\JenisSurat;
use App\Models\SuratMasuk;
use App\Models\RiwayatAktivitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class Form extends Component
{
    use WithFileUploads;

    // Mode form
    public $isEdit = false;
    public $suratId = null;
    
    // Form properties
    public $nomor = '';
    public $asal = '';
    public $jenis_id = '';
    public $tanggal_surat = '';
    public $tanggal_terima = '';
    public $perihal = '';
    public $keterangan = '';
    public $lampiran = null;
    public $oldLampiran = null;
    
    // Untuk pilihan jenis surat
    public $jenisSuratOptions = [];
    
    protected function rules()
    {
        $rules = [
            'nomor' => 'required|string|max:100',
            'asal' => 'required|string|max:150',
            'jenis_id' => 'required|exists:jenis_surat,id',
            'tanggal_surat' => 'required|date',
            'tanggal_terima' => 'required|date',
            'perihal' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ];
        
        if (!$this->isEdit) {
            $rules['lampiran'] = 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240';
        } else {
            $rules['lampiran'] = 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240';
        }
        
        return $rules;
    }
    
    protected function messages()
    {
        return [
            'nomor.required' => 'Nomor surat wajib diisi',
            'asal.required' => 'Asal surat wajib diisi',
            'jenis_id.required' => 'Jenis surat wajib dipilih',
            'tanggal_surat.required' => 'Tanggal surat wajib diisi',
            'tanggal_terima.required' => 'Tanggal diterima wajib diisi',
            'perihal.required' => 'Perihal wajib diisi',
            'lampiran.required' => 'Lampiran wajib diupload',
            'lampiran.mimes' => 'Lampiran harus berupa PDF, Word, atau gambar (JPG/JPEG/PNG)',
            'lampiran.max' => 'Ukuran lampiran maksimal 10MB',
        ];
    }
    
    public function mount($id = null)
    {
        $this->jenisSuratOptions = JenisSurat::orderBy('nama_jenis')->get();
        
        if ($id) {
            $this->isEdit = true;
            $this->suratId = $id;
            $this->loadData($id);
        }
    }
    
    public function loadData($id)
    {
        $suratMasuk = SuratMasuk::with('jenis')->findOrFail($id);
        
        $this->nomor = $suratMasuk->no_surat;
        $this->asal = $suratMasuk->asal_surat;
        $this->jenis_id = $suratMasuk->jenis_id;
        
        // Format tanggal
        $this->tanggal_surat = $suratMasuk->tanggal_surat instanceof Carbon 
            ? $suratMasuk->tanggal_surat->format('Y-m-d')
            : date('Y-m-d', strtotime($suratMasuk->tanggal_surat));
            
        $this->tanggal_terima = $suratMasuk->tanggal_diterima instanceof Carbon 
            ? $suratMasuk->tanggal_diterima->format('Y-m-d')
            : date('Y-m-d', strtotime($suratMasuk->tanggal_diterima));
        
        $this->perihal = $suratMasuk->perihal;
        $this->keterangan = $suratMasuk->keterangan;
        $this->oldLampiran = $suratMasuk->file_path;
    }
    
    public function save()
    {
        $validatedData = $this->validate();
        
        try {
            $filePath = $this->handleFileUpload();
            
            if ($this->isEdit) {
                $suratMasuk = SuratMasuk::findOrFail($this->suratId);
                
                $suratMasuk->update([
                    'no_surat' => $this->nomor,
                    'asal_surat' => $this->asal,
                    'jenis_id' => $this->jenis_id,
                    'tanggal_surat' => $this->tanggal_surat,
                    'tanggal_diterima' => $this->tanggal_terima,
                    'perihal' => $this->perihal,
                    'keterangan' => $this->keterangan,
                    'file_path' => $filePath ?? $suratMasuk->file_path,
                ]);
                
                RiwayatAktivitas::create([
                    'user_id' => Auth::id(),
                    'surat_masuk_id' => $suratMasuk->id,
                    'aktivitas' => 'edit',
                    'deskripsi' => "Mengedit surat masuk: {$this->nomor}",
                    'logged_at' => now(),
                ]);
                
                session()->flash('success', 'Surat masuk berhasil diupdate!');
                
            } else {
                $suratMasuk = SuratMasuk::create([
                    'no_surat' => $this->nomor,
                    'asal_surat' => $this->asal,
                    'jenis_id' => $this->jenis_id,
                    'user_id' => Auth::id(),
                    'tanggal_surat' => $this->tanggal_surat,
                    'tanggal_diterima' => $this->tanggal_terima . ' ' . now()->format('H:i:s'),
                    'perihal' => $this->perihal,
                    'keterangan' => $this->keterangan,
                    'file_path' => $filePath,
                ]);
                
                RiwayatAktivitas::create([
                    'user_id' => Auth::id(),
                    'surat_masuk_id' => $suratMasuk->id,
                    'aktivitas' => 'tambah',
                    'deskripsi' => "Menambah surat masuk: {$this->nomor}",
                    'logged_at' => now(),
                ]);
                
                session()->flash('success', 'Surat masuk berhasil disimpan!');
                $this->resetForm();
            }
            
            return redirect()->route('suratmasuk.index');
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error simpan surat masuk: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan internal pada server saat menyimpan data.');
        }
    }
    
    private function handleFileUpload()
    {
        if (!$this->lampiran) {
            return null;
        }
        
        if ($this->isEdit && $this->oldLampiran && Storage::disk('public')->exists($this->oldLampiran)) {
            Storage::disk('public')->delete($this->oldLampiran);
        }

        // Format nama file: 20260425_143025_001_SK_2026.pdf
        $extension = $this->lampiran->getClientOriginalExtension();
        $safeNomor = preg_replace('/[^a-zA-Z0-9\-]/', '_', $this->nomor);
        $fileName = date('Ymd_His') . '_' . $safeNomor . '.' . $extension;
        
        $filePath = $this->lampiran->storeAs('uploads/surat-masuk', $fileName, 'public');
        
        return $filePath;
    }
    
    private function resetForm()
    {
        $this->reset(['nomor', 'asal', 'jenis_id', 'tanggal_surat', 'tanggal_terima', 'perihal', 'keterangan', 'lampiran']);
        $this->resetValidation();
    }
    
    public function cancel()
    {
        return redirect()->route('suratmasuk.index');
    }
    
    // Render view
    public function render()
    {
        return view('livewire.admin.SuratMasuk.form')->layout('layouts.app');
    }
}