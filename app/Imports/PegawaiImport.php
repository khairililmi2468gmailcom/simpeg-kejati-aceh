<?php

namespace App\Imports;

use App\Models\Pegawai;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\WithMapping;

class PegawaiImport implements ToModel, WithHeadingRow, WithValidation, WithColumnFormatting, WithEvents, WithMapping
{
    public function model(array $row)
    {
        $nip = $row['nip'];

        // Paksa jadi string, jaga leading zero & hindari scientific notation
        if (is_numeric($nip)) {
            $nip = number_format($nip, 0, '', '');
        }

        $nip = str_pad((string) $nip, 18, '0', STR_PAD_LEFT); // jaga panjang 18

        $data = [
            'nip' => $nip,
            'nrp' => isset($row['nrp']) ? (string) $row['nrp'] : null,
            'karpeg' => isset($row['karpeg']) ? (string) $row['karpeg'] : null,
            'nama' => (string) $row['nama'],
            'tmpt_lahir' => isset($row['tmpt_lahir']) ? (string) $row['tmpt_lahir'] : null,
            'tgl_lahir' => $row['tgl_lahir'] ?? null,
            'agama' => isset($row['agama']) ? (string) $row['agama'] : null,
            'suku' => isset($row['suku']) ? (string) $row['suku'] : null,
            'gol_darah' => isset($row['gol_darah']) ? (string) $row['gol_darah'] : null,
            'j_kelamin' => isset($row['jk']) ? (string) $row['jk'] : null,
            'status' => isset($row['status']) ? (string) $row['status'] : null,
            'j_anak' => $row['j_anak'] ?? null,
            'id_provinsi' => isset($row['id_provinsi']) ? (string) $row['id_provinsi'] : null,
            'id_kabupaten' => isset($row['id_kabupaten']) ? (string) $row['id_kabupaten'] : null,
            'id_kecamatan' => isset($row['id_kecamatan']) ? (string) $row['id_kecamatan'] : null,
            'alamat' => isset($row['alamat']) ? (string) $row['alamat'] : null,
            'kode_pos' => isset($row['kode_pos']) ? (string) $row['kode_pos'] : null,
            'hp' => isset($row['no_hp']) ? (string) $row['no_hp'] : null,
            'email' => isset($row['email']) ? (string) $row['email'] : null,
            'pendidikan' => isset($row['pendidikan']) ? (string) $row['pendidikan'] : null,
            'universitas' => isset($row['universitas']) ? (string) $row['universitas'] : null,
            'jurusan' => isset($row['jurusan']) ? (string) $row['jurusan'] : null,
            't_lulus' => $row['t_lulus'] ?? null,
            'tahun_masuk' => $row['tahun_masuk'] ?? null,
            'tmt_jabatan' => now(),
            'id_golongan' => isset($row['id_golongan']) ? (string) $row['id_golongan'] : null,
            'id_jabatan' => $row['id_jabatan'] ?? null,
            'kode_kantor' => isset($row['id_unit_kerja']) ? (string) $row['id_unit_kerja'] : null,
            'ket' => isset($row['ket']) ? (string) $row['ket'] : null,
        ];

        return new Pegawai($data);
    }
    public function map($row): array
    {
        // Cast paksa ke string sebelum validasi
        return [
            'nip' => isset($row['nip']) ? (string)$row['nip'] : null,
            'nrp' => isset($row['nrp']) ? (string)$row['nrp'] : null,
            'karpeg' => isset($row['karpeg']) ? (string)$row['karpeg'] : null,
            'nama' => isset($row['nama']) ? (string)$row['nama'] : null,
            'tmpt_lahir' => isset($row['tmpt_lahir']) ? (string)$row['tmpt_lahir'] : null,
            'tgl_lahir' => $row['tgl_lahir'] ?? null,
            'agama' => isset($row['agama']) ? (string)$row['agama'] : null,
            'suku' => isset($row['suku']) ? (string)$row['suku'] : null,
            'gol_darah' => isset($row['gol_darah']) ? (string)$row['gol_darah'] : null,
            'jk' => isset($row['jk']) ? (string)$row['jk'] : null,
            'status' => isset($row['status']) ? (string)$row['status'] : null,
            'j_anak' => $row['j_anak'] ?? null,
            'id_provinsi' => isset($row['id_provinsi']) ? (string)$row['id_provinsi'] : null,
            'id_kabupaten' => isset($row['id_kabupaten']) ? (string)$row['id_kabupaten'] : null,
            'id_kecamatan' => isset($row['id_kecamatan']) ? (string)$row['id_kecamatan'] : null,
            'alamat' => isset($row['alamat']) ? (string)$row['alamat'] : null,
            'kode_pos' => isset($row['kode_pos']) ? (string)$row['kode_pos'] : null,
            'no_hp' => isset($row['no_hp']) ? (string)$row['no_hp'] : null,
            'email' => isset($row['email']) ? (string)$row['email'] : null,
            'pendidikan' => isset($row['pendidikan']) ? (string)$row['pendidikan'] : null,
            'universitas' => isset($row['universitas']) ? (string)$row['universitas'] : null,
            'jurusan' => isset($row['jurusan']) ? (string)$row['jurusan'] : null,
            't_lulus' => $row['t_lulus'] ?? null,
            'tahun_masuk' => $row['tahun_masuk'] ?? null,
            'id_golongan' => isset($row['id_golongan']) ? (string)$row['id_golongan'] : null,
            'id_jabatan' => isset($row['id_jabatan']) ? (string)$row['id_jabatan'] : null,
            'id_unit_kerja' => isset($row['id_unit_kerja']) ? (string)$row['id_unit_kerja'] : null,
            'ket' => isset($row['ket']) ? (string)$row['ket'] : null,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // misalnya kolom A adalah NIP
            'B' => NumberFormat::FORMAT_TEXT, // jika kolom B = NRP
            'C' => NumberFormat::FORMAT_TEXT, // karpeg
            // tambahkan kolom lain yang perlu dipaksa sebagai teks
        ];
    }
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $worksheet = $event->getReader()->getActiveSheet();

