<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Bukti Cuti Pegawai</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #2980b9;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            font-size: 13px;
            line-height: 1.6;
            margin: 12px;
            background: white;
        }

        .container {
            background: white;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            position: relative;
        }

        .watermark {
            position: absolute;
            opacity: 0.07;
            font-size: 100px;
            transform: rotate(-45deg);
            top: 30%;
            left: 10%;
            color: var(--primary-color);
            pointer-events: none;
            z-index: 0;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid var(--primary-color);
        }

        .header-logo {
            position: absolute;
            left: 0;
            top: 0;
        }

        .header-logo img {
            height: 80px;
        }

        .header-content {
            text-align: center;
        }

        .header-content h2 {
            color: var(--primary-color);
            font-size: 16px;
            text-transform: uppercase;
            margin: 0;
        }

        .header-content h1 {
            color: var(--primary-color);
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0px 0 0px 0;
        }

        .header-content p {
            margin: 0;
            font-size: 11px;
            color: var(--secondary-color);
            line-height: 1.4;
        }


        .foto-container {
            float: right;
            width: 120px;
            height: 150px;
            margin-left: 30px;
            border: 3px solid #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .foto-pegawai {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .title {
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            text-align: center;
            color: #2c3e50;
            text-decoration: underline;
            letter-spacing: 1px;
        }

        .content-section {
            padding: 15px;
            border-radius: 6px;
            position: relative;
            z-index: 1;
        }

        .signature-section {
            margin-top: 36px;
            padding-top: 20px;
            border-top: 2px solid var(--primary-color);
            text-align: right;
        }

        .ttd-section {
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

        .official-stamp {
            float: left;
            width: 150px;
            opacity: 0.8;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="watermark">KEJATI ACEH</div>

        <div class="header">
            <div class="header-logo">
                <img src="{{ public_path('image/logo.png') }}" alt="Logo Kejati">
            </div>
            <div class="header-content">
                <h2>KEJAKSAAN TINGGI REPUBLIK INDONESIA</h2>
                <h1>KEJAKSAAN TINGGI ACEH</h1>
                <p>Jl. Tgk. Daud Beureueh No.15, Batoh, Kota Banda Aceh<br>Telp: (0651) 34123 | Email: kejatiaceh@go.id
                </p>
            </div>
        </div>

        <h1 class="title">SURAT BUKTI CUTI PEGAWAI</h1>

        <div class="content-section">
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 13px;">
                <tr>
                    <td style="width: 160px; font-weight: 600; color: #2c3e50;">Nomor Surat</td>
                    <td style="width: 10px;">:</td>
                    <td style="border-bottom: 1px dashed #ccc;">{{ $cuti->no_surat ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: 600; color: #2c3e50;">Nama Pegawai</td>
                    <td>:</td>
                    <td style="border-bottom: 1px dashed #ccc;">{{ $cuti->pegawai->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: 600; color: #2c3e50;">NIP</td>
                    <td>:</td>
                    <td style="border-bottom: 1px dashed #ccc;">{{ $cuti->nip ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: 600; color: #2c3e50;">Jenis Cuti</td>
                    <td>:</td>
                    <td style="border-bottom: 1px dashed #ccc;">{{ $cuti->cuti->jenis_cuti ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: 600; color: #2c3e50;">Tanggal Mulai</td>
                    <td>:</td>
                    <td style="border-bottom: 1px dashed #ccc;">
                        {{ $cuti->tanggal_mulai ? \Carbon\Carbon::parse($cuti->tanggal_mulai)->translatedFormat('d F Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: 600; color: #2c3e50;">Tanggal Selesai</td>
                    <td>:</td>
                    <td style="border-bottom: 1px dashed #ccc;">
                        {{ $cuti->tanggal_selesai ? \Carbon\Carbon::parse($cuti->tanggal_selesai)->translatedFormat('d F Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: 600; color: #2c3e50;">Lama Cuti</td>
                    <td>:</td>
                    <td style="border-bottom: 1px dashed #ccc;">{{ $cuti->jumlah_cuti ?? '-' }} Hari Kerja</td>
                </tr>
                <tr>
                    <td style="font-weight: 600; color: #2c3e50;">Keterangan</td>
                    <td>:</td>
                    <td style="border-bottom: 1px dashed #ccc;">{{ $cuti->keterangan ?? '-' }}</td>
                </tr>
            </table>

        </div>

        <div class="content-section">
            <p style="color: var(--accent-color); font-weight: 600; margin-bottom: 10px; font-style:italic;">CATATAN
                RESMI:</p>
            <ol style="color: var(--secondary-color); padding-left: 20px;">
                <li>Surat ini sah apabila telah dibubuhi tanda tangan dan stempel resmi</li>
                <li>Masa cuti tidak dapat diperpanjang tanpa persetujuan tertulis</li>
                <li>Wajib lapor kembali setelah masa cuti berakhir</li>
            </ol>
        </div>


        <div class="ttd-section">
            <div class="signature-box">
                Banda Aceh, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>

                {{-- Tampilkan "Plt." jika isPlt == true --}}
                {{ $kepalakejaksaan->isPlt ? 'Plt. ' : '' }}Kepala Kejaksaan Tinggi Aceh<br>

                <div class="qr-code">
                    <img src="data:image/png;base64, {!! $qrCode !!}" width="100">
                </div>

                <br>
                <strong><u>{{ $kepalakejaksaan->nama ?? '-' }}</u></strong><br>

                {{-- Tampilkan Pangkat di bawah nama --}}
                {{ $kepalakejaksaan->pangkat ?? '-' }}<br>

                NIP.
                {{ $kepalakejaksaan->nip
                    ? substr($kepalakejaksaan->nip, 0, 8) .
                        ' ' .
                        substr($kepalakejaksaan->nip, 8, 6) .
                        ' ' .
                        substr($kepalakejaksaan->nip, 14, 1) .
                        ' ' .
                        substr($kepalakejaksaan->nip, 15, 3)
                    : '-' }}
            </div>
        </div>
    </div>
</body>

</html>
