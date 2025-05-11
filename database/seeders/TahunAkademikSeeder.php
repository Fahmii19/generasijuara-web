<?php

namespace Database\Seeders;

use App\Models\TahunAkademikModel;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TahunAkademikSeeder extends Seeder
{
    public function run()
    {
        $currentYear = (int)date('Y');
        $now = Carbon::now();

        // Hanya buat untuk tahun 2024 (2 semester)
        $year = $currentYear;

        for ($smt = 1; $smt <= 2; $smt++) {
            $kode = $year . $smt;
            $nextYear = $year + 1;
            $tahun_ajar = $year . '/' . $nextYear;

            if ($smt == 1) {
                $ket = "Semester Ganjil Tahun Ajaran " . $tahun_ajar;
                $periodeStart = $year . '-07-01';
                $periodeEnd = $year . '-12-31';
                $tgl_raport = ($year + 1) . '-01-31';
                $tgl_cover_raport = ($year + 1) . '-01-31';
            } else {
                $ket = "Semester Genap Tahun Ajaran " . $tahun_ajar;
                $periodeStart = $nextYear . '-01-01';
                $periodeEnd = $nextYear . '-06-30';
                $tgl_raport = $nextYear . '-06-30';
                $tgl_cover_raport = $nextYear . '-06-30';
            }

            $params = [
                'kode' => $kode,
                'tahun_ajar' => $tahun_ajar,
                'keterangan' => $ket,
                'periode_start' => $periodeStart,
                'periode_end' => $periodeEnd,
                'tgl_raport' => $tgl_raport,
                'tgl_cover_raport' => $tgl_cover_raport,
                'is_active' => true, // Aktifkan semua yang dibuat
                'is_generate_rombel' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            TahunAkademikModel::updateOrCreate(
                ['kode' => $kode],
                $params
            );
        }
    }
}
