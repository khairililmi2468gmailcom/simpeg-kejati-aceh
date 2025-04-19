@extends('layouts.app-admin')

@section('content')
    <div>
        <h1 class="text-3xl font-bold text-[#00A181]">Tambah Kabupaten</h1>
        <p class="text-gray-600">Lengkapi form untuk menambahkan Kabupaten baru</p>
    </div>

    <div class="max-w-xl mx-auto mt-6 p-6 bg-white shadow-md rounded-xl">
        <form action="{{ route('admin.kabupaten.store') }}" method="POST" id="createForm">
            @csrf
            <div class="mb-4">
                <label for="nama_kabupaten" class="block text-sm font-medium text-gray-700">Nama Kabupaten</label>
                <input type="text" name="nama_kabupaten" id="nama_kabupaten" value="{{ old('nama_kabupaten') }}"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]"
                    maxlength="50" required>
                @error('nama_kabupaten')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 relative">
                <label for="id_provinsi" class="block text-sm font-medium text-gray-700">Provinsi</label>

                <div x-data="dropdown()" x-init="init('{{ old('id_provinsi') }}')" class="relative">
                    <input x-model="search" @input="filter()" @focus="open = true" @click="open = true"
                        @click.away="open = false" @keydown.escape="open = false" placeholder="Cari provinsi..."
                        class="cursor-pointer mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]" />
                    <input type="hidden" name="id_provinsi" :value="selectedId" required>

                    <ul x-show="open" x-transition
                        class="absolute z-10 bg-white border border-gray-200 w-full mt-1 max-h-52 overflow-auto rounded-lg shadow-md">
                        <template x-for="prov in filtered" :key="prov.id">
                            <li @click="select(prov)"
                                :class="selectedId === prov.id ? 'bg-[#00A181] text-white' : 'hover:bg-gray-100'"
                                class="cursor-pointer px-4 py-2 transition">
                                <span x-text="prov.nama"></span>
                            </li>
                        </template>
                        <li x-show="filtered.length === 0" class="text-center text-gray-400 py-2">Provinsi tidak ditemukan
                        </li>
                    </ul>
                </div>
                @error('id_provinsi')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.kabupaten.index') }}"
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

<script src="https://unpkg.com/alpinejs" defer></script>
<script>
    function dropdown() {
        return {
            open: false,
            search: '',
            selectedId: '',
            provinsiList: @json($provinsi->map(fn($p) => ['id' => $p->id, 'nama' => $p->nama_provinsi])),
            filtered: [],
            watch: {
                search: debounce(function(value) {
                    this.filter();
                }, 200)
            },
            init(selectedId) {
                this.selectedId = selectedId;
                const prov = this.provinsiList.find(p => p.id === selectedId);
                this.search = prov ? prov.nama : '';
                this.filter();
            },
            filter() {
                const keyword = this.search.toLowerCase();
                this.filtered = this.provinsiList.filter(p => p.nama.toLowerCase().includes(keyword));
            },
            select(prov) {
                this.selectedId = prov.id;
                this.search = prov.nama;
                this.open = false;
            },
            get selectedName() {
                const prov = this.provinsiList.find(p => p.id === this.selectedId);
                return prov ? prov.nama : '';
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
        const selectedProvinsi = document.querySelector('input[name="id_provinsi"]').value;
        if (!selectedProvinsi) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Provinsi belum dipilih',
                text: 'Silakan pilih provinsi terlebih dahulu.',
                confirmButtonColor: '#00A181',
            });
        }
    });
    document.getElementById('submitBtn').addEventListener('click', function(e) {
        const kabupaten = document.getElementById('nama_kabupaten').value.trim();
        const provinsi = document.querySelector('input[name="id_provinsi"]').value;

        if (!kabupaten ) {
            Swal.fire({
                icon: 'error',
                title: 'Lengkapi data',
                text: 'Kabupaten  wajib diisi.',
                confirmButtonColor: '#00A181',
            });
            return;
        }
        if (!provinsi ) {
            Swal.fire({
                icon: 'error',
                title: 'Lengkapi data',
                text: 'Provinsi  wajib diisi.',
                confirmButtonColor: '#00A181',
            });
            return;
        }


        // Menampilkan konfirmasi SweetAlert
        Swal.fire({
            title: 'Perbarui Data?',
            text: 'Apakah Anda yakin ingin menambahkan data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#00A181',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika konfirmasi, kirim form
                document.getElementById('createForm').submit();
            }
        });
    });
</script>
@endpush