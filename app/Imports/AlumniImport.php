<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\AlumniModel;
use App\Models\TahunAkademikModel;
use DB;

class AlumniImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            $tahun_akademik_id = '';

            foreach ($rows as $key => $row) {

                if ($row[0] == 'Tahun Akademik') {
                    $tahun_akademik_id = TahunAkademikModel::where('tahun_ajar', $row[2])->value('id');
                    continue;
                } elseif ($key < 2) continue;
                
                if (empty($row[0])) continue;

                $tempIndex = 0;
                $no = $row[$tempIndex++];
                $paket = strtolower($row[$tempIndex++]);
                $nis = $row[$tempIndex++];
                $nisn = $row[$tempIndex++];
                $nama = $row[$tempIndex++];
                $jenis_kelamin = $row[$tempIndex++];
                $no_hp = $row[$tempIndex++];
                $email = $row[$tempIndex++];
                $lanjut_kuliah = strtolower($row[$tempIndex++]) === 'ya' ? 1 : 0;
                $nama_sekolah = $row[$tempIndex++];
                $prodi = $row[$tempIndex++];
                $surat_penerimaan = $row[$tempIndex++];
                $usaha = $row[$tempIndex++];
                $sertifikat = $row[$tempIndex++];

                $alumni = AlumniModel::updateOrCreate(
                    ['nis' => $nis],
                    [
                        'tahun_akademik_id' => $tahun_akademik_id,
                        'no' => $no,
                        'paket' => $paket,
                        'nama' => $nama,
                        'jenis_kelamin' => $jenis_kelamin,
                        'no_hp' => $no_hp,
                        'email' => $email,
                        'lanjut_kuliah' => $lanjut_kuliah,
                        'nama_sekolah' => $nama_sekolah,
                        'prodi' => $prodi,
                        'surat_penerimaan' => $surat_penerimaan,
                        'usaha' => $usaha,
                        'sertifikat' => $sertifikat,
                    ]
                );

                // dd($alumni);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            error_log($e->getMessage());
        }
    }
}
