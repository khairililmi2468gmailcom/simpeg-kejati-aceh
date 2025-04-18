@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    <!-- CDN SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="flex h-screen items-center justify-center bg-[#F0F0F0] bg-center">
        <div class="bg-white p-8 shadow-lg rounded-lg max-w-sm w-full mx-4">
            <h1 class="text-4xl font-bold text-[#00A180] text-center">Login</h1>
            <p class="text-center text-gray-600 mb-4">Silakan masuk ke akun Anda</p>

            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input id="email" type="email" placeholder="Masukkan email..."
                    class="input-field w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A180]">
                <p class="error-message hidden" id="error-email">Format email tidak valid</p>
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
                class="cursor-pointer w-full bg-[#00A180] text-white py-2 rounded-full hover:bg-[#008F70] transition duration-200 text-center">
                Login
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
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    this.innerHTML = "🙈";
                } else {
                    passwordInput.type = "password";
                    this.innerHTML = "👁️";
                }
            });

            document.querySelectorAll(".input-field").forEach(input => {
                input.addEventListener("input", function() {
                    let errorElement = document.getElementById(`error-${this.id}`);
                    if (errorElement) {
                        errorElement.classList.add("hidden");
                    }
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
                errorElement.classList.add("hidden");
                return true;
            }

            document.getElementById("email").addEventListener("input", validateEmail);

            document.getElementById("loginBtn").addEventListener("click", function() {
                let email = document.getElementById("email").value.trim();
                let password = document.getElementById("password").value.trim();
                let isValid = true;

                if (!validateEmail({
                        target: {
                            value: email
                        }
                    })) {
                    isValid = false;
                }

                if (password === "") {
                    document.getElementById("error-password").classList.remove("hidden");
                    isValid = false;
                }

                if (isValid) {
                    fetch('/login', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            },
                            body: JSON.stringify({
                                email: email,
                                password: password
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showSwal("Login Berhasil", "Anda akan diarahkan ke dashboard.");
                                setTimeout(() => window.location.href = '/admin/home', 1500);
                            } else {
                                showSwal("Login Gagal", data.message || "Email atau password salah",
                                    false);
                            }
                        });
                } else {
                    showSwal("Login Gagal", "Periksa kembali data yang Anda isi.", false);
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
