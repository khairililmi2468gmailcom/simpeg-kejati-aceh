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
                <input type="text" name="nama_provinsi" id="nama_provinsi" value="{{ old('nama_provinsi') }}"
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
                <button type="submit" id="submitBtn"
                    class="cursor-pointer px-4 py-2 bg-[#00A181] text-white rounded-lg hover:bg-[#009171] transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const submitBtn = document.getElementById('submitBtn');
            const form = document.getElementById('form-provinsi');

            submitBtn.addEventListener('click', function(e) {
                e.preventDefault();

                const nama = document.getElementById('nama_provinsi').value.trim();

                if (!nama) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lengkapi data',
                        text: 'Nama provinsi wajib diisi.',
                        confirmButtonColor: '#00A181',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Simpan Data?',
                    text: 'Apakah Anda yakin ingin menyimpan data ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#00A181',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    timer: 2500,
                    showConfirmButton: false
                });
            @endif

            @if ($errors->has('nama_provinsi'))
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
