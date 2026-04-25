<?php

namespace App\Livewire\Admin\SuratKeluar;

use App\Models\JenisSurat;
use App\Models\SuratKeluar;
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

    public bool    $isEdit    = false;
    public ?int    $suratId   = null;

    // Form properties
    public string  $nomor          = '';
    public string  $tujuan         = '';
    public string  $jenis_id       = '';
    public string  $tanggal_surat  = '';
    public string  $tanggal_kirim  = '';
    public string  $perihal        = '';
    public string  $keterangan     = '';
    public         $lampiran       = null;
    public ?string $oldLampiran    = null;

    public $jenisSuratOptions = [];

    protected function rules(): array
    {
        $rules = [
            'nomor'         => 'required|string|max:100',
            'tujuan'        => 'required|string|max:150',
            'jenis_id'      => 'required|exists:jenis_surat,id',
            'tanggal_surat' => 'required|date',
            'tanggal_kirim' => 'nullable|date',
            'perihal'       => 'required|string|max:255',
            'keterangan'    => 'nullable|string',
        ];

        // Validasi file: required saat tambah, nullable saat edit
        if (!$this->isEdit) {
            $rules['lampiran'] = 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240';
        } else {
            $rules['lampiran'] = 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240';
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'nomor.required'         => 'Nomor surat wajib diisi.',
            'tujuan.required'        => 'Tujuan surat wajib diisi.',
            'jenis_id.required'      => 'Jenis surat wajib dipilih.',
            'tanggal_surat.required' => 'Tanggal surat wajib diisi.',
            'perihal.required'       => 'Perihal wajib diisi.',
            'lampiran.required'      => 'Lampiran wajib diupload.',
            'lampiran.mimes' => 'Lampiran harus berupa PDF, Word, atau gambar (JPG/JPEG/PNG)',
            'lampiran.max' => 'Ukuran lampiran maksimal 10MB',
        ];
    }

    public function mount(?int $id = null): void
    {
        $this->jenisSuratOptions = JenisSurat::orderBy('nama_jenis')->get();

        if ($id) {
            $this->isEdit  = true;
            $this->suratId = $id;
            $this->loadData($id);
        }
    }

    public function loadData(int $id): void
    {
        $surat = SuratKeluar::findOrFail($id);

        $this->nomor         = $surat->no_surat;
        $this->tujuan        = $surat->tujuan_surat;
        $this->jenis_id      = (string) $surat->jenis_id;

        // Format tanggal
        $this->tanggal_surat = $surat->tanggal_surat instanceof Carbon
            ? $surat->tanggal_surat->format('Y-m-d')
            : date('Y-m-d', strtotime($surat->tanggal_surat));
            
        $this->tanggal_kirim = $surat->tanggal_dikirim
            ? ($surat->tanggal_dikirim instanceof Carbon
                ? $surat->tanggal_dikirim->format('Y-m-d')
                : date('Y-m-d', strtotime($surat->tanggal_dikirim)))
            : '';

        $this->perihal       = $surat->perihal;
        $this->keterangan    = $surat->keterangan ?? '';
        $this->oldLampiran   = $surat->file_path;
    }

    public function save()
    {
        $this->validate();

        try {
            $filePath = $this->handleFileUpload();

            $tanggalKirim = $this->tanggal_kirim 
                ? $this->tanggal_kirim . ' ' . now()->format('H:i:s') 
                : null;

            if ($this->isEdit) {
                $surat = SuratKeluar::findOrFail($this->suratId);
                $surat->update([
                    'no_surat'       => $this->nomor,
                    'tujuan_surat'   => $this->tujuan,
                    'jenis_id'       => $this->jenis_id,
                    'tanggal_surat'  => $this->tanggal_surat,
                    'tanggal_dikirim'=> $tanggalKirim,
                    'perihal'        => $this->perihal,
                    'keterangan'     => $this->keterangan,
                    'file_path'      => $filePath ?? $surat->file_path,
                ]);

                RiwayatAktivitas::create([
                    'user_id'        => Auth::id(),
                    'surat_keluar_id'=> $surat->id,
                    'aktivitas'      => 'edit',
                    'deskripsi'      => "Mengedit surat keluar: {$this->nomor}",
                    'logged_at'      => now(),
                ]);

                session()->flash('success', 'Surat keluar berhasil diupdate!');

            } else {
                $surat = SuratKeluar::create([
                    'no_surat'       => $this->nomor,
                    'tujuan_surat'   => $this->tujuan,
                    'jenis_id'       => $this->jenis_id,
                    'user_id'        => Auth::id(),
                    'tanggal_surat'  => $this->tanggal_surat,
                    'tanggal_dikirim'=> $tanggalKirim,
                    'perihal'        => $this->perihal,
                    'keterangan'     => $this->keterangan,
                    'file_path'      => $filePath,
                ]);

                RiwayatAktivitas::create([
                    'user_id'        => Auth::id(),
                    'surat_keluar_id'=> $surat->id,
                    'aktivitas'      => 'tambah',
                    'deskripsi'      => "Menambah surat keluar: {$this->nomor}",
                    'logged_at'      => now(),
                ]);

                session()->flash('success', 'Surat keluar berhasil disimpan!');
            }

            return redirect()->route('suratkeluar.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function handleFileUpload(): ?string
    {
        if (!$this->lampiran) {
            return null;
        }

        // Hapus file lama jika edit
        if ($this->isEdit && $this->oldLampiran && Storage::disk('public')->exists($this->oldLampiran)) {
            Storage::disk('public')->delete($this->oldLampiran);
        }

        // Format nama file: 20260425_143025_001_SK_2026.pdf
        $extension = $this->lampiran->getClientOriginalExtension();
        $safeNomor = preg_replace('/[^a-zA-Z0-9\-]/', '_', $this->nomor);
        $fileName = date('Ymd_His') . '_' . $safeNomor . '.' . $extension;
        
        return $this->lampiran->storeAs('uploads/surat-keluar', $fileName, 'public');
    }

    public function updatedLampiran()
    {
        $this->validate([
            'lampiran' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ], [
            'lampiran.max' => 'Ukuran file terlalu besar. Maksimal 10MB.',
            'lampiran.mimes' => 'File harus berupa PDF, Word, atau gambar (JPG/PNG).',
        ]);
    }

    public function cancel()
    {
        return redirect()->route('suratkeluar.index');
    }

    public function render()
    {
        return view('livewire.admin.SuratKeluar.form')->layout('layouts.app');
    }
}