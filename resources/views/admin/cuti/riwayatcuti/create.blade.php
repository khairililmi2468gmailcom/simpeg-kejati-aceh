@extends('layouts.app-admin')

@section('content')
    <div>
        <h1 class="text-3xl font-bold text-[#00A181]">Tambah Riwayat Cuti</h1>
        <p class="text-gray-600">Masukkan informasi riwayat cuti pegawai baru.</p>
    </div>

    <div class="max-w-3xl mx-auto mt-6 p-6 bg-white shadow-md rounded-xl">
        <form id="createForm" action="{{ route('admin.cuti.riwayatcuti.store') }}" method="POST" enctype="multipart/form-data">
            @csrf


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
            </div>

            {{-- Nama Cuti --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama cuti</label>
                <div class="custom-select group relative">
                    <div class="selected-item flex items-center justify-between cursor-pointer w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm hover:border-gray-400"
                        onclick="toggleDropdown('cuti')">
                        <span id="cuti-display">Pilih Cuti</span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <div id="cuti-dropdown"
                        class="dropdown-content hidden absolute w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-50 max-h-64 overflow-y-auto">
                        <input type="text"
                            class="search-input w-full px-3 py-2 border-b border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00A181] rounded-t-lg"
                            placeholder="Cari cuti..." onkeyup="filterOptions('cuti', this.value)">
                        <div class="options" id="cuti-options">
                            @foreach ($cutiList as $cuti)
                                <div class="option-item px-3 py-2 hover:bg-gray-100 cursor-pointer transition-colors"
                                    data-value="{{ $cuti->id }}"
                                    onclick='selectItem("cuti", @json($cuti->id), @json($cuti->jenis_cuti))'>
                                    {{ $cuti->jenis_cuti }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <input type="hidden" name="cuti_id" id="cuti-input" value="{{ old('cuti_id') }}">
            </div>

           
            {{-- Jumlah Cuti --}}
            <div class="mb-4">
                <label for="jumlah_cuti" class="block text-sm font-medium text-gray-700">Jumlah Cuti/Hari </label>
                <input type="text" name="jumlah_cuti" id="jumlah_cuti" maxlength="6" inputmode="numeric" pattern="\d*"
                    value="{{ old('jumlah_cuti') }}"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]"
                    required>
            </div>

            {{-- Keterangan --}}
            <div class="mb-4">
                <label for="keterangan" class="block text-sm font-medium text-gray-700">keterangan</label>
                <input type="text" name="keterangan" id="keterangan" value="{{ old('keterangan') }}" maxlength="50"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]">
            </div>

            {{-- Tanggal Mulai, Selesai, No Surat --}}
            @foreach (['tanggal_mulai' => 'Tanggal Mulai', 'tanggal_selesai' => 'Tanggal Selesai'] as $field => $label)
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
                </div>
            @endforeach

            {{-- Tombol --}}
            <div class="flex justify-end">
                <a href="{{ route('admin.cuti.riwayatcuti.index') }}"
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

@push('scripts')
    <script>
        const dropdowns = {
            pegawai: false,
            cuti: false
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
            ['pegawai', 'cuti'].forEach(type => {
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
        const jumlahJam = document.getElementById('jumlah_cuti');

        jumlahJam.addEventListener('input', function() {
            // Hilangkan karakter non-digit
            this.value = this.value.replace(/\D/g, '');

            // Potong jika lebih dari 6 digit
            if (this.value.length > 6) {
                this.value = this.value.slice(0, 6);
            }
        });
    </script>
@endpush
