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
        // Tabel Kepangkatan
        Schema::create('kepangkatan', function (Blueprint $table) {
            $table->string('no_sk', 50)->primary();
            $table->string('nip', 18)->nullable();
            $table->text('alasan')->nullable();
            $table->string('no_pertimbangan', 60)->nullable();
            $table->date('tanggal_sk')->nullable();
            $table->string('pembuat_sk', 50)->nullable();
            $table->date('tmt_sk_pangkat')->nullable();
            $table->string('no_usulan', 50)->nullable();
            $table->string('jenis_usulan', 25)->nullable();
            $table->string('pangkat_l', 25)->nullable();
            $table->string('id_golongan', 5)->nullable();

            // Foreign keys
            $table->foreign('nip')->references('nip')->on('pegawai')->onDelete('cascade');
            $table->foreign('id_golongan')->references('id_golongan')->on('golongan')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kepangkatan');
    }
};
