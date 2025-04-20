<div class="overflow-x-auto rounded-xl shadow mb-2">
    <div class="flex items-center justify-between bg-[#00A181] px-6 py-4 rounded-t-lg">
        <h3 class="text-lg font-semibold text-white font-poppins">Daftar Cuti Pegawai</h3>
        <form method="GET" action="{{ route('admin.laporan.index') }}"
            class="md:flex md:gap-3 grid gap-4 w-full md:w-1/3">

            <input type="hidden" name="tab" value="cuti">
            <div class="flex items-center w-full md:flex-[1]">
                <select name="per_page_cuti" onchange="this.form.submit()"
                    class="w-full border border-gray-300 text-black px-3 py-2 bg-white rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]">
                    @foreach ([5, 10, 25, 50, 100, 250, 500, 1000, 2000, 5000, 10000] as $size)
                        <option value="{{ $size }}"
                            {{ request('per_page_cuti', 5) == $size ? 'selected' : '' }}>
                            {{ $size }} / halaman
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="relative w-full md:flex-[2]">
                <input type="text" name="searchCuti" id="search" value="{{ request('searchCuti') }}"
                    class="w-full px-4 py-2 pl-10 text-sm text-black border border-gray-300 rounded-md bg-[#F0F0F0] focus:outline-none focus:ring-2 focus:ring-[#00A181]"
                    placeholder="Cari Cuti Pegawai...">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                    </svg>
                </div>
            </div>
        </form>
    </div>
    <table class="min-w-full bg-white border border-gray-300 rounded-xl">
        <thead class="bg-gray-100 text-[#02172C] font-poppins text-sm text-center">
            <tr class="uppercase">
                <th class="px-4 py-3 border border-gray-300">No</th>
                <th class="px-4 py-3 border border-gray-300">Nama, NIP</th>
                <th class="px-4 py-3 border border-gray-300">No. Surat</th>
                <th class="px-4 py-3 border border-gray-300">Jenis Cuti</th>
                <th class="px-4 py-3 border border-gray-300">Tanggal Mulai</th>
                <th class="px-4 py-3 border border-gray-300">Tanggal Selesai</th>
                <th class="px-4 py-3 border border-gray-300">Keterangan</th>
                <th class="px-4 py-3 border border-gray-300">Action</th>
            </tr>
        </thead>
        <tbody class="bg-[#F9FAFB] text-gray-800 text-sm font-poppins">
            @forelse ($menerimaCuti as $index => $cuti)
                <tr class="hover:bg-gray-100 transition duration-150 ease-in-out">
                    <td class="px-4 py-3 border border-gray-300 text-center">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 border border-gray-300">
                        <div class="font-medium text-black">{{ $cuti->pegawai->nama }}</div>
                        <div class="text-xs text-gray-500">NIP: {{ $cuti->pegawai->nip }}</div>
                    </td>
                    <td class="px-4 py-3 border border-gray-300">{{ $cuti->no_surat }}</td>
                    <td class="px-4 py-3 border border-gray-300">{{ $cuti->cuti->jenis_cuti }}</td>
                    <td class="px-4 py-3 border border-gray-300">
                        {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d-m-Y') }}</td>
                    <td class="px-4 py-3 border border-gray-300">
                        {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d-m-Y') }}</td>
                    <td class="px-4 py-3 border border-gray-300">{{ $cuti->keterangan }}</td>
                    <td class="px-4 py-3 border border-gray-300 text-center">
                        <a href="#"
                            class="bg-[#00A181] hover:bg-[#007f66] text-white px-3 py-1 rounded-md text-xs font-medium transition">
                            Cetak
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="16" class="text-center py-6 text-gray-500">Data tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-4  flex justify-end">
    {{ $menerimaCuti->appends(request()->all())->links() }}
</div>
@if ($menerimaCuti->hasPages())
    <div class="mt-6 flex justify-end mb-8">
        <nav class="flex items-center space-x-1 text-sm">
            {{-- Tombol Previous --}}
            @if ($menerimaCuti->onFirstPage())
                <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">← Prev</span>
            @else
                <a href="{{ $menerimaCuti->previousPageUrl() }}"
                    class="px-3 py-1 bg-white border rounded-md text-[#00A181] hover:bg-[#00A181]/10">← Prev</a>
            @endif

            {{-- Angka halaman --}}
            @foreach ($menerimaCuti->getUrlRange(1, $menerimaCuti->lastPage()) as $page => $url)
                @if ($page == $menerimaCuti->currentPage())
                    <span class="px-3 py-1 bg-[#00A181] text-white rounded-md font-semibold">{{ $page }}</span>
                @else
                    <a href="{{ $url }}"
                        class="px-3 py-1 bg-white border rounded-md hover:bg-[#00A181]/10 text-[#00A181]">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Tombol Next --}}
            @if ($menerimaCuti->hasMorePages())
                <a href="{{ $menerimaCuti->nextPageUrl() }}"
                    class="px-3 py-1 bg-white border rounded-md text-[#00A181] hover:bg-[#00A181]/10">Next →</a>
            @else
                <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">Next →</span>
            @endif
        </nav>
    </div>
