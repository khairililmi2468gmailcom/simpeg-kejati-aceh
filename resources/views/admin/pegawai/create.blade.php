@extends('layouts.app-admin')

@section('content')
    <div>
        <h1 class="text-3xl font-bold text-[#00A181]">Tambah Pegawai</h1>
        <p class="text-gray-600">Tambahkan data pegawai Kejaksaan Tinggi</p>
    </div>
    <button type="button" onclick="isiFormOtomatis()"
        class="cursor-pointer bg-[#00A181] text-white px-4 py-2 rounded-lg mt-4">Isi
        Otomatis</button>

    <div class="max-w-6xl mx-auto mt-6 p-6 bg-white shadow-md rounded-xl">
        <form action="{{ route('admin.pegawai.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h3 class="text-2xl font-extrabold dark:text-white md:mb-4">Data Pribadi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- NIP (readonly) --}}
                <div>
                    <label class="block font-semibold text-gray-700">NIP</label>
                    <input type="text" name="nip" id="nip" maxlength="18" oninput="validateNIP()"
                        value="{{ old('nip') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]">
                    <p id="nip-warning" class="text-sm text-red-600 mt-1 hidden">
                        NIP harus terdiri dari 18 karakter.
                    </p>
                </div>


                {{-- NRP --}}
                <div>
                    <label class="block font-semibold text-gray-700">NRP</label>
                    <input type="text" name="nrp" maxlength="25" oninput="this.value = this.value.slice(0, 25);"
                        value="{{ old('nrp') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Karpeg --}}
                <div>
                    <label class="block font-semibold text-gray-700">Karpeg</label>
                    <input type="text" name="karpeg" maxlength="25" oninput="this.value = this.value.slice(0, 25);"
                        value="{{ old('karpeg') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Nama --}}
                <div>
                    <label class="block font-semibold text-gray-700">Nama</label>
                    <input type="text" name="nama" maxlength="100" oninput="this.value = this.value.slice(0, 100);"
                        value="{{ old('nama') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Tempat Lahir --}}
                <div>
                    <label class="block font-semibold text-gray-700">Tempat Lahir</label>
                    <input type="text" name="tmpt_lahir" maxlength="25" oninput="this.value = this.value.slice(0, 25);"
                        value="{{ old('tmpt_lahir') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Tanggal Lahir --}}
                <div>
                    <label class="block font-semibold text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" value="{{ old('tgl_lahir') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Agama, Suku --}}
                <div>
                    <label class="block font-semibold text-gray-700">Agama</label>
                    <select name="agama"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]">
                        <option value="">-- Pilih Agama --</option>
                        <option value="Islam" @selected(old('agama') == 'Islam')>Islam</option>
                        <option value="Kristen" @selected(old('agama') == 'Kristen')>Kristen</option>
                        <option value="Katolik" @selected(old('agama') == 'Katolik')>Katolik</option>
                        <option value="Hindu" @selected(old('agama') == 'Hindu')>Hindu</option>
                        <option value="Buddha" @selected(old('agama') == 'Buddha')>Buddha</option>
                        <option value="Konghucu" @selected(old('agama') == 'Konghucu')>Konghucu</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700">Suku</label>
                    <input type="text" name="suku" maxlength="25" oninput="this.value = this.value.slice(0, 25);"
                        value="{{ old('suku') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Golongan Darah, Jenis Kelamin --}}
                <div>
                    <label class="block font-semibold text-gray-700">Golongan Darah</label>
                    <select name="gol_darah"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]">
                        <option value="">-- Pilih Golongan Darah --</option>
                        <option value="A" @selected(old('gol_darah') == 'A')>A</option>
                        <option value="B" @selected(old('gol_darah') == 'B')>B</option>
                        <option value="AB" @selected(old('gol_darah') == 'AB')>AB</option>
                        <option value="O" @selected(old('gol_darah') == 'O')>O</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700">Jenis Kelamin</label>
                    <select name="j_kelamin"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                    <option value="Laki-Laki" @selected(old('j_kelamin') == 'Laki-Laki')>Laki-Laki</option>
                    <option value="Perempuan" @selected(old('j_kelamin') == 'Perempuan')>Perempuan</option>
                    </select>
                </div>

                {{-- Status, Jumlah Anak --}}
                <div>
                    <label class="block font-semibold text-gray-700">Status</label>
                    <select name="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]">
                        <option value="">-- Pilih Status --</option>
                        <option value="Menikah" @selected(old('status') == 'Menikah')>Menikah</option>
                        <option value="Belum Menikah" @selected(old('status') == 'Belum Menikah')>Belum Menikah</option>
                        <option value="Cerai" @selected(old('status') == 'Cerai')>Cerai</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700">Jumlah Anak</label>
                    <input type="number" name="j_anak" maxlength="11" oninput="this.value = this.value.slice(0, 11);"
                        value="{{ old('j_anak') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Provinsi --}}
                <div class="relative">
                    <label class="block font-semibold text-gray-700 mb-2">Provinsi</label>
                    <div class="custom-select group">
                        <div class="selected-item flex items-center justify-between cursor-pointer w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm hover:border-gray-400"
                            onclick="toggleDropdown('provinsi')">
                            <span id="provinsi-display">
                                {{ old('id_provinsi') ? $provinsi->firstWhere('id', old('id_provinsi'))?->nama_provinsi : 'Pilih Provinsi' }}
                            </span>
                            <svg class="w-5 h-5 text-gray-400 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <div id="provinsi-dropdown"
                            class="dropdown-content hidden absolute w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-50 max-h-64 overflow-y-auto">
                            <input type="text"
                                class="search-input w-full px-3 py-2 border-b border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00A181] rounded-t-lg"
                                placeholder="Cari provinsi..." onkeyup="filterOptions('provinsi', this.value)">
                            <div class="options">
                                @foreach ($provinsi as $prov)
                                    <div class="option-item px-3 py-2 hover:bg-gray-100 cursor-pointer transition-colors
                        {{ old('id_provinsi') == $prov->id ? 'bg-[#00A181] text-white hover:bg-[#009171]' : '' }}"
                                        data-value="{{ $prov->id }}"
                                        onclick="selectItem('provinsi', {{ $prov->id }}, '{{ $prov->nama_provinsi }}')">
                                        {{ $prov->nama_provinsi }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_provinsi" id="provinsi-input" value="{{ old('id_provinsi') }}">
                    <p id="provinsi-warning" class="text-sm text-red-600 mt-1 hidden">
                        Provinsi wajib dipilih.
                    </p>

                </div>


                {{-- Kabupaten --}}
                <div class="relative">
                    <label class="block font-semibold text-gray-700 mb-2">Kabupaten</label>
                    <div class="custom-select group">
                        <div class="selected-item flex items-center justify-between cursor-pointer w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm hover:border-gray-400"
                            onclick="toggleDropdown('kabupaten')">
                            <span id="kabupaten-display">Pilih Kabupaten</span>
                            <svg class="w-5 h-5 text-gray-400 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" :class="{ 'rotate-180': dropdowns.kabupaten }">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <div id="kabupaten-dropdown"
                            class="dropdown-content hidden absolute w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-50 max-h-64 overflow-y-auto">
                            <input type="text"
                                class="search-input w-full px-3 py-2 border-b border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00A181] rounded-t-lg"
                                placeholder="Cari kabupaten..." onkeyup="filterOptions('kabupaten', this.value)">
                            <div class="options" id="kabupaten-options">
                                {{-- Kabupaten akan dimuat melalui JavaScript setelah provinsi dipilih --}}
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_kabupaten" id="kabupaten-input" value="">
                    <p id="kabupaten-warning" class="text-sm text-red-600 mt-1 hidden">
                        Kabupaten wajib dipilih.
                    </p>

                </div>

                {{-- Kecamatan --}}
                <div class="relative">
                    <label class="block font-semibold text-gray-700 mb-2">Kecamatan</label>
                    <div class="custom-select group">
                        <div class="selected-item flex items-center justify-between cursor-pointer w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm hover:border-gray-400"
                            onclick="toggleDropdown('kecamatan')">
                            <span id="kecamatan-display">Pilih Kecamatan</span>
                            <svg class="w-5 h-5 text-gray-400 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" :class="{ 'rotate-180': dropdowns.kecamatan }">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <div id="kecamatan-dropdown"
                            class="dropdown-content hidden absolute w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-50 max-h-64 overflow-y-auto">
                            <input type="text"
                                class="search-input w-full px-3 py-2 border-b border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00A181] rounded-t-lg"
                                placeholder="Cari kecamatan..." onkeyup="filterOptions('kecamatan', this.value)">
                            <div class="options" id="kecamatan-options">
                                {{-- Kecamatan akan dimuat melalui JavaScript setelah kabupaten dipilih --}}
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_kecamatan" id="kecamatan-input" value="">
                    <p id="kecamatan-warning" class="text-sm text-red-600 mt-1 hidden">
                        Kecamatan wajib dipilih.
                    </p>

                </div>


                <div>
                    <label class="block font-semibold text-gray-700">Alamat</label>
                    <input type="text" name="alamat" maxlength="100"
                        oninput="this.value = this.value.slice(0, 100);" value="{{ old('alamat') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Kode Pos, No HP --}}
                <div>
                    <label class="block font-semibold text-gray-700">Kode Pos</label>
                    <input type="text" name="kode_pos" maxlength="12" oninput="this.value = this.value.slice(0, 12);"
                        value="{{ old('kode_pos') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>
                <div>
                    <label class="block font-semibold text-gray-700">No. HP</label>
                    <input type="text" name="hp" maxlength="12" oninput="this.value = this.value.slice(0, 12);"
                        value="{{ old('hp') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>
            </div>
            <h3 class="text-2xl font-extrabold dark:text-white md:mb-4 md:mt-8">Data Pendidikan</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Pendidikan, Universitas --}}
                <div>
                    <label class="block font-semibold text-gray-700">Pendidikan Terakhir</label>
                    <input type="text" name="pendidikan" maxlength="25"
                        oninput="this.value = this.value.slice(0, 25);" value="{{ old('pendidikan') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>
                <div>
                    <label class="block font-semibold text-gray-700">Universitas</label>
                    <input type="text" name="universitas" maxlength="99"
                        oninput="this.value = this.value.slice(0, 99);" value="{{ old('universitas') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Jurusan, Tahun Lulus --}}
                <div>
                    <label class="block font-semibold text-gray-700">Jurusan</label>
                    <input type="text" name="jurusan" maxlength="100"
                        oninput="this.value = this.value.slice(0, 100);" value="{{ old('jurusan') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>
                <div>
                    <label class="block font-semibold text-gray-700">Tahun Lulus</label>
                    <input type="number" name="t_lulus" maxlength="4" oninput="this.value = this.value.slice(0, 4);"
                        value="{{ old('t_lulus') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Tahun Masuk --}}
                <div>
                    <label class="block font-semibold text-gray-700">Tahun Masuk</label>
                    <input type="number" name="tahun_masuk" maxlength="4"
                        oninput="this.value = this.value.slice(0, 4);" value="{{ old('tahun_masuk') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

            </div>
            {{-- <h3 class="text-2xl font-extrabold dark:text-white md:mb-4 md:mt-8">Data Jabatan</h3> --}}

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


                {{-- Golongan --}}
                {{-- <div>
                    <label class="block font-semibold text-gray-700">TMT Jabatan</label>
                    <input type="date" name="tmt_jabatan" value="{{ old('tmt_jabatan') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div> --}}
                {{-- <div>
                    <label class="block font-semibold text-gray-700 mb-2">Golongan</label>
                    <select name="id_golongan" id="id_golongan"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]">
                        <option value="">Pilih Golongan</option>
                        @foreach ($golongan as $gol)
                            <option value="{{ $gol->id_golongan }}"
                                {{ old('id_golongan') == $gol->id_golongan ? 'selected' : '' }}>
                                {{ $gol->pangkat }}
                            </option>
                        @endforeach
                    </select>
                    <p id="golongan-warning" class="text-sm text-red-600 mt-1 hidden">
                        Golongan wajib dipilih.
                    </p>

                </div> --}}


                {{-- Jabatan --}}
                {{-- <div>
                    <label class="block font-semibold text-gray-700">Jabatan</label>
                    <select name="id_jabatan" id="id_jabatan"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]">
                        <option value="">Pilih Jabatan</option>
                        @foreach ($jabatan as $jab)
                            <option value="{{ $jab->id_jabatan }}"
                                {{ old('id_jabatan') == $jab->id_jabatan ? 'selected' : '' }}>
                                {{ $jab->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                    <p id="jabatan-warning" class="text-sm text-red-600 mt-1 hidden">
                        Jabatan wajib dipilih.
                    </p>

                </div> --}}

                {{-- Unit Kerja --}}
                {{-- <div>
                    <label class="block font-semibold text-gray-700">Unit Kerja</label>
                    <select name="kode_kantor" id="kode_kantor"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]">
                        <option value="">Pilih Unit Kerja</option>
                        @foreach ($unitKerja as $unit)
                            <option value="{{ $unit->kode_kantor }}"
                                {{ old('kode_kantor') == $unit->kode_kantor ? 'selected' : '' }}>
                                {{ $unit->nama_kantor }}
                            </option>
                        @endforeach
                    </select>
                    <p id="unitkerja-warning" class="text-sm text-red-600 mt-1 hidden">
                        Unit Kerja wajib dipilih.
                    </p>

                </div> --}}
            </div>
            <h3 class="text-2xl font-extrabold dark:text-white md:mb-4 md:mt-8">Data Tambahan</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


                {{-- Keterangan --}}
                <div class="md:col-span-2">
                    <label class="block font-semibold text-gray-700">Keterangan</label>
                    <textarea name="ket" rows="2" maxlength="150" oninput="this.value = this.value.slice(0, 150);"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]">{{ old('ket') }}