                // Paksa semua nilai di kolom A (NIP) dibaca sebagai string
                foreach ($worksheet->getRowIterator() as $row) {
                    $cell = $worksheet->getCell('A' . $row->getRowIndex());
                    $value = $cell->getValue();

                    // Kalau value berupa float/numeric panjang, konversi ke string
                    if (is_numeric($value)) {
                        $cell->setValueExplicit((string) number_format($value, 0, '', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    }
                }
            }
        ];
    }


    public function rules(): array
    {
        return [
            'nip' => 'required|string|max:18|unique:pegawai,nip',
            'nrp' => 'nullable|string|max:25',
            'karpeg' => 'nullable|string|max:25',
            'nama' => 'required|string|max:100',
            'tmpt_lahir' => 'nullable|string|max:25',
            'tgl_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:25',
            'suku' => 'nullable|string|max:25',
            'gol_darah' => 'nullable|string|max:5',
            'jk' => 'nullable|string|max:25',
            'status' => 'nullable|string|max:25',
            'j_anak' => 'nullable|integer',
            'id_provinsi' => 'nullable|string|max:2|exists:provinsi,id',
            'id_kabupaten' => 'nullable|string|max:4|exists:kabupaten,id',
            'id_kecamatan' => 'nullable|string|max:7|exists:kecamatan,id',
            'alamat' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:12',
            'no_hp' => 'nullable|string|max:12',
            'email' => 'nullable|email|max:100',
            'pendidikan' => 'nullable|string|max:25',
            'universitas' => 'nullable|string|max:100',
            'jurusan' => 'nullable|string|max:100',
            't_lulus' => 'nullable|digits:4',
            'tahun_masuk' => 'nullable|digits:4',
            'id_golongan' => 'required|string|exists:golongan,id_golongan',
            'id_jabatan' => 'nullable|integer|exists:jabatan,id_jabatan',
            'id_unit_kerja' => 'nullable|string|exists:unit_kerja,kode_kantor',
            'ket' => 'nullable|string|max:150',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'id_provinsi.exists' => 'Provinsi tidak valid.',
            'id_kabupaten.exists' => 'Kabupaten tidak valid.',
            'id_kecamatan.exists' => 'Kecamatan tidak valid.',
            'id_golongan.exists' => 'Golongan tidak ditemukan.',
            'id_jabatan.exists' => 'Jabatan tidak ditemukan.',
            'id_unit_kerja.exists' => 'Unit kerja tidak ditemukan.',
        ];
    }
}
