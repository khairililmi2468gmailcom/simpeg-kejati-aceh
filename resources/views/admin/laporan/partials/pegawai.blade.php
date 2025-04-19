 {{-- Judul --}}
 <h2 class="text-xl font-semibold text-gray-800 mb-3">Daftar Pegawai Kejaksaan</h2>
 {{-- Filter & Search --}}
 <form method="GET" action="{{ route('admin.laporan.index') }}"
     class="flex flex-wrap md:flex-nowrap items-center justify-between gap-2 mb-6">

     <div class="relative w-full md:w-1/3">
         <input type="text" name="searchPegawai" id="search" value="{{ request('searchPegawai') }}"
             class="border border-gray-300 px-4 py-2 pl-10 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-[#00A181]"
             placeholder="Cari Pegawai...">
         <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
             <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round"
                     d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
             </svg>
         </div>
     </div>

     <div class="flex items-center gap-2">
         <select name="per_page_pegawai" onchange="this.form.submit()"
             class="border border-gray-300 px-3 py-2 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#00A181]">
             @foreach ([5, 10, 25, 50, 100, 250, 500, 1000, 2000, 5000, 10000] as $size)
                 <option value="{{ $size }}" {{ request('per_page_pegawai', 5) == $size ? 'selected' : '' }}>
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
 {{-- Tabel --}}
 <div class="overflow-x-auto rounded-lg shadow mb-8">
     <table class="min-w-full bg-white border border-gray-200 rounded-xl">
         <thead>
             <tr class="bg-[#00A181] text-white text-center">
                 <th class="px-3 py-2 border align-middle" rowspan="2">NO</th>
                 <th class="px-3 py-2 border align-middle" rowspan="2">Nama,NIP, NRP, Karpeg</th>
                 <th class="px-3 py-2 border align-middle" rowspan="2">Jabatan</th>
                 <th class="px-3 py-2 border border-b-0" colspan="2">Pangkat</th>
                 <th class="px-3 py-2 border align-middle" rowspan="2">Tempat dan Tanggal Lahir</th>
                 <th class="px-3 py-2 border align-middle" rowspan="2">TMT Pensiun</th>
                 <th class="px-3 py-2 border align-middle" rowspan="2">Alamat</th>
                 <th class="px-3 py-2 border align-middle" rowspan="2">No HP</th>
                 <th class="px-3 py-2 border align-middle" rowspan="2">Action</th>
             </tr>
             <tr class="bg-[#00A181] text-white text-center">
                 <th class="px-3 py-2 border">Pangkat</th>
                 <th class="px-3 py-2 border">TMT Pangkat</th>
             </tr>
         </thead>
         <tbody class="text-gray-700">
             @foreach ($pegawais as $index => $pegawai)
                 <tr class="hover:bg-gray-100 text-sm">
                     <td class="px-3 py-2 border text-center">{{ $index + 1 }}</td>
                     <td class="px-3 py-2 border">
                         <div class="font-semibold">{{ $pegawai->nama }}</div>
                         <div class="text-xs text-gray-500">NIP: {{ $pegawai->nip }}</div>
                         <div class="text-xs text-gray-500">NRP: {{ $pegawai->nrp }}</div>
                         <div class="text-xs text-gray-500">Karpeg: {{ $pegawai->karpeg }}</div>
                     </td>
                     <td class="px-3 py-2 border text-center">{{ $pegawai->jabatan->nama_jabatan ?? '-' }}</td>
                     <td class="px-3 py-2 border text-center">{{ $pegawai->golongan->pangkat ?? '-' }}</td>
                     <td class="px-3 py-2 border text-center">
                         {{ \Carbon\Carbon::parse($pegawai->tmt_pangkat)->format('d-m-Y') }}
                     </td>
                     <td class="px-3 py-2 border ">{{ $pegawai->tmpt_lahir ?? '-' }},
                         {{ \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('d-m-Y') ?? '-' }}</td>
                     <td class="px-3 py-2 border text-center">{{ $pegawai->tmt_pensiun  ?? '-'}}</td>
                     <td class="px-3 py-2 border">{{ $pegawai->alamat ?? '-' }}</td>
                     <td class="px-3 py-2 border">{{ $pegawai->hp ?? '-' }}</td>
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
     {{ $pegawais->appends(request()->all())->links() }}
 </div>
 @if ($pegawais->hasPages())
     <div class="mt-6 flex justify-end mb-8">
         <nav class="flex items-center space-x-1 text-sm">
             {{-- Tombol Previous --}}
             @if ($pegawais->onFirstPage())
                 <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">← Prev</span>
             @else
                 <a href="{{ $pegawais->previousPageUrl() }}"
                     class="px-3 py-1 bg-white border rounded-md text-[#00A181] hover:bg-[#00A181]/10">← Prev</a>
             @endif

             {{-- Angka halaman --}}
             @foreach ($pegawais->getUrlRange(1, $pegawais->lastPage()) as $page => $url)
                 @if ($page == $pegawais->currentPage())
                     <span
                         class="px-3 py-1 bg-[#00A181] text-white rounded-md font-semibold">{{ $page }}</span>
                 @else
                     <a href="{{ $url }}"
                         class="px-3 py-1 bg-white border rounded-md hover:bg-[#00A181]/10 text-[#00A181]">{{ $page }}</a>
                 @endif
             @endforeach

             {{-- Tombol Next --}}
             @if ($pegawais->hasMorePages())
                 <a href="{{ $pegawais->nextPageUrl() }}"
                     class="px-3 py-1 bg-white border rounded-md text-[#00A181] hover:bg-[#00A181]/10">Next →</a>
             @else
                 <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">Next →</span>
             @endif
         </nav>
     </div>
 @endif
