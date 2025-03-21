@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    <div class="flex h-screen items-center justify-center bg-white bg-center">
        <div class="bg-[#F0F0F0] p-8 shadow-lg rounded-lg max-w-sm w-full mx-4">
            <h1 class="text-4xl font-bold text-[#00A180] text-center">Login</h1>
            <p class="text-center text-gray-600 mb-4">Silakan masuk ke akun Anda</p>

            <div class="mb-4">
                <label class="block text-gray-700">NIP</label>
                <input id="nip" type="text" maxlength="18" placeholder="Masukkan NIP..." oninput="validateNIP(event)"
                    class="input-field w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A180]">
                <p class="error-message hidden" id="error-nip">NIP harus 18 digit</p>
                <p class="error-message hidden" id="error-nip-length"></p>
            </div>

            <div class="mb-10 relative">
                <label class="block text-gray-700">Password</label>
                <div class="relative">
                    <input id="password" type="password" placeholder="Masukkan password..."
                        class="input-field w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A180]">
                    <button type="button" id="togglePassword"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-500 cursor-pointer">
                        👁️
                    </button>
                </div>
                <p class="error-message hidden" id="error-password">Password tidak boleh kosong</p>
            </div>

            <button id="loginBtn"
                class="w-full bg-[#00A180] text-white py-2 rounded-full hover:bg-[#008F70] transition duration-200 text-center">
                Login
            </button>

            {{-- <p class="text-center text-gray-600 mt-4">
                Belum punya akun?
                <a hx-get="/register" hx-target="body" class="text-[#00A180] font-bold hover:underline">Daftar di sini</a>
            </p> --}}
        </div>
    </div>

    <!-- Modal Notifikasi -->
    <div id="modalNotification" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center max-w-sm">
            <h2 id="modalTitle" class="text-lg font-semibold"></h2>
            <p id="modalMessage" class="text-gray-600 mt-2"></p>
            <button id="closeModalBtn" class="mt-4 px-4 py-2 bg-[#00A180] text-white rounded-md">OK</button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function showModal(title, message) {
                document.getElementById("modalTitle").innerText = title;
                document.getElementById("modalMessage").innerText = message;
                document.getElementById("modalNotification").classList.remove("hidden");
            }

            function closeModal() {
                document.getElementById("modalNotification").classList.add("hidden");
            }

            // Pastikan tombol OK menutup modal
            document.getElementById("closeModalBtn").addEventListener("click", closeModal);

            // Toggle Password Visibility
            document.getElementById("togglePassword").addEventListener("click", function() {
                let passwordInput = document.getElementById("password");
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    this.innerHTML = "🙈"; // Mata tertutup
                } else {
                    passwordInput.type = "password";
                    this.innerHTML = "👁️"; // Mata terbuka
                }
            });

            // Menghilangkan error saat mulai mengetik
            document.querySelectorAll(".input-field").forEach(input => {
                input.addEventListener("input", function() {
                    let errorElement = document.getElementById(`error-${this.id}`);
                    if (errorElement) {
                        errorElement.classList.add("hidden");
                    }
                });
            });

            // Validasi NIP
            function validateNIP(event) {
                let input = event.target;
                input.value = input.value.replace(/\D/g, ''); // Hanya angka yang boleh dimasukkan

                let nipLength = input.value.length;
                let errorLength = document.getElementById("error-nip-length");

                if (nipLength < 18) {
                    errorLength.innerText = `Kurang ${18 - nipLength} karakter`;
                    errorLength.classList.remove("hidden");
                } else {
                    errorLength.classList.add("hidden");
                }
            }

            document.getElementById("nip").addEventListener("input", validateNIP);

            // Validasi Form Saat Login Diklik
            document.getElementById("loginBtn").addEventListener("click", function() {
                let nip = document.getElementById("nip").value.trim();
                let password = document.getElementById("password").value.trim();

                let isValid = true;
                let errors = {
                    nip: nip.length !== 18,
                    password: password === "",
                };

                Object.keys(errors).forEach(key => {
                    let errorElement = document.getElementById(`error-${key}`);
                    if (errorElement) {
                        errorElement.classList.toggle("hidden", !errors[key]);
                    }
                    if (errors[key]) isValid = false;
                });

                if (isValid) {
                    showModal("Login Berhasil", "Anda akan masuk ke halaman dashboard.");
                } else {
                    showModal("Login Gagal", "Periksa kembali data yang Anda isi.");
                }
            });
        });
    </script>

    <style>
        .error-message {
            color: red;
            font-size: 14px;
        }

        .hidden {
            display: none;
        }
    </style>
@endsection
`
