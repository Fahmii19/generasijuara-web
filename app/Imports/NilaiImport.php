<?php

namespace App\Imports;

use App\Models\KelasMataPelajaranModel;
use App\Models\KelasModel;
use App\Models\MataPelajaranModel;
use App\Models\NilaiModel;
use App\Models\PpdbModel;
use App\Models\TutorModel;
use App\Models\UserRoleModel;
use App\Utils\Misc;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class NilaiImport implements SkipsEmptyRows, ToCollection, WithCalculatedFormulas

{
    private $startRowIndex;

    public function __construct($startRowIndex = 0)
    {
        $this->startRowIndex = $startRowIndex;
    }

    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            $kelasCode = null;
            $nis = null;
            $nisn = null;
            $nama = null;
            $kkm = null;

            $kelasDB = null;
            $wbDB = null;
            foreach ($rows as $key => $row) {
                $mapel = null;
                $tutor = null;
                $tutorDB = null;
                $mapelDB = null;

                if ($key < $this->startRowIndex) {
                    continue;
                }

                if(!empty($row[1])) {
                    $kelasCode = trim($row[1]);
                    $kelasDB = KelasModel::where('kode', $kelasCode)->first();
                    if(empty($kelasDB)) throw new Exception("Kelas not found: ".$kelasCode);
                }
                
                if(!empty($row[2])) {
                    $nis = trim($row[2]);
                    $wbDB = PpdbModel::where('nis', $nis)->first();
                    if(empty($wbDB)) throw new Exception("WB not found (nis): ".$nis);
                }
                
                // if(!empty($row[3])) {
                //     $nisn = trim($row[3]);
                //     $wbDB = PpdbModel::where('nisn', $nisn)->first();
                //     if(empty($wbDB)) throw new Exception("WB not found (nisn): ".$nisn);
                // }
                
                if(!empty($row[4])) $nama = $row[4];
                
                if(!empty($row[5])) {
                    $mapelID = trim($row[5]);
                    $mapelDB = MataPelajaranModel::find($mapelID);
                    if(empty($mapelDB)) throw new Exception("Mapel not found: ".$mapelID);
                }
                
                if(!empty($row[8])) {
                    $tutor = trim($row[8]);
                    $tutorDB = TutorModel::select('t.*')
                        ->from('tutor as t')
                        ->leftJoin('users as u', 'u.id', '=', 't.user_id')
                        ->where('u.name', $tutor)
                        ->first();
                    if(empty($tutorDB)) throw new Exception("Tutor not found: ".$tutor);
                }
                
                if(!empty($row[9])) $kkm = $row[9];
                
                // if(empty($row[8])) continue;
                // if(!empty($row[8]) && empty($row[5])) continue;

                if (empty($kelasDB) || empty($mapelDB)) {
                    throw new Exception("Kelas or Mapel not found");
                }
                $kmpDB = KelasMataPelajaranModel::with(['kmp_setting'])
                    ->where('kelas_id', $kelasDB->id)
                    ->where('mata_pelajaran_id', $mapelDB->id);
                if(!empty($tutorDB)) $kmpDB->where('tutor_id', $tutorDB->id);
                    
                $kmpDB = $kmpDB->first();

                $kmpDataJson = json_encode([
                    'kelas' => !empty($kelasDB) ? $kelasDB->id : null,
                    'mp' => !empty($mapelDB) ? $mapelDB->id : null,
                    'tutor' => !empty($tutorDB) ? $tutorDB->id : null,
                ]);
                if(empty($kmpDB)) {
                    Log::debug("KMP not found: ".$kmpDataJson);
                    throw new Exception("Mapel ".$row[5]." pada kelas ".$row[1]." tidak ditemukan!");
                }

                // Jika auth.user_id != import.tutor->user_id maka throw exception
                $user_id = Auth::user()->id;
                $user_role_id = UserRoleModel::where('user_id', $user_id)->first()->role_id;
                if ($user_role_id == 2) {
                    if ($tutorDB->user_id != $user_id) {
                        throw new Exception("Tidak berhak import nilai untuk tutor lain");
                    }
                }
                
                // Log::debug(json_encode([
                //     'kelasCode' => $kelasCode,
                //     'nis' => $nis,
                //     'nisn' => $nisn,
                //     'nama' => $nama,
                //     'mapel' => $mapel,
                //     'tutor' => $tutor,
                //     'kkm' => $kkm,
                // ]));

                if (empty($kmpDB->kmp_setting)) {
                    Log::debug("KMP Setting ".$kmpDB->mata_pelajaran_detail->nama." not found: ".$kmpDataJson);
                    throw new Exception(
                        'Setting mapel `'.$kmpDB->mata_pelajaran_detail->nama.
                        '` pada kelas `'.$kelasDB->nama.'` belum diatur, silahkan hubungi admin!'
                    );
                }
                
                $p_persentase_tm = $kmpDB->kmp_setting->persentase_tm;
                $p_persentase_um = $kmpDB->kmp_setting->persentase_um;
                $k_persentase_tm = $kmpDB->kmp_setting->k_persentase_tm;
                $k_persentase_um = $kmpDB->kmp_setting->k_persentase_um;
                if ($mapelDB->kelompok == 'kelompok_khusus') {
                    $p_nilai_1 = ($row[10] * $p_persentase_tm / 100) + (0 * $p_persentase_um / 100) ?? null;
                    $k_nilai_1 = $row[14] ?? null;
                    $data = [
                        'kelas_id' => $kelasDB->id,
                        'kmp_id' => $kmpDB->id,
                        'wb_id' => $wbDB->id,
                        'p_tugas_1' => $row[10] ?? null,
                        'p_ujian_1' => null,
                        'p_nilai_1' => !empty($p_nilai_1) ? $p_nilai_1 : null,
                        'p_predikat_1' => Misc::checkPredikat($p_nilai_1) ?? null,
                        'k_nilai_1' =>  $k_nilai_1 ?? null,
                        'k_predikat_1' => Misc::checkPredikat($k_nilai_1) ?? null,
                    ];
                }else{
                    $p_nilai_1 = ($row[10] * $p_persentase_tm / 100) + ($row[11] * $p_persentase_um / 100) ?? null;
                    $p_nilai_2 = ($row[16] * $p_persentase_tm / 100) + ($row[17] * $p_persentase_um / 100) ?? null;
                    $p_nilai_3 = ($row[22] * $p_persentase_tm / 100) + ($row[23] * $p_persentase_um / 100) ?? null;
                    $data = [
                        'kelas_id' => $kelasDB->id,
                        'kmp_id' => $kmpDB->id,
                        'wb_id' => $wbDB->id,
                        'p_tugas_1' => $row[10] ?? null,
                        'p_ujian_1' => $row[11] ?? null,
                        'p_nilai_1' => !empty($p_nilai_1) ? $p_nilai_1 : null,
                        'p_predikat_1' => Misc::checkPredikat($p_nilai_1) ?? null,
                        'k_nilai_1' =>  $row[14] ?? null,
                        'k_predikat_1' => Misc::checkPredikat($row[14]) ?? null,
                        'p_tugas_2' => $row[16] ?? null,
                        'p_ujian_2' => $row[17] ?? null,
                        'p_nilai_2' => !empty($p_nilai_2) ? $p_nilai_2 : null,
                        'p_predikat_2' => Misc::checkPredikat($p_nilai_2) ?? null,
                        'k_nilai_2' => $row[20] ?? null,
                        'k_predikat_2' => Misc::checkPredikat($row[20]) ?? null,
                        'p_tugas_3' => $row[22] ?? null,
                        'p_ujian_3' => $row[23] ?? null,
                        'p_nilai_3' => !empty($p_nilai_3) ? $p_nilai_3 : null,
                        'p_predikat_3' => Misc::checkPredikat($p_nilai_3) ?? null,
                        'k_nilai_3' => $row[26] ?? null,
                        'k_predikat_3' => Misc::checkPredikat($row[26]) ?? null,
                        'sikap_spiritual' => $row[28] ?? null,
                        'sikap_sosial' => $row[29] ?? null,
                    ];
                }

                $nilai = NilaiModel::where('wb_id', $wbDB->id)
                    ->where('kmp_id', $kmpDB->id)
                    ->first();
                if (empty($nilai)) {
                    NilaiModel::create($data);
                }else{
                    $nilai->update($data);
                }
                // Log::debug(json_encode($data));
                // error_log($row[10]);
            }
            
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // error_log($e->getMessage());
            Log::debug($e->getMessage().' on line '.$e->getLine());
            // throw ValidationException::withMessages([$e->getMessage()]);
            throw new Exception($e->getMessage());

            return false;
        }
    }
}
