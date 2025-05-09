<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaketKelasModel;
use App\Models\PaketSppModel;  // Pastikan model PaketSppModel sudah ada
use App\Utils\Constant;

class PaketKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menambahkan data ke tabel paket_spp jika belum ada
        $paketSppModel = [
            [
                'id' => 1,
                'cabang_id' => 1,  // Gantilah dengan nilai yang valid untuk cabang_id
                'layanan_kelas_id' => 1,  // Gantilah dengan nilai yang valid untuk layanan_kelas_id
                'paket_kelas_id' => 1,  // Gantilah dengan nilai yang valid untuk paket_kelas_id
                'semester' => '2024-1',  // Gantilah sesuai dengan semester yang sesuai
                'kelas' => 'PAKET A',  // Misalnya, nama kelas
                'biaya' => 1000000,  // Gantilah dengan biaya yang sesuai
                'biaya_program' => 500000,  // Gantilah dengan biaya program yang sesuai
                'biaya_pendaftaran' => 100000,  // Gantilah dengan biaya pendaftaran yang sesuai
                'jenis_pendaftaran' => 'Reguler',  // Jenis pendaftaran
                'keterangan' => 'Paket A untuk setara SD',  // Keterangan
                'type' => 'PAKET A',  // Gantilah dengan type yang sesuai
                'is_active' => true,  // Aktivasi paket
                'created_by' => 1,  // Gantilah dengan ID pengguna yang valid
                'updated_by' => 1,  // Gantilah dengan ID pengguna yang valid
                'semester_khusus' => false,  // Menentukan apakah semester khusus
                'jumlah_smt_kk' => 2,  // Jumlah semester untuk KK (Kartu Keluarga) jika relevan
                'biaya_kk' => 50000,  // Biaya KK
                'selected_kk' => '',  // Menentukan apakah paket ini dipilih
            ],
            // Anda bisa menambahkan data lain jika diperlukan
        ];

        foreach ($paketSppModel as $paket) {
            // Cek apakah data dengan id yang sama sudah ada
            $existingPaket = PaketSppModel::find($paket['id']);
            if (!$existingPaket) {
                PaketSppModel::create($paket);
            }
        }

        // Data PaketKelas yang sudah ada di seeder sebelumnya
        $paketKelas = [
            [
                'nama' => 'PAKET A (Setara SD)',
                'kode' => 'PAKETA',
                'is_active' => true,
                'type' => Constant::TYPE_KELAS_ABC,
            ],
            [
                'nama' => 'PAKET B (Setara SMP)',
                'kode' => 'PAKETB',
                'is_active' => true,
                'type' => Constant::TYPE_KELAS_ABC,
            ],
            [
                'nama' => 'PAKET C (Setara SMA)',
                'kode' => 'PAKETC',
                'is_active' => true,
                'type' => Constant::TYPE_KELAS_ABC,
            ],
            [
                'nama' => 'SHIDDIQ',
                'kode' => 'SHIDDIQ',
                'is_active' => true,
                'type' => Constant::TYPE_KELAS_PAUD,
            ],
            [
                'nama' => 'AMANAH',
                'kode' => 'AMANAH',
                'is_active' => true,
                'type' => Constant::TYPE_KELAS_PAUD,
            ],
            [
                'nama' => 'KABAR',
                'kode' => 'KABAR',
                'is_active' => true,
                'type' => Constant::TYPE_KELAS_PAUD,
            ],
        ];

        // Loop untuk menyisipkan atau memperbarui data pada paket_kelas
        foreach ($paketKelas as $pk) {
            $db = PaketKelasModel::where('kode', $pk['kode'])->first();
            if (empty($db)) {
                $db = PaketKelasModel::create($pk);
            } else {
                $db->update($pk);
            }
        }
    }
}