@endif
{{-- Pencarian dan Filter --}}
<div class="bg-white max-w-180 rounded-lg p-8 shadow-md">
    <h3 class="text-[20px] font-semibold mb-4">Pencarian Pegawai Kejaksaan Tinggi Aceh</h3>

    <form method="GET" action="{{ route('admin.laporan.index') }}">
        <input type="hidden" name="tab" value="cuti">

        <div class="flex flex-col md:flex-row md:space-x-4 mb-4">
            <div class="flex-1 relative">
                <input type="text" name="searchCuti" placeholder="Masukkan NIP Pegawai"
                    value="{{ request('searchCuti') }}" class="w-full border px-4 py-2 rounded-lg" />
            </div>
            <div>
                <button type="submit" class="cursor-pointer bg-[#00A181] text-white px-6 py-2 rounded-lg mt-2 md:mt-0">
                    Cari
                </button>
            </div>
        </div>
        <h3 class="text-[20px] font-semibold mb-4">Berdasarkan Tahun Cuti</h3>

        {{-- Dropdown Tahun Cuti --}}
        <div class="w-full shadow-md p-4 border border-[#E0E0E0] rounded-md mb-6">
            <div class="flex flex-wrap items-center w-full mb-4">
                <div class="w-full md:w-1/2  md:pl-8 mb-2 md:mb-0">
                    <label class="block text-[18px] font-semibold text-gray-800">
                        Laporan Tahun Cuti
                    </label>
                </div>
                <div class="w-full md:w-1/2 pr-5 relative">
                    <div class="relative">
                        <div class="selected-item w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm cursor-pointer flex justify-between items-center"
                            onclick="toggleDropdown('tahuncuti')">
                            <span id="tahuncuti-display">
                                {{ request('tahun_cuti') ?? '-- Pilih Tahun Cuti --' }}
                            </span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <div id="tahuncuti-dropdown"
                            class="dropdown-content hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-64 overflow-y-auto">
                            <input type="text" class="w-full px-3 py-2 border-b border-gray-200 focus:outline-none"
                                placeholder="Cari Tahun..." onkeyup="filterOptions('tahuncuti', this.value)">
                            <div class="options" id="tahuncuti-options">
                                @foreach ($tahunList as $tahun)
                                    <div class="option-item px-3 py-2 hover:bg-gray-100 cursor-pointer transition-colors {{ request('tahun_cuti') == $tahun ? 'bg-[#00A181] text-white hover:bg-[#009171]' : '' }}"
                                        data-value="{{ $tahun }}"
                                        onclick='selectItem("tahuncuti", @json($tahun), @json($tahun))'>
                                        {{ $tahun }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="tahun_cuti" id="tahuncuti-input"
                        value="{{ request('tahun_cuti') }}">
                </div>
            </div>

            {{-- Tombol Cari --}}
            <div class="w-full">
                <button type="submit"
                    class="cursor-pointer w-full bg-[#00A181] hover:bg-[#008f73] text-white px-6 py-2 rounded-md text-[16px] font-semibold">
                    Cari
                </button>
            </div>
        </div>

        <a href="{{ route('admin.laporan.index', ['tab' => 'cuti']) }}"
            class="cursor-pointer w-[6rem] mt-4 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-3 py-2 rounded-lg flex items-center space-x-1"
            title="Reset Pencarian">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-500" viewBox="0 0 21 21"
                fill="none">
                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                    stroke-linejoin="round" transform="matrix(0 1 1 0 2.5 2.5)">
                    <path
                        d="M3.9865 1.0781C1.6027 2.4632 0 5.0444 0 8c0 4.4183 3.5817 8 8 8s8-3.5817 8-8-3.5817-8-8-8" />
                    <path d="M4 1v4H0" transform="matrix(1 0 0 -1 0 6)" />
                </g>
            </svg>
            <span>Reset</span>
        </a>
        <div class="mt-4 text-sm text-gray-600">
            <p>Petunjuk:</p>
            <ul class="list-disc ml-6">
                <li>Masukkan Tahun Cuti yang bersangkutan</li>
                <li>Klik Tombol Cari</li>
            </ul>
        </div>
    </form>
</div>
<script>
    const dropdowns = {
        unitkerja: false,
        jabatanfungsional: false,
        tahuncuti: false,
    };

    function toggleDropdown(type) {
        for (let key in dropdowns) {
            if (key !== type) {
                const el = document.getElementById(`${key}-dropdown`);
                if (el) el.classList.add('hidden');
                dropdowns[key] = false;
            }
        }

        dropdowns[type] = !dropdowns[type];
        const currentDropdown = document.getElementById(`${type}-dropdown`);
        if (currentDropdown) currentDropdown.classList.toggle('hidden', !dropdowns[type]);
    }

    function filterOptions(type, searchValue) {
        const options = document.querySelectorAll(`#${type}-options .option-item`);
        options.forEach(option => {
            const text = option.textContent.toLowerCase();
            option.style.display = text.includes(searchValue.toLowerCase()) ? 'block' : 'none';
        });
    }

    function selectItem(type, value, label) {
        // Update tampilan dan input
        document.getElementById(`${type}-display`).textContent = label;
        document.getElementById(`${type}-input`).value = value;

        // Highlight item yang dipilih
        const items = document.querySelectorAll(`#${type}-options .option-item`);
        items.forEach(item => {
            if (item.dataset.value === value.toString()) {
                item.classList.add('bg-[#00A181]', 'text-white', 'hover:bg-[#009171]');
            } else {
                item.classList.remove('bg-[#00A181]', 'text-white', 'hover:bg-[#009171]');
            }
        });

        toggleDropdown(type); // close dropdown
    }

    // Close dropdown if click outside
    document.addEventListener('click', function(event) {
        Object.keys(dropdowns).forEach(type => {
            const dropdown = document.getElementById(`${type}-dropdown`);
            const trigger = document.querySelector(`[onclick="toggleDropdown('${type}')"]`);

            // ⛑️ Tambahkan pengecekan null
            if (!dropdown || !trigger) return; // skip this type if element not found
            if (!dropdown.contains(event.target) && !trigger.contains(event.target)) {
                dropdown.classList.add('hidden');
                dropdowns[type] = false;
            }


        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const tahun = document.getElementById('tahuncuti-input').value;
        const items = document.querySelectorAll(`#tahuncuti-options .option-item`);
        items.forEach(item => {
            if (item.dataset.value === tahun) {
                item.classList.add('bg-[#00A181]', 'text-white', 'hover:bg-[#009171]');
            }
        });
    });
</script>
