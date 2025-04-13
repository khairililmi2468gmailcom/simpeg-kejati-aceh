@extends('layouts.app-admin')

@section('content')
    <h1 class="text-3xl font-bold text-[#00A181]">Kabupaten</h1>
    <p class="text-gray-600">Halaman Kabupaten</p>
    <!-- Info Button with Tooltip -->
    <div class="flex items-center justify-end  space-x-2 mb-2">
        <button onclick="toggleReferensiModal()"
            class="cursor-pointer inline-flex items-center justify-center w-9 h-9 rounded-full bg-yellow-400 hover:bg-yellow-500 text-white focus:outline-none"
            title="Lihat petunjuk pengisian Excel">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
            </svg>
        </button>
        <span class="text-sm text-gray-600 hidden md:inline">Petunjuk Pengisian Excel</span>
    </div>
    <div class="flex flex-wrap justify-between items-center mb-4 mt-4">
        <!-- Input Search -->
        <div class="w-full md:w-1/3 mb-4 md:mb-0 relative">
            <form action="{{ route('admin.kabupaten.index') }}" method="GET">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Kabupaten..."
                    class="px-4 py-2 mb-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#00A181] w-full">
                <select name="per_page" onchange="this.form.submit()"
                    class="border border-gray-300 px-3 py-2 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#00A181] w-full">
                    @foreach ([5, 10, 25, 50, 100, 250, 500, 1000, 2000, 5000, 10000] as $size)
                        <option value="{{ $size }}" {{ request('per_page', 5) == $size ? 'selected' : '' }}>
                            {{ $size }} / halaman
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="flex flex-wrap justify-end space-x-2">

            <!-- Download Template -->
            <a href="{{ route('admin.kabupaten.download-template') }}"
                class="inline-flex items-center px-4 py-2 bg-[#00A181] text-white rounded hover:bg-[#009171] transition mb-2 md:mb-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M5 20h14v-2H5v2zm7-18l-5.5 5.5h3.5v6h4v-6h3.5L12 2z" />
                </svg>
                Download Template
            </a>

            <!-- Import Excel -->
            <button id="openImportModal"
                class="cursor-pointer bg-[#00A181] text-white px-4 py-2 rounded hover:bg-[#009171] flex items-center gap-2 transition mb-2 md:mb-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                    <path
                        d="M19 2H8c-1.1 0-2 .9-2 2v4h2V4h11v16H8v-4H6v4c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z" />
                    <path d="M13 12h-2V8H8l4-4 4 4h-3zM5 18v-2h6v2H5z" />
                </svg>
                Import Excel
            </button>

            <!-- Tambah Kabupaten -->
            <a href="{{ route('admin.kabupaten.create') }}"
                class="inline-flex items-center text-white bg-[#00A181] hover:bg-[#008f73] focus:outline-none focus:ring-4 focus:ring-[#00A181]/50 font-medium rounded-lg text-sm px-6 py-2.5 text-center mb-2 md:mb-0">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Kabupaten
            </a>

            <!-- Hapus Data -->
            <button id="bulkDeleteBtn"
                class="cursor-pointer inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-6 py-2.5 disabled:opacity-50 mb-2 md:mb-0"
                disabled>
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4a1 1 0 011 1v1H9V4a1 1 0 011-1zM4 7h16">
                    </path>
                </svg>
                Hapus Data yang Dipilih
            </button>

        </div>
    </div>

    <!-- Tabel Provinsi -->
    <div class="overflow-auto max-h-[70vh] rounded-xl scrollbar-hidden">

        <table class="w-full text-base text-left text-gray-700 bg-white shadow-lg rounded-xl overflow-hidden">
            <thead class="text-white bg-[#00A181]">
                <tr>
                    <th class="px-5 py-4 text-center"><input type="checkbox" id="checkAll"></th>
                    <th class="px-5 py-4">ID Kabupaten</th>
                    <th class="px-5 py-4">Nama Kabupaten</th>
                    <th class="px-5 py-4">ID Provinsi</th>
                    <th class="px-5 py-4">Nama Provinsi</th>
                    <th class="px-5 py-4">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200" id="provinsiTableBody">
                @forelse ($kabupaten as $item)
                    <tr class="hover:bg-gray-50 transition-all duration-150">
                        <td class="px-5 py-4 text-center">
                            <input type="checkbox" class="checkbox-item" value="{{ $item->id }}">
                        </td>
                        <td class="px-5 py-4">{{ $item->id }}</td>
                        <td class="px-5 py-4">{{ $item->nama_kabupaten }}</td>
                        <td class="px-5 py-4">{{ $item->provinsi->id }}</td>
                        <td class="px-5 py-4">{{ $item->provinsi->nama_provinsi }}</td>
                        <td class="px-5 py-4 space-y-2">
                            <a href="{{ route('admin.kabupaten.edit', $item->id) }}"
                                class="w-full sm:w-auto inline-flex justify-center items-center text-white bg-yellow-500 hover:bg-yellow-600 font-semibold rounded-md text-sm px-4 py-2">
                                Edit
                            </a>
                            <form action="{{ route('admin.kabupaten.destroy', $item->id) }}" method="POST"
                                class="w-full sm:w-auto inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    class="cursor-pointer w-full sm:w-auto btn-delete inline-flex justify-center items-center text-white bg-red-500 hover:bg-red-600 font-semibold rounded-md text-sm px-4 py-2">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">Data tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- Pagination --}}
    <div class="mt-6 flex justify-end">
        {{ $kabupaten->links() }}
    </div>
    @if ($kabupaten->hasPages())
        <div class="mt-6 flex justify-end">
            <nav class="flex items-center space-x-1 text-sm">
                {{-- Tombol Previous --}}
                @if ($kabupaten->onFirstPage())
                    <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">← Prev</span>
                @else
                    <a href="{{ $kabupaten->previousPageUrl() }}"
                        class="px-3 py-1 bg-white border rounded-md text-[#00A181] hover:bg-[#00A181]/10">← Prev</a>
                @endif

                {{-- Angka halaman --}}
                @foreach ($kabupaten->getUrlRange(1, $kabupaten->lastPage()) as $page => $url)
                    @if ($page == $kabupaten->currentPage())
                        <span class="px-3 py-1 bg-[#00A181] text-white rounded-md font-semibold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                            class="px-3 py-1 bg-white border rounded-md hover:bg-[#00A181]/10 text-[#00A181]">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Tombol Next --}}
                @if ($kabupaten->hasMorePages())
                    <a href="{{ $kabupaten->nextPageUrl() }}"
                        class="px-3 py-1 bg-white border rounded-md text-[#00A181] hover:bg-[#00A181]/10">Next →</a>
                @else
                    <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">Next →</span>
                @endif
            </nav>
        </div>
    @endif

    <script>
        function changePerPage(perPage) {
            const params = new URLSearchParams(window.location.search);
            params.set('per_page', perPage);
            window.location.search = params.toString();
        }
    </script>
    <!-- Modal Upload -->
    <div id="importModal" class="fixed inset-0 bg-transparent bg-opacity-10 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6 relative">
            <!-- Close Button -->
            <button id="closeImportModal" class="cursor-pointer absolute top-2 right-2 text-gray-600 hover:text-red-500">
                ✕
            </button>

            <h2 class="text-xl font-semibold text-[#00A181] mb-4">Upload File Excel</h2>
            <form id="importForm" action="{{ route('admin.kabupaten.import') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div id="dropzone"
                    class="border-2 border-dashed border-gray-300 p-6 rounded-lg text-center text-gray-600 cursor-pointer hover:border-[#00A181] hover:text-[#00A181] transition">
                    <p class="mb-2">Seret file ke sini atau klik untuk pilih file Excel</p>
                    <div id="filePreview" class="hidden mt-2 flex items-center justify-center gap-2 text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M16.704 2.29a1 1 0 00-.707-.29H7a2 2 0 00-2 2v2H4a2 2 0 00-2 2v6a2 2 0 002 2h4.5v2H6a1 1 0 000 2h8a1 1 0 000-2h-2.5v-2H16a2 2 0 002-2V4a1 1 0 00-.296-.71zM12 18h-4v-2h4v2zm4-4H4V8h12v6zm0-8H6V4h10v2z" />
                        </svg>
                        <span id="fileName" class="text-sm font-medium"></span>
                    </div>
                    <input type="file" name="file" id="excelFileInput" accept=".xlsx,.xls" class="hidden"
                        required>

                </div>

                <div class="mt-4 text-right">
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-4 hidden" id="progressContainer">
                        <div class="bg-[#00A181] h-2.5 rounded-full transition-all duration-300" id="progressBar"
                            style="width: 0%;"></div>
                    </div>
                    <button type="submit" id="uploadBtn"
                        class="cursor-pointer bg-[#00A181] text-white px-4 py-2 rounded hover:bg-[#009171] transition">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal -->
    <div id="referensiModal"
        class="fixed top-24 left-1/2 transform -translate-x-1/2 z-50 hidden bg-white border border-gray-300 rounded-lg shadow-xl w-[95%] md:w-[70%] max-h-[80vh] overflow-y-auto p-5">
        <div class="flex justify-between items-center mb-3">
            <h2 class="text-lg font-semibold text-[#00A181]">Petunjuk Pengisian Excel</h2>
            <button onclick="toggleReferensiModal()"
                class="cursor-pointer text-gray-500 hover:text-red-500 text-xl">✖</button>
        </div>

        <p class="text-sm text-gray-600 mb-4">
            <strong>Catatan:</strong> Gunakan ID Provinsi sesuai referensi berikut untuk kolom <code>id_provinsi</code> di
            file Excel.
        </p>

        <!-- Search -->
        <input type="text" id="searchInput" oninput="filterReferensiTable()" placeholder="Cari nama provinsi..."
            class="w-full px-3 py-2 mb-3 border border-gray-300 rounded text-sm" />

        <!-- Tabel Provinsi -->
        <div id="referensiTable" class="overflow-x-auto text-sm">
            <table id="referensiTableContent" class="min-w-full table-auto border">
                <thead>
                    <tr class="bg-gray-100 text-left text-xs text-gray-700 uppercase">
                        <th class="border px-3 py-2">ID Provinsi</th>
                        <th class="border px-3 py-2">Nama Provinsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($referensi['provinsi'] as $prov)
                        <tr class="hover:bg-[#00A181] hover:text-white">
                            <td class="border px-3 py-1.5">{{ $prov->id }}</td>
                            <td class="border px-3 py-1.5">{{ $prov->nama }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
                    form.action = "{{ route('admin.kabupaten.bulkDelete') }}";

                    const token = document.createElement('input');
                    token.type = 'hidden';
                    token.name = '_token';
                    token.value = '{{ csrf_token() }}';
                    form.appendChild(token);

                    selected.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'id[]';
                        input.value = id;
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
    <script>
        // Open modal
        document.getElementById('openImportModal').addEventListener('click', () => {
            document.getElementById('importModal').classList.remove('hidden');
        });

        // Close modal
        document.getElementById('closeImportModal').addEventListener('click', () => {
            document.getElementById('importModal').classList.add('hidden');
        });

        // Dropzone logic
        const dropzone = document.getElementById('dropzone');
        const input = document.getElementById('excelFileInput');

        dropzone.addEventListener('click', () => input.click());

        dropzone.addEventListener('dragover', e => {
            e.preventDefault();
            dropzone.classList.add('border-[#00A181]', 'text-[#00A181]');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('border-[#00A181]', 'text-[#00A181]');
        });

        dropzone.addEventListener('drop', e => {
            e.preventDefault();
            dropzone.classList.remove('border-[#00A181]', 'text-[#00A181]');
            input.files = e.dataTransfer.files;

            if (input.files.length > 0) {
                document.getElementById('fileName').textContent = input.files[0].name;
                document.getElementById('filePreview').classList.remove('hidden');
            }
        });

        input.addEventListener('change', () => {
            const preview = document.getElementById('filePreview');
            const fileNameSpan = document.getElementById('fileName');

            if (input.files.length > 0) {
                fileNameSpan.textContent = input.files[0].name;
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
                fileNameSpan.textContent = '';
            }
        });

        document.getElementById('importForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            const progressBar = document.getElementById('progressBar');
            const progressContainer = document.getElementById('progressContainer');
            const uploadBtn = document.getElementById('uploadBtn');

            progressContainer.classList.remove('hidden');
            uploadBtn.disabled = true;
            progressBar.style.width = '0%';

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Failed to fetch response');
                    }
                })
                .then(data => {
                    uploadBtn.disabled = false;
                    progressBar.style.width = '100%';

                    setTimeout(() => {
                        progressContainer.classList.add('hidden');
                        progressBar.style.width = '0%';

                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: data.message || 'Data berhasil diimpor!',
                                confirmButtonColor: '#00A181'
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: data.message || 'Terjadi kesalahan saat mengimpor.',
                                confirmButtonColor: '#00A181'
                            });
                        }
                    }, 500);
                })
                .catch(error => {
                    uploadBtn.disabled = false;
                    progressContainer.classList.add('hidden');
                    progressBar.style.width = '0%';

                    console.error('Error during upload:', error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat mengirim data. Lihat konsol untuk detail.',
                        confirmButtonColor: '#00A181'
                    });
                });
        });

        // ✅ Pastikan modal disembunyikan saat reload
        window.addEventListener('load', () => {
            document.getElementById('importModal').classList.add('hidden');
        });
    </script>
    <script>
        function toggleReferensiModal() {
            const modal = document.getElementById('referensiModal');
            modal.classList.toggle('hidden');
            document.getElementById('searchInput').value = '';
            filterReferensiTable();
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
