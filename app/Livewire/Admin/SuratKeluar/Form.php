<?php

namespace App\Livewire\Admin\SuratKeluar;

use App\Models\JenisSurat;
use App\Models\SuratKeluar;
use App\Models\RiwayatAktivitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
    public $tujuan = '';
    public $jenis_id = '';
    public $tanggal_surat = '';
    public $tanggal_kirim = '';
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
            'tujuan' => 'required|string|max:150',
            'jenis_id' => 'required|exists:jenis_surat,id',
            'tanggal_surat' => 'required|date',
            'tanggal_kirim' => 'required|date',
            'perihal' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ];
        
        if (!$this->isEdit) {
            $rules['lampiran'] = 'required|file|mimes:pdf,doc,docx|max:10240';
        } else {
            $rules['lampiran'] = 'nullable|file|mimes:pdf,doc,docx|max:10240';
        }
        
        return $rules;
    }
    
    protected function messages()
    {
        return [
            'nomor.required' => 'Nomor surat wajib diisi',
            'tujuan.required' => 'Tujuan surat wajib diisi',
            'jenis_id.required' => 'Jenis surat wajib dipilih',
            'jenis_id.exists' => 'Jenis surat tidak valid',
            'tanggal_surat.required' => 'Tanggal surat wajib diisi',
            'tanggal_surat.date' => 'Format tanggal surat tidak valid',
            'tanggal_kirim.required' => 'Tanggal kirim wajib diisi',
            'perihal.required' => 'Perihal wajib diisi',
            'lampiran.required' => 'Lampiran wajib diupload',
            'lampiran.mimes' => 'Lampiran harus berupa file PDF atau Word',
            'lampiran.max' => 'Ukuran lampiran maksimal 10MB',
        ];
    }
    
    public function mount($id = null)
    {
        // Load jenis surat options
        $this->jenisSuratOptions = JenisSurat::orderBy('nama_jenis')->get();
        
        if ($id) {
            $this->isEdit = true;
            $this->suratId = $id;
            $this->loadData($id);
        }
    }
    
    public function loadData($id)
    {
        $suratKeluar = SuratKeluar::with('jenis')->findOrFail($id);
        
        $this->nomor = $suratKeluar->no_surat;
        $this->tujuan = $suratKeluar->tujuan_surat;
        $this->jenis_id = $suratKeluar->jenis_id;
        
        // Format tanggal
        $this->tanggal_surat = $suratKeluar->tanggal_surat instanceof Carbon 
            ? $suratKeluar->tanggal_surat->format('Y-m-d')
            : date('Y-m-d', strtotime($suratKeluar->tanggal_surat));
            
        $this->tanggal_kirim = $suratKeluar->tanggal_dikirim instanceof Carbon 
            ? $suratKeluar->tanggal_dikirim->format('Y-m-d')
            : date('Y-m-d', strtotime($suratKeluar->tanggal_dikirim));
        
        $this->perihal = $suratKeluar->perihal;
        $this->keterangan = $suratKeluar->keterangan;
        $this->oldLampiran = $suratKeluar->file_path;
    }
    
    public function save()
    {
        $validatedData = $this->validate();
        
        try {
            $filePath = $this->handleFileUpload();
            
            if ($this->isEdit) {
                // UPDATE
                $suratKeluar = SuratKeluar::findOrFail($this->suratId);
                
                $suratKeluar->update([
                    'no_surat' => $this->nomor,
                    'tujuan_surat' => $this->tujuan,
                    'jenis_id' => $this->jenis_id,
                    'tanggal_surat' => $this->tanggal_surat,
                    'tanggal_dikirim' => $this->tanggal_kirim,
                    'perihal' => $this->perihal,
                    'keterangan' => $this->keterangan,
                    'file_path' => $filePath ?? $suratKeluar->file_path,
                ]);
                
                // Log aktivitas
                RiwayatAktivitas::create([
                    'user_id' => Auth::id(),
                    'surat_keluar_id' => $suratKeluar->id,
                    'aktivitas' => 'edit',
                    'deskripsi' => "Mengedit surat keluar: {$this->nomor}",
                    'logged_at' => now(),
                ]);
                
                session()->flash('success', 'Surat keluar berhasil diupdate!');
                
            } else {
                // CREATE
                $suratKeluar = SuratKeluar::create([
                    'no_surat' => $this->nomor,
                    'tujuan_surat' => $this->tujuan,
                    'jenis_id' => $this->jenis_id,
                    'user_id' => Auth::id(),
                    'tanggal_surat' => $this->tanggal_surat,
                    'tanggal_dikirim' => $this->tanggal_kirim,
                    'perihal' => $this->perihal,
                    'keterangan' => $this->keterangan,
                    'file_path' => $filePath,
                ]);
                
                // Log aktivitas
                RiwayatAktivitas::create([
                    'user_id' => Auth::id(),
                    'surat_keluar_id' => $suratKeluar->id,
                    'aktivitas' => 'tambah',
                    'deskripsi' => "Menambah surat keluar: {$this->nomor}",
                    'logged_at' => now(),
                ]);
                
                session()->flash('success', 'Surat keluar berhasil disimpan!');
                $this->resetForm();
            }
            
            return redirect()->route('suratkeluar.index');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    private function handleFileUpload()
    {
        if (!$this->lampiran) {
            return null;
        }
        
        // Delete old file if exists in edit mode
        if ($this->isEdit && $this->oldLampiran && Storage::disk('public')->exists($this->oldLampiran)) {
            Storage::disk('public')->delete($this->oldLampiran);
        }
        
        $fileName = time() . '_' . $this->lampiran->getClientOriginalName();
        $filePath = $this->lampiran->storeAs('uploads/surat-keluar', $fileName, 'public');
        
        return $filePath;
    }
    
    private function resetForm()
    {
        $this->reset(['nomor', 'tujuan', 'jenis_id', 'tanggal_surat', 'tanggal_kirim', 'perihal', 'keterangan', 'lampiran']);
        $this->resetValidation();
    }
    
    public function cancel()
    {
        return redirect()->route('suratkeluar.index');
    }
    
    public function render()
    {
        return view('livewire.admin.suratkeluar.form');
    }
}