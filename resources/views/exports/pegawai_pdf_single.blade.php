<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Formulir Data Pegawai</title>
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
            margin: 20px;
            background: white;
        }

        .container {
            background: white;
            padding: 35px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid var(--primary-color);
        }

        .header img {
            height: 100px;
            margin-bottom: 15px;
        }

        .header h1 {
            color: var(--primary-color);
            font-size: 24px;
            margin: 10px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .header h2 {
            color: var(--secondary-color);
            font-size: 18px;
            margin: 5px 0;
        }

        .section {
            margin-bottom: 30px;
            padding: 20px;
            background: #fff;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }

        .section-title {
            color: var(--accent-color);
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--accent-color);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 180px 10px 1fr;
            gap: 15px 10px;
            align-items: baseline;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            text-align: right;
        }

        .form-separator {
            color: var(--accent-color);
            text-align: center;
        }

        .form-value {
            padding-bottom: 3px;
            border-bottom: 2px solid #e9ecef;
            color: var(--secondary-color);
        }

        .foto-container {
            float: right;
            width: 140px;
            height: 180px;
            margin: 0 0 20px 30px;
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

        .signature-section {
            float: right;
            padding-top: 20px;
            text-align: center;
        }

        .qr-code {
            padding: 10px;
            background: #fff;
            display: inline-block;
            text-align: center;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }

        .watermark {
            position: fixed;
            opacity: 0.1;
            font-size: 120px;
            transform: rotate(-45deg);
            top: 40%;
            left: 20%;
            color: var(--primary-color);
            pointer-events: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="watermark">KEJATI ACEH</div>

        <div class="header">
            <img src="{{ public_path('image/logo.png') }}" alt="Logo Kejati">
            <h1>KEJAKSAAN TINGGI ACEH</h1>
            <h2>FORMULIR DATA PEGAWAI</h2>
            <p>Jl. Tgk. Daud Beureueh No.15, Banda Aceh | Telp: (0651) 34123 | Email: kejatiaceh@go.id</p>
        </div>

        @if (!empty($pegawai->foto))
            <div class="foto-container">
                <img class="foto-pegawai" src="{{ public_path('storage/' . $pegawai->foto) }}" alt="Foto Pegawai">
            </div>
        @endif

        {{-- SECTION 1: Biodata Pegawai --}}
        <div class="section">
            <div class="section-title">A. BIODATA PEGAWAI</div>
            <table class="form-table">
                <tr>
                    <td class="label">1. Nama Lengkap</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">2. NIP</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->nip ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">3. NRP</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->nrp ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">4. Tempat & Tanggal Lahir</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->tmpt_lahir }},
                        {{ $pegawai->tgl_lahir ? \Carbon\Carbon::parse($pegawai->tgl_lahir)->translatedFormat('d F Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">5. Jenis Kelamin</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->j_kelamin ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">6. Agama</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->agama ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">7. Alamat</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->alamat ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">8. No. HP</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->hp ?? '-' }}</td>
                </tr>
            </table>
        </div>

        {{-- SECTION 2: Jabatan --}}
        <div class="section">
            <div class="section-title">B. JABATAN PEGAWAI</div>
            <table class="form-table">
                <tr>
                    <td class="label">1. Jabatan</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->jabatan->nama_jabatan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">2. Unit Kerja</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->unitkerja->nama_kantor ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">3. Pangkat</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->golongan->pangkat ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">4. Golongan</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->golongan->id_golongan ?? '-' }}</td>
                </tr>
            </table>
        </div>

        {{-- SECTION 3: Data Pendidikan --}}
        <div class="section">
            <div class="section-title">C. DATA PENDIDIKAN</div>
            <table class="form-table">
                <tr>
                    <td class="label">1. Pendidikan Terakhir</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->pendidikan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">2. Universitas</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->universitas ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">3. Jurusan</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->jurusan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">4. Tahun Masuk</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->tahun_masuk ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">5. Tahun Lulus</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->t_lulus ?? '-' }}</td>
                </tr>
            </table>
        </div>

        {{-- SECTION 4: Data Tambahan --}}
        <div class="section">
            <div class="section-title">D. DATA TAMBAHAN</div>
            <table class="form-table">
                <tr>
                    <td class="label">1. Alamat</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->alamat ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">2. Kode Pos</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->kode_pos ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">3. No. HP</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->hp ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">4. KARPEG</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pegawai->karpeg ?? '-' }}</td>
                </tr>
            </table>
        </div>

        {{-- TTD dan QR --}}

        <div class="signature-section">
            <p>Banda Aceh, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <div class="qr-code">
                <img src="data:image/png;base64,{{ $qrCode }}" width="100" alt="TTD Digital">
            </div>
        </div>
</body>

</html>
