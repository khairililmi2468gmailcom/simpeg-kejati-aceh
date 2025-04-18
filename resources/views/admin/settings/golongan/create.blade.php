@extends('layouts.app-admin')

@section('content')
    <div>
        <h1 class="text-3xl font-bold text-[#00A181]">Tambah Golongan</h1>
        <p class="text-gray-600">Tambahkan golongan baru.</p>
    </div>

    <div class="max-w-3xl mx-auto mt-6 p-6 bg-white shadow-md rounded-xl">
        <form id="createForm" action="{{ route('admin.settings.golongan.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="id_golongan" class="block text-sm font-medium text-gray-700">Kode Golongan</label>
                <input type="text" name="id_golongan" id="id_golongan" value="{{ old('id_golongan') }}" maxlength="5"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]"
                    required>
                @error('id_golongan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="jabatan_fungsional" class="block text-sm font-medium text-gray-700">Jabatan Fungsional</label>
                <input type="text" name="jabatan_fungsional" id="jabatan_fungsional"
                    value="{{ old('jabatan_fungsional') }}" maxlength="25"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]"
                    required>
                @error('jabatan_fungsional')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="pangkat" class="block text-sm font-medium text-gray-700">Pangkat</label>
                <input type="text" name="pangkat" id="pangkat" value="{{ old('pangkat') }}" maxlength="25"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]"
                    required>
                @error('pangkat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>



            {{-- Tombol --}}
            <div class="flex justify-end">
                <a href="{{ route('admin.settings.index') }}"
                    class="px-4 py-2 mr-2 text-[#00A181] border border-[#00A181] rounded-lg hover:bg-[#00A181] hover:text-white transition">
                    Batal
                </a>
                <button type="button" id="submitBtn"
                    class="cursor-pointer px-4 py-2 bg-[#00A181] text-white rounded-lg hover:bg-[#009171] transition">
                    Simpan Jabatan
                </button>
            </div>
        </form>
    </div>
@endsection
@if ($errors->any())
    <script>
        window.addEventListener('load', () => {
            let errorMessages = `{{ implode('\n', $errors->all()) }}`;
            Swal.fire({
                title: 'Gagal Menyimpan',
                text: errorMessages,
                icon: 'error',
                confirmButtonColor: '#00A181',
            });
        });
    </script>
@endif
@push('scripts')
    <script>
        document.getElementById('submitBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Tambah Jabatan?',
                text: "Apakah Anda yakin ingin menambahkan jabatan baru?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00A181',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Tambah',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('createForm').submit();
                }
            });
        });
    </script>
@endpush
