@extends('layouts.app')

@section('title', 'Register Page')

@section('content')
    <div class="flex h-screen items-center justify-center bg-white bg-center px-10 py-8">
        <div class="bg-[#F0F0F0] p-8 shadow-lg rounded-lg max-w-2xl w-full mx-8 my-8">
            <h1 class="text-4xl font-bold text-[#00A180] text-center mb-4">Register</h1>
            <p class="text-center text-gray-600 mb-6">Silakan daftar akun baru Anda</p>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700">Nama</label>
                    <input id="name" type="text" placeholder="Masukkan nama..." class="input-field">
                    <p class="error-message hidden" id="error-name">Nama tidak boleh kosong</p>
                </div>

                <div>
                    <label class="block text-gray-700">NIP</label>
                    <input id="nip" type="text" placeholder="Masukkan NIP..." maxlength="18" class="input-field"
                        oninput="validateNIP(event)">
                    <p class="error-message hidden" id="error-nip">NIP harus 18 digit</p>
                    <p class="error-message hidden" id="error-nip-length"></p>
                </div>

                <div class="col-span-2">
                    <label class="block text-gray-700">Email</label>
                    <input id="email" type="email" placeholder="Masukkan email..." class="input-field">
                    <p class="error-message hidden" id="error-email">Format email tidak valid</p>
                </div>

                <div class="relative">
                    <label class="block text-gray-700">Password</label>
                    <div class="relative">
                        <input id="password" type="password" placeholder="Masukkan password..." class="input-field pr-10">
                        <button type="button" id="togglePassword" class="toggle-password">👁️</button>
                    </div>
                    <p class="error-message hidden" id="error-password">Password tidak boleh kosong</p>
                </div>

                <div class="relative">
                    <label class="block text-gray-700">Konfirmasi Password</label>
                    <div class="relative">
                        <input id="confirmPassword" type="password" placeholder="Masukkan konfirmasi password..."
                            class="input-field pr-10">
                        <button type="button" id="toggleConfirmPassword" class="toggle-password">👁️</button>
                    </div>
                    <p class="error-message hidden" id="error-confirmPassword">Konfirmasi password tidak boleh kosong</p>
                    <p class="error-message hidden" id="error-passwordMatch">Password dan konfirmasi harus sama</p>
                </div>
            </div>

            <button id="registerBtn" class="btn-primary mt-6">Register</button>

            <p class="text-center text-gray-600 mt-4">
                Sudah punya akun?
                <a hx-get="/" hx-target="body" class="text-[#00A180] font-bold hover:underline">Masuk di sini</a>
            </p>
        </div>
    </div>

    <!-- Modal Notifikasi -->
    <div id="modalNotification" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center max-w-sm">
            <h2 id="modalTitle" class="text-lg font-semibold"></h2>
            <p id="modalMessage" class="text-gray-600 mt-2"></p>
            <button onclick="closeModal()" class="mt-4 px-4 py-2 bg-[#00A180] text-white rounded-md">OK</button>
        </div>
    </div>

    <script>
        function showModal(title, message) {
            document.getElementById("modalTitle").innerText = title;
            document.getElementById("modalMessage").innerText = message;
            document.getElementById("modalNotification").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("modalNotification").classList.add("hidden");
        }

        // Menghilangkan pesan error saat input mulai diisi ulang
        document.querySelectorAll(".input-field").forEach(input => {
            input.addEventListener("input", function() {
                let errorElement = document.getElementById(`error-${this.id}`);
                if (errorElement) {
                    errorElement.classList.add("hidden");
                }
            });
        });

        // Toggle Password Visibility
        document.querySelectorAll(".toggle-password").forEach(button => {
            button.addEventListener("click", function() {
                let input = this.previousElementSibling;
                if (input.type === "password") {
                    input.type = "text";
                    this.innerHTML = "🙈"; // Ikon mata tertutup
                } else {
                    input.type = "password";
                    this.innerHTML = "👁️"; // Ikon mata terbuka
                }
            });
        });

        // Prevent non-numeric input & enforce 18 digits for NIP
        function validateNIP(event) {
            let input = event.target;
            input.value = input.value.replace(/\D/g, ''); // Hanya angka yang boleh masuk

            let nipLength = input.value.length;
            let errorLength = document.getElementById("error-nip-length");

            if (nipLength < 18) {
                errorLength.innerText = `Kurang ${18 - nipLength} karakter`;
                errorLength.classList.remove("hidden");
            } else {
                errorLength.classList.add("hidden");
            }
        }

        // Validasi Form Saat Register Diklik
        document.getElementById("registerBtn").addEventListener("click", function() {
            let name = document.getElementById("name").value.trim();
            let nip = document.getElementById("nip").value.trim();
            let email = document.getElementById("email").value.trim();
            let password = document.getElementById("password").value.trim();
            let confirmPassword = document.getElementById("confirmPassword").value.trim();

            let isValid = true;
            let errors = {
                name: name === "",
                nip: nip.length !== 18,
                email: !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email),
                password: password === "",
                confirmPassword: confirmPassword === "",
                passwordMatch: password !== confirmPassword,
            };

            Object.keys(errors).forEach(key => {
                let errorElement = document.getElementById(`error-${key}`);
                if (errorElement) {
                    errorElement.classList.toggle("hidden", !errors[key]);
                }
                if (errors[key]) isValid = false;
            });

            if (isValid) {
                showModal("Registrasi Berhasil", "Akun Anda telah terdaftar!");
            } else {
                showModal("Registrasi Gagal", "Periksa kembali data yang Anda isi.");
            }
        });
    </script>

    <style>
        .input-field {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border 0.3s ease;
        }

        .input-field:focus {
            border-color: #00A180;
            box-shadow: 0 0 5px #00A180;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            background: none;
            border: none;
            font-size: 18px;
        }

        .btn-primary {
            width: 100%;
            background: #00A180;
            color: white;
            padding: 12px;
            border-radius: 50px;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background: #008F70;
        }

        .error-message {
            color: red;
            font-size: 14px;
        }

        .hidden {
            display: none;
        }
    </style>
@endsection
