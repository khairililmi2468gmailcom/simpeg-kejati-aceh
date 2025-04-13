@extends('layouts.app-admin')

@section('content')
    <div>
        <h1 class="text-3xl font-bold text-[#00A181]">Edit Kecamatan</h1>
        <p class="text-gray-600">Perbarui Kecamatan</p>
    </div>


    <div class="max-w-xl mx-auto mt-6 p-6 bg-white shadow-md rounded-xl">
        <form action="{{ route('admin.kecamatan.update', $kecamatan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nama_kecamatan" class="block text-sm font-medium text-gray-700">Nama kecamatan</label>
                <input type="text" name="nama_kecamatan" id="nama_kecamatan"
                    value="{{ old('nama_kecamatan', $kecamatan->nama_kecamatan) }}"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]"
                    maxlength="30" required>
                @error('nama_kecamatan')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4 relative">
                <label for="id_kabupaten" class="block text-sm font-medium text-gray-700">Kabupaten</label>

                <div x-data="dropdown()" x-init="init('{{ old('id_kabupaten', $kecamatan->id_kabupaten) }}')" class="relative">
                    <input x-model="search" @input="filter()" @focus="open = true" @click="open = true"
                        @click.away="open = false" @keydown.escape="open = false" placeholder="Cari Kabupaten..."
                        class="cursor-pointer mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />
                    <input type="hidden" name="id_kabupaten" :value="selectedId" required>

                    <ul x-show="open" x-transition
                        class="absolute z-10 bg-white border border-gray-200 w-full mt-1 max-h-52 overflow-auto rounded-lg shadow-md">
                        <template x-for="kab in filtered" :key="kab.id">
                            <li @click="select(kab)"
                                :class="selectedId === kab.id ? 'bg-[#00A181] text-white' : 'hover:bg-gray-100'"
                                class="cursor-pointer px-4 py-2 transition">
                                <span x-text="kab.nama"></span>
                            </li>
                        </template>

                        <li x-show="filtered.length === 0" class="text-center text-gray-400 py-2">Kabupaten tidak ditemukan
                        </li>
                    </ul>
                </div>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.kecamatan.index') }}"
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
<script src="https://unpkg.com/alpinejs" defer></script>
<script>
    function dropdown() {
        return {
            open: false,
            search: '',
            selectedId: '',
            kabupatenList: @json($kabupaten->map(fn($p) => ['id' => $p->id, 'nama' => $p->nama_kabupaten])),
            filtered: [],
            watch: {
                search: debounce(function(value) {
                    this.filter();
                }, 200)
            },
            init(selectedId) {
                this.selectedId = selectedId;
                const kab = this.kabupatenList.find(p => p.id === selectedId);
                this.search = kab ? kab.nama : '';
                this.filter();
            },
            filter() {
                const keyword = this.search.toLowerCase();
                this.filtered = this.kabupatenList.filter(p => p.nama.toLowerCase().includes(keyword));
            },
            select(kab) {
                this.selectedId = kab.id;
                this.search = kab.nama;
                this.open = false;
            },
            get selectedName() {
                const kab = this.kabupatenList.find(p => p.id === this.selectedId);
                return kab ? kab.nama : '';
            }
        }
    }

    function debounce(func, delay) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        }
    }
</script>
@push('scripts')
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const selectedKabupaten = document.querySelector('input[name="id_kabupaten"]').value;
            if (!selectedKabupaten) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Kabupaten belum dipilih',
                    text: 'Silakan pilih provinsi terlebih dahulu.',
                    confirmButtonColor: '#00A181',
                });
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn) {
                submitBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    const nama = document.getElementById('nama_kecamatan').value.trim();
                    const jenis = document.querySelector('input[name="id_kabupaten"]').value.trim();

                    if (!nama || !jenis) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lengkapi data',
                            text: 'Nama dan kabupaten wajib diisi.',
                            confirmButtonColor: '#00A181',
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Perbarui Data?',
                        text: 'Apakah Anda yakin ingin memperbarui data ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#00A181',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Simpan',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.querySelector('form').submit();
                        }
                    });
                });
            }
        });
    </script>
@endpush
