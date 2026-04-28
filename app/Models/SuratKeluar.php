<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory; 

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
        'tanggal_dikirim' => 'datetime:Y-m-d H:i:s',
    ];

    // Scope untuk optimasi query
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->whereFullText(['no_surat', 'tujuan_surat', 'perihal'], $search);
        }
        return $query;
    }

    public function scopeDateRange($query, $start, $end)
    {
        if ($start) {
            $query->where('tanggal_dikirim', '>=', $start);
        }
        if ($end) {
            $query->where('tanggal_dikirim', '<=', $end . ' 23:59:59');
        }
        return $query;
    }

    public function jenis()
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function riwayatAktivitas()
    {
        return $this->hasMany(RiwayatAktivitas::class);
    }
}