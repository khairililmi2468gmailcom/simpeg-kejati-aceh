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
        Schema::create('mutasi', function (Blueprint $table) {
            $table->string('no_sk', 50)->primary();
            $table->string('nip', 18);
            $table->unsignedBigInteger('id_jabatan');
            $table->string('jabatan_l', 50);
            $table->string('tempat_l', 100);
            $table->date('tanggal_sk');
            $table->date('tmt_l'); // Tanggal Mulai Tugas Lama
            $table->date('tmt_jabatan');

            // Foreign keys
            $table->foreign('nip')->references('nip')->on('pegawai')->onDelete('cascade');
            $table->foreign('id_jabatan')->references('id_jabatan')->on('jabatan')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi');
    }
};
