<?php

namespace App\Services;

use App\Models\KelasMataPelajaranModel;
use App\Models\KelasModel;
use App\Models\KelasWbModel;
use App\Models\RombelModel;
use App\Models\PpdbModel;
use App\Utils\Constant;
use Illuminate\Support\Facades\DB;
use Log;

/**
 * 
 */
class KelasService
{
    function __construct()
    {
        
    }

    /**
     * Duplicate kelas
     *
     * @param  array  $data
     * @return array is_error, response_code, message, trace
     */
    public function duplicateKelas($data)
    {
        DB::beginTransaction();
        try {
            // Tahun akademik yang akan diubah
            $id_sesudah = !empty($data['id']) ? $data['id'] : null;
            $kode_sesudah = !empty($data['kode']) ? $data['kode'] : null;
            $tahun_ajar_sesudah = !empty($data['tahun_ajar']) ? $data['tahun_ajar'] : null;

            // Get data kelas
            $kelas_list = KelasModel::with(['paket_kelas','layanan_kelas',])
                                    ->where('tahun_akademik_id', $data['tahun_aktif'])
                                    ->get();
            
            if (!empty($kelas_list)) {
                foreach ($kelas_list as $key => $kelas) {
                    // Inisialisasi nama kelas baru
                    $nama_kelas = null;

                    // Memisahkan nama kelas
                    $nama_kelas_separated = explode(' ', $kelas->nama);

                    // Properti kelas baru
                    $semester_baru = ($kelas->semester % 2 == 0) ? 1 : 2;

                    // Cek golongan kelas (A/B/C/D)
                    $hasGolongan = false;
                    $golongan_string = null;
                    if (!empty($nama_kelas_separated[2])) {
                        if (strtoupper($nama_kelas_separated[2]) != 'MODULAR') {
                            $hasGolongan = true;
                            $golongan_string = substr($nama_kelas_separated[2], 0, 1);
                        }
                    }

                    if ($kelas->type == Constant::TYPE_KELAS_ABC) {
                        $kelas_numb = $kelas->kelas;
                        if ($kelas->semester % 2 == 0) {
                            /**
                             * @TODO: Jika kelas 12 dilewati atau bagaimana?
                             */
                            if($kelas->kelas == 12) continue;
                            
                            $kelas_numb = $kelas->kelas + 1;
                        }
    
                        $hasPeminatan = false;
                        $peminatan_string = null;
                        if(strpos($kelas->nama, 'IPA') !== false){
                            $hasPeminatan = true;
                            $peminatan_string = 'IPA';
                        } elseif (strpos($kelas->nama, 'IPS') !== false) {
                            $hasPeminatan = true;
                            $peminatan_string = 'IPS';
                        }
    
                        $modular_string = null;
                        if(strpos($kelas->nama, 'NON') !== false){
                            $modular_string = substr($kelas->nama, -11);
                        } else {
                            $modular_string = substr($kelas->nama, -7);
                        }
                        // dd($kelas_numb);
                        // Penamaan kelas baru
                        $nama_kelas = substr($kelas->paket_kelas->kode, -1).
                                        $kelas_numb.$semester_baru." ".
                                        $kelas->layanan_kelas->kode.
                                        ($hasGolongan ? " " . $golongan_string . "-" : "-").
                                        ($hasPeminatan ? $peminatan_string : '').
                                        substr($kode_sesudah, 0, 4)." ".
                                        $modular_string;

                    } else {
                        // Penamaan kelas baru
                        $nama_kelas = $kelas->paket_kelas->kode.
                                        $kelas->kelas.$semester_baru." ".
                                        $kelas->layanan_kelas->kode.
                                        ($hasGolongan ? " " . $golongan_string . "-" : "-").
                                        substr($kode_sesudah, 0, 4);
                    }
                    
                    // Cari Kelas
                    $findKelas = KelasModel::where('kode', $nama_kelas)
                                            ->first();
                    
                    // Jika kelas belum ada sebelumnya
                    if (empty($findKelas)) {
                        $paramsKelasBaru = [
                            'layanan_kelas_id' => $kelas->layanan_kelas_id,
                            'nama' => $nama_kelas,
                            'kode' => $nama_kelas,
                            'type' => $kelas->type,
                            'biaya' => $kelas->biaya,
                            'is_active' => $kelas->is_active,
                            'kelas' => $kelas->kelas,
                            'semester' => $semester_baru,
                            'jurusan' => $kelas->jurusan,
                            'tahun_akademik_id' => $id_sesudah,
                            'paket_kelas_id' => $kelas->paket_kelas_id,
                        ];

                        // Menyimpan kelas baru
                        $kelasBaru = KelasModel::create($paramsKelasBaru);
    
                        // Duplicate data kelas
                        $source = KelasModel::with([
                            'mata_pelajaran',
                            'warga_belajar',
                        ])->find($kelas->id);
    
                        if (!empty($source)) {
                            // Mata pelajaran
                            foreach ($source->mata_pelajaran as $key => $mp) {
                                $kmp = KelasMataPelajaranModel::create([
                                    'kelas_id' => $kelasBaru->id,
                                    'mata_pelajaran_id' => $mp['mata_pelajaran_id'],
                                    'tutor_id' => $mp['tutor_id'],
                                ]);
                            }

                            // Warga belajar
                            foreach ($source->warga_belajar as $key => $wb) {
                                $kwb = KelasWbModel::create([
                                    'kelas_id' => $kelasBaru->id,
                                    'wb_id' => $wb['wb_id'],
                                ]);
                            }

                            // Rombel
                            foreach ($source->warga_belajar as $key => $wb) {
                                $ppdb = PpdbModel::find($wb['wb_id']);
                                $existingData = RombelModel::join('ppdb', 'rombel.ppdb_id', '=', 'ppdb.id')
                                    ->where('rombel.tahun_akademik_id', $id_sesudah)
                                    ->where('ppdb.nisn', $ppdb->nisn)
                                    ->first();
                                

                                if (!$existingData) {
                                    $rombel = RombelModel::create([
                                        'ppdb_id' => $wb['wb_id'],
                                        'tahun_akademik_id' => $id_sesudah,
                                        'kelas_id' => $kelasBaru->id,
                                        'is_active' => false,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
            
            DB::commit();

            $return_data = [
                'error' => false,
                'response_code' => 200,
                'message' => 'Berhasil menduplikasi kelas',
            ];

            return $return_data;
        } catch (\Exception $e) {
            DB::rollBack();
            $return_data = [
                'error' => true,
                'response_code' => 400,
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ];
            return $return_data;
        }catch (\Throwable $e) {
            DB::rollBack();
            $return_data = [
                'error' => true,
                'response_code' => 400,
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ];
            return $return_data;
        }
    }

}