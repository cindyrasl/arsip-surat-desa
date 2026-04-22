<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('riwayat_aktivitas', function (Blueprint $table) {
            $table->id('id_log');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->foreignId('id_surat_masuk')->nullable()->constrained('surat_masuk', 'id_surat_masuk')->onDelete('set null');
            $table->foreignId('id_surat_keluar')->nullable()->constrained('surat_keluar', 'id_surat_keluar')->onDelete('set null');
            $table->enum('aktivitas', ['tambah', 'edit', 'hapus', 'restore', 'login', 'logout', 'upload', 'download']);
            $table->text('deskripsi');
            $table->timestamp('logged_at')->useCurrent();
            
            // Index untuk query cepat
            $table->index('id_user');
            $table->index('aktivitas'); 
            $table->index('logged_at');    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_aktivitas');
    }
};