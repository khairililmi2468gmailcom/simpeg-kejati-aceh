<h2 class="text-xl font-semibold text-gray-800 mb-3">Laporan Kepangkatan Pegawai</h2>

<div class="overflow-x-auto rounded-lg shadow mb-8">
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr class="bg-[#00A181] text-white text-center">
                <th class="px-3 py-2 border">No</th>
                <th class="px-3 py-2 border">Nama Pegawai</th>
                <th class="px-3 py-2 border">Golongan</th>
                <th class="px-3 py-2 border">Pangkat</th>
                <th class="px-3 py-2 border">TMT</th>
                <th class="px-3 py-2 border">Nomor SK</th>
                <th class="px-3 py-2 border">Tanggal SK</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            @forelse ($kepangkatan as $index => $item)
            <tr class="hover:bg-gray-100 text-sm">
                <td class="px-3 py-2 border text-center">{{ $index + 1 }}</td>
                <td class="px-3 py-2 border">{{ $item->pegawai->nama }}</td>
                <td class="px-3 py-2 border">{{ $item->golongan }}</td>
                <td class="px-3 py-2 border">{{ $item->pangkat }}</td>
                <td class="px-3 py-2 border">{{ $item->tmt }}</td>
                <td class="px-3 py-2 border">{{ $item->nomor_sk }}</td>
                <td class="px-3 py-2 border">{{ $item->tanggal_sk }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-3 text-gray-500">Tidak ada data kepangkatan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
