@extends('layouts.app-admin')

@section('content')
    <div>
        <h1 class="text-3xl font-bold text-[#00A181]">Tambah Mutasi</h1>
        <p class="text-gray-600">Masukkan informasi mutasi pegawai.</p>
    </div>

    <div class="max-w-3xl mx-auto mt-6 p-6 bg-white shadow-md rounded-xl">
        <form id="createForm" action="{{ route('admin.kepangkatan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="no_sk" class="block text-sm font-medium text-gray-700">No. SK</label>
                <input type="text" name="no_sk" id="no_sk" value="{{ old('no_sk') }}" maxlength="50"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]"
                    required>
                @error('no_sk')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Pegawai --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pegawai</label>
                <div class="custom-select group relative">
                    <div class="selected-item flex items-center justify-between cursor-pointer w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm hover:border-gray-400"
                        onclick="toggleDropdown('pegawai')">
                        <span id="pegawai-display">Pilih Pegawai</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <div id="pegawai-dropdown"
                        class="dropdown-content hidden absolute w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-50 max-h-64 overflow-y-auto">
                        <input type="text"
                            class="search-input w-full px-3 py-2 border-b border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00A181] rounded-t-lg"
                            placeholder="Cari Pegawai..." onkeyup="filterOptions('pegawai', this.value)">
                        <div class="options" id="pegawai-options">
                            @foreach ($pegawaiList as $pegawai)
                                <div class="option-item px-3 py-2 hover:bg-gray-100 cursor-pointer transition-colors"
                                    data-value="{{ $pegawai->nip }}"
                                    onclick='selectItem("pegawai", @json($pegawai->nip), @json($pegawai->nama . " ($pegawai->nip)"))'>
                                    {{ $pegawai->nama }} ({{ $pegawai->nip }})
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <input type="hidden" name="nip" id="pegawai-input" value="{{ old('nip') }}">
                @error('nip')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Golongan --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Golongan</label>
                <div class="custom-select group relative">
                    <div class="selected-item flex items-center justify-between cursor-pointer w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm hover:border-gray-400"
                        onclick="toggleDropdown('golongan')">
                        <span id="golongan-display">Pilih Golongan</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <div id="golongan-dropdown"
                        class="dropdown-content hidden absolute w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-50 max-h-64 overflow-y-auto">
                        <input type="text"
                            class="search-input w-full px-3 py-2 border-b border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00A181] rounded-t-lg"
                            placeholder="Cari golongan..." onkeyup="filterOptions('golongan', this.value)">
                        <div class="options" id="golongan-options">
                            @foreach ($golonganList as $golongan)
                                <div class="option-item px-3 py-2 hover:bg-gray-100 cursor-pointer transition-colors"
                                    data-value="{{ $golongan->id_golongan }}"
                                    onclick='selectItem("golongan", @json($golongan->id_golongan), @json($golongan->jabatan_fungsional))'>
                                    {{ $golongan->jabatan_fungsional }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id_golongan" id="golongan-input" value="{{ old('id_golongan') }}">
                @error('id_golongan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="no_pertimbangan" class="block text-sm font-medium text-gray-700">No. Pertimbangan</label>
                <input type="text" inputmode="numeric" pattern="\d*" name="no_pertimbangan" id="no_pertimbangan" value="{{ old('no_pertimbangan') }}"
                    maxlength="60"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]"
                    required>
                @error('no_pertimbangan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="pembuat_sk" class="block text-sm font-medium text-gray-700">Pembuat SK</label>
                <input type="text" name="pembuat_sk" id="pembuat_sk" value="{{ old('pembuat_sk') }}" maxlength="50"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]"
                    required>
                @error('pembuat_sk')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="no_usulan" class="block text-sm font-medium text-gray-700">No. Usulan</label>
                <input type="text" name="no_usulan" id="no_usulan" value="{{ old('no_usulan') }}" maxlength="50"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]"
                    required>
                @error('no_usulan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="jenis_usulan" class="block text-sm font-medium text-gray-700">Jenis Usulan</label>
                <input type="text" name="jenis_usulan" id="jenis_usulan" value="{{ old('jenis_usulan') }}" maxlength="25"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]"
                    required>
                @error('jenis_usulan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="pangkat_l" class="block text-sm font-medium text-gray-700">Pangkat Lama</label>
                <input type="text" name="pangkat_l" id="pangkat_l" value="{{ old('pangkat_l') }}" maxlength="25"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]"
                    required>
                @error('pangkat_l')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- Tanggal SK, TMT Jabatan --}}
            @foreach (['tanggal_sk' => 'Tanggal SK', 'tmt_sk_pangkat' => 'TMT SK Pangkat'] as $field => $label)
                <div class="mb-4">
                    <label for="{{ $field }}"
                        class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                    <div class="relative max-w-sm">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input name="{{ $field }}" id="{{ $field }}" type="date"
                            value="{{ old($field) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                            required>
                    </div>
                    @error($field)
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach
            <div class="mb-4">
                <label for="alasan" class="block text-sm font-medium text-gray-700">Alasan</label>
                <textarea name="alasan" id="alasan" rows="4" maxlength="200"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181] resize-y"
                    oninput="updateCharCount()">{{ old('alasan') }}</textarea>
                <p id="charCount" class="text-sm text-gray-500 mt-1 text-right">0 / 200 karakter</p>
                @error('alasan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- Tombol --}}
            <div class="flex justify-end">
                <a href="{{ route('admin.kepangkatan.index') }}"
                    class="px-4 py-2 mr-2 text-[#00A181] border border-[#00A181] rounded-lg hover:bg-[#00A181] hover:text-white transition">
                    Batal
                </a>
                <button type="button" id="submitBtn"
                    class="cursor-pointer px-4 py-2 bg-[#00A181] text-white rounded-lg hover:bg-[#009171] transition">
                    Simpan
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
        const dropdowns = {
            pegawai: false,
            golongan: false
        };

        function toggleDropdown(type) {
            // Tutup dropdown lain
            for (const key in dropdowns) {
                if (key !== type && dropdowns[key]) {
                    document.getElementById(`${key}-dropdown`).classList.add('hidden');
                    dropdowns[key] = false;
                }
            }

            // Toggle dropdown yang diklik
            const dropdown = document.getElementById(`${type}-dropdown`);
            dropdown.classList.toggle('hidden');
            dropdowns[type] = !dropdowns[type];
        }

        function selectItem(type, value, text) {
            document.getElementById(`${type}-input`).value = value;
            document.getElementById(`${type}-display`).textContent = text;

            // Reset highlight
            document.querySelectorAll(`#${type}-dropdown .option-item`).forEach(item => {
                item.classList.remove('bg-[#00A181]', 'text-white', 'hover:bg-[#009171]');
            });

            // Highlight selected
            const selected = document.querySelector(`#${type}-dropdown .option-item[data-value="${value}"]`);
            selected.classList.add('bg-[#00A181]', 'text-white', 'hover:bg-[#009171]');

            // Tutup dropdown
            toggleDropdown(type);
        }

        function filterOptions(type, query) {
            const options = document.querySelectorAll(`#${type}-options .option-item`);
            const lowerQuery = query.toLowerCase();
            options.forEach(option => {
                const text = option.textContent.toLowerCase();
                option.style.display = text.includes(lowerQuery) ? 'block' : 'none';
            });
        }

        // Inisialisasi warna saat halaman diload
        window.addEventListener('load', () => {
            ['pegawai', 'golongan'].forEach(type => {
                const val = document.getElementById(`${type}-input`).value;
                const selected = document.querySelector(
                    `#${type}-dropdown .option-item[data-value="${val}"]`);
                if (selected) {
                    selected.classList.add('bg-[#00A181]', 'text-white');
                    document.getElementById(`${type}-display`).textContent = selected.textContent;
                }
            });
        });

        document.getElementById('submitBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Tambah Data?',
                text: "Apakah Anda yakin ingin menambah data ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00A181',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('createForm').submit();
                }
            });
        });
        // untuk fungsi memotong number input jam
        const no_pertimbangan = document.getElementById('no_pertimbangan');

        no_pertimbangan.addEventListener('input', function() {
            // Hilangkan karakter non-digit
            this.value = this.value.replace(/\D/g, '');

            // Potong jika lebih dari 6 digit
            if (this.value.length > 60) {
                this.value = this.value.slice(0, 60);
            }
        });

        function updateCharCount() {
            const textarea = document.getElementById('alasan');
            const counter = document.getElementById('charCount');
            const max = 200;
            const current = textarea.value.length;
            counter.textContent = `${current} / ${max} karakter`;

            if (current > max) {
                textarea.value = textarea.value.substring(0, max);
                counter.textContent = `${max} / ${max} karakter`;
            }
        }

        // Jalankan saat halaman diload untuk set awal
        window.addEventListener('load', updateCharCount);

        const noPertimbangan = document.getElementById('no_pertimbangan');

        noPertimbangan.addEventListener('input', function() {
            // Hilangkan karakter non-digit
            this.value = this.value.replace(/\D/g, '');

            // Potong jika lebih dari 6 digit
            if (this.value.length > 60) {
                this.value = this.value.slice(0, 60);
            }
        });
    </script>
@endpush
