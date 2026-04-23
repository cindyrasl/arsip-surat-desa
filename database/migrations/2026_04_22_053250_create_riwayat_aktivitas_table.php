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
            $table->foreignId('surat_masuk_id')->nullable()->constrained('surat_masuk')->nullOnDelete();
            $table->foreignId('surat_keluar_id')->nullable()->constrained('surat_keluar')->nullOnDelete();
            $table->enum('aktivitas', ['tambah', 'edit', 'hapus', 'restore', 'login', 'logout', 'upload', 'download']);
            $table->text('deskripsi');
            $table->timestamp('logged_at')->useCurrent();
            
            // Index untuk query cepat
            $table->index('user_id');
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