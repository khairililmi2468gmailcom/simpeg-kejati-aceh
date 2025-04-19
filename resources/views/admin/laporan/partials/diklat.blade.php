<h2 class="text-xl font-semibold text-gray-800 mb-3">Laporan Diklat Pegawai</h2>

<div class="overflow-x-auto rounded-lg shadow mb-8">
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr class="bg-[#00A181] text-white text-center">
                <th class="px-3 py-2 border">No</th>
                <th class="px-3 py-2 border">Nama Pegawai</th>
                <th class="px-3 py-2 border">Jenis Diklat</th>
                <th class="px-3 py-2 border">Nama Diklat</th>
                <th class="px-3 py-2 border">Tanggal Mulai</th>
                <th class="px-3 py-2 border">Tanggal Selesai</th>
                <th class="px-3 py-2 border">Keterangan</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            @forelse ($mengikutiDiklat as $index => $item)
            <tr class="hover:bg-gray-100 text-sm">
                <td class="px-3 py-2 border text-center">{{ $index + 1 }}</td>
                <td class="px-3 py-2 border">{{ $item->pegawai->nama }}</td>
                <td class="px-3 py-2 border">{{ $item->jenis_diklat }}</td>
                <td class="px-3 py-2 border">{{ $item->nama_diklat }}</td>
                <td class="px-3 py-2 border">{{ $item->tanggal_mulai }}</td>
                <td class="px-3 py-2 border">{{ $item->tanggal_selesai }}</td>
                <td class="px-3 py-2 border">{{ $item->keterangan }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-3 text-gray-500">Tidak ada data diklat.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
