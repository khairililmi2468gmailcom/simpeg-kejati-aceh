<h1 class="text-3xl font-bold text-[#00A181]">Daftar Unit Kerja</h1>
<p class="text-gray-400 italic">Pages Unit Kerja</p>

<div class="flex flex-wrap justify-between items-center mb-4 mt-4">
    <!-- Input Search -->
    <div class="w-full md:w-1/3 mb-4 md:mb-0 relative">
        <form action="{{ route('admin.settings.index') }}" method="GET">
            <input type="text" name="searchUnitKerja" value="{{ request('searchUnitKerja') }}"
                placeholder="Cari Nama Kantor..."
                class="px-4 py-2 mb-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#00A181] w-full">
            <select name="per_page_unit_kerja" onchange="this.form.submit()"
                class="border border-gray-300 px-3 py-2 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#00A181] w-full">
                @foreach ([5, 10, 25, 50, 100, 250, 500, 1000, 2000, 5000, 10000] as $size)
                    <option value="{{ $size }}"
                        {{ request('per_page_unit_kerja', 5) == $size ? 'selected' : '' }}>
                        {{ $size }} / halaman
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="flex flex-wrap justify-end space-x-2">

        <a href="{{ route('admin.settings.unitkerja.create') }}"
            class="inline-flex items-center text-white bg-[#00A181] hover:bg-[#008f73] focus:outline-none focus:ring-4 focus:ring-[#00A181]/50 font-medium rounded-lg text-sm px-6 py-2.5 text-center mb-2 md:mb-0">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Unit Kerja
        </a>

        <!-- Hapus Data -->
        <button id="bulkDeleteBtn"
            class="bulk-delete-btn cursor-pointer inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-6 py-2.5 opacity-50 mb-2 md:mb-0"
            data-action="{{ route('admin.settings.unitkerja.bulkDelete') }}" data-token="{{ csrf_token() }}" disabled>
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
                <th class="px-5 py-4 text-center"><input type="checkbox" class="check-all" id="checkAll"></th>
                <th class="px-5 py-4">Kode Kantor</th>
                <th class="px-5 py-4">Nama Kantor</th>
                <th class="px-5 py-4">Provinsi</th>
                <th class="px-5 py-4">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($unitkerjas as $item)
                <tr class="hover:bg-gray-50 transition-all duration-150">
                    <td class="px-5 py-4 text-center">
                        <input type="checkbox" class="checkbox-item" value="{{ $item->kode_kantor }}">
                    </td>
                    <td class="px-5 py-4">{{ $item->kode_kantor ?? '-' }}</td>
                    <td class="px-5 py-4">{{ $item->nama_kantor ?? '-' }}</td>
                    <td class="px-5 py-4">{{ $item->provinsi->nama_provinsi  ?? '-'}}</td>
                    <td class="px-5 py-4 space-y-2">
                        <a href="{{ route('admin.settings.unitkerja.edit', $item->kode_kantor) }}"
                            class="w-full sm:w-auto inline-flex justify-center items-center text-white bg-yellow-500 hover:bg-yellow-600 font-semibold rounded-md text-sm px-4 py-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828A4 4 0 019 17H5v-4a4 4 0 014-4z" />
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('admin.settings.unitkerja.destroy', $item->kode_kantor) }}"
                            method="POST" class="w-full sm:w-auto inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                class="cursor-pointer w-full sm:w-auto btn-delete inline-flex justify-center items-center text-white bg-red-500 hover:bg-red-600 font-semibold rounded-md text-sm px-4 py-2">
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
                    <td colspan="4" class="text-center py-6 text-gray-500">Data tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-6 flex justify-end">
    {{ $unitkerjas->links() }}
</div>
@if ($unitkerjas->hasPages())
    <div class="mt-6 flex justify-end">
        <nav class="flex items-center space-x-1 text-sm">
            {{-- Tombol Previous --}}
            @if ($unitkerjas->onFirstPage())
                <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">← Prev</span>
            @else
                <a href="{{ $unitkerjas->previousPageUrl() }}"
                    class="px-3 py-1 bg-white border rounded-md text-[#00A181] hover:bg-[#00A181]/10">← Prev</a>
            @endif

            {{-- Angka halaman --}}
            @foreach ($unitkerjas->getUrlRange(1, $unitkerjas->lastPage()) as $page => $url)
                @if ($page == $unitkerjas->currentPage())
                    <span class="px-3 py-1 bg-[#00A181] text-white rounded-md font-semibold">{{ $page }}</span>
                @else
                    <a href="{{ $url }}"
                        class="px-3 py-1 bg-white border rounded-md hover:bg-[#00A181]/10 text-[#00A181]">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Tombol Next --}}
            @if ($unitkerjas->hasMorePages())
                <a href="{{ $unitkerjas->nextPageUrl() }}"
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



@push('scripts')
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
    </script>
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
