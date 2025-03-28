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
            $table->string('provinsi', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_kerja');
    }
};
