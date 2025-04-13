@extends('layouts.app-admin')

@section('content')
    <h1 class="text-3xl font-bold text-[#00A181]">Diklat</h1>
    <p class="text-gray-600">Halaman Diklat</p>

    <div class="flex flex-wrap justify-between items-center mb-4 mt-4">
        <!-- Input Search -->
        <div class="w-full md:w-1/3 mb-4 md:mb-0 relative">
            <form action="{{ route('admin.diklat.master.index') }}" method="GET">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Diklat..."
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



            <!-- Tambah Kecamatan -->
            <a href="{{ route('admin.diklat.master.create') }}"
                class="inline-flex items-center text-white bg-[#00A181] hover:bg-[#008f73] focus:outline-none focus:ring-4 focus:ring-[#00A181]/50 font-medium rounded-lg text-sm px-6 py-2.5 text-center mb-2 md:mb-0">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Kecamatan
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
    <table class="w-full text-base text-left text-gray-700 bg-white shadow-lg rounded-xl overflow-hidden">
        <thead class="text-white bg-[#00A181]">
            <tr>
                <th class="px-5 py-4 text-center"><input type="checkbox" id="checkAll"></th>
                <th class="px-5 py-4">Nama Diklat</th>
                <th class="px-5 py-4">Jenis Diklat</th>
                <th class="px-5 py-4">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
            @forelse ($diklat as $item)
                <tr class="hover:bg-gray-50 transition-all duration-150">
                    <td class="px-5 py-4 text-center">
                        <input type="checkbox" class="checkbox-item" value="{{ $item->id }}">
                    </td>
                    <td class="px-5 py-4">{{ $item->nama_diklat }}</td>
                    <td class="px-5 py-4">{{ $item->jenis_diklat }}</td>
                    <td class="px-5 py-4 space-y-2">
                        <a href="{{ route('admin.diklat.master.edit', $item->id) }}"
                            class="w-full sm:w-auto inline-flex justify-center items-center text-white bg-yellow-500 hover:bg-yellow-600 font-semibold rounded-md text-sm px-4 py-2">
                            Edit
                        </a>
                        <form action="{{ route('admin.diklat.master.destroy', $item->id) }}" method="POST"
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
    {{-- Pagination --}}
    <div class="mt-6 flex justify-end">
        {{ $diklat->links() }}
    </div>
    @if ($diklat->hasPages())
        <div class="mt-6 flex justify-end">
            <nav class="flex items-center space-x-1 text-sm">
                {{-- Tombol Previous --}}
                @if ($diklat->onFirstPage())
                    <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">← Prev</span>
                @else
                    <a href="{{ $diklat->previousPageUrl() }}"
                        class="px-3 py-1 bg-white border rounded-md text-[#00A181] hover:bg-[#00A181]/10">← Prev</a>
                @endif

                {{-- Angka halaman --}}
                @foreach ($diklat->getUrlRange(1, $diklat->lastPage()) as $page => $url)
                    @if ($page == $diklat->currentPage())
                        <span class="px-3 py-1 bg-[#00A181] text-white rounded-md font-semibold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                            class="px-3 py-1 bg-white border rounded-md hover:bg-[#00A181]/10 text-[#00A181]">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Tombol Next --}}
                @if ($diklat->hasMorePages())
                    <a href="{{ $diklat->nextPageUrl() }}"
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
                    form.action = "{{ route('admin.diklat.master.bulkDelete') }}";

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
