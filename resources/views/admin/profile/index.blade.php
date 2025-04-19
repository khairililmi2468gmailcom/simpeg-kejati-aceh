@extends('layouts.app-admin')

@section('content')
    <h1 class="text-3xl font-bold text-[#00A181]">Profil Pengguna</h1>
    <p class="mb-12">Halaman profile pengguna</p>
    <div class="max-w-4xl mx-auto">

        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-6 border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-6 border border-red-300">
                <h3 class="font-bold mb-2">Terjadi Kesalahan:</h3>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg p-4 mb-6 transition-all duration-300 hover:shadow-xl">
            <form action="{{ route('admin.profile.update') }}" method="POST" id="profileForm" class="space-y-6">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#00A181] focus:border-[#00A181] placeholder-gray-400 transition-all"
                                placeholder="John Doe">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#00A181] focus:border-[#00A181] placeholder-gray-400 transition-all"
                                placeholder="email@example.com">
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100">
                    <button type="button" id="submitBtn"
                        class="cursor-pointer inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#00A181] hover:bg-[#008f72] transition-colors duration-200 shadow-sm">
                        <svg class="-ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#00A181',
            });
        @endif

        // Handle error messages
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan!',
                html: `
                    <ul class="text-left list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                confirmButtonColor: '#00A181',
            });
        @endif
        document.getElementById('submitBtn').addEventListener('click', function(e) {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();

            if (!name || !email) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lengkapi data',
                    text: 'Nama dan Email wajib diisi.',
                    confirmButtonColor: '#00A181',
                });
                return;
            }

            // Konfirmasi perubahan data
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
                    document.getElementById('profileForm').submit();
                }
            });
        });
    </script>
@endpush
