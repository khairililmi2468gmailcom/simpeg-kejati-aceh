@extends('layouts.app-admin')

@section('content')
    <h1 class="text-3xl font-bold text-[#00A181]">Data Pegawai</h1>
    <p class="mb-4">Halaman daftar pegawai Kejaksaan Tinggi</p>
    <!-- Info Button -->
    <div class="flex items-center justify-start  space-x-2 mb-4">
        <button onclick="toggleReferensiModal()"
            class="cursor-context-menu inline-flex items-center justify-center w-9 h-9 rounded-full bg-yellow-400 hover:bg-yellow-500 text-white focus:outline-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
            </svg>
        </button>
        <span class="text-sm text-gray-600 hidden md:inline">Petunjuk Pengisian Excel</span>
    </div>
    {{-- Filter & Search --}}
    <form method="GET" action="{{ route('admin.pegawai') }}"
        class="flex flex-wrap md:flex-nowrap items-center justify-between gap-2 mb-6">

        <div class="relative w-full md:w-1/3">
            <input type="text" name="search" id="search" value="{{ request('search') }}"
                class="border border-gray-300 px-4 py-2 pl-10 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-[#00A181]"
                placeholder="Cari pegawai...">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                </svg>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <select name="per_page" onchange="this.form.submit()"
                class="border border-gray-300 px-3 py-2 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]">
                @foreach ([5, 10, 25, 50, 100, 250, 500, 1000, 2000, 5000, 10000] as $size)
                    <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
                        {{ $size }} / halaman
                    </option>
                @endforeach
            </select>

            <button type="submit"
                class="inline-flex items-center text-white bg-[#00A181] hover:bg-[#008f73] focus:ring-4 focus:ring-[#00A181]/50 font-medium rounded-md text-sm px-4 py-2">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                </svg>
                Cari
            </button>
        </div>
    </form>
    <div class="flex flex-wrap items-center gap-3 mb-4">

        <!-- Export PDF -->
        <a href="{{ route('admin.pegawai.export.pdf') }}"
            class="inline-flex items-center text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-sm px-5 py-2.5">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Export PDF
        </a>

        <!-- Export Excel -->
        <a href="{{ route('admin.pegawai.export.excel') }}"
            class="inline-flex items-center text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Export Excel
        </a>

        <!-- Import Excel -->
        <form action="{{ route('admin.pegawai.import.excel') }}" method="POST" enctype="multipart/form-data"
            class="inline-flex items-center gap-2">
            @csrf
            <label
                class="inline-flex items-center bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg text-sm px-4 py-2.5 cursor-pointer">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>Import Excel</span>
                <input type="file" name="file" class="hidden" onchange="this.form.submit()" accept=".xlsx,.xls">
            </label>
        </form>

        <!-- Download Template Excel -->
        <a href="{{ url('/pegawai/template/excel') }}" download
            class="inline-flex items-center text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v16h16V4H4zm8 8v4m0-4l-2 2m2-2l2 2" />
            </svg>
            Unduh Template
        </a>

    </div>

    <div class="flex justify-end space-x-2 mb-4 mt-4">

        <!-- Tombol Tambah -->
        <a href="{{ route('admin.pegawai.create') }}"
            class="inline-flex items-center text-white bg-[#00A181] hover:bg-[#008f73] focus:outline-none focus:ring-4 focus:ring-[#00A181]/50 font-medium rounded-lg text-sm px-6 py-2.5 text-center dark:bg-[#00A181] dark:hover:bg-[#008f73] dark:focus:ring-[#00795f]">
            <!-- Icon tambah -->
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Pegawai
        </a>

        <!-- Tombol Hapus -->
        <button id="bulkDeleteBtn"
            class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-6 py-2.5 disabled:opacity-50"
            disabled>
            <!-- Icon hapus -->
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4a1 1 0 011 1v1H9V4a1 1 0 011-1zM4 7h16">
                </path>
            </svg>
            Hapus Data yang Dipilih
        </button>
    </div>

    <table class="w-full text-base text-left text-gray-700 bg-white shadow-lg rounded-xl overflow-hidden">
        <thead class="text-white bg-[#00A181]">
            <tr>
                <th class="px-5 py-4 text-center"><input type="checkbox" id="checkAll"></th>
                <th class="px-5 py-4">NIP</th>
                <th class="px-5 py-4">Nama</th>
                <th class="px-5 py-4">Golongan</th>
                <th class="px-5 py-4">Jabatan</th>
                <th class="px-5 py-4">Unit Kerja</th>
                <th class="px-5 py-4">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($pegawai as $item)
                <tr class="hover:bg-gray-50 transition-all duration-150">
                    <td class="px-5 py-4 text-center">
                        <input type="checkbox" class="checkbox-item" value="{{ $item->nip }}">
                    </td>
                    <td class="px-5 py-4 font-medium">{{ $item->nip }}</td>
                    <td class="px-5 py-4">{{ $item->nama }}</td>
                    <td class="px-5 py-4">{{ $item->golongan->pangkat ?? '-' }}</td>
                    <td class="px-5 py-4">{{ $item->jabatan->nama_jabatan ?? '-' }}</td>
                    <td class="px-5 py-4">{{ $item->unitKerja->nama_kantor ?? '-' }}</td>
                    <td class="px-5 py-4 space-y-2">
                        {{-- Tombol Detail --}}
                        <a href="{{ route('admin.pegawai.show', $item->nip) }}"
                            class="inline-flex items-center text-white bg-blue-500 hover:bg-blue-600 font-semibold rounded-md text-sm px-4 py-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Detail
                        </a>

                        {{-- Tombol Edit --}}
                        <a href="{{ route('admin.pegawai.edit', $item->nip) }}"
                            class="inline-flex items-center text-white bg-yellow-500 hover:bg-yellow-600 font-semibold rounded-md text-sm px-4 py-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828A4 4 0 019 17H5v-4a4 4 0 014-4z" />
                            </svg>
                            Edit
                        </a>

                        {{-- Tombol Hapus --}}
                        <form action="{{ route('admin.pegawai.destroy', $item->nip) }}" method="POST"
                            class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                class="btn-delete inline-flex items-center text-white bg-red-500 hover:bg-red-600 font-semibold rounded-md text-sm px-4 py-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4a1 1 0 011 1v1H9V4a1 1 0 011-1zM4 7h16" />
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-500">Data tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="mt-6 flex justify-end">
        {{ $pegawai->appends(request()->all())->links() }}
    </div>
    @if ($pegawai->hasPages())
        <div class="mt-6 flex justify-end">
            <nav class="flex items-center space-x-1 text-sm">
                {{-- Tombol Previous --}}
                @if ($pegawai->onFirstPage())
                    <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">← Prev</span>
                @else
                    <a href="{{ $pegawai->previousPageUrl() }}"
                        class="px-3 py-1 bg-white border rounded-md text-[#00A181] hover:bg-[#00A181]/10">← Prev</a>
                @endif

                {{-- Angka halaman --}}
                @foreach ($pegawai->getUrlRange(1, $pegawai->lastPage()) as $page => $url)
                    @if ($page == $pegawai->currentPage())
                        <span
                            class="px-3 py-1 bg-[#00A181] text-white rounded-md font-semibold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                            class="px-3 py-1 bg-white border rounded-md hover:bg-[#00A181]/10 text-[#00A181]">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Tombol Next --}}
                @if ($pegawai->hasMorePages())
                    <a href="{{ $pegawai->nextPageUrl() }}"
                        class="px-3 py-1 bg-white border rounded-md text-[#00A181] hover:bg-[#00A181]/10">Next →</a>
                @else
                    <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">Next →</span>
                @endif
            </nav>
        </div>
    @endif
    <!-- Modal -->
    <div id="referensiModal"
        class="fixed top-24 left-1/2 transform -translate-x-1/2 z-50 hidden bg-white border border-gray-300 rounded-lg shadow-xl w-[95%] md:w-[70%] max-h-[80vh] overflow-y-auto p-5">
        <div class="flex justify-between items-center mb-3">
            <h2 class="text-lg font-semibold text-[#00A181]">Petunjuk Pengisian Excel</h2>
            <button onclick="toggleReferensiModal()" class="cursor-grabbing text-gray-500 hover:text-red-500">✖</button>
        </div>

        <p class="text-sm text-gray-600 mb-4">
            <strong>Catatan:</strong> NIP maksimal 18 digit. Gunakan ID dari data referensi berikut untuk kolom Provinsi,
            Kabupaten, Kecamatan, Golongan, Jabatan, dan Unit Kerja.
        </p>

        <!-- Tabs -->
        <div class="flex flex-wrap gap-2 mb-4">
            @foreach (['provinsi', 'kabupaten', 'kecamatan', 'golongan', 'jabatan', 'unitkerja'] as $tab)
                <button class="tab-btn bg-gray-200 text-black px-4 py-1.5 rounded text-sm"
                    onclick="showReferensiTab('{{ $tab }}', this)">
                    {{ ucfirst($tab) }}
                </button>
            @endforeach
        </div>

        <!-- Search -->
        <input type="text" id="searchInput" oninput="filterReferensiTable()" placeholder="Cari nama..."
            class="w-full px-3 py-2 mb-3 border border-gray-300 rounded text-sm" />

        <!-- Konten Tab -->
        <div id="referensiTable" class="overflow-x-auto text-sm">
            <p class="text-gray-500">Pilih salah satu tab di atas untuk melihat datanya.</p>
        </div>
    </div>

    <script>
        function changePerPage(perPage) {
            const params = new URLSearchParams(window.location.search);
            params.set('per_page', perPage);
            window.location.search = params.toString();
        }
    </script>
@endsection


@section('scripts')
    <script>
        document.getElementById('search').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
@endsection
@push('scripts')
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
@endpush

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const checkAll = document.getElementById('checkAll');
        const checkboxes = document.querySelectorAll('.checkbox-item');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

        // Toggle semua checkbox
        checkAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = checkAll.checked);
            toggleBulkDeleteBtn();
        });

        // Toggle tombol hapus jika ada yang dicentang
        checkboxes.forEach(cb => {
            cb.addEventListener('change', toggleBulkDeleteBtn);
        });

        function toggleBulkDeleteBtn() {
            const checked = [...checkboxes].some(cb => cb.checked);
            bulkDeleteBtn.disabled = !checked;
        }

        // Tombol Bulk Delete
        bulkDeleteBtn.addEventListener('click', function() {
            const selected = [...checkboxes].filter(cb => cb.checked).map(cb => cb.value);

            if (selected.length === 0) return;

            Swal.fire({
                title: 'Yakin ingin menghapus data terpilih?',
                text: `${selected.length} data akan dihapus!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim ke server via form dinamis
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ route('admin.pegawai.bulkDelete') }}";

                    const token = document.createElement('input');
                    token.type = 'hidden';
                    token.name = '_token';
                    token.value = '{{ csrf_token() }}';
                    form.appendChild(token);

                    selected.forEach(nip => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'nips[]';
                        input.value = nip;
                        form.appendChild(input);
                    });

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>

@push('scripts')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: false,
                confirmButtonColor: '#00A181'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal Import',
                html: `{!! session('error') !!}`,
                confirmButtonColor: 'red'
            });
        </script>
    @endif

    <script>
        let referensi = @json($referensi);
        let selectedProvinsiId = null;
        let selectedKabupatenId = null;

        function toggleReferensiModal() {
            const modal = document.getElementById('referensiModal');
            modal.classList.toggle('hidden');
            // Reset
            document.getElementById('referensiTable').innerHTML =
                '<p class="text-gray-500">Pilih salah satu tab di atas untuk melihat datanya.</p>';
            selectedProvinsiId = null;
            selectedKabupatenId = null;
        }

        function showReferensiTab(tabName, btn) {
            // Highlight tab aktif
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('bg-[#00A181]', 'text-white');
                el.classList.add('bg-gray-200', 'text-black');
            });
            btn.classList.remove('bg-gray-200', 'text-black');
            btn.classList.add('bg-[#00A181]', 'text-white', 'font-semibold', 'shadow-md', 'scale-105', 'border-b-4',
                'border-[#00745e]');

            let html = '';
            let headers = ['ID', 'Nama'];
            let rows = [];

            if (tabName === 'provinsi') {
                rows = referensi.provinsi.map(item => {
                    return `<tr onclick="handleSelectProvinsi(${item.id})" class="cursor-pointer hover:bg-[#00A181] hover:text-white">
                        <td class="border px-3 py-1.5">${item.id}</td>
                        <td class="border px-3 py-1.5">${item.nama}</td>
                    </tr>`;
                });
            } else if (tabName === 'kabupaten' && selectedProvinsiId) {
                headers = ['ID', 'Nama', 'ID Provinsi', 'Nama Provinsi'];
                rows = referensi.kabupaten
                    .filter(item => String(item.id_provinsi) === String(selectedProvinsiId))
                    .map(item => {
                        return `<tr onclick="handleSelectKabupaten(${item.id})" class="cursor-pointer hover:bg-[#00A181] hover:text-white">
                            <td class="border px-3 py-1.5">${item.id}</td>
                            <td class="border px-3 py-1.5">${item.nama}</td>
                            <td class="border px-3 py-1.5">${item.id_provinsi}</td>
                            <td class="border px-3 py-1.5">${item.nama_provinsi}</td>
                        </tr>`;
                    });
            } else if (tabName === 'kecamatan' && selectedKabupatenId) {
                headers = ['ID', 'Nama', 'ID Kabupaten', 'Nama Kabupaten'];
                rows = referensi.kecamatan
                    .filter(item => String(item.id_kabupaten) === String(selectedKabupatenId))
                    .map(item => {
                        return `<tr class="hover:bg-[#f0fdfa]">
                            <td class="border px-3 py-1.5">${item.id}</td>
                            <td class="border px-3 py-1.5">${item.nama}</td>
                            <td class="border px-3 py-1.5">${item.id_kabupaten}</td>
                            <td class="border px-3 py-1.5">${item.nama_kabupaten}</td>
                        </tr>`;
                    });
            } else if (['golongan', 'jabatan', 'unitkerja'].includes(tabName)) {
                rows = referensi[tabName].map(item => {
                    return `<tr class="hover:bg-[#f0fdfa]">
                        <td class="border px-3 py-1.5">${item.id}</td>
                        <td class="border px-3 py-1.5">${item.nama}</td>
                    </tr>`;
                });
            } else {
                document.getElementById('referensiTable').innerHTML =
                    `<p class="text-gray-500">Silakan pilih Provinsi dulu.</p>`;
                return;
            }

            html = `
                <table id="referensiTableContent" class="min-w-full table-auto border">
                    <thead>
                        <tr class="bg-gray-100 text-left text-xs text-gray-700 uppercase">
                            ${headers.map(header => `<th class="border px-3 py-2">${header}</th>`).join('')}
                        </tr>
                    </thead>
                    <tbody>
                        ${rows.join('')}
                    </tbody>
                </table>`;
            document.getElementById('referensiTable').innerHTML = html;
            document.getElementById('searchInput').value = '';
        }

        function handleSelectProvinsi(id) {
            selectedProvinsiId = id;
            selectedKabupatenId = null;
            showReferensiTab('kabupaten', document.querySelector("[onclick*='kabupaten']"));
        }

        function handleSelectKabupaten(id) {
            selectedKabupatenId = id;
            showReferensiTab('kecamatan', document.querySelector("[onclick*='kecamatan']"));
        }

        function filterReferensiTable() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const rows = document.querySelectorAll("#referensiTableContent tbody tr");
            rows.forEach(row => {
                const nama = row.cells[1]?.innerText.toLowerCase() || '';
                row.style.display = nama.includes(input) ? "" : "none";
            });
        }
    </script>
@endpush