</textarea>
                </div>

                <div class="px-4 py-6">
                    <div id="image-preview"
                        class="max-w-sm p-6 mb-4 bg-gray-100 border-dashed border-2 border-gray-400 rounded-lg items-center mx-auto text-center cursor-pointer">
                        <input id="foto-input" name="foto" type="file" class="hidden" accept="image/*" />
                        <label for="foto-input" class="cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-700 mx-auto mb-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                            </svg>
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-700">Upload picture</h5>
                            <p class="font-normal text-sm text-gray-400 md:px-6">Choose photo size should be less than <b
                                    class="text-gray-600">2mb</b></p>
                            <p class="font-normal text-sm text-gray-400 md:px-6">and should be in <b
                                    class="text-gray-600">JPG, PNG, or GIF</b> format.</p>
                            <span id="filename" class="text-gray-500 bg-gray-200 z-50"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <a href="{{ route('admin.pegawai.index') }}"
                    class="cursor-pointer inline-block bg-gray-300 hover:bg-gray-400 text-gray-700 px-5 py-2 rounded shadow">
                    Batal
                </a>
                <button type="submit"
                    class="cursor-pointer bg-[#00A181] hover:bg-[#009171] text-white px-6 py-2 rounded shadow">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
@push('styles')
    <style>
        /* Style untuk item terpilih */
        .option-item.selected {
            @apply bg-[#00A181] text-white hover:bg-[#009171] !important;
        }

        /* Hover state */
        .option-item:hover:not(.selected) {
            @apply bg-gray-100;
        }

        /* Style untuk panah dropdown */
        .custom-select:hover .selected-item {
            @apply border-gray-400;
        }
    </style>
@endpush
@push('scripts')
    <script>
        const uploadInput = document.getElementById('foto-input');
        const filenameLabel = document.getElementById('filename');
        const imagePreview = document.getElementById('image-preview');

        // Check if the event listener has been added before
        let isEventListenerAdded = false;

        uploadInput.addEventListener('change', (event) => {
            const file = event.target.files[0];

            if (file) {
                filenameLabel.textContent = file.name;

                // Sembunyikan label ketika gambar berhasil dipilih
                document.querySelector('label[for="foto-input"]').classList.add('hidden');

                const reader = new FileReader();
                reader.onload = (e) => {
                    const imgTag = document.createElement('img');
                    imgTag.src = e.target.result;
                    imgTag.className = "max-h-48 rounded-lg mx-auto";
                    imgTag.alt = "Image preview";

                    const previewContainer = document.getElementById('image-preview');
                    const oldImage = previewContainer.querySelector('img');
                    if (oldImage) previewContainer.removeChild(oldImage);
                    previewContainer.appendChild(imgTag);

                    previewContainer.classList.remove('border-dashed', 'border-2', 'border-gray-400');
                };

                reader.readAsDataURL(file);
            } else {
                filenameLabel.textContent = '';
                imagePreview.innerHTML =
                    `<div class="bg-gray-200 h-48 rounded-lg flex items-center justify-center text-gray-500">No image preview</div>`;
                imagePreview.classList.add('border-dashed', 'border-2', 'border-gray-400');

                // Tampilkan kembali label jika tidak ada file
                document.querySelector('label[for="foto-input"]').classList.remove('hidden');
            }
        });


        uploadInput.addEventListener('click', (event) => {
            event.stopPropagation();
        });
    </script>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    {{-- SweetAlert --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: false
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Silakan periksa kembali inputan Anda.',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (!form) return;

            form.addEventListener('submit', function(e) {
                let valid = true;

                const fields = [{
                        id: 'provinsi-input',
                        warning: 'provinsi-warning'
                    },
                    {
                        id: 'kabupaten-input',
                        warning: 'kabupaten-warning'
                    },
                    {
                        id: 'kecamatan-input',
                        warning: 'kecamatan-warning'
                    },
                    {
                        id: 'id_golongan',
                        warning: 'golongan-warning'
                    },
                    {
                        id: 'id_jabatan',
                        warning: 'jabatan-warning'
                    },
                    {
                        id: 'kode_kantor',
                        warning: 'unitkerja-warning'
                    }
                ];

                fields.forEach(field => {
                    const el = document.getElementById(field.id);
                    const warning = document.getElementById(field.warning);

                    if (!el || !warning) return;

                    if (!el.value) {
                        warning.classList.remove('hidden');
                        valid = false;
                    } else {
                        warning.classList.add('hidden');
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Beberapa data wajib diisi belum lengkap.',
                        timer: 3000,
                        showConfirmButton: false
                    });
                }
            });
        });
    </script>

    {{-- Select2 --}}

    <script>
        const dropdowns = {
            provinsi: false,
            kabupaten: false,
            kecamatan: false
        };

        function toggleDropdown(type) {
            dropdowns[type] = !dropdowns[type];
            const dropdown = document.getElementById(`${type}-dropdown`);
            dropdown.classList.toggle('hidden');

            // Close others
            Object.keys(dropdowns).forEach(key => {
                if (key !== type) {
                    dropdowns[key] = false;
                    document.getElementById(`${key}-dropdown`).classList.add('hidden');
                }
            });
        }

        async function selectItem(type, id, name) {
            document.getElementById(`${type}-display`).innerText = name;
            document.getElementById(`${type}-input`).value = id;

            // Update selected style
            const options = document.querySelectorAll(`#${type}-dropdown .option-item`);
            options.forEach(option => {
                option.classList.remove('bg-[#00A181]', 'text-white');
                if (option.dataset.value == id) {
                    option.classList.add('bg-[#00A181]', 'text-white');
                }
            });

            // Close dropdown
            document.getElementById(`${type}-dropdown`).classList.add('hidden');
            dropdowns[type] = false;

            // Reset & Load
            if (type === 'provinsi') {
                resetDropdown('kabupaten');
                resetDropdown('kecamatan');
                await loadKabupaten(id);
            } else if (type === 'kabupaten') {
                resetDropdown('kecamatan');
                await loadKecamatan(id);
            }
        }

        function resetDropdown(type) {
            document.getElementById(`${type}-display`).innerText = `Pilih ${type.charAt(0).toUpperCase() + type.slice(1)}`;
            document.getElementById(`${type}-input`).value = '';
            document.getElementById(`${type}-options`).innerHTML = '';
        }

        async function loadKabupaten(provinsiId) {
            try {
                const response = await fetch(`/get-kabupaten/${provinsiId}`);
                const data = await response.json();
                const optionsContainer = document.getElementById('kabupaten-options');
                optionsContainer.innerHTML = '';

                data.forEach(kab => {
                    const option = document.createElement('div');
                    option.className =
                        `option-item px-3 py-2 cursor-pointer hover:bg-[#f0fdfa] transition-colors`;
                    option.setAttribute('data-value', kab.id);
                    option.innerText = kab.nama_kabupaten;
                    option.onclick = () => selectItem('kabupaten', kab.id, kab.nama_kabupaten);
                    optionsContainer.appendChild(option);
                });
            } catch (error) {
                console.error('Gagal load kabupaten:', error);
            }
        }

        async function loadKecamatan(kabupatenId) {
            try {
                const response = await fetch(`/get-kecamatan/${kabupatenId}`);
                const data = await response.json();
                const optionsContainer = document.getElementById('kecamatan-options');
                optionsContainer.innerHTML = '';

                data.forEach(kec => {
                    const option = document.createElement('div');
                    option.className =
                        `option-item px-3 py-2 cursor-pointer hover:bg-[#f0fdfa] transition-colors`;
                    option.setAttribute('data-value', kec.id);
                    option.innerText = kec.nama_kecamatan;
                    option.onclick = () => selectItem('kecamatan', kec.id, kec.nama_kecamatan);
                    optionsContainer.appendChild(option);
                });
            } catch (error) {
                console.error('Gagal load kecamatan:', error);
            }
        }

        function filterOptions(type, searchText) {
            const options = document.querySelectorAll(`#${type}-dropdown .option-item`);
            searchText = searchText.toLowerCase();
            options.forEach(option => {
                const text = option.innerText.toLowerCase();
                option.style.display = text.includes(searchText) ? 'block' : 'none';
            });
        }

        // Auto selected style saat load
        window.addEventListener('load', () => {
            ['provinsi', 'kabupaten', 'kecamatan'].forEach(type => {
                const val = document.getElementById(`${type}-input`).value;
                const selected = document.querySelector(
                    `#${type}-dropdown .option-item[data-value="${val}"]`);
                if (selected) {
                    selected.classList.add('bg-[#00A181]', 'text-white');
                }
            });
        });

        // Close semua dropdown jika klik di luar
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.custom-select')) {
                Object.keys(dropdowns).forEach(type => {
                    dropdowns[type] = false;
                    document.getElementById(`${type}-dropdown`).classList.add('hidden');
                });
            }
        });
    </script>

