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
        Schema::table('users', function (Blueprint $table) {
            $table->string('kendaraan')->nullable()->after('catatan');
            $table->string('plat')->nullable()->after('kendaraan');
            $table->string('wilayah')->nullable()->after('plat');
            $table->date('tanggal_bergabung')->nullable()->after('wilayah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['kendaraan', 'plat', 'wilayah', 'tanggal_bergabung']);
        });
    }
};
