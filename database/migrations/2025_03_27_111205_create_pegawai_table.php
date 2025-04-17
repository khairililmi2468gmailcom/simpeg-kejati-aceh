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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->string('nip', 18)->primary();
            $table->string('nrp', 25)->nullable();
            $table->string('karpeg', 25)->nullable();
            $table->string('nama', 100);
            $table->string('tmpt_lahir', 25)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('agama', 25)->nullable();
            $table->string('suku', 25)->nullable();
            $table->string('gol_darah', 5)->nullable();
            $table->string('j_kelamin', 25)->nullable();
            $table->string('status', 25)->nullable();
            $table->integer('j_anak')->nullable();
            $table->string('id_provinsi', 2)->nullable();
            $table->string('id_kabupaten', 4)->nullable();
            $table->string('id_kecamatan', 7)->nullable();
            $table->string('alamat', 100)->nullable();
            $table->string('kode_pos', 12)->nullable();
            $table->string('hp', 12)->nullable();
            $table->string('pendidikan', 25)->nullable();
            $table->string('universitas', 100)->nullable();
            $table->string('jurusan', 100)->nullable();
            $table->year('t_lulus')->nullable();
            $table->year('tahun_masuk')->nullable();
            $table->string('foto', 100)->nullable();
            $table->date('tmt_jabatan')->nullable();
            $table->string('id_golongan', 5)->nullable();
            $table->string('kode_kantor', 10)->nullable();
            $table->unsignedBigInteger('id_jabatan')->nullable();
            $table->string('ket', 25)->nullable();
            $table->timestamps();
        });

        // Menambahkan foreign key setelah tabel dibuat
        Schema::table('pegawai', function (Blueprint $table) {
            $table->foreign('id_provinsi')->references('id')->on('provinsi')->onDelete('set null');
            $table->foreign('id_kabupaten')->references('id')->on('kabupaten')->onDelete('set null');
            $table->foreign('id_kecamatan')->references('id')->on('kecamatan')->onDelete('set null');
            $table->foreign('id_golongan')->references('id_golongan')->on('golongan')->onDelete('cascade');
            $table->foreign('kode_kantor')->references('kode_kantor')->on('unit_kerja')->onDelete('set null');
            $table->foreign('id_jabatan')->references('id_jabatan')->on('jabatan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
