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
        Schema::create('preferensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
 
            // Ukuran
            $table->enum('ukuran_atasan', ['XS','S','M','L','XL','XXL'])->nullable();
            $table->enum('ukuran_bawahan', ['XS','S','M','L','XL','XXL'])->nullable();
            $table->unsignedSmallInteger('tinggi_badan')->nullable(); // cm
            $table->unsignedSmallInteger('berat_badan')->nullable();  // kg
 
            // Preferensi gaya, warna, jenis — disimpan sebagai JSON array
            $table->json('gaya_berpakaian')->nullable(); // ['Casual','Streetwear',...]
            $table->json('warna_favorit')->nullable();   // ['Hitam','Navy',...]
            $table->json('jenis_pakaian')->nullable();   // ['Kaos','Kemeja',...]
            $table->json('pantangan')->nullable();        // ['Rok','Dress',...]
 
            $table->text('catatan_kurator')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferensi');
    }
};
