<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Data Mutasi Pegawai - Kejati Aceh</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 0;
        }

        .kop-surat {
            position: relative;
            /* Menjadikan kontainer relatif untuk posisi absolut */
            border-bottom: 3px solid #a8aaac;
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

        .header-kanan {
            width: fit-content;
            float: right;
            margin: 10px 20px 0 0;
            font-size: 12px;
            text-align: left;
            position: relative;
            z-index: 10;
        }

        /* Agar tidak tumpang tindih dengan title */
        .title {
            clear: both;
            margin-top: 80px;
        }

        /* Untuk cetak biar tetap muncul di setiap halaman */
        @media print {
            .header-kanan {
                position: fixed;
                top: 20px;
                right: 20px;
            }

            .title {
                margin-top: 100px;
            }
        }

        .title {
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            margin: 20px 0;
            text-align: center;
            color: #000000;
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
            background-color: #f1f1f1;
            color: black;
            padding: 5px;
            text-align: center;
            font-weight: 600;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #c4c4c4;
            color: #2c3e50;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .ttd-section {
            margin-top: 30px;
            float: right;
            width: 300px;
        }

        .signature-box {
            text-align: center;
        }

        .qr-code {
            margin-top: 15px;
            text-align: center;
        }
    </style>
</head>

<body>
    @php
        $bulanSekarang = strtoupper(\Carbon\Carbon::now()->translatedFormat('F')); // APRIL
        $bulanAngka = \Carbon\Carbon::now()->format('m'); // 04
        $tahunSekarang = \Carbon\Carbon::now()->format('Y'); // 2025
    @endphp

    <!-- Header Kanan -->
    <div class="header-kanan">
        Lampiran SURAT KEPALA KEJAKSAAN TINGGI ACEH<br>
        Nomor : B-        /L.1/Cp.3/{{ $bulanAngka }}/{{ $tahunSekarang }}<br>
        Tanggal :     {{ $bulanSekarang }} {{ $tahunSekarang }}
        <div style="width: 100%; border-bottom: 1px solid black; margin-top: 2px;"></div>
    </div>
    <h1 class="title" style="text-decoration: underline">LAPORAN DATA MUTASI PEGAWAI</h1>

    <table border="1" cellspacing="0" cellpadding="4"
        style="font-size: 12px; width: 100%; border-collapse: collapse; margin-top: 20px">
        <thead>
            <tr>
                <th>NO</th>
                <th>NAMA, PANGKAT<br>NRP DAN NIP</th>
                <th>JABATAN LAMA</th>
                <th>KELAS JABATAN LAMA</th>
                <th>JABATAN BARU</th>
                <th>KELAS JABATAN BARU</th>
                <th>BESARNYA TUNJANGAN JABATAN STRUKTURAL</th>
                <th>BIAYA</th>
            </tr>
            <tr>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mutasi as $key => $data)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        <strong>{{ strtoupper($data->pegawai->nama ?? '-') }}</strong><br>
                        {{ $data->golonganPegawai->jabatan_fungsional ?? '-' }} -
                        ({{ $data->golonganPegawai->pangkat ?? '-' }}) <br>
                        NIP. {{ $data->nip ?? '-' }}<br>
                        NRP. {{ $data->pegawai->nrp ?? '-' }}
                    </td>
                    <td>{{ $data->jabatan_l ?? '-' }}</td>
                    <td>{{ $data->kelas_jabatan_l ?? '10 (Sepuluh)' }}</td>
                    <td>{{ $data->pegawai->jabatan->nama_jabatan ?? '-' }}</td>
                    <td>{{ $data->kelas_jabatan_b ?? '10 (Sepuluh)' }}</td>
                    <td>Rp.540.000,00 (lima ratus empat puluh ribu rupiah)</td>
                    <td>Biaya Negara</td>
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
            <br>
            <strong><u>{{ $kepalakejaksaan->nama ?? '-' }}</u></strong><br>
            NIP.
            {{ substr($kepalakejaksaan->nip, 0, 8) . ' ' . substr($kepalakejaksaan->nip, 8, 6) . ' ' . substr($kepalakejaksaan->nip, 14, 1) . ' ' . substr($kepalakejaksaan->nip, 15, 3) ?? '-' }}
        </div>
    </div>
</body>

</html>
