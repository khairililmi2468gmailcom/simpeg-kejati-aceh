@extends('layouts.app-admin')

@section('content')
    <h1 class="text-3xl font-bold text-[#00A181]">Data Pegawai</h1>
    <p class="mb-4">Halaman daftar pegawai Kejaksaan Tinggi</p>

    <div class="flex justify-between mb-4">
        <input type="text" id="search" class="border px-3 py-2 w-1/3" placeholder="Cari pegawai...">
        <select id="filterGolongan" class="border px-3 py-2 text-black">
            <option value="">Semua Golongan</option>
            @foreach ($golongan as $g)
                <option value="{{ $g->id_golongan }}">{{ $g->nama_golongan }}</option>
            @endforeach
        </select>
        <select id="filterJabatan" class="border px-3 py-2">
            <option value="">Semua Jabatan</option>
            @foreach ($jabatan as $j)
                <option value="{{ $j->id_jabatan }}">{{ $j->nama_jabatan }}</option>
            @endforeach
        </select>
    </div>

    <table class="w-full border-collapse border-2 border-gray-300">
        <thead>
            <tr class="bg-[#00A181] text-left text-white">
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
                    <td class="p-2">{{ $item->nip }}</td>
                    <td class="p-2">{{ $item->nama }}</td>
                    <td class="p-2">{{ $item->golongan->pangkat ?? '-' }} </td>
                    <td class="p-2">{{ $item->jabatan->nama_jabatan ?? '-' }}</td>
                    <td class="p-2">{{ $item->unitKerja->nama_kantor ?? '-' }}
                    </td>
                    <td class="p-2">
                        <a href="{{ route('admin.pegawai.show', $item->nip) }}"
                            class="bg-blue-500 text-white px-3 py-1 rounded">Detail</a>
                        <a href="{{ route('admin.pegawai.edit', $item->nip) }}"
                            class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>
                        <form action="{{ route('admin.pegawai.destroy', $item->nip) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
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
