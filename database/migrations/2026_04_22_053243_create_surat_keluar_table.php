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
            $table->id('id_surat_keluar');
            $table->foreignId('id_jenis')->constrained('jenis_surat', 'id_jenis')->onDelete('restrict');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('restrict');
            $table->string('no_surat', 100);
            $table->string('tujuan_surat', 150);
            $table->string('perihal', 255);
            $table->date('tanggal_surat');
            $table->date('tanggal_dikirim');
            $table->string('keterangan')->nullable();
            $table->string('file_path');
            $table->softDeletes();
            $table->timestamps();
            
            // Index untuk pencarian cepat
            $table->index('no_surat', 'idx_sk_no_surat');
            $table->index('tujuan_surat', 'idx_sk_tujuan_surat');
            $table->index('perihal', 'idx_sk_perihal');
            $table->index('tanggal_dikirim', 'idx_sk_tanggal_dikirim');
            $table->index('deleted_at', 'idx_sk_deleted_at');
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