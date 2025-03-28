<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('menerima_cuti', function (Blueprint $table) {
            $table->string('no_surat', 50)->primary();
            $table->string('nip', 18);
            $table->unsignedBigInteger('cuti_id');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('jumlah_cuti');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // Menambahkan foreign key setelah tabel dibuat
        Schema::table('menerima_cuti', function (Blueprint $table) {
            $table->foreign('nip')->references('nip')->on('pegawai')->onDelete('cascade');
            $table->foreign('cuti_id')->references('id')->on('cuti')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menerima_cuti');
    }
};
