<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    
    // Kolom-kolom yang boleh diisi
    protected $fillable = [
        'nama',           
        'username',       
        'email',         
        'password',      
        'jabatan',      
        'foto',          
        'last_login_at',  
        'last_login_ip',  
    ];

    // Kolom-kolom yang disembunyikan saat model diubah ke array/JSON
    protected $hidden = [
        'password',        
        'remember_token', 
    ];

    // Tipe data casting untuk kolom tertentu
        protected $casts = [
        'email_verified_at' => 'datetime',  
        'last_login_at' => 'datetime',     
    ];

    // Relasi: Satu user dapat mengelola banyak surat masuk (one-to-many)
    public function suratMasuk()
    {
        return $this->hasMany(SuratMasuk::class);
    }

    // Relasi: Satu user dapat mengelola banyak surat keluar (one-to-many)
    public function suratKeluar()
    {
        return $this->hasMany(SuratKeluar::class);
    }

    // Relasi: Satu user dapat melakukan banyak aktivitas (one-to-many)
    public function riwayatAktivitas()
    {
        return $this->hasMany(RiwayatAktivitas::class);
    }

    // Ambil format last login yang sudah diformat
    public function getLastLoginFormattedAttribute()
    {
        return $this->last_login_at?->format('d/m/Y H:i:s') ?? 'Belum pernah login';
    }
}