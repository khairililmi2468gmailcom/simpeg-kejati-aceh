<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Data Kepangkatan Pegawai - Kejati Aceh</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 0;
        }

        .kop-surat {
            position: relative;
            /* Menjadikan kontainer relatif untuk posisi absolut */
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 10px;
            margin: 0 20px 10px 20px;
        }

        .kop-content {
            display: flex;
            align-items: center;
            /* Menyelaraskan secara vertikal */
            justify-content: center;
            /* Membuat teks berada di tengah */
        }

        .logo-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            width: 80px;
            height: auto;
        }

        .logo-wrapper.right {
            right: 0;
            left: auto;
        }

        .logo {
            width: 100%;
            height: auto;
        }

        .institution-info {
            text-align: center;
            padding: 0 10px;
            z-index: 1;
            /* Agar teks tetap di atas logo */
        }

        .institution-info h1 {
            margin: 0;
            font-size: 32px;
            color: #2c3e50;
            line-height: 1.1;
        }

        .institution-info h2 {
            margin: 3px 0;
            font-size: 14px;
            color: #34495e;
        }

        .address {
            font-size: 10px;
            color: #7f8c8d;
            font-weight: 400;
            line-height: 1.3;
            margin-top: 2px;
        }

        .title {
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            margin: 20px 0;
            text-align: center;
            color: #2c3e50;
            letter-spacing: 1px;
        }

        /* Tutorial CSS untuk tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        th {
            background-color: #2c3e50;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ecf0f1;
            color: #2c3e50;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .ttd-section {
            margin-top: 40px;
            float: right;
            width: 300px;
        }

        .signature-box {
            border-top: 2px solid #2c3e50;
            padding-top: 15px;
            text-align: center;
        }

        .qr-code {
            margin-top: 15px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="kop-surat">
        <div class="kop-content">
            <!-- Logo kiri -->
            <div class="logo-wrapper">
                <img class="logo" src="{{ public_path('image/logo.png') }}" alt="Logo Kejati">
            </div>
            <!-- Teks pusat -->
            <div class="institution-info">
                <h2>KEJAKSAAN TINGGI REPUBLIK INDONESIA</h1>
                    <h1>KEJAKSAAN TINGGI ACEH</h1>
                    <div class="address">
                        Jl. Dr. M. Mohammed Hasan, Batoh, Kota Banda Aceh<br>
                        Telp. (0651) 22240 | Fax. (0651) 28094
                        Website: www.kejati-aceh.go.id | Email: kejatiaceh@go.id
                    </div>
            </div>

        </div>
    </div>


    <h1 class="title">LAPORAN DATA KEPANGKATAN PEGAWAI</h1>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. SK</th>
                <th>NIP</th>
                <th>Nama Pegawai</th>
                <th>Jabatan Fungsional</th>
                <th>Pangkat Lama</th>
                <th>Pangkat Baru</th>
                <th>TMT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kepangkatan as $key => $data)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $data->no_sk ?? '-' }}</td>
                    <td>{{ $data->nip }}</td>
                    <td>{{ strtoupper($data->pegawai->nama) }}</td>
                    <td>{{ $data->golongan->jabatan_fungsional }}</td>
                    <td>{{ $data->pangkat_l ?? '-' }}</td>
                    <td>{{ $data->pegawai->golongan->pangkat ?? '-' }}</td>
                    <td>{{ $data->tmt_sk_pangkat ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="ttd-section">
        <div class="signature-box">
            Banda Aceh, {{ $tanggalCetak }}<br>
            Kepala Kejaksaan Tinggi Aceh<br>
            <div class="qr-code">
                <img src="data:image/png;base64, {!! $qrCode !!}" width="100">
            </div>
            <br><br>
            <strong><u>DR. H. MUHAMMAD FADLI, S.H., M.H.</u></strong><br>
            NIP. 19730512 199803 1 005
        </div>

    </div>
</body>

</html>
