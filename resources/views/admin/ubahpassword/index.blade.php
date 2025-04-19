@extends('layouts.app-admin')

@section('content')
    <h1 class="text-3xl font-bold text-[#00A181]">Ubah Password</h1>
    <p class="mb-12">Halaman ubah password account</p>
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
            <form action="{{ route('admin.ubahpassword.update') }}" method="POST" id="ubahPasswordForm" class="space-y-6">
                @csrf

                <div class="space-y-4">
                    {{-- Password Baru --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="password">Password Baru</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="password" name="password" id="password"
                                class="block w-full px-4 py-3 pr-12 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#00A181] focus:border-[#00A181] placeholder-gray-400 transition-all"
                                placeholder="Masukkan password baru">
                            <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer"
                                onclick="togglePassword('password')">
                                {{-- Eye Open --}}
                                <svg id="eye-password-show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                                </svg>

                                {{-- Eye Closed --}}
                                <svg id="eye-password-hide" xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-gray-500 hidden" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 012.219-3.419M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                </svg>
                            </span>

                        </div>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="password_confirmation">Konfirmasi
                            Password</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="block w-full px-4 py-3 pr-12 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#00A181] focus:border-[#00A181] placeholder-gray-400 transition-all"
                                placeholder="Ulangi password baru">
                            <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer"
                                onclick="togglePassword('password_confirmation')">
                                {{-- Eye Open --}}
                                <svg id="eye-password_confirmation-show" xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                                </svg>

                                {{-- Eye Closed --}}
                                <svg id="eye-password_confirmation-hide" xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-gray-500 hidden" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 012.219-3.419M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                </svg>
                            </span>

                        </div>
                    </div>
                </div>
                <div class="pt-6 border-t border-gray-100">
                    <button type="button" id="submitBtn"
                        class="cursor-pointer inline-flex items-center justify-center px-6 py-3 border border-transparent password-base font-medium rounded-md text-white bg-[#00A181] hover:bg-[#008f72] transition-colors duration-200 shadow-sm">
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

        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            const eyeShow = document.getElementById('eye-' + fieldId + '-show');
            const eyeHide = document.getElementById('eye-' + fieldId + '-hide');

            if (input.type === 'password') {
                input.type = 'text';
                eyeShow.classList.add('hidden');
                eyeHide.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeShow.classList.remove('hidden');
                eyeHide.classList.add('hidden');
            }
        }

        document.getElementById('submitBtn').addEventListener('click', function() {
            const password = document.getElementById('password').value.trim();
            const confirmPassword = document.getElementById('password_confirmation').value.trim();
            const passwordPattern = /^(?=.*[A-Z])(?=.*\d).{8,}$/;
          
            if (!password || !confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lengkapi Data',
                    text: 'Password dan konfirmasi password wajib diisi.',
                    confirmButtonColor: '#00A181',
                });
                return;
            }

            if (password !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Tidak Sama',
                    text: 'Password dan konfirmasi password tidak cocok.',
                    confirmButtonColor: '#00A181',
                });
                return;
            }
            if (!passwordPattern.test(password)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Tidak Aman',
                    text: 'Password harus minimal 8 karakter, mengandung huruf besar dan angka.',
                    confirmButtonColor: '#00A181',
                });
                return;
            }

            Swal.fire({
                title: 'Ubah Password?',
                text: 'Apakah Anda yakin ingin mengubah password?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00A181',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('ubahPasswordForm').submit();
                }
            });
        });
    </script>
@endpush
