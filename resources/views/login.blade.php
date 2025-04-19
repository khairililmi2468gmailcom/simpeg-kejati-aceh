@extends('layouts.app')

@section('title', 'Login - SIMPEG Kajati Aceh')

@section('content')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="flex h-screen items-center justify-center bg-[#F0F0F0] px-4">
        <div class="bg-white p-10 shadow-2xl rounded-3xl w-full max-w-md md:max-w-xl lg:max-w-2xl animate-fade-in">
            <div class="mb-8 text-center">
                <img src="{{ asset('image/logo.png') }}" alt="Logo Kejati Aceh" class="mx-auto mb-4 w-20 h-20">
                <h1 class="text-5xl font-extrabold text-[#00A180] mb-2 tracking-tight">SIMPEG</h1>
                <h2 class="text-xl font-semibold text-gray-700">Kejaksaan Tinggi Provinsi Aceh</h2>
                <p class="mt-2 text-gray-500">Silakan masuk ke akun Anda</p>
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 mb-1">Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-[#00A180]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 12H8m0 0l-4 4m4-4l-4-4m16 8V8a2 2 0 00-2-2H6a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2z" />
                        </svg>
                    </span>
                    <input id="email" type="email" placeholder="Masukkan email..."
                        class="input-field w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00A180]">
                </div>
                <p class="error-message hidden mt-1" id="error-email">Format email tidak valid</p>
            </div>

            <div class="mb-8">
                <label class="block text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-[#00A180]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11c0-1.105-.895-2-2-2s-2 .895-2 2m8 0c0-1.105-.895-2-2-2s-2 .895-2 2m4 4h.01M16 4h.01M8 4h.01M21 12c0 4.418-4.03 8-9 8s-9-3.582-9-8 4.03-8 9-8 9 3.582 9 8z" />
                        </svg>
                    </span>
                    <input id="password" type="password" placeholder="Masukkan password..."
                        class="input-field w-full pl-10 pr-10 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00A180]">
                    <button type="button" id="togglePassword"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-500 cursor-pointer text-sm">
                        <!-- Mata Terbuka -->
                        <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <!-- Mata Tertutup -->
                        <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.978 9.978 0 012.223-3.592M9.88 9.88a3 3 0 104.24 4.24" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                        </svg>
                    </button>

                </div>
                <p class="error-message hidden mt-1" id="error-password">Password tidak boleh kosong</p>
            </div>

            <button id="loginBtn"
                class="cursor-pointer w-full bg-[#00A180] text-white py-3 text-lg rounded-xl hover:bg-[#008F70] transition duration-200 text-center font-semibold shadow-md hover:shadow-lg">
                🔐 Masuk
            </button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function showSwal(title, message, isSuccess = true) {
                Swal.fire({
                    icon: isSuccess ? 'success' : 'error',
                    title: title,
                    text: message,
                    confirmButtonColor: '#00A180'
                });
            }

            document.getElementById("togglePassword").addEventListener("click", function() {
                let passwordInput = document.getElementById("password");
                let eyeOpen = document.getElementById("eyeOpen");
                let eyeClosed = document.getElementById("eyeClosed");

                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    eyeOpen.classList.add("hidden");
                    eyeClosed.classList.remove("hidden");
                } else {
                    passwordInput.type = "password";
                    eyeOpen.classList.remove("hidden");
                    eyeClosed.classList.add("hidden");
                }
            });


            document.querySelectorAll(".input-field").forEach(input => {
                input.addEventListener("input", function() {
                    let errorElement = document.getElementById(`error-${this.id}`);
                    if (errorElement) errorElement.classList.add("hidden");
                });
            });

            function validateEmail(event) {
                let email = event.target.value;
                let errorElement = document.getElementById("error-email");
                let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    errorElement.classList.remove("hidden");
                    return false;
                }
                return true;
            }


            document.getElementById("email").addEventListener("input", function() {
                let errorElement = document.getElementById("error-email");
                errorElement.classList.add("hidden");
            });

            document.getElementById("loginBtn").addEventListener("click", function() {
                let email = document.getElementById("email").value.trim();
                let password = document.getElementById("password").value.trim();
                let isValid = true;
                const loginBtn = this;

                if (!validateEmail({
                        target: {
                            value: email
                        }
                    })) isValid = false;
                if (password === "") {
                    document.getElementById("error-password").classList.remove("hidden");
                    isValid = false;
                }

                if (isValid) {
                    loginBtn.disabled = true;
                    loginBtn.innerText = "Memproses...";

                    fetch('/login', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            },
                            body: JSON.stringify({
                                email,
                                password
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            loginBtn.disabled = false;
                            loginBtn.innerText = "🔐 Masuk";

                            if (data.success) {
                                showSwal("Login Berhasil", "Anda akan diarahkan ke dashboard.");
                                setTimeout(() => window.location.href = '/admin/home', 1500);
                            } else {
                                showSwal("Login Gagal", data.message || "Email atau password salah",
                                    false);
                            }
                        })
                        .catch(() => {
                            loginBtn.disabled = false;
                            loginBtn.innerText = "🔐 Masuk";
                            showSwal("Kesalahan Server", "Tidak dapat terhubung ke server.", false);
                        });
                } else {
                    showSwal("Login Gagal", "Periksa kembali data yang Anda isi.", false);
                }
            });
        });
    </script>

    <style>
        .error-message {
            color: #e11d48;
            /* merah tailwind */
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .hidden {
            display: none;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.5s ease-in-out;
        }
    </style>
@endsection
