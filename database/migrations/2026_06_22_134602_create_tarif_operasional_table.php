<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tarif_operasional', function (Blueprint $table) {
            $table->id();
            $table->string('kunci')->unique(); // 'tarif_kurir' atau 'tarif_kurator'
            $table->unsignedBigInteger('nominal'); // dalam rupiah
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
        
        // Seed nilai default
        DB::table('tarif_operasional')->insert([
            ['kunci' => 'tarif_kurir',    'nominal' => 10000, 'keterangan' => 'Per paket terkirim', 'created_at' => now(), 'updated_at' => now()],
            ['kunci' => 'tarif_kurator',  'nominal' => 15000, 'keterangan' => 'Per box dikurasi',   'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarif_operasional');
    }
};
