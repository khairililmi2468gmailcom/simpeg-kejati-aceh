@if ($kepalakejaksaan && $kepalakejaksaan->count())
    {{-- Form Edit --}}
    <div class="max-w-3xl mx-auto mt-10">
        <div class="bg-white shadow-md rounded-xl p-8">
            <div class="flex items-center mb-6">
                <svg class="h-8 w-8 text-[#00A181] mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A13.937 13.937 0 0112 15c2.137 0 4.145.502 5.879 1.388M15 11a3 3 0 10-6 0 3 3 0 006 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="text-2xl font-bold text-[#00A181]">Edit Kepala Kejaksaan</h2>
            </div>

            <form action="{{ route('admin.settings.kepalakejaksaan.update', $kepalakejaksaan->first()->id) }}"
                method="POST" id="editForm">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div class="mb-5">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="nama" id="nama" value="{{ $kepalakejaksaan->first()->nama }}"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]">
                </div>

                {{-- NIP --}}
                <div class="mb-5">
                    <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                    <input type="number" name="nip" id="nip" value="{{ $kepalakejaksaan->first()->nip }}"
                        maxlength="18"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]">
                </div>
                {{-- Pangkat --}}
                <div class="mb-5">
                    <label for="pangkat" class="block text-sm font-medium text-gray-700 mb-1">Pangkat</label>
                    <input type="text" name="pangkat" id="pangkat" value="{{ $kepalakejaksaan->first()->pangkat }}"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#00A181]">
                </div>

                {{-- Plt Checkbox --}}
                <div class="mb-5">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="isPlt" value="1" class="form-checkbox text-[#00A181]"
                            {{ $kepalakejaksaan->first()->isPlt ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700">Pejabat Pelaksana Tugas (Plt)</span>
                    </label>
                </div>



                {{-- Tombol --}}
                <div class="flex justify-end">
                    <button type="button" id="submitBtn"
                        class="cursor-pointer bg-[#00A181] hover:bg-[#008F75] text-white font-semibold px-6 py-2 rounded-lg shadow transition duration-150">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@else
    {{-- Tombol Create --}}
    <div class="flex justify-center mt-10">
        <a href="{{ route('admin.settings.kepalakejaksaan.create') }}"
            class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow transition duration-150">
            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Kepala Kejaksaan
        </a>
    </div>
@endif
@if ($errors->any())
    <script>
        window.addEventListener('load', () => {
            let errorMessages = `{!! implode('\n', $errors->all()) !!}`;
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
        document.getElementById('nip').addEventListener('input', function() {
            if (this.value.length > 18) {
                this.value = this.value.slice(0, 18);
            }
        });
        document.getElementById('submitBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Perbarui Data?',
                text: "Apakah Anda yakin ingin memperbarui data ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00A181',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('editForm').submit();
                }
            });
        });
    </script>
@endpush
