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
        Schema::create('paket_subscription', function (Blueprint $table) {
            $table->id();
            $table->string('nama');           // Style Box, Premium Box, dll
            $table->string('slug')->unique(); // style, premium, starter
            $table->string('icon', 10)->default('📦');
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('harga'); // per periode, dalam Rupiah
            $table->unsignedTinyInteger('jumlah_item'); // jumlah item per box
            $table->json('fitur')->nullable();  // array fitur yang didapat
            $table->json('tidak')->nullable();  // array fitur yang tidak didapat
            $table->string('badge')->nullable(); // 'Paling Populer', dll
            $table->boolean('highlight')->default(false); // card highlight
            $table->boolean('aktif')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_subscription');
    }
};
