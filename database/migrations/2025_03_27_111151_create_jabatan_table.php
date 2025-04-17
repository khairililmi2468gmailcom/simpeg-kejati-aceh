<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jabatan', function (Blueprint $table) {
            $table->id('id_jabatan');
            $table->string('nama_jabatan', 100);
            $table->text('ket')->nullable();
            $table->string('kode_kantor', 10)->nullable();
            $table->timestamps();
        });

        // Menambahkan foreign key setelah tabel dibuat
        Schema::table('jabatan', function (Blueprint $table) {
            $table->foreign('kode_kantor')->references('kode_kantor')->on('unit_kerja')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jabatan');
    }
};
