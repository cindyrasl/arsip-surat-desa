<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory; 
    
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
        'tanggal_diterima' => 'datetime:Y-m-d H:i:s',
    ];

    public function scopeSelectMinimal($query)
    {
        return $query->select([
            'id',
            'no_surat',
            'asal_surat', 
            'perihal',
            'tanggal_diterima',
            'jenis_id',
            'user_id',
        ]);
    }

    public function scopeSearch($query, $search)
    {
        if (empty($search)) return $query;
        
        $searchTerm = '%' . $search . '%';
        return $query->where(function($q) use ($searchTerm) {
            $q->where('no_surat', 'like', $searchTerm)
              ->orWhere('asal_surat', 'like', $searchTerm)
              ->orWhere('perihal', 'like', $searchTerm);
        });
    }

    public function scopeDateRange($query, $start, $end)
    {
        if ($start) {
            $query->where('tanggal_diterima', '>=', $start);
        }
        if ($end) {
            $query->where('tanggal_diterima', '<=', $end . ' 23:59:59');
        }
        return $query;
    }

     public function jenis()
    {
        return $this->belongsTo(JenisSurat::class)->select(['id', 'nama_jenis']);
    }

    public function user() 
    {
        return $this->belongsTo(User::class)->select(['id', 'nama']);
    }

    public function riwayatAktivitas()
    {
        return $this->hasMany(RiwayatAktivitas::class);
    }
}