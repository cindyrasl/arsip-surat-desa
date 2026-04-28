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
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_id')->constrained('jenis_surat')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->string('no_surat', 100);
            $table->string('tujuan_surat', 150);
            $table->string('perihal', 255);
            $table->date('tanggal_surat');
            $table->dateTime('tanggal_dikirim');
            $table->string('keterangan')->nullable();
            $table->string('file_path');
            $table->timestamps();
            
            // Index untuk pencarian cepat
            $table->index('tanggal_dikirim', 'idx_sk_tanggal_dikirim');

            $table->fullText(['no_surat', 'tujuan_surat', 'perihal'], 'ft_sk_search');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};