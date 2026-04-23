<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratKeluar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'surat_keluar';

    protected $fillable = [
        'jenis_id',
        'user_id',
        'no_surat',
        'tujuan_surat',
        'perihal',
        'tanggal_surat',
        'tanggal_dikirim',
        'keterangan',
        'file_path',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_dikirim' => 'date',
    ];

    public function jenis()
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function pengguna()
    {
        return $this->belongsTo(User::class);
    }
}