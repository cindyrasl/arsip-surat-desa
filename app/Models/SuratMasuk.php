<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratMasuk extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'surat_masuk';
    
    protected $fillable = [
        'jenis_id',
        'user_id',
        'no_surat',
        'asal_surat',
        'perihal',
        'tanggal_surat',
        'tanggal_diterima',
        'keterangan',
        'file_path',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_diterima' => 'datetime',
    ];

    public function jenis()
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}