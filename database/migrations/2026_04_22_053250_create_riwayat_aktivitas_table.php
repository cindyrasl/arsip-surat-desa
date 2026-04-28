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
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('surat_masuk_id')->nullable()->constrained('surat_masuk')->onDelete('set null'); 
            $table->foreignId('surat_keluar_id')->nullable()->constrained('surat_keluar')->onDelete('set null'); 
            $table->enum('aktivitas', ['tambah', 'edit', 'hapus', 'restore', 'login', 'logout', 'upload', 'download']);
            $table->text('deskripsi');
            $table->timestamp('logged_at')->useCurrent();
            
            $table->index('user_id');
            $table->index('aktivitas'); 
            $table->index('logged_at');    
            
            $table->index(['logged_at', 'aktivitas'], 'idx_logged_aktivitas'); // Ganti composite index
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