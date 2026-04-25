<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\GaleriSurat;
use App\Livewire\Admin\JenisSurat;
use App\Livewire\Admin\Laporan;
use App\Livewire\Admin\Pengguna;
use App\Livewire\Admin\RiwayatAktivitas;
use App\Livewire\Admin\SuratKeluar\Detail as SuratKeluarDetail;
use App\Livewire\Admin\SuratKeluar\Index as SuratKeluarIndex;
use App\Livewire\Admin\SuratMasuk\Detail as SuratMasukDetail;
use App\Livewire\Admin\SuratMasuk\Form as SuratMasukForm;
use App\Livewire\Admin\SuratMasuk\Index as SuratMasukIndex;
use App\Livewire\Admin\SuratKeluar\Form as SuratKeluarForm;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\ResetPassword;
use Illuminate\Support\Facades\Auth;

// ── AUTH ──────────────────────────────────────────────────────────────────

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');
});

Route::post('/logout', function () {
    if (Auth::check()) {
        \App\Models\RiwayatAktivitas::create([
            'user_id'   => Auth::id(),
            'aktivitas' => 'logout',
            'deskripsi' => 'User ' . Auth::user()->username . ' berhasil logout.',
            'logged_at' => now(),
        ]);
    }
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// ── ADMIN PANEL (requires auth) ───────────────────────────────────────────

Route::middleware('auth')->group(function () {

    Route::get('/',         Dashboard::class)->name('dashboard');

    // Surat Masuk
    Route::get('/surat-masuk',             SuratMasukIndex::class)->name('suratmasuk.index');
    Route::get('/surat-masuk/tambah',      SuratMasukForm::class)->name('suratmasuk.create');
    Route::get('/surat-masuk/{id}/edit',   SuratMasukForm::class)->name('suratmasuk.edit');
    Route::get('/surat-masuk/{id}',        SuratMasukDetail::class)->name('suratmasuk.detail');

    // Surat Keluar
    Route::get('/surat-keluar',            SuratKeluarIndex::class)->name('suratkeluar.index');
    Route::get('/surat-keluar/tambah',     SuratKeluarForm::class)->name('suratkeluar.create');
    Route::get('/surat-keluar/{id}/edit',  SuratKeluarForm::class)->name('suratkeluar.edit');
    Route::get('/surat-keluar/{id}',       SuratKeluarDetail::class)->name('suratkeluar.detail');

    // Jenis Surat
    Route::get('/jenis-surat', JenisSurat::class)->name('jenissurat.index');

    // Galeri Surat
    Route::get('/galeri-surat', GaleriSurat::class)->name('galerisurat.index');

    // Laporan
    Route::get('/laporan', Laporan::class)->name('laporan.index');

    // Pengguna
    Route::get('/pengguna', Pengguna::class)->name('pengguna.index');

    // Riwayat Aktivitas
    Route::get('/riwayataktivitas', RiwayatAktivitas::class)->name('riwayataktivitas.index');
});