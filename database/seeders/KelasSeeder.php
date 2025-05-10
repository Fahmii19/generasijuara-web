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
                'nama' => 'A11 HST A-2025 NON MODULAR',
                'kode' => 'A11 HST A-2025 NON MODULAR',
                'type' => 0,
                'biaya' => 500000,
                'is_active' => 1,
                'kelas' => 8,
                'semester' => 1,
                'tahun_akademik_id' => 38,
                'paket_kelas_id' => 1,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'is_lock_nilai' => 0,
                'jurusan' => null,
                'jenis_rapor' => 'lama',
            ],
            [
                'layanan_kelas_id' => 1,
                'nama' => 'A12 HST A-2025 NON MODULAR',
                'kode' => 'A12 HST A-2025 NON MODULAR',
                'type' => 0,
                'biaya' => 500000,
                'is_active' => 1,
                'kelas' => 9,
                'semester' => 2,
                'tahun_akademik_id' => 38,
                'paket_kelas_id' => 2,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'is_lock_nilai' => 0,
                'jurusan' => null,
                'jenis_rapor' => 'lama',
            ],
            // Tambahkan entri lainnya sesuai kebutuhan...
        ]);
    }
}
