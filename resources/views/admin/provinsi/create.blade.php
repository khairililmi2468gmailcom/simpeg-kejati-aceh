@extends('layouts.app-admin')

@section('content')
<div>
    <h1 class="text-3xl font-bold text-[#00A181]">Tambah Provinsi</h1>
    <p class="text-gray-600">Masukkan nama provinsi baru</p>
</div>

<div class="max-w-xl mx-auto mt-6 p-6 bg-white shadow-md rounded-xl">
    <form id="form-provinsi" action="{{ route('admin.provinsi.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="nama_provinsi" class="block text-sm font-medium text-gray-700">Nama Provinsi</label>
            <input type="text" name="nama_provinsi" id="nama_provinsi"
                value="{{ old('nama_provinsi') }}"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]"
                maxlength="30" required>
            @error('nama_provinsi')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.provinsi.index') }}"
               class="px-4 py-2 mr-2 text-[#00A181] border border-[#00A181] rounded-lg hover:bg-[#00A181] hover:text-white transition">
               Batal
            </a>
            <button type="submit"
                class="cursor-pointer px-4 py-2 bg-[#00A181] text-white rounded-lg hover:bg-[#009171] transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('form-provinsi');
        form.addEventListener('submit', function(e) {
            const nama = document.getElementById('nama_provinsi').value.trim();

            if (nama === '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Nama Provinsi harus diisi!',
                    confirmButtonColor: '#00A181'
                });
            }
        });

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: false
            });
        @endif

        @if($errors->has('nama_provinsi'))
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                text: '{{ $errors->first('nama_provinsi') }}',
                confirmButtonColor: '#00A181'
            });
        @endif
    });
</script>
@endpush
