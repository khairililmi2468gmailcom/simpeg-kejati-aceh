<table>
    <thead>
        <tr>
            <th>NIP</th>
            <th>Nama</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Provinsi</th>
            <th>Kabupaten</th>
            <th>Kecamatan</th>
            <th>Alamat</th>
            <th>No HP</th>
            <th>Email</th>
            <th>Golongan</th>
            <th>Jabatan</th>
            <th>Unit Kerja</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pegawais as $pegawai)
        <tr>
            <td>{{ $pegawai->nip }}</td>
            <td>{{ $pegawai->nama }}</td>
            <td>{{ $pegawai->tmpt_lahir }}</td>
            <td>{{ $pegawai->tgl_lahir }}</td>
            <td>{{ $pegawai->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            <td>{{ $pegawai->provinsi->nama ?? '' }}</td>
            <td>{{ $pegawai->kabupaten->nama ?? '' }}</td>
            <td>{{ $pegawai->kecamatan->nama ?? '' }}</td>
            <td>{{ $pegawai->alamat }}</td>
            <td>{{ $pegawai->no_hp }}</td>
            <td>{{ $pegawai->email }}</td>
            <td>{{ $pegawai->golongan->nama ?? '' }}</td>
            <td>{{ $pegawai->jabatan->nama ?? '' }}</td>
            <td>{{ $pegawai->unitKerja->nama ?? '' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
