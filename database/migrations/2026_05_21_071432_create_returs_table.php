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
        Schema::create('returs', function (Blueprint $table) {
            $table->id();
            
            $table->string('kode_retur')->unique(); // RTR-20250115-001
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('box_id')->constrained('boxes');
 
            // Item yang diretur (array of inventory_item id)
            $table->json('item_retur');
 
            $table->enum('alasan_retur', [
                'tidak_cocok_ukuran',
                'tidak_suka_style',
                'kualitas_kurang',
                'warna_tidak_sesuai',
                'kondisi_rusak',
                'lainnya',
            ]);
 
            $table->text('catatan_retur')->nullable();
            $table->enum('metode_pengembalian', ['drop_off', 'pickup'])->default('drop_off');
 
            $table->enum('status', ['diajukan','diproses','selesai','ditolak'])->default('diajukan');
            $table->text('catatan_admin')->nullable();
 
            $table->timestamp('tanggal_batas_retur')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returs');
    }
};
