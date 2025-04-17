@extends('layouts.app-admin')

@section('content')
    <div>
        <h1 class="text-3xl font-bold text-[#00A181]">Tambah Jabatan</h1>
        <p class="text-gray-600">Masukkan data jabatan baru.</p>
    </div>

    <div class="max-w-3xl mx-auto mt-6 p-6 bg-white shadow-md rounded-xl">
        <form id="createForm" action="{{ route('admin.settings.jabatan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Nama Jabatan --}}
            <div class="mb-4">
                <label for="nama_jabatan" class="block text-sm font-medium text-gray-700">Nama Jabatan</label>
                <input type="text" name="nama_jabatan" id="nama_jabatan" value="{{ old('nama_jabatan') }}" maxlength="50"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]">
                @error('nama_jabatan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Unit Kerja --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Unit Kerja</label>
                <div class="custom-select group relative">
                    <div class="selected-item flex items-center justify-between cursor-pointer w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm hover:border-gray-400"
                        onclick="toggleDropdown('unitkerja')">
                        <span id="unitkerja-display">
                            {{ $unitKerjaList->firstWhere('kode_kantor', old('kode_kantor'))?->nama_kantor ?? 'Pilih Unit Kerja' }}
                        </span>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <div id="unitkerja-dropdown"
                        class="dropdown-content hidden absolute w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-50 max-h-64 overflow-y-auto">
                        <input type="text"
                            class="search-input w-full px-3 py-2 border-b border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00A181] rounded-t-lg"
                            placeholder="Cari Unit Kerja..." onkeyup="filterOptions('unitkerja', this.value)">
                        <div class="options" id="unitkerja-options">
                            @foreach ($unitKerjaList as $unitkerja)
                                <div class="option-item px-3 py-2 hover:bg-gray-100 cursor-pointer transition-colors {{ old('kode_kantor') == $unitkerja->kode_kantor ? 'bg-[#00A181] text-white hover:bg-[#009171]' : '' }}"
                                    data-value="{{ $unitkerja->kode_kantor }}"
                                    onclick='selectItem("unitkerja", @json($unitkerja->kode_kantor), @json($unitkerja->nama_kantor))'>
                                    {{ $unitkerja->nama_kantor }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <input type="hidden" name="kode_kantor" id="unitkerja-input" value="{{ old('kode_kantor') }}">
                @error('kode_kantor')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Keterangan --}}
            <div class="mb-4">
                <label for="ket" class="block text-sm font-medium text-gray-700">Keterangan</label>
                <textarea name="ket" id="ket" rows="4" maxlength="200"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181] resize-y"
                    oninput="updateCharCount()">{{ old('ket') }}</textarea>
                <p id="charCount" class="text-sm text-gray-500 mt-1 text-right">0 / 200 karakter</p>
                @error('ket')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end">
                <a href="{{ route('admin.settings.index') }}"
                    class="px-4 py-2 mr-2 text-[#00A181] border border-[#00A181] rounded-lg hover:bg-[#00A181] hover:text-white transition">
                    Batal
                </a>
                <button type="button" id="submitBtn"
                    class="cursor-pointer px-4 py-2 bg-[#00A181] text-white rounded-lg hover:bg-[#009171] transition">
                    Simpan Jabatan
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
            unitkerja: false
        };

        function toggleDropdown(type) {
            for (const key in dropdowns) {
                if (key !== type && dropdowns[key]) {
                    document.getElementById(`${key}-dropdown`).classList.add('hidden');
                    dropdowns[key] = false;
                }
            }

            const dropdown = document.getElementById(`${type}-dropdown`);
            dropdown.classList.toggle('hidden');
            dropdowns[type] = !dropdowns[type];
        }

        function selectItem(type, value, text) {
            document.getElementById(`${type}-input`).value = value;
            document.getElementById(`${type}-display`).textContent = text;

            document.querySelectorAll(`#${type}-dropdown .option-item`).forEach(item => {
                item.classList.remove('bg-[#00A181]', 'text-white', 'hover:bg-[#009171]');
            });

            const selected = document.querySelector(`#${type}-dropdown .option-item[data-value="${value}"]`);
            selected.classList.add('bg-[#00A181]', 'text-white', 'hover:bg-[#009171]');
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

        window.addEventListener('load', () => {
            ['unitkerja'].forEach(type => {
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
                title: 'Tambah Jabatan?',
                text: "Apakah Anda yakin ingin menyimpan data ini?",
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

        function updateCharCount() {
            const textarea = document.getElementById('ket');
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
    </script>
@endpush
