@extends('layouts.app-admin')

@section('content')
    <div class="space-y-12">
        <div class="border-b border-gray-900/10 pb-12">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-3xl font-semibold text-[#00A181]">Detail Riwayat Diklat</h2>
                    <p class="mt-1 text-sm text-gray-600">Informasi lengkap mengenai riwayat diklat pegawai.</p>
                </div>
                <a href="{{ route('admin.diklat.riwayat.index') }}"
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
                        <x-display label="No. STTPP" class="sm:col-span-3">{{ $data->no_sttpp }}</x-display>
                        <x-display label="Nama Diklat" class="sm:col-span-3">{{ $data->diklat->nama_diklat }}</x-display>
                        <x-display label="Jenis Diklat" class="sm:col-span-3">{{ $data->diklat->jenis_diklat }}</x-display>
                        <x-display label="Tempat Diklat" class="sm:col-span-3">{{ $data->tempat_diklat }}</x-display>
                        <x-display label="Penyelenggara" class="sm:col-span-2">{{ $data->penyelenggara }}</x-display>
                        <x-display label="Angkatan" class="sm:col-span-2">{{ $data->angkatan ?? '-' }}</x-display>
                        <x-display label="Jumlah Jam" class="sm:col-span-2">{{ $data->jumlah_jam }} jam</x-display>
                    </div>
                </div>

                {{-- GROUP 3: Waktu dan Durasi --}}
                <div>
                    <h3 class="text-lg font-semibold text-[24px] text-[#00A181] mb-4">Waktu dan Durasi</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-6 gap-x-6 gap-y-6">
                        <x-display label="Tanggal Mulai"
                            class="sm:col-span-3">{{ \Carbon\Carbon::parse($data->tanggal_mulai)->format('d M Y') }}</x-display>
                        <x-display label="Tanggal Selesai"
                            class="sm:col-span-3">{{ \Carbon\Carbon::parse($data->tanggal_selesai)->format('d M Y') }}</x-display>
                        <x-display label="Tanggal STTPP"
                            class="sm:col-span-3">{{ \Carbon\Carbon::parse($data->tanggal_sttpp)->format('d M Y') }}</x-display>
                    </div>
                </div>

                {{-- GROUP 4: Dokumen Pendukung --}}
                @if ($data->file_sttpp)
                    <div>
                        <h3 class="text-lg font-semibold text-[#00A181] mb-4">📎 Dokumen Pendukung</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-6 gap-x-6 gap-y-6">
                            <div class="sm:col-span-6">
                                <label class="block text-sm font-medium text-gray-900">File STTPP</label>
                                <div class="mt-1">
                                    <a href="{{ asset('storage/' . $data->file_sttpp) }}" target="_blank"
                                        class="text-blue-600 hover:underline">📄 Lihat File STTPP</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
