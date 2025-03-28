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
            $table->string('nip', 18);
            $table->text('alasan');
            $table->string('no_pertimbangan', 60);
            $table->date('tanggal_sk');
            $table->string('pembuat_sk', 50);
            $table->date('tmt_sk_pangkat');
            $table->string('no_usulan', 50);
            $table->string('jenis_usulan', 25);
            $table->string('pangkat_l', 25);
            $table->string('id_golongan', 5);

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
