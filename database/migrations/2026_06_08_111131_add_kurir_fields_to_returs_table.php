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
        Schema::table('returs', function (Blueprint $table) {
            $table->foreignId('kurir_id')->nullable()->constrained('users')->after('catatan_admin');
            $table->timestamp('tanggal_dijemput')->nullable()->after('kurir_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('returs', function (Blueprint $table) {
            $table->dropForeign(['kurir_id']);
            $table->dropColumn(['kurir_id', 'tanggal_dijemput']);
        });
    }
};
