<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alats', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel 'kategori'
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->string('nama_alat');
            $table->integer('harga_per_hari')->default(0);
            $table->integer('stok')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alats');
    }
};