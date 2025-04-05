@extends('layouts.app-admin')

@section('content')
    <h1 class="text-3xl font-bold text-[#00A181]">Data Pegawai</h1>
    <p class="mb-4">Halaman daftar pegawai Kejaksaan Tinggi</p>
    <input type="text" id="search" class="border px-3 py-2 w-1/3" placeholder="Cari pegawai...">

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

    <table class="w-full border-collapse border-2 border-gray-100 p-2">
        <thead>
            <tr class="bg-[#00A181] text-left text-white">
                <th class="p-2 text-center"><input type="checkbox" id="checkAll"></th>

                <th class="p-2">NIP</th>
                <th class="p-2">Nama</th>
                <th class="p-2">Golongan</th>
                <th class="p-2">Jabatan</th>
                <th class="p-2">Unit Kerja</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($pegawai as $item)
                <tr class="border">
                    <td class="p-2 text-center">
                        <input type="checkbox" class="checkbox-item" value="{{ $item->nip }}">
                    </td>
                    <td class="p-2">{{ $item->nip }}</td>
                    <td class="p-2">{{ $item->nama }}</td>
                    <td class="p-2">{{ $item->golongan->pangkat ?? '-' }} </td>
                    <td class="p-2">{{ $item->jabatan->nama_jabatan ?? '-' }}</td>
                    <td class="p-2">{{ $item->unitKerja->nama_kantor ?? '-' }}
                    </td>
                    <td class="p-2">
                        <a href="{{ route('admin.pegawai.show', $item->nip) }}"
                            class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <!-- Icon Detail (eye) -->
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                            Detail
                        </a>

                        <a href="{{ route('admin.pegawai.edit', $item->nip) }}"
                            class="inline-flex items-center text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">
                            <!-- Icon Edit (pencil) -->
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828A4 4 0 019 17H5v-4a4 4 0 014-4z">
                                </path>
                            </svg>
                            Edit
                        </a>

                        <form action="{{ route('admin.pegawai.destroy', $item->nip) }}" method="POST"
                            class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                class="btn-delete inline-flex items-center cursor-pointer text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                <!-- Icon Hapus (trash) -->
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4a1 1 0 011 1v1H9V4a1 1 0 011-1zM4 7h16">
                                    </path>
                                </svg>
                                Hapus
                            </button>
                        </form>


                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
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
