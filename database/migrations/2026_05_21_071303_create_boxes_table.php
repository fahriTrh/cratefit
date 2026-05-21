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
        Schema::create('boxes', function (Blueprint $table) {
            $table->id();
            $table->string('kode_box')->unique(); // CF-20250101
            $table->foreignId('langganan_id')->constrained('langganan');
            $table->foreignId('user_id')->constrained();                          // pelanggan
            $table->foreignId('kurator_id')->nullable()->constrained('users');   // kurator yang mengisi
            $table->foreignId('kurir_id')->nullable()->constrained('users');     // kurir yang mengantar
 
            $table->enum('status', [
                'menunggu_kurasi',
                'sedang_dikurasi',
                'siap_dikirim',
                'dalam_pengiriman',
                'tiba',
                'selesai',
            ])->default('menunggu_kurasi');
 
            $table->string('nomor_resi')->nullable();
            $table->string('ekspedisi')->nullable(); // JNE, SiCepat, dll
            $table->text('catatan_kurasi')->nullable();
            $table->text('catatan_internal')->nullable();
 
            $table->timestamp('tanggal_dikurasi')->nullable();
            $table->timestamp('tanggal_dikirim')->nullable();
            $table->timestamp('tanggal_tiba')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boxes');
    }
};