@endpush
<script src="{{ asset('js/faker.min.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const provinsiSelect = document.getElementById('provinsi-select');
        const kabupatenSelect = document.getElementById('kabupaten-select');
        const kecamatanSelect = document.getElementById('kecamatan-select');

        // Preload kabupaten & kecamatan saat halaman edit dibuka
        const currentKabupaten = "{{ old('id_kabupaten') }}";
        const currentKecamatan = "{{ old('id_kecamatan') }}";
        const currentProvinsi = "{{ old('id_provinsi') }}";


        if (currentProvinsi) {
            fetchKabupaten(currentProvinsi, currentKabupaten);
        }
        if (currentKabupaten) {
            fetchKecamatan(currentKabupaten, currentKecamatan);
        }

        provinsiSelect.addEventListener('change', function() {
            fetchKabupaten(this.value);
            kecamatanSelect.innerHTML = `<option value="">-- Pilih Kecamatan --</option>`;
        });

        kabupatenSelect.addEventListener('change', function() {
            fetchKecamatan(this.value);
        });

        function fetchKabupaten(provinsiId, selected = '') {
            fetch(`/get-kabupaten/${provinsiId}`)
                .then(response => response.json())
                .then(data => {
                    kabupatenSelect.innerHTML = '<option value="">-- Pilih Kabupaten --</option>';
                    data.forEach(kab => {
                        const selectedAttr = kab.id === selected ? 'selected' : '';
                        kabupatenSelect.innerHTML +=
                            `<option value="${kab.id}" ${selectedAttr}>${kab.nama_kabupaten}</option>`;
                    });
                });
        }

        function fetchKecamatan(kabupatenId, selected = '') {
            fetch(`/get-kecamatan/${kabupatenId}`)
                .then(response => response.json())
                .then(data => {
                    kecamatanSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                    data.forEach(kec => {
                        const selectedAttr = kec.id === selected ? 'selected' : '';
                        kecamatanSelect.innerHTML +=
                            `<option value="${kec.id}" ${selectedAttr}>${kec.nama_kecamatan}</option>`;
                    });
                });
        }


    });

    function validateNIP() {
        const nipInput = document.getElementById('nip');
        const warning = document.getElementById('nip-warning');

        // Paksa maksimal 18 karakter (hard limit)
        if (nipInput.value.length > 18) {
            nipInput.value = nipInput.value.slice(0, 18);
        }

        // Tampilkan warning jika kurang dari 18
        if (nipInput.value.length < 18) {
            warning.classList.remove('hidden');
        } else {
            warning.classList.add('hidden');
        }
    }
    document.querySelector('form').addEventListener('submit', function(e) {
        let valid = true;

        const fields = [{
                id: 'provinsi-input',
                warning: 'provinsi-warning'
            },
            {
                id: 'kabupaten-input',
                warning: 'kabupaten-warning'
            },
            {
                id: 'kecamatan-input',
                warning: 'kecamatan-warning'
            },
            {
                id: 'id_golongan',
                warning: 'golongan-warning'
            },
            {
                id: 'id_jabatan',
                warning: 'jabatan-warning'
            },
            {
                id: 'kode_kantor',
                warning: 'unitkerja-warning'
            }
        ];

        fields.forEach(field => {
            const el = document.getElementById(field.id);
            const warning = document.getElementById(field.warning);

            if (!el.value) {
                warning.classList.remove('hidden');
                valid = false;
            } else {
                warning.classList.add('hidden');
            }
        });

        if (!valid) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Beberapa data wajib diisi belum lengkap.',
                timer: 3000,
                showConfirmButton: false
            });
        }
    });

    function isiFormOtomatis() {
        document.querySelector('[name="nip"]').value = faker.random.number({
            min: 1e17,
            max: 9e17
        }).toString();
        document.querySelector('[name="nrp"]').value = faker.random.alphaNumeric(10);
        document.querySelector('[name="karpeg"]').value = faker.random.alphaNumeric(10);
        document.querySelector('[name="nama"]').value = faker.name.findName();
        document.querySelector('[name="tmpt_lahir"]').value = faker.address.city();
        document.querySelector('[name="tgl_lahir"]').value = faker.date.past(40, '2000-01-01').toISOString().split('T')[
            0];
        document.querySelector('[name="agama"]').value = 'Islam';
        document.querySelector('[name="suku"]').value = faker.random.word();
        document.querySelector('[name="gol_darah"]').value = 'O';
        document.querySelector('[name="j_kelamin"]').value = 'Laki-Laki';
        document.querySelector('[name="status"]').value = 'Menikah';
        document.querySelector('[name="j_anak"]').value = Math.floor(Math.random() * 5);
        document.querySelector('[name="alamat"]').value = faker.address.streetAddress();
        document.querySelector('[name="kode_pos"]').value = faker.address.zipCode();
        document.querySelector('[name="hp"]').value = faker.phone.phoneNumber('08##########');
        document.querySelector('[name="pendidikan"]').value = 'S1';
        document.querySelector('[name="universitas"]').value = faker.company.companyName();
        document.querySelector('[name="jurusan"]').value = 'Hukum';
        document.querySelector('[name="t_lulus"]').value = faker.random.number({
            min: 1990,
            max: 2022
        });
        document.querySelector('[name="tahun_masuk"]').value = faker.random.number({
            min: 1980,
            max: 2020
        });
        document.querySelector('[name="tmt_jabatan"]').value = faker.date.past(10).toISOString().split('T')[0];
        const ketInput = document.querySelector('[name="ket"]');
        if (ketInput) {
            ketInput.value = faker.lorem.sentence().slice(0, 150);
        }

        // Untuk select lain seperti jabatan, golongan, unit kerja — bisa diisi manual atau random ambil salah satu option.
    }
</script>
