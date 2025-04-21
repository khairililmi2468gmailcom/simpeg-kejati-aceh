{{-- Tabel --}}
<div class="overflow-x-auto rounded-lg mb-2 ">
    <div class="flex items-center justify-between bg-[#00A181] px-6 py-4 rounded-t-lg">
        <h3 class="text-lg font-semibold text-white font-poppins">Daftar Diklat Pegawai</h3>
        @php
            $queryParams = request()->only(['nip', 'no_sttpp', 'diklat_id']);
        @endphp
        <form method="GET" action="{{ route('admin.laporan.index') }}"
            class="w-full max-w-full md:max-w-4xl lg:max-w-2xl  flex flex-col md:flex-row md:items-center md:justify-right gap-3">
            <input type="hidden" name="tab" value="diklat">

            {{-- Select Jumlah per Halaman --}}
            <div class="w-full md:w-auto">
                <select name="per_page_diklat" onchange="this.form.submit()"
                    class="w-full md:w-32 border border-gray-300 text-black px-3 py-2 bg-white rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]">
                    @foreach ([5, 10, 25, 50, 100, 250, 500, 1000, 2000, 5000, 10000] as $size)
                        <option value="{{ $size }}"
                            {{ request('per_page_diklat', 5) == $size ? 'selected' : '' }}>
                            {{ $size }} / halaman
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Input Pencarian --}}
            <div class="relative w-full md:flex-1">
                <input type="text" name="searchDiklat" id="search" value="{{ request('searchDiklat') }}"
                    class="w-full px-4 py-2 pl-10 text-sm text-black border border-gray-300 rounded-md bg-[#F0F0F0] focus:outline-none focus:ring-2 focus:ring-[#00A181]"
                    placeholder="Cari Diklat...">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                    </svg>
                </div>
            </div>
            <div class="w-full md:w-auto text-center md:text-right">
                <a href="{{ route('admin.laporan.diklat.pdf', $queryParams) }}" target="_blank"
                    class="inline-flex items-center gap-2 bg-[#007f66] hover:bg-[#005e4f] text-white px-4 py-2 rounded-md text-sm font-medium transition">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 495 495"
                        class="w-5 h-5 fill-current text-white">
                        <g>
                            <rect x="247.5" style="fill:#46F8FF;" width="170" height="92.5" />
                            <rect x="77.5" style="fill:#9BFBFF;" width="170" height="92.5" />
                            <polygon style="fill:#FFDA44;"
                                points="247.5,232.5 247.5,92.5 0,92.5 0,412.5 77.5,412.5 77.5,232.5" />
                            <path style="fill:#FFCD00;" d="M495,92.5H247.5v140h170v180H495V92.5z M397.5,202.5c-11.046,0-20-8.954-20-20
                s8.954-20,20-20s20,8.954,20,20S408.546,202.5,397.5,202.5z" />
                            <circle style="fill:#FFFFFF;" cx="397.5" cy="182.5" r="20" />
                            <polygon style="fill:#9BFBFF;"
                                points="147.5,412.5 147.5,372.5 247.5,372.5 247.5,342.5 147.5,342.5 147.5,302.5 
                247.5,302.5 247.5,232.5 77.5,232.5 77.5,495 247.5,495 247.5,412.5" />
                            <polygon style="fill:#46F8FF;"
                                points="247.5,232.5 247.5,302.5 347.5,302.5 347.5,342.5 247.5,342.5 247.5,372.5 
                347.5,372.5 347.5,412.5 247.5,412.5 247.5,495 417.5,495 417.5,232.5" />
                            <rect x="147.5" y="372.5" style="fill:#005ECE;" width="200" height="40" />
                            <rect x="147.5" y="302.5" style="fill:#005ECE;" width="200" height="40" />
                        </g>
                    </svg>
                    Cetak Daftar Diklat
                </a>
            </div>
        </form>

    </div>

    <table class="min-w-full bg-white border border-gray-300 rounded-b-lg">
        <thead class="bg-gray-100 text-[#02172C] font-poppins text-sm text-center">
            <tr class="uppercase">
                <th rowspan="2" class="px-3 py-2 border border-gray-300">NO</th>
                <th rowspan="2" class="px-3 py-2 border border-gray-300">Nama, NIP, NRP, Karpeg</th>
                <th rowspan="2" class="px-3 py-2 border border-gray-300">Jabatan</th>
                <th colspan="2" class="px-3 py-2 border border-gray-300 border-b-0">Diklat</th>
                <th rowspan="2" class="px-2 py-2 border border-gray-300">Tempat Penyelenggara</th>
                <th rowspan="2" class="px-0 py-2 border border-gray-300">Angkatan dan Jumlah Jam</th>
                <th colspan="2" class="px-3 py-2 border border-gray-300 border-b-0">Tanggal</th>
                <th colspan="2" class="px-3 py-2 border border-gray-300">STTP</th>
                <th rowspan="2" class="px-3 py-2 border border-gray-300">Action</th>
            </tr>
            <tr class="uppercase">
                <th class="px-3 py-2 border border-gray-300">Jenis</th>
                <th class="px-3 py-2 border border-gray-300">Nama</th>
                <th class="px-3 py-2 border border-gray-300">Mulai</th>
                <th class="px-3 py-2 border border-gray-300">Selesai</th>
                <th class="px-3 py-2 border border-gray-300">No</th>
                <th class="px-3 py-2 border border-gray-300">Tanggal</th>
            </tr>

        </thead>
        <tbody class="text-gray-800 font-poppins text-sm">
            @forelse ($mengikutiDiklat as $index => $diklat)
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-2 border border-gray-300 text-center">{{ $index + 1 }}</td>
                    <td class="px-3 py-2 border border-gray-300">
                        <div class="font-medium text-black">{{ $diklat->pegawai->nama }}</div>
                        <div class="text-xs text-gray-500">NIP: {{ $diklat->pegawai->nip }}</div>
                        <div class="text-xs text-gray-500">NRP: {{ $diklat->pegawai->nrp }}</div>
                        <div class="text-xs text-gray-500">Karpeg: {{ $diklat->pegawai->karpeg }}</div>
                    </td>
                    <td class="px-3 py-2 border border-gray-300 text-center">
                        {{ $diklat->pegawai->jabatan->nama_jabatan ?? '-' }}
                    </td>
                    <td class="px-3 py-2 border border-gray-300 text-center">
                        {{ $diklat->diklat->jenis_diklat ?? '-' }}
                    </td>
                    <td class="px-3 py-2 border border-gray-300 text-center">
                        {{ $diklat->diklat->nama_diklat ?? '-' }}
                    </td>
                    <td class="px-3 py-2 border border-gray-300 text-center">
                        {{ $diklat->tempat_diklat ?? '-' }}
                    </td>
                    <td class="px-0 py-2 border border-gray-300 text-center">
                        <div class="font-medium text-gray-500">Angkatan: {{ $diklat->angkatan ?? '-' }}
                        </div>
                        <div class="text-xs font-medium text-gray-500">Jumlah Jam: {{ $diklat->jumlah_jam }}</div>

                    </td>
                    <td class="px-3 py-2 border border-gray-300 text-center">
                        {{ \Carbon\Carbon::parse($diklat->tanggal_mulai)->format('d-m-Y') }}
                    </td>
                    <td class="px-3 py-2 border border-gray-300">
                        {{ \Carbon\Carbon::parse($diklat->tanggal_selesai)->format('d-m-Y') ?? '-' }}
                    </td>
                    <td class="px-3 py-2 border border-gray-300 text-center">
                        {{ $diklat->no_sttpp ?? '-' }}
                    </td>
                    <td class="px-3 py-2 border border-gray-300">
                        {{ \Carbon\Carbon::parse($diklat->tanggal_sttpp)->format('d-m-Y') ?? '-' }}
                    </td>
                    <td class="px-4 py-3 border border-gray-300 text-center">
                        <a href="{{ route('admin.laporan.diklat.single.pdf', $diklat->no_sttpp) }}" target="_blank"
                            class="inline-flex items-center gap-2 bg-[#00A181] hover:bg-[#007f66] text-white px-4 py-2 rounded text-sm font-medium transition">
                            {{-- Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 495 495"
                                class="w-5 h-5 fill-current text-white">
                                <g>
                                    <rect x="247.5" style="fill:#46F8FF;" width="170" height="92.5" />
                                    <rect x="77.5" style="fill:#9BFBFF;" width="170" height="92.5" />
                                    <polygon style="fill:#FFDA44;"
                                        points="247.5,232.5 247.5,92.5 0,92.5 0,412.5 77.5,412.5 77.5,232.5" />
                                    <path style="fill:#FFCD00;" d="M495,92.5H247.5v140h170v180H495V92.5z M397.5,202.5c-11.046,0-20-8.954-20-20
                                        s8.954-20,20-20s20,8.954,20,20S408.546,202.5,397.5,202.5z" />
                                    <circle style="fill:#FFFFFF;" cx="397.5" cy="182.5" r="20" />
                                    <polygon style="fill:#9BFBFF;"
                                        points="147.5,412.5 147.5,372.5 247.5,372.5 247.5,342.5 147.5,342.5 147.5,302.5 
                                        247.5,302.5 247.5,232.5 77.5,232.5 77.5,495 247.5,495 247.5,412.5" />
                                    <polygon style="fill:#46F8FF;"
                                        points="247.5,232.5 247.5,302.5 347.5,302.5 347.5,342.5 247.5,342.5 247.5,372.5 
                                        347.5,372.5 347.5,412.5 247.5,412.5 247.5,495 417.5,495 417.5,232.5" />
                                    <rect x="147.5" y="372.5" style="fill:#005ECE;" width="200" height="40" />
                                    <rect x="147.5" y="302.5" style="fill:#005ECE;" width="200" height="40" />
                                </g>
                            </svg>
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
<div>

</div>
{{-- Pagination --}}
<div class="mt-2  flex justify-end">
    {{ $mengikutiDiklat->appends(request()->all())->links() }}
</div>
@if ($mengikutiDiklat->hasPages())
    <div class="mt-6 flex justify-end mb-4">
        <nav class="flex items-center space-x-1 text-sm">
            {{-- Tombol Previous --}}
            @if ($mengikutiDiklat->onFirstPage())
                <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">← Prev</span>
            @else
                <a href="{{ $mengikutiDiklat->previousPageUrl() }}"
                    class="px-3 py-1 bg-white border rounded-md text-[#00A181] hover:bg-[#00A181]/10">← Prev</a>
            @endif
            @php
                $current = $mengikutiDiklat->currentPage();
                $last = $mengikutiDiklat->lastPage();
                $start = max($current - 2, 1);
                $end = min($current + 2, $last);
            @endphp
            {{-- Tampilkan "..." di awal jika halaman pertama tidak ditampilkan --}}
            @if ($start > 1)
                <a href="{{ $mengikutiDiklat->url(1) }}"
                    class="px-3 py-1 bg-white border rounded-md hover:bg-[#00A181]/10 text-[#00A181]">1</a>
                @if ($start > 2)
                    <span class="px-2">...</span>
                @endif
            @endif
            {{-- Loop halaman tengah --}}
            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $current)
                    <span
                        class="px-3 py-1 bg-[#00A181] text-white rounded-md font-semibold">{{ $page }}</span>
                @else
                    <a href="{{ $mengikutiDiklat->url($page) }}"
                        class="px-3 py-1 bg-white border rounded-md hover:bg-[#00A181]/10 text-[#00A181]">{{ $page }}</a>
                @endif
            @endfor
            {{-- Tampilkan "..." di akhir jika halaman terakhir tidak ditampilkan --}}
            @if ($end < $last)
                @if ($end < $last - 1)
                    <span class="px-2">...</span>
                @endif
                <a href="{{ $mengikutiDiklat->url($last) }}"
                    class="px-3 py-1 bg-white border rounded-md hover:bg-[#00A181]/10 text-[#00A181]">{{ $last }}</a>
            @endif

            {{-- Tombol Next --}}
            @if ($mengikutiDiklat->hasMorePages())
                <a href="{{ $mengikutiDiklat->nextPageUrl() }}"
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
        <input type="hidden" name="tab" value="diklat">

        <div class="flex flex-col md:flex-row md:space-x-4 mb-4">
            <div class="flex-1 relative">
                <input type="text" name="searchDiklat" placeholder="Masukkan NIP Pegawai"
                    value="{{ request('searchDiklat') }}" class="w-full border px-4 py-2 rounded-lg" />
            </div>
            <div>
                <button type="submit"
                    class="cursor-pointer bg-[#00A181] text-white px-6 py-2 rounded-lg mt-2 md:mt-0">
                    Cari
                </button>
            </div>
        </div>
        <h3 class="text-[20px] font-semibold mb-4">Berdasarkan Jenis Diklat</h3>

        {{-- Dropdown Jenis Diklat --}}
        <div class="w-full shadow-md p-4 border border-[#E0E0E0] rounded-md mb-6">
            <div class="flex flex-wrap items-center w-full mb-4">
                <div class="w-full md:w-1/2  md:pl-8 mb-2 md:mb-0">
                    <label class="block text-[18px] font-semibold text-gray-800">
                        Laporan Jenis Diklat
                    </label>
                </div>
                <div class="w-full md:w-1/2 pr-5 relative">
                    <div class="relative">
                        <div class="selected-item w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm cursor-pointer flex justify-between items-center"
                            onclick="toggleDropdown('namadiklat')">
                            <span id="namadiklat-display">
                                -- Pilih Jenis Diklat --
                            </span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <div id="namadiklat-dropdown"
                            class="dropdown-content hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-64 overflow-y-auto">
                            <input type="text" class="w-full px-3 py-2 border-b border-gray-200 focus:outline-none"
                                placeholder="Cari Jenis Diklat..." onkeyup="filterOptions('namadiklat', this.value)">
                            <div class="options" id="namadiklat-options">
                                @foreach ($diklatValues as $diklatvalue)
                                    <div class="option-item px-3 py-2 hover:bg-gray-100 cursor-pointer transition-colors {{ request('nama_diklat') == $diklatvalue->nama_diklat ? 'bg-[#00A181] text-white hover:bg-[#009171]' : '' }}"
                                        data-value="{{ $diklatvalue->nama_diklat }}"
                                        onclick='selectItem("namadiklat", "{{ $diklatvalue->nama_diklat }}", "{{ $diklatvalue->nama_diklat }}")'>
                                        {{ $diklatvalue->nama_diklat }}
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="nama_diklat" id="namadiklat-input"
                        value="{{ request('nama_diklat') }}">
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
        <h3 class="text-[20px] font-semibold mb-4">Berdasarkan Tahun Diklat</h3>

        {{-- Dropdown Tahun Diklat --}}
        <div class="w-full shadow-md p-4 border border-[#E0E0E0] rounded-md mb-6">
            <div class="flex flex-wrap items-center w-full mb-4">
                <div class="w-full md:w-1/2  md:pl-8 mb-2 md:mb-0">
                    <label class="block text-[18px] font-semibold text-gray-800">
                        Laporan Tahun Diklat
                    </label>
                </div>
                <div class="w-full md:w-1/2 pr-5 relative">
                    <div class="relative">
                        <div class="selected-item w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm cursor-pointer flex justify-between items-center"
                            onclick="toggleDropdown('tahundiklat')">
                            <span id="tahundiklat-display">
                                -- Pilih Tahun Diklat --
                            </span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <div id="tahundiklat-dropdown"
                            class="dropdown-content hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-64 overflow-y-auto">
                            <input type="text" class="w-full px-3 py-2 border-b border-gray-200 focus:outline-none"
                                placeholder="Cari Tahun..." onkeyup="filterOptions('tahundiklat', this.value)">
                            <div class="options" id="tahundiklat-options">
                                @foreach ($tahunListDiklat as $tahun)
                                    <div class="option-item px-3 py-2 hover:bg-gray-100 cursor-pointer transition-colors {{ request('tahun_diklat') == $tahun ? 'bg-[#00A181] text-white hover:bg-[#009171]' : '' }}"
                                        data-value="{{ $tahun }}"
                                        onclick='selectItem("tahundiklat", @json($tahun), @json($tahun))'>
                                        {{ $tahun }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="tahun_diklat" id="tahundiklat-input"
                        value="{{ request('tahun_diklat') }}">
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

        <a href="{{ route('admin.laporan.index', ['tab' => 'diklat']) }}"
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
                <li>Masukkan Jenis Diklat yang bersangkutan</li>
                <li>Masukkan Tahun Diklat yang bersangkutan</li>
                <li>Klik Tombol Cari</li>
            </ul>
        </div>
    </form>
</div>
<script>
    const dropdowns = {
        unitkerja: false,
        jabatanfungsional: false,
        tahundiklat: false,
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
        const tahun = document.getElementById('tahundiklat-input').value;
        const items = document.querySelectorAll(`#tahundiklat-options .option-item`);
        items.forEach(item => {
            if (item.dataset.value === tahun) {
                item.classList.add('bg-[#00A181]', 'text-white', 'hover:bg-[#009171]');
            }
        });
    });
</script>
