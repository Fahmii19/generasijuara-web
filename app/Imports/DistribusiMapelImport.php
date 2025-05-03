<?php

namespace App\Imports;

use App\Models\DistribusiMapelModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\MataPelajaranModel;
use App\Models\TutorModel;
use App\Utils\Constant;
use App\Utils\Misc;
use DB;
use Exception;

class DistribusiMapelImport implements ToCollection
{
    private $startRowIndex;
    private $kelasNums = [];

    public function __construct($startRowIndex = 0, $kelasNums = [])
    {
        $this->startRowIndex = $startRowIndex;
        $this->kelasNums = $kelasNums;
    }

    public function collection(Collection $rows)
    {
        $kelompok = 'kelompok_umum';
        $sub_kelompok = null;

        DB::beginTransaction();
        try {

            foreach ($rows[0] as $key => $col) {
                if (!empty($col) && $col != "MAPEL") {
                    $this->kelasNums[] = $col;
                }
            }

            DistribusiMapelModel::whereIn('kelas_num', $this->kelasNums)->delete();
            // DB::commit();
            // return true;

            foreach ($rows as $key => $row) {
                if ($key < $this->startRowIndex) {
                    continue;
                }

                if ($row[0] == "KELOMPOK UMUM") {
                    $kelompok = 'kelompok_umum';
                    $sub_kelompok = null;
                } elseif ($row[0] == "PEMINATAN IPA") {
                    $kelompok = 'mia';
                    $sub_kelompok = null;
                } elseif ($row[0] == "PEMINATAN IPS") {
                    $kelompok = 'iis';
                    $sub_kelompok = null;
                } elseif ($row[0] == "KELOMPOK KHUSUS") {
                    $kelompok = 'kelompok_khusus';
                    $sub_kelompok = null;
                } elseif ($row[0] == "KETERAMPILAN WAJIB") {
                    $kelompok = 'kelompok_khusus';
                    $sub_kelompok = 'keterampilan_wajib';
                } elseif ($row[0] == "KETERAMPILAN PILIHAN") {
                    $kelompok = 'kelompok_khusus';
                    $sub_kelompok = 'keterampilan_pilihan';
                } elseif ($row[0] == "PEMBERDAYAAN") {
                    $kelompok = 'kelompok_khusus';
                    $sub_kelompok = 'pemberdayaan';
                } else {
                    $mapel = null;
                    foreach ($row as $kc => $col) {
                        // error_log($col);
                        if ($kc == 0) {
                            $mapel = MataPelajaranModel::updateOrCreate(
                                [
                                    'nama' => trim($col)
                                ],
                                [
                                    'kelompok' => $kelompok,
                                    'sub_kelompok' => $sub_kelompok
                                ]
                            );
                        }elseif (!empty($col) && !empty($mapel)) {
                            $tutorName = trim($col);
                            $tutor = TutorModel::select('tutor.*')
                                ->where('u.name', $tutorName)
                                ->leftJoin('users as u', 'u.id', '=', 'tutor.user_id')
                                ->first();

                            if(empty($tutor)) error_log("Tutor not found: ".$tutorName);
                            
                            DistribusiMapelModel::updateOrCreate(
                                [
                                    'kelas_num' => $rows[0][$kc],
                                    'mapel_id' => $mapel->id,
                                ],
                                [
                                    'tutor_id' => !empty($tutor) ? $tutor->id : null,
                                ]
                            );
                        }
                    }
                    
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            error_log($e->getMessage());
        }
    }
}
