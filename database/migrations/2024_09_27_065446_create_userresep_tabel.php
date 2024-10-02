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
        Schema::create('userresep_tabel', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('deskripsi');
            $table->string('bahan');
            $table->string('image')->nullable();
            $table->enum('kategori', ['makanan', 'minuman']);
            $table->enum('status', ['diproses', 'diterima', 'ditolak'])->default('diproses');
            $table->json('pembuatan')->nullable(); // Menambahkan kolom pembuatan jika diperlukan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userresep_tabel');
    }
};
