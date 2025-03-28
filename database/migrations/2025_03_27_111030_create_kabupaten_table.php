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
        Schema::create('kabupaten', function (Blueprint $table) {
            $table->string('id', 4)->primary(); // ID kabupaten (varchar 4 karakter)
            $table->string('nama_kabupaten', 50);
            $table->string('id_provinsi', 2); // Foreign key ke provinsi

            // Relasi ke tabel provinsi
            $table->foreign('id_provinsi')->references('id')->on('provinsi')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kabupaten');
    }
};
