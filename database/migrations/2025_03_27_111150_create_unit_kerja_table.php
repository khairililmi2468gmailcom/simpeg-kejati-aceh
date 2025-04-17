<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('unit_kerja', function (Blueprint $table) {
            $table->string('kode_kantor', 10)->primary();
            $table->string('nama_kantor', 100);
            $table->string('id_provinsi', 2)->nullable();
            $table->timestamps();
        });
        Schema::table('pegawai', function (Blueprint $table) {
            $table->foreign('id_provinsi')->references('id')->on('provinsi')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_kerja');
    }
};
