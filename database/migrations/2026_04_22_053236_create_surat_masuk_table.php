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
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_id')->constrained('jenis_surat')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->string('no_surat', 100);
            $table->string('asal_surat', 150);
            $table->string('perihal', 255);
            $table->date('tanggal_surat');
            $table->dateTime('tanggal_diterima');
            $table->string('keterangan')->nullable();
            $table->string('file_path');

            $table->softDeletes();
            $table->timestamps();
            
            // Index untuk pencarian cepat
            $table->index('tanggal_diterima', 'idx_sm_tanggal_diterima');

            $table->fullText(['no_surat', 'asal_surat', 'perihal'], 'ft_sm_search');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};