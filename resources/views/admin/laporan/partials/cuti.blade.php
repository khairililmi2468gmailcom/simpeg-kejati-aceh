<h2 class="text-xl font-semibold text-gray-800 mb-3">Laporan Cuti Pegawai</h2>

<form method="GET" action="{{ route('admin.laporan.index') }}"
     class="flex flex-wrap md:flex-nowrap items-center justify-between gap-2 mb-6">
     <input type="hidden" name="tab" value="cuti">

     <div class="relative w-full md:w-1/3">
         <input type="text" name="searchCuti" id="search" value="{{ request('searchCuti') }}"
             class="border border-gray-300 px-4 py-2 pl-10 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-[#00A181]"
             placeholder="Cari Cuti...">
         <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
             <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round"
                     d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
             </svg>
         </div>
     </div>

     <div class="flex items-center gap-2">
         <select name="per_page_cuti" onchange="this.form.submit()"
             class="border border-gray-300 px-3 py-2 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]">
             @foreach ([5, 10, 25, 50, 100, 250, 500, 1000, 2000, 5000, 10000] as $size)
                 <option value="{{ $size }}" {{ request('per_page_cuti', 5) == $size ? 'selected' : '' }}>
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
<div class="overflow-x-auto rounded-lg shadow mb-8">
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr class="bg-[#00A181] text-white text-center">
                <th class="px-3 py-2 border">No</th>
                <th class="px-3 py-2 border">Nama, NIP</th>
                <th class="px-3 py-2 border">No. Surat</th>
                <th class="px-3 py-2 border">Jenis Cuti</th>
                <th class="px-3 py-2 border">Tanggal Mulai</th>
                <th class="px-3 py-2 border">Tanggal Selesai</th>
                <th class="px-3 py-2 border">Keterangan</th>
                <th class="px-3 py-2 border">Action</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            @foreach ($menerimaCuti as $index => $cuti)
                <tr class="hover:bg-gray-100 text-sm">
                    <td class="px-3 py-2 border text-center">{{ $index + 1 }}</td>
                    <td class="px-3 py-2 border">
                        <div class="font-semibold">{{ $cuti->pegawai->nama }}</div>
                        <div class="text-xs text-gray-500">NIP: {{ $cuti->pegawai->nip }}</div>
                    </td>
                    <td class="px-3 py-2 border">{{ $cuti->no_surat }}</td>
                    <td class="px-3 py-2 border">{{ $cuti->cuti->jenis_cuti }}</td>
                    <td class="px-3 py-2 border">{{ $cuti->tanggal_mulai }}</td>
                    <td class="px-3 py-2 border">{{ $cuti->tanggal_selesai }}</td>
                    <td class="px-3 py-2 border">{{ $cuti->keterangan }}</td>
                    <td class="px-3 py-2 border text-center">
                        <a href="#" class="bg-[#00A181] hover:bg-[#007f66] text-white px-3 py-1 rounded text-xs">
                            Cetak
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
 {{-- Pagination --}}
 <div class="mt-6  flex justify-end">
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
                    <span
                        class="px-3 py-1 bg-[#00A181] text-white rounded-md font-semibold">{{ $page }}</span>
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
