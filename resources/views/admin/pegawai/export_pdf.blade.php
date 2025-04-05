<!DOCTYPE html>
<html>
<head>
    <title>Data Pegawai</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #999;
            padding: 6px 10px;
            text-align: left;
        }
        th {
            background-color: #00A181;
            color: white;
        }
    </style>
</head>
<body>
    <h2>Data Pegawai Kejaksaan Tinggi</h2>
    <table>
        <thead>
            <tr>
                <th>NIP</th>
                <th>Nama</th>
                <th>Golongan</th>
                <th>Jabatan</th>
                <th>Unit Kerja</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pegawai as $item)
                <tr>
                    <td>{{ $item->nip }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->golongan->pangkat ?? '-' }}</td>
                    <td>{{ $item->jabatan->nama_jabatan ?? '-' }}</td>
                    <td>{{ $item->unitKerja->nama_kantor ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
