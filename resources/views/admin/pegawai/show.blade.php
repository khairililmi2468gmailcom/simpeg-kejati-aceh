@extends('layouts.app-admin')

@section('content')
<div>
    <h1 class="text-3xl font-bold text-[#00A181]">Detail Pegawai</h1>
    <p class="text-gray-600">Formulir detail data pegawai Kejaksaan Tinggi</p>
</div>
    <div class="max-w-6xl mx-auto mt-6 p-8 bg-white shadow-md rounded-xl relative">

        {{-- Judul Formulir --}}
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-[#00A181] uppercase">Detail Data Pegawai</h2>
            <p class="text-gray-600">Kejaksaan Tinggi {{ strtoupper($pegawai->provinsi->nama_provinsi ?? '-') }}</p>
        </div>

        {{-- Foto Pegawai di pojok kanan atas --}}
        @if ($pegawai->foto)
            <div class="absolute top-8 right-8">
                <img src="{{ asset('storage/' . $pegawai->foto) }}" alt="Foto Pegawai"
                    class="w-32 h-40 object-cover rounded-md border shadow-sm">
            </div>
        @endif

        {{-- Konten Formulir --}}
        <div class="space-y-2 text-sm leading-6">
            @php
                function row($label, $value) {
                    return "<div class='flex'><div class='w-56 font-semibold text-gray-700'>$label</div><div class='w-3'>:</div><div class='flex-1 pl-2'>$value</div></div>";
                }
            @endphp

            {!! row('NIP', $pegawai->nip) !!}
            {!! row('NRP', $pegawai->nrp) !!}
            {!! row('Karpeg', $pegawai->karpeg) !!}
            {!! row('Nama', $pegawai->nama) !!}
            {!! row('Tempat Lahir', $pegawai->tmpt_lahir) !!}
            {!! row('Tanggal Lahir', \Carbon\Carbon::parse($pegawai->tgl_lahir)->format('d-m-Y')) !!}
            {!! row('Agama', $pegawai->agama) !!}
            {!! row('Suku', $pegawai->suku) !!}
            {!! row('Golongan Darah', $pegawai->gol_darah) !!}
            {!! row('Jenis Kelamin', $pegawai->j_kelamin) !!}
            {!! row('Status', $pegawai->status) !!}
            {!! row('Jumlah Anak', $pegawai->j_anak) !!}
            {!! row('Provinsi', $pegawai->provinsi->nama_provinsi ?? '-') !!}
            {!! row('Kabupaten', $pegawai->kabupaten->nama_kabupaten ?? '-') !!}
            {!! row('Kecamatan', $pegawai->kecamatan->nama_kecamatan ?? '-') !!}
            {!! row('Kode Pos', $pegawai->kode_pos) !!}
            {!! row('Alamat', $pegawai->alamat) !!}
            {!! row('No. HP', $pegawai->hp) !!}
            {!! row('Pendidikan Terakhir', $pegawai->pendidikan) !!}
            {!! row('Universitas', $pegawai->universitas) !!}
            {!! row('Jurusan', $pegawai->jurusan) !!}
            {!! row('Tahun Lulus', $pegawai->t_lulus) !!}
            {!! row('Tahun Masuk', $pegawai->tahun_masuk) !!}
            {!! row('TMT Jabatan', \Carbon\Carbon::parse($pegawai->tmt_jabatan)->format('d-m-Y')) !!}
            {!! row('Golongan', $pegawai->golongan->pangkat ?? '-') !!}
            {!! row('Jabatan', $pegawai->jabatan->nama_jabatan ?? '-') !!}
            {!! row('Unit Kerja', $pegawai->unitKerja->nama_kantor ?? '-') !!}
            {!! row('Keterangan', $pegawai->ket) !!}
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-8">
            <a href="{{ route('admin.pegawai') }}"
                class="inline-block bg-[#00A181] hover:bg-[#009171] text-white px-6 py-2 rounded-md shadow transition">
                ← Kembali
            </a>
        </div>
    </div>
@endsection
