@extends('layouts.app-admin')

@section('content')
    @php
        $tab = request('tab', 'pegawai');

        $titles = [
            'pegawai' => 'Pegawai',
            'cuti' => 'Cuti',
            'diklat' => 'Diklat',
            'mutasi' => 'Mutasi',
            'kepangkatan' => 'Kepangkatan',
        ];

        $currentTitle = $titles[$tab] ?? 'Laporan';
    @endphp
    <div class="p-6">
        <h1 class="text-3xl font-bold text-[#00A181]">Laporan {{ $currentTitle }}</h1>
        <p class="text-gray-600 mb-8">Halaman laporan {{ strtolower($currentTitle) }}</p> {{-- Tab Navigasi --}}
        @php
            $tab = request('tab', 'pegawai');
        @endphp

        <div class="flex space-x-2 mb-6 overflow-x-auto scrollbar-hide">
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

    </div>
@endsection
