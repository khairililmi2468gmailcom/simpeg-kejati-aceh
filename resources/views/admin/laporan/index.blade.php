@extends('layouts.app-admin')

@section('content')
    <div class="p-6">
        <h1 class="text-3xl font-bold text-[#00A181]">Laporan</h1>
        <p class="text-gray-600 mb-8">Halaman Laporan</p>
        {{-- Tab Navigasi --}}
        @php
            $tab = request('tab', 'pegawai');
        @endphp

        <div class="flex space-x-2 mb-6">
            <a href="{{ route('admin.laporan.index', ['tab' => 'pegawai']) }}"
                class="px-4 py-2 rounded {{ $tab === 'pegawai' ? 'bg-[#00A181] text-white' : 'bg-gray-200 text-gray-700' }}">Laporan
                Pegawai</a>

            <a href="{{ route('admin.laporan.index', ['tab' => 'cuti']) }}"
                class="px-4 py-2 rounded {{ $tab === 'cuti' ? 'bg-[#00A181] text-white' : 'bg-gray-200 text-gray-700' }}">Laporan
                Cuti</a>

            <a href="{{ route('admin.laporan.index', ['tab' => 'diklat']) }}"
                class="px-4 py-2 rounded {{ $tab === 'diklat' ? 'bg-[#00A181] text-white' : 'bg-gray-200 text-gray-700' }}">Laporan
                Diklat</a>

            <a href="{{ route('admin.laporan.index', ['tab' => 'mutasi']) }}"
                class="px-4 py-2 rounded {{ $tab === 'mutasi' ? 'bg-[#00A181] text-white' : 'bg-gray-200 text-gray-700' }}">Laporan
                Mutasi</a>

            <a href="{{ route('admin.laporan.index', ['tab' => 'kepangkatan']) }}"
                class="px-4 py-2 rounded {{ $tab === 'kepangkatan' ? 'bg-[#00A181] text-white' : 'bg-gray-200 text-gray-700' }}">Laporan
                Kepangkatan</a>
        </div>
        @if ($tab === 'pegawai')
            @include('admin.laporan.partials.pegawai')
        @elseif ($tab === 'cuti')
            @include('admin.laporan.partials.cuti')
        @elseif ($tab === 'diklat')
            @include('admin.laporan.partials.diklat')
        @elseif ($tab === 'mutasi')
            @include('admin.laporan.partials.mutasi')
        @elseif ($tab === 'kepangkatan')
            @include('admin.laporan.partials.kepangkatan')
        @endif

        {{-- Pencarian dan Filter --}}
        <div class="bg-white border rounded-lg p-4 shadow-md">
            <h3 class="text-md font-semibold mb-4">Pencarian Pegawai Kejaksaan Tinggi Aceh</h3>

            <form method="GET" action="{{ route('admin.laporan.index') }}">
                <div class="flex flex-col md:flex-row md:space-x-4 mb-4">
                    <div class="flex-1 relative">
                        <input type="text" name="searchPegawai" placeholder="Masukkan NIP Pegawai"
                            value="{{ request('searchPegawai') }}" class="w-full border px-4 py-2 rounded-lg" />
                    </div>
                    <div>
                        <button type="submit" class="bg-[#00A181] text-white px-6 py-2 rounded-lg mt-2 md:mt-0">
                            Cari
                        </button>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm">Unit Kerja</label>
                        <select name="unit_kerja" class="w-full border px-3 py-2 rounded-lg">
                            <option value="">-- Pilih Unit Kerja --</option>
                            {{-- Isi dari controller --}}
                            @foreach ($unitkerjas as $unit)
                                <option value="{{ $unit->kode_kantor }}">{{ $unit->nama_kantor }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm">Jabatan Fungsionalitas</label>
                        <select name="jabatan_fungsional" class="w-full border px-3 py-2 rounded-lg">
                            <option value="">-- Pilih Jabatan Fungsional --</option>
                            {{-- Isi dari controller --}}
                            @foreach ($golongans as $jabatan)
                                <option value="{{ $jabatan->id_golongan }}">{{ $jabatan->jabatan_fungsional }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-4 text-sm text-gray-600">
                    <p>Petunjuk:</p>
                    <ul class="list-disc ml-6">
                        <li>Masukkan Unit Kerja yang bersangkutan</li>
                        <li>Masukkan Jabatan Fungsional</li>
                        <li>Klik Tombol Cari</li>
                    </ul>
                </div>
            </form>
        </div>

    </div>
@endsection
