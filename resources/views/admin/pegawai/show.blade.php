@extends('layouts.app-admin')

@section('content')
    <div>
        <h1 class="text-3xl font-bold text-[#00A181]">Detail Pegawai</h1>
        <p class="text-gray-600">Formulir detail data pegawai Kejaksaan Tinggi</p>
    </div>

    <div class="max-w-6xl mx-auto mt-6 p-6 sm:p-8 bg-white shadow-md rounded-xl relative" x-data="{ tab: 'pribadi' }">
        {{-- Foto Pegawai --}}
        @if ($pegawai->foto)
            <div class="absolute top-24 right-6 sm:top-8 sm:right-8 md:top-10 md:right-10 lg:top-12 lg:right-12 z-10">
                <img src="{{ asset('storage/' . $pegawai->foto) }}" alt="Foto Pegawai"
                    class="w-24 h-32 sm:w-28 sm:h-36 md:w-32 md:h-40 object-cover rounded-md border shadow-sm">
            </div>
        @endif


        {{-- Tab Menu --}}
        <div class="flex justify-center space-x-4 mb-6">
            <button class="cursor-pointer px-4 py-2 rounded-md text-sm font-semibold"
                :class="tab === 'pribadi' ? 'bg-[#00A181] text-white' : 'bg-gray-100 text-gray-700'"
                @click="tab = 'pribadi'">
                Data Pribadi
            </button>
            <button class="cursor-pointer px-4 py-2 rounded-md text-sm font-semibold"
                :class="tab === 'alamat' ? 'bg-[#00A181] text-white' : 'bg-gray-100 text-gray-700'"
                @click="tab = 'alamat'">
                Alamat & Kontak
            </button>
            <button class="cursor-pointer px-4 py-2 rounded-md text-sm font-semibold"
                :class="tab === 'pendidikan' ? 'bg-[#00A181] text-white' : 'bg-gray-100 text-gray-700'"
                @click="tab = 'pendidikan'">
                Pendidikan & Jabatan
            </button>
        </div>
        {{-- Identitas Utama --}}
        <div class="mb-6">
            <div class="text-xl font-bold text-gray-800">{{ $pegawai->nama }}</div>
            <div class="text-sm text-gray-600">NIP: {{ $pegawai->nip }}</div>
        </div>

        {{-- Spacer --}}
        <div class="h-36 sm:h-20 md:h-24 lg:h-2"></div>

        {{-- Konten Tab --}}
        <div class="space-y-2 text-sm leading-6">
            @php
                function row($label, $value)
                {
                    return "<div class='flex flex-wrap'><div class='w-44 font-semibold text-gray-700'>$label</div><div class='w-3'>:</div><div class='flex-1 pl-2 break-words'>$value</div></div>";
                }
            @endphp

            {{-- Data Pribadi --}}
            <div x-show="tab === 'pribadi'" x-cloak>
                {!! row('NRP', $pegawai->nrp) !!}
                {!! row('Karpeg', $pegawai->karpeg) !!}
                {!! row('Tempat Lahir', $pegawai->tmpt_lahir) !!}
                {!! row('Tanggal Lahir', \Carbon\Carbon::parse($pegawai->tgl_lahir)->format('d-m-Y')) !!}
                {!! row('Jenis Kelamin', $pegawai->j_kelamin) !!}
                {!! row('Agama', $pegawai->agama) !!}
                {!! row('Suku', $pegawai->suku) !!}
                {!! row('Golongan Darah', $pegawai->gol_darah) !!}
                {!! row('Status Pernikahan', $pegawai->status) !!}
                {!! row('Jumlah Anak', $pegawai->j_anak) !!}
            </div>

            {{-- Alamat & Kontak --}}
            <div x-show="tab === 'alamat'" x-cloak>
                {!! row('Alamat', $pegawai->alamat) !!}
                {!! row('Provinsi', $pegawai->provinsi->nama_provinsi ?? '-') !!}
                {!! row('Kabupaten', $pegawai->kabupaten->nama_kabupaten ?? '-') !!}
                {!! row('Kecamatan', $pegawai->kecamatan->nama_kecamatan ?? '-') !!}
                {!! row('Kode Pos', $pegawai->kode_pos) !!}
                {!! row('No. HP', $pegawai->hp) !!}
            </div>

            {{-- Pendidikan & Jabatan --}}
            <div x-show="tab === 'pendidikan'" x-cloak>
                {!! row('Pendidikan Terakhir', $pegawai->pendidikan) !!}
                {!! row('Universitas', $pegawai->universitas) !!}
                {!! row('Jurusan', $pegawai->jurusan) !!}
                {!! row('Tahun Masuk', $pegawai->tahun_masuk) !!}
                {!! row('Tahun Lulus', $pegawai->t_lulus) !!}
                {!! row('TMT Jabatan', \Carbon\Carbon::parse($pegawai->tmt_jabatan)->format('d M Y')) !!}
                {!! row('Jabatan', $pegawai->jabatan->nama_jabatan ?? '-') !!}
                {!! row('Golongan', $pegawai->golongan->pangkat ?? '-') !!}
                {!! row('Unit Kerja', $pegawai->unitKerja->nama_kantor ?? '-') !!}
                {!! row('Keterangan', $pegawai->ket) !!}
            </div>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-8">
            <a href="{{ route('admin.pegawai.index') }}"
                class="inline-block bg-[#00A181] hover:bg-[#009171] text-white px-6 py-2 rounded-md shadow transition cursor-pointer">
                ← Kembali
            </a>
        </div>
    </div>
@endsection
