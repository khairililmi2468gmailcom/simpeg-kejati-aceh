@extends('layouts.app-admin')

@section('content')
    <div>
        <h1 class="text-3xl font-bold text-[#00A181]">Edit Diklat</h1>
        <p class="text-gray-600">Perbarui informasi Diklat</p>
    </div>

    <div class="max-w-xl mx-auto mt-6 p-6 bg-white shadow-md rounded-xl">
        <form action="{{ route('admin.cuti.jeniscuti.update', $cuti->id) }}" method="POST" id="editForm">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="jenis_cuti" class="block text-sm font-medium text-gray-700">Jenis Cuti</label>
                <input type="text" name="jenis_cuti" id="jenis_cuti"
                    value="{{ old('jenis_cuti', $cuti->jenis_cuti) }}"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]"
                    maxlength="50" required>
                @error('jenis_cuti')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.cuti.jeniscuti.index') }}"
                    class="px-4 py-2 mr-2 text-[#00A181] border border-[#00A181] rounded-lg hover:bg-[#00A181] hover:text-white transition">
                    Batal
                </a>
                <button type="button" id="submitBtn"
                    class="cursor-pointer px-4 py-2 bg-[#00A181] text-white rounded-lg hover:bg-[#009171] transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const jenis = document.getElementById('jenis_cuti').value.trim();

            if (!jenis) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Lengkapi data',
                    text: 'Nama dan Jenis Diklat wajib diisi.',
                    confirmButtonColor: '#00A181',
                });
            }
        });
        document.getElementById('submitBtn').addEventListener('click', function(e) {
            const jenis = document.getElementById('jenis_cuti').value.trim();

            if (!jenis) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lengkapi data',
                    text: 'Jenis Cuti wajib diisi.',
                    confirmButtonColor: '#00A181',
                });
                return;
            }

            // Menampilkan konfirmasi SweetAlert
            Swal.fire({
                title: 'Perbarui Data?',
                text: 'Apakah Anda yakin ingin memperbarui data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00A181',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika konfirmasi, kirim form
                    document.getElementById('editForm').submit();
                }
            });
        });
    </script>
@endpush
