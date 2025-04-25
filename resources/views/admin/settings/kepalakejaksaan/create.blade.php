@extends('layouts.app-admin')

@section('content')
    <div class="max-w-3xl mx-auto mt-10">
        <h1 class="text-3xl font-bold text-[#00A181] mb-6 text-center">Tambah Kepala Kejaksaan</h1>

        <div class="bg-white shadow-md rounded-xl p-8">
            <form id="createForm" action="{{ route('admin.settings.kepalakejaksaan.store') }}" method="POST">
                @csrf

                {{-- Input Nama --}}
                <div class="mb-6">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Kepala Kejaksaan</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181] focus:outline-none">
                    @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input NIP --}}
                <div class="mb-6">
                    <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                    <input type="text" name="nip" id="nip" value="{{ old('nip') }}"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181] focus:outline-none">
                    @error('nip')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Pangkat --}}
                <div class="mb-6">
                    <label for="pangkat" class="block text-sm font-medium text-gray-700 mb-1">Pangkat</label>
                    <input type="text" name="pangkat" id="pangkat" value="{{ old('pangkat') }}"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]">
                    @error('pangkat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Plt Checkbox --}}
                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="isPlt" class="form-checkbox text-[#00A181]"
                            {{ old('isPlt') ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700">Pejabat Pelaksana Tugas (Plt)</span>
                    </label>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-between items-center">
                    <a href="{{ route('admin.settings.index') }}"
                        class="text-gray-600 hover:text-[#00A181] hover:underline transition duration-150">← Kembali ke
                        Pengaturan</a>

                    <button type="button" id="submitBtn"
                        class="cursor-pointer bg-[#00A181] hover:bg-[#008F75] transition duration-150 text-white font-semibold px-6 py-2 rounded-lg shadow">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

{{-- Validasi Error Alert --}}
@if ($errors->any())
    <script>
        window.addEventListener('load', () => {
            let errorMessages = `{!! implode('\n', $errors->all()) !!}`;
            Swal.fire({
                title: 'Gagal Menyimpan',
                text: errorMessages,
                icon: 'error',
                confirmButtonColor: '#00A181',
            });
        });
    </script>
@endif

{{-- SweetAlert Konfirmasi --}}
@push('scripts')
    <script>
        document.getElementById('submitBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Tambah Kepala Kejaksaan?',
                text: "Apakah Anda yakin ingin menyimpan data ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00A181',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('createForm').submit();
                }
            });
        });
    </script>
@endpush
