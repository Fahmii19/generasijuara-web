<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAkademikModel;

class TahunAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $startYear = 2019;
        $endYear = (int) date('Y');

        for($year = $startYear; $year <= $endYear; $year++){
            for ($smt=1; $smt <= 2 ; $smt++) {
                $kode = $year.$smt;
                $nextYear = $year+1;
                $tahun_ajar = $year.'/'.$nextYear;
                if($smt%2 == 1){
                    $ket = "Semester Ganjil Tahun Ajaran ".$year." - ".$nextYear;
                    $periodeStart = $year.'-07-01';
                    $periodeEnd = $year.'-12-01';
                }else{
                    $ket = "Semester Genap Tahun Ajaran ".$year." - ".$nextYear;
                    $periodeStart = ($nextYear).'-01-01';
                    $periodeEnd = ($nextYear).'-07-01';
                }

                $params = [
                    'kode' => $kode,
                    'tahun_ajar' => $tahun_ajar,
                    'keterangan' => $ket,
                    'periode_start' => $periodeStart,
                    'periode_end' => $periodeEnd,
                    'is_active' => false,
                ];

                $tahunAkademik = TahunAkademikModel::where('kode', $params['kode'])->first();
                if (empty($tahunAkademik)) {
                    TahunAkademikModel::create($params);
                }
            }
        }
    }
}
