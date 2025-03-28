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
        Schema::create('kecamatan', function (Blueprint $table) {
            $table->string('id', 7)->primary(); // ID kecamatan (varchar 7 karakter)
            $table->string('nama_kecamatan', 50);
            $table->string('id_kabupaten', 4); // Foreign key ke kabupaten

            // Relasi ke tabel kabupaten
            $table->foreign('id_kabupaten')->references('id')->on('kabupaten')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kecamatan');
    }
};
