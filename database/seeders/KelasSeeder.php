<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelas')->insert([
            [
                'layanan_kelas_id' => 1,
                'nama' => 'Kelas 1A',
                'kode' => '1A',
                'type' => 'reguler',
                'biaya' => 500000,
                'is_active' => 1,
                'kelas' => '1',
                'semester' => 1,
                'tahun_akademik_id' => 24,
                'paket_kelas_id' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'is_lock_nilai' => 0,
                'jurusan' => 'IPA',
                'jenis_rapor' => 'Semesteran',
            ],
            [
                'layanan_kelas_id' => 2,
                'nama' => 'Kelas 2B',
                'kode' => '2B',
                'type' => 'unggulan',
                'biaya' => 750000,
                'is_active' => 1,
                'kelas' => '2',
                'semester' => 2,
                'tahun_akademik_id' => 24,
                'paket_kelas_id' => 2,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'is_lock_nilai' => 0,
                'jurusan' => 'IPS',
                'jenis_rapor' => 'K13',
            ],
            // Tambahkan entri lainnya sesuai kebutuhan...
        ]);
    }
}
