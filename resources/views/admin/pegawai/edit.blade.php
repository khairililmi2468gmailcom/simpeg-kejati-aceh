@extends('layouts.app-admin')

@section('content')
    <div>
        <h1 class="text-3xl font-bold text-[#00A181]">Edit Pegawai</h1>
        <p class="text-gray-600">Perbarui data pegawai Kejaksaan Tinggi</p>
    </div>

    <div class="max-w-6xl mx-auto mt-6 p-6 bg-white shadow-md rounded-xl">
        <form action="{{ route('admin.pegawai.update', $pegawai->nip) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- NIP (readonly) --}}
                <div>
                    <label class="block font-semibold text-gray-700">NIP</label>
                    <input type="text" name="nip" value="{{ $pegawai->nip }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]"
                        readonly>
                </div>

                {{-- NRP --}}
                <div>
                    <label class="block font-semibold text-gray-700">NRP</label>
                    <input type="text" name="nrp" value="{{ $pegawai->nrp }}"  maxlength="25" oninput="this.value = this.value.slice(0, 25);"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Karpeg --}}
                <div>
                    <label class="block font-semibold text-gray-700">Karpeg</label>
                    <input type="text" name="karpeg" value="{{ $pegawai->karpeg }}"  maxlength="25" oninput="this.value = this.value.slice(0, 25);"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Nama --}}
                <div>
                    <label class="block font-semibold text-gray-700">Nama</label>
                    <input type="text" name="nama" value="{{ $pegawai->nama }}" maxlength="100" oninput="this.value = this.value.slice(0, 100);"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Tempat Lahir --}}
                <div>
                    <label class="block font-semibold text-gray-700">Tempat Lahir</label>
                    <input type="text" name="tmpt_lahir" value="{{ $pegawai->tmpt_lahir }}" maxlength="25" oninput="this.value = this.value.slice(0, 25);"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Tanggal Lahir --}}
                <div>
                    <label class="block font-semibold text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" value="{{ $pegawai->tgl_lahir }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Agama, Suku --}}
                <div>
                    <label class="block font-semibold text-gray-700">Agama</label>
                    <select name="agama"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]">
                        <option value="">-- Pilih Agama --</option>
                        <option value="Islam" @selected($pegawai->agama == 'Islam')>Islam</option>
                        <option value="Kristen" @selected($pegawai->agama == 'Kristen')>Kristen</option>
                        <option value="Katolik" @selected($pegawai->agama == 'Katolik')>Katolik</option>
                        <option value="Hindu" @selected($pegawai->agama == 'Hindu')>Hindu</option>
                        <option value="Buddha" @selected($pegawai->agama == 'Buddha')>Buddha</option>
                        <option value="Konghucu" @selected($pegawai->agama == 'Konghucu')>Konghucu</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700">Suku</label>
                    <input type="text" name="suku" value="{{ $pegawai->suku }}" maxlength="25" oninput="this.value = this.value.slice(0, 25);"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Golongan Darah, Jenis Kelamin --}}
                <div>
                    <label class="block font-semibold text-gray-700">Golongan Darah</label>
                    <select name="gol_darah"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]">
                        <option value="">-- Pilih Golongan Darah --</option>
                        <option value="A" @selected($pegawai->gol_darah == 'A')>A</option>
                        <option value="B" @selected($pegawai->gol_darah == 'B')>B</option>
                        <option value="AB" @selected($pegawai->gol_darah == 'AB')>AB</option>
                        <option value="O" @selected($pegawai->gol_darah == 'O')>O</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700">Jenis Kelamin</label>
                    <select name="j_kelamin"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                    <option value="Laki-Laki" @selected($pegawai->j_kelamin == 'Laki-Laki')>Laki-Laki</option>
                    <option value="Perempuan" @selected($pegawai->j_kelamin == 'Perempuan')>Perempuan</option>
                    </select>
                </div>

                {{-- Status, Jumlah Anak --}}
                <div>
                    <label class="block font-semibold text-gray-700">Status</label>
                    <select name="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]">
                        <option value="">-- Pilih Status --</option>
                        <option value="Menikah" @selected($pegawai->status == 'Menikah')>Menikah</option>
                        <option value="Belum Menikah" @selected($pegawai->status == 'Belum Menikah')>Belum Menikah</option>
                        <option value="Cerai" @selected($pegawai->status == 'Cerai')>Cerai</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700">Jumlah Anak</label>
                    <input type="number" name="j_anak" value="{{ $pegawai->j_anak }}" maxlength="11" oninput="this.value = this.value.slice(0, 11);"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Provinsi --}}
                <div class="relative">
                    <label class="block font-semibold text-gray-700 mb-2">Provinsi</label>
                    <div class="custom-select group">
                        <div class="selected-item flex items-center justify-between cursor-pointer w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm hover:border-gray-400"
                            onclick="toggleDropdown('provinsi')">
                            <span id="provinsi-display">
                                {{ $pegawai->provinsi->nama_provinsi ?? 'Pilih Provinsi' }}
                            </span>
                            <svg class="w-5 h-5 text-gray-400 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" :class="{ 'rotate-180': dropdowns.provinsi }">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
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
                                        {{ $pegawai->id_provinsi == $prov->id ? 'bg-[#00A181] text-white hover:bg-[#009171]' : '' }}"
                                        data-value="{{ $prov->id }}"
                                        onclick="selectItem('provinsi', {{ $prov->id }}, '{{ $prov->nama_provinsi }}')">
                                        {{ $prov->nama_provinsi }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_provinsi" id="provinsi-input" value="{{ $pegawai->id_provinsi }}">
                </div>

                {{-- Kabupaten --}}
                <div class="relative">
                    <label class="block font-semibold text-gray-700 mb-2">Kabupaten</label>
                    <div class="custom-select group">
                        <div class="selected-item flex items-center justify-between cursor-pointer w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm hover:border-gray-400"
                            onclick="toggleDropdown('kabupaten')">
                            <span id="kabupaten-display">
                                {{ $pegawai->kabupaten->nama_kabupaten ?? 'Pilih Kabupaten' }}
                            </span>
                            <svg class="w-5 h-5 text-gray-400 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" :class="{ 'rotate-180': dropdowns.kabupaten }">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </div>
                        <div id="kabupaten-dropdown"
                            class="dropdown-content hidden absolute w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-50 max-h-64 overflow-y-auto">
                            <input type="text"
                                class="search-input w-full px-3 py-2 border-b border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00A181] rounded-t-lg"
                                placeholder="Cari kabupaten..." onkeyup="filterOptions('kabupaten', this.value)">
                            <div class="options" id="kabupaten-options">
                                @if ($pegawai->id_kabupaten)
                                    <div class="option-item px-3 py-2 hover:bg-gray-100 cursor-pointer transition-colors bg-[#00A181] text-white hover:bg-[#009171]"
                                        data-value="{{ $pegawai->id_kabupaten }}"
                                        onclick="selectItem('kabupaten', {{ $pegawai->id_kabupaten }}, '{{ $pegawai->kabupaten->nama_kabupaten }}')">
                                        {{ $pegawai->kabupaten->nama_kabupaten }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_kabupaten" id="kabupaten-input"
                        value="{{ $pegawai->id_kabupaten }}">
                </div>

                {{-- Kecamatan --}}
                <div class="relative">
                    <label class="block font-semibold text-gray-700 mb-2">Kecamatan</label>
                    <div class="custom-select group">
                        <div class="selected-item flex items-center justify-between cursor-pointer w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm hover:border-gray-400"
                            onclick="toggleDropdown('kecamatan')">
                            <span id="kecamatan-display">
                                {{ $pegawai->kecamatan->nama_kecamatan ?? 'Pilih Kecamatan' }}
                            </span>
                            <svg class="w-5 h-5 text-gray-400 transform transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" :class="{ 'rotate-180': dropdowns.kecamatan }">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </div>
                        <div id="kecamatan-dropdown"
                            class="dropdown-content hidden absolute w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-50 max-h-64 overflow-y-auto">
                            <input type="text"
                                class="search-input w-full px-3 py-2 border-b border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00A181] rounded-t-lg"
                                placeholder="Cari kecamatan..." onkeyup="filterOptions('kecamatan', this.value)">
                            <div class="options" id="kecamatan-options">
                                @if ($pegawai->id_kecamatan)
                                    <div class="option-item px-3 py-2 hover:bg-gray-100 cursor-pointer transition-colors bg-[#00A181] text-white hover:bg-[#009171]"
                                        data-value="{{ $pegawai->id_kecamatan }}"
                                        onclick="selectItem('kecamatan', {{ $pegawai->id_kecamatan }}, '{{ $pegawai->kecamatan->nama_kecamatan }}')">
                                        {{ $pegawai->kecamatan->nama_kecamatan }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_kecamatan" id="kecamatan-input"
                        value="{{ $pegawai->id_kecamatan }}">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700">Alamat</label>
                    <input type="text" name="alamat" value="{{ $pegawai->alamat }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Kode Pos, No HP --}}
                <div>
                    <label class="block font-semibold text-gray-700">Kode Pos</label>
                    <input type="text" name="kode_pos" value="{{ $pegawai->kode_pos }}" maxlength="12" oninput="this.value = this.value.slice(0, 12);"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>
                <div>
                    <label class="block font-semibold text-gray-700">No. HP</label>
                    <input type="text" name="hp" value="{{ $pegawai->hp }}" maxlength="12" oninput="this.value = this.value.slice(0, 12);"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Pendidikan, Universitas --}}
                <div>
                    <label class="block font-semibold text-gray-700">Pendidikan Terakhir</label>
                    <input type="text" name="pendidikan" value="{{ $pegawai->pendidikan }}" maxlength="25" oninput="this.value = this.value.slice(0, 25);"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>
                <div>
                    <label class="block font-semibold text-gray-700">Universitas</label>
                    <input type="text" name="universitas" value="{{ $pegawai->universitas }}" maxlength="99" oninput="this.value = this.value.slice(0, 99);"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Jurusan, Tahun Lulus --}}
                <div>
                    <label class="block font-semibold text-gray-700">Jurusan</label>
                    <input type="text" name="jurusan" value="{{ $pegawai->jurusan }}" maxlength="100" oninput="this.value = this.value.slice(0, 100);"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>
                <div>
                    <label class="block font-semibold text-gray-700">Tahun Lulus</label>
                    <input type="number" name="t_lulus" value="{{ $pegawai->t_lulus }}" oninput="this.value = this.value.slice(0, 4);"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>

                {{-- Tahun Masuk, TMT Jabatan --}}
                <div>
                    <label class="block font-semibold text-gray-700">Tahun Masuk</label>
                    <input type="number" name="tahun_masuk" value="{{ $pegawai->tahun_masuk }}" maxlength="4" oninput="this.value = this.value.slice(0, 4);"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div>
                {{-- <div>
                    <label class="block font-semibold text-gray-700">TMT Jabatan</label>
                    <input type="date" name="tmt_jabatan" value="{{ $pegawai->tmt_jabatan }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                </div> --}}

                {{-- Golongan --}}
                {{-- <div>
                    <label class="block font-semibold text-gray-700">Golongan</label>
                    <select name="id_golongan"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                    @foreach ($golongan as $gol)
                        <option value="{{ $gol->id_golongan }}" @selected($pegawai->id_golongan == $gol->id_golongan)>{{ $gol->pangkat }}
                        </option>
                    @endforeach
                    </select>
                </div> --}}

                {{-- Jabatan --}}
                {{-- <div>
                    <label class="block font-semibold text-gray-700">Jabatan</label>
                    <select name="id_jabatan"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                    @foreach ($jabatan as $jab)
                        <option value="{{ $jab->id_jabatan }}" @selected($pegawai->id_jabatan == $jab->id_jabatan)>{{ $jab->nama_jabatan }}
                        </option>
                    @endforeach
                    </select>
                </div> --}}

                {{-- Unit Kerja --}}
                {{-- <div>
                    <label class="block font-semibold text-gray-700">Unit Kerja</label>
                    <select name="kode_kantor"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />

                    @foreach ($unitKerja as $unit)
                        <option value="{{ $unit->kode_kantor }}" @selected($pegawai->kode_kantor == $unit->kode_kantor)>
                            {{ $unit->nama_kantor }}</option>
                    @endforeach
                    </select>
                </div> --}}

                {{-- Keterangan --}}
                <div class="md:col-span-2">
                    <label class="block font-semibold text-gray-700">Keterangan</label>
                    <textarea name="ket" rows="2" maxlength="150" oninput="this.value = this.value.slice(0, 150);"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />
{{ $pegawai->ket }}</textarea>
                </div>

                {{-- Foto --}}
                <div
                    class="border-2 border-dashed border-gray-300 rounded-lg p-4 relative bg-gray-50 text-center hover:border-[#00A181]">
                    <input type="file" name="foto" id="foto-input"
                        class="absolute inset-0 opacity-0 z-10 cursor-pointer" />
                    <p class="text-gray-600">Tarik dan letakkan file di sini atau klik untuk memilih</p>
                </div>

                @if ($pegawai->foto)
                    <div>
                        <label class="block font-semibold text-gray-700">Foto Saat Ini</label>
                        <img src="{{ asset('storage/' . $pegawai->foto) }}"
                            class="w-28 h-36 object-cover rounded shadow">
                    </div>
                @endif
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const provinsiSelect = document.getElementById('provinsi-select');
        const kabupatenSelect = document.getElementById('kabupaten-select');
        const kecamatanSelect = document.getElementById('kecamatan-select');

        // Preload kabupaten & kecamatan saat halaman edit dibuka
        const currentKabupaten = "{{ $pegawai->id_kabupaten }}";
        const currentKecamatan = "{{ $pegawai->id_kecamatan }}";
        const currentProvinsi = provinsiSelect.value;

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
</script>
