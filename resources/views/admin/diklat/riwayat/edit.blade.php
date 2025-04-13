@extends('layouts.app-admin')

@section('content')
    <div>
        <h1 class="text-3xl font-bold text-[#00A181]">Edit Riwayat Diklat</h1>
        <p class="text-gray-600">Perbarui informasi riwayat diklat pegawai.</p>
    </div>

    <div class="max-w-3xl mx-auto mt-6 p-6 bg-white shadow-md rounded-xl">
        <form id="editForm" action="{{ route('admin.diklat.riwayat.update', $data->no_sttpp) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- No STTPP --}}
            <div class="mb-4">
                <label for="no_sttpp" class="block text-sm font-medium text-gray-700">No. STTPP</label>
                <input type="text" name="no_sttpp" id="no_sttpp" value="{{ old('no_sttpp', $data->no_sttpp) }}"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]"
                    disabled>
            </div>

            {{-- Tempat Diklat --}}
            <div class="mb-4">
                <label for="tempat_diklat" class="block text-sm font-medium text-gray-700">Tempat Diklat</label>
                <input type="text" name="tempat_diklat" id="tempat_diklat"
                    value="{{ old('tempat_diklat', $data->tempat_diklat) }}" maxlength="50"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]"
                    required>
            </div>

            {{-- Nama Pegawai --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pegawai</label>
                <div class="custom-select group relative">
                    <div class="selected-item flex items-center justify-between cursor-pointer w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm hover:border-gray-400"
                        onclick="toggleDropdown('pegawai')">
                        <span id="pegawai-display">
                            {{ $pegawaiList->firstWhere('nip', old('nip', $data->nip))?->nama ?? 'Pilih Pegawai' }}
                        </span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" :class="{ 'rotate-180': dropdowns.pegawai }">
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
                                <div class="option-item px-3 py-2 hover:bg-gray-100 cursor-pointer transition-colors {{ old('nip', $data->nip) == $pegawai->nip ? 'bg-[#00A181] text-white hover:bg-[#009171]' : '' }}"
                                    data-value="{{ $pegawai->nip }}"
                                    onclick="selectItem('pegawai', '{{ $pegawai->nip }}', '{{ $pegawai->nama }} ({{ $pegawai->nip }})')">
                                    {{ $pegawai->nama }} ({{ $pegawai->nip }})
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <input type="hidden" name="nip" id="pegawai-input" value="{{ old('nip', $data->nip) }}">
            </div>
            {{-- Nama Diklat --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Diklat</label>
                <div class="custom-select group relative">
                    <div class="selected-item flex items-center justify-between cursor-pointer w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm hover:border-gray-400"
                        onclick="toggleDropdown('diklat')">
                        <span id="diklat-display">
                            {{ $diklatList->firstWhere('id', old('diklat_id', $data->diklat_id))?->nama_diklat ?? 'Pilih Diklat' }}
                        </span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" :class="{ 'rotate-180': dropdowns.diklat }">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <div id="diklat-dropdown"
                        class="dropdown-content hidden absolute w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-50 max-h-64 overflow-y-auto">
                        <input type="text"
                            class="search-input w-full px-3 py-2 border-b border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00A181] rounded-t-lg"
                            placeholder="Cari Diklat..." onkeyup="filterOptions('diklat', this.value)">
                        <div class="options" id="diklat-options">
                            @foreach ($diklatList as $diklat)
                                <div class="option-item px-3 py-2 hover:bg-gray-100 cursor-pointer transition-colors {{ old('diklat_id', $data->diklat_id) == $diklat->id ? 'bg-[#00A181] text-white hover:bg-[#009171]' : '' }}"
                                    data-value="{{ $diklat->id }}"
                                    onclick="selectItem('diklat', '{{ $diklat->id }}', '{{ $diklat->nama_diklat }}')">
                                    {{ $diklat->nama_diklat }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <input type="hidden" name="diklat_id" id="diklat-input" value="{{ old('diklat_id', $data->diklat_id) }}">
            </div>

            {{-- Penyelenggara --}}
            <div class="mb-4">
                <label for="penyelenggara" class="block text-sm font-medium text-gray-700">Penyelenggara</label>
                <input type="text" name="penyelenggara" id="penyelenggara"
                    value="{{ old('penyelenggara', $data->penyelenggara) }}" maxlength="50"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]"
                    required>
            </div>

            {{-- Angkatan --}}
            <div class="mb-4">
                <label for="angkatan" class="block text-sm font-medium text-gray-700">Angkatan</label>
                <input type="text" name="angkatan" id="angkatan" value="{{ old('angkatan', $data->angkatan) }}"
                    maxlength="12"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]">
            </div>

            {{-- Jumlah Jam --}}
            <div class="mb-4">
                <label for="jumlah_jam" class="block text-sm font-medium text-gray-700">Jumlah Jam</label>
                <input type="number" name="jumlah_jam" id="jumlah_jam"
                    value="{{ old('jumlah_jam', $data->jumlah_jam) }}" maxlength="11"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]"
                    required>
            </div>


            {{-- Tanggal Mulai --}}
            <div class="mb-4">
                <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <div class="relative max-w-sm">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input name="tanggal_mulai" id="tanggal_mulai" type="date"
                        value="{{ old('tanggal_mulai', $data->tanggal_mulai) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5">
                </div>
            </div>

            {{-- Tanggal Selesai --}}
            <div class="mb-4">
                <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <div class="relative max-w-sm">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input name="tanggal_selesai" id="tanggal_selesai" type="date"
                        value="{{ old('tanggal_selesai', $data->tanggal_selesai) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5">
                </div>
            </div>

            {{-- Tanggal STTPP --}}
            <div class="mb-4">
                <label for="tanggal_sttpp" class="block text-sm font-medium text-gray-700">Tanggal STTPP</label>
                <div class="relative max-w-sm">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input name="tanggal_sttpp" id="tanggal_sttpp" type="date"
                        value="{{ old('tanggal_sttpp', $data->tanggal_sttpp) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5">
                </div>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end">
                <a href="{{ route('admin.diklat.riwayat.index') }}"
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
        const dropdowns = {
            pegawai: false,
            diklat: false
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
            ['pegawai', 'diklat'].forEach(type => {
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
                title: 'Perbarui Data?',
                text: "Apakah Anda yakin ingin memperbarui data ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00A181',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('editForm').submit();
                }
            });
        });
        document.getElementById('jumlah_jam').addEventListener('input', function() {
            if (this.value.length > 6) {
                this.value = this.value.slice(0, 6);
            }
        });
    </script>
@endpush
