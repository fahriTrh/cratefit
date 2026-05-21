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
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('kode_item')->unique(); // ITM-0001
            $table->string('nama');
            $table->string('kategori');  // Atasan, Bawahan, Outer, dll
            $table->string('jenis');     // Kemeja, Kaos, Celana, dll
            $table->enum('ukuran', ['XS','S','M','L','XL','XXL','28','29','30','31','32','33','34']);
            $table->string('warna')->nullable();
            $table->string('brand')->nullable();
            $table->enum('kondisi', ['bagus_sekali','bagus','cukup_baik'])->default('bagus');
            $table->unsignedInteger('harga'); // harga per item dalam Rupiah
            $table->unsignedSmallInteger('stok')->default(1);
            $table->json('tags')->nullable(); // ['vintage','oversized','casual',...]
            $table->string('foto')->nullable(); // path foto
 
            $table->enum('status', ['tersedia','dikurasi','terkirim','diretur','nonaktif'])
                  ->default('tersedia');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
