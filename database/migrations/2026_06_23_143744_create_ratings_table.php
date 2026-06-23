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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('rated_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('box_id')->constrained('boxes')->onDelete('cascade');
            $table->enum('tipe', ['kurator', 'kurir']); // Tipe yang di-rating
            $table->integer('rating')->min(1)->max(5); // Rating 1-5 bintang
            $table->text('komentar')->nullable();
            $table->timestamps();
            
            // Cegah duplikasi rating
            $table->unique(['user_id', 'rated_user_id', 'box_id', 'tipe']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
