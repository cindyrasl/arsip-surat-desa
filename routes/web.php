<?php
// routes/web.php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('livewire.auth.login');
})->name('login');

Route::view('/lupa-password', 'livewire.auth.reset-password')->name('lupa-password');

Route::view('/dashboard', 'livewire.admin.dashboard')->name('dashboard');

// Route untuk Surat Masuk
Route::view('/suratmasuk', 'livewire.admin.SuratMasuk.index')->name('suratmasuk.index');
Route::view('/suratmasuk/create', 'livewire.admin.SuratMasuk.create')->name('suratmasuk.create');
Route::view('/suratmasuk/edit', 'livewire.admin.SuratMasuk.edit')->name('suratmasuk.edit');
Route::view('/suratmasuk/detail', 'livewire.admin.SuratMasuk.detail')->name('suratmasuk.detail');

// Route untuk Surat Keluar
Route::view('/suratkeluar', 'livewire.admin.SuratKeluar.index')->name('suratkeluar.index');
Route::view('/suratkeluar/create', 'livewire.admin.SuratKeluar.create')->name('suratkeluar.create');
Route::view('/suratkeluar/edit', 'livewire.admin.SuratKeluar.edit')->name('suratkeluar.edit');
Route::view('/suratkeluar/detail', 'livewire.admin.SuratKeluar.detail')->name('suratkeluar.detail');

// Route untuk Galeri Surat
Route::view('/galerisurat', 'livewire.admin.GaleriSurat.index')->name('galerisurat.index');

// Route untuk Riwayat Aktivitas
Route::view('/riwayataktivitas', 'livewire.admin.RiwayatAktivitas.index')->name('riwayataktivitas.index');

// Route untuk Jenis Surat
Route::view('/jenissurat', 'livewire.admin.JenisSurat.index')->name('jenissurat.index');

// Route untuk Pengguna
Route::view('/pengguna', 'livewire.admin.Pengguna.index')->name('pengguna.index');

// Route untuk Laporan
Route::view('/laporan', 'livewire.admin.Laporan.index')->name('laporan.index');
?>