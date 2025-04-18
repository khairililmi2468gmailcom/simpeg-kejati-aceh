@extends('layouts.app-admin')

@section('content')
    <div class="space-y-12">
        <div class="border-b border-gray-900/10 pb-12">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-3xl font-semibold text-[#00A181]">Detail Riwayat Mutasi</h2>
                    <p class="mt-1 text-sm text-gray-600">Informasi lengkap mengenai riwayat mutasi pegawai.</p>
                </div>
                <a href="{{ route('admin.mutasi.index') }}"
                    class="inline-flex items-center text-[#00A181] border border-[#00A181] hover:bg-[#00A181] hover:text-white font-medium rounded-lg px-4 py-2 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>
            </div>

            <div class="mt-10 space-y-12 text-gray-800 bg-white p-8 rounded-xl">
                {{-- GROUP 1: Data Pegawai --}}
                <div>
                    <h3 class="text-lg font-semibold text-[24px] text-[#00A181] mb-4">Data Pegawai</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-6 gap-x-6 gap-y-6">
                        <x-display label="NIP" class="sm:col-span-3">{{ $data->pegawai->nip }}</x-display>
                        <x-display label="Nama Pegawai" class="sm:col-span-3">{{ $data->pegawai->nama }}</x-display>
                    </div>
                </div>

                {{-- GROUP 2: Data Diklat --}}
                <div>
                    <h3 class="text-lg font-semibold text-[24px] text-[#00A181] mb-4">Data Diklat</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-6 gap-x-6 gap-y-6">
                        <x-display label="No. SK" class="sm:col-span-3">{{ $data->no_sk }}</x-display>
                        <x-display label="Jabatan Saat Ini" class="sm:col-span-3">{{ $data->pegawai->jabatan->nama_jabatan  ?? '-'}}</x-display>
                        <x-display label="Keterangan Jabatan" class="sm:col-span-3">{{ $data->pegawai->jabatan->ket ?? '-' }}</x-display>
                        <x-display label="Jabatan Lama" class="sm:col-span-3">{{ $data->jabatan_l ?? '-' }}</x-display>
                        <x-display label="Unit Saat Ini" class="sm:col-span-3">{{ $data->pegawai->unitkerja->nama_kantor ?? '-' }}</x-display>
                        <x-display label="Unit Kerja Lama" class="sm:col-span-3">{{ $data->tempat_l ?? '-' }}</x-display>
                        <x-display label="Tanggal SK" class="sm:col-span-3">{{ \Carbon\Carbon::parse( $data->tanggal_sk ?? '-')->format('d M Y') }}</x-display>
                        <x-display label="TMT Lama" class="sm:col-span-3">{{ \Carbon\Carbon::parse( $data->tmt_l )->format('d M Y') : '-'  }}</x-display>
                        <x-display label="Terhitung Mulai Tanggal Jabatan" class="sm:col-span-3">{{ \Carbon\Carbon::parse( $data->tmt_jabatan )->format('d M Y') : '-' }}</x-display>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
