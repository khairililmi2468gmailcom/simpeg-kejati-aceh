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
        Schema::create('mengikuti_diklat', function (Blueprint $table) {
            $table->string('no_sttpp', 50)->primary(); // Nomor STTPP sebagai primary key
            $table->string('nip', 18);
            $table->unsignedBigInteger('diklat_id');
            $table->text('tempat_diklat');
            $table->text('penyelenggara');
            $table->string('angkatan', 12);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('jumlah_jam');
            $table->date('tanggal_sttpp');

            // Foreign keys
            $table->foreign('nip')->references('nip')->on('pegawai')->onDelete('cascade');
            $table->foreign('diklat_id')->references('id')->on('diklat')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mengikuti_diklat');
    }
};
