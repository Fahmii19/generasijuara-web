<?php

namespace App\Http\Controllers\Ajax;

use App\Exports\NilaiExport;
use App\Http\Controllers\Controller;
use App\Imports\NilaiImport;
use Illuminate\Http\Request;
use App\Models\NilaiModel;
use App\Models\KmpSettingModel;
use App\Models\KelasMataPelajaranModel;
use App\Models\KelasModel;
use App\Models\NilaiItemsModel;
use App\Models\TagihanItemsModel;
use App\Models\TagihanModel;
use App\Utils\Constant;
use App\Utils\Misc;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class NilaiController extends Controller
{
    public function importExcel(Request $request)
    {
        if ($request->hasFile('import_file')) {
            try {
                Excel::import(new NilaiImport(3), $request->file('import_file'));
                return response()->json([], 200); 
            } catch (\Throwable $th) {
                return response()->json([
                    'error' => true,
                    'message' => $th->getMessage(),
                ], 500);
            }
        }
    }
    
    public function get(Request $request)
    {
        try {
            $wb_id = !empty($request->get('wb_id')) ? $request->get('wb_id') : null;
            $kmp_id = !empty($request->get('kmp_id')) ? $request->get('kmp_id') : null;
            $kelas_id = KelasMataPelajaranModel::find($kmp_id)->kelas_id;
            $jenis_rapor = KelasModel::find($kelas_id)->jenis_rapor;

            $nilai = NilaiModel::with('items')
                ->where('wb_id', $wb_id)
                ->where('kmp_id', $kmp_id)
                ->first();
            
            $data = [
                'nilai' => $nilai,
                'jenis_rapor' => $jenis_rapor
            ];

            // dd($data);
            return response()->json(['error' => false, 'message' => null, 'data' => $data ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function save(Request $request)
    {
        // dd($request->all());
        try {
            $wb_id = !empty($request->get('wb_id')) ? $request->get('wb_id') : null;
            $kmp_id = !empty($request->get('kmp_id')) ? $request->get('kmp_id') : null;

            $kmp_setting = KmpSettingModel::where('kmp_id', $kmp_id)->first();
            $jumlah_modul = !empty($kmp_setting) ? $kmp_setting->jumlah_modul : 3;
            $persentase_tm = !empty($kmp_setting) ? $kmp_setting->persentase_tm : 0;
            $persentase_um = !empty($kmp_setting) ? $kmp_setting->persentase_um : 0;
            $k_persentase_tm = !empty($kmp_setting) ? $kmp_setting->k_persentase_tm : 0;
            $k_persentase_um = !empty($kmp_setting) ? $kmp_setting->k_persentase_um : 0;


            $params = $request->all();
            $kelas = KelasModel::find($params['kelas_id']);
            if (empty($kelas)) {
                return response()->json(['error' => true, 'message' => 'Kelas tidak ditemukan'], 400); 
            }

            if ($kelas->is_lock_nilai) {
                return response()->json(['error' => true, 'message' => 'Nilai kelas sudah dikunci. silahkan hubungi admin'], 400); 
            }
            // dd($params);
            $data = [
                'kelas_id' => $params['kelas_id'],
                'kmp_id' => $kmp_id,
                'wb_id' => $wb_id,
                'p_tugas_1' => null,
                'p_ujian_1' => null,
                'p_nilai_1' => null,
                'p_predikat_1' => null,
                'k_nilai_1' => null,
                'k_predikat_1' => null,
                'p_tugas_2' => null,
                'p_ujian_2' => null,
                'p_nilai_2' => null,
                'p_predikat_2' => null,
                'k_nilai_2' => null,
                'k_predikat_2' => null,
                'p_tugas_3' => null,
                'p_ujian_3' => null,
                'p_nilai_3' => null,
                'p_predikat_3' => null,
                'k_nilai_3' => null,
                'k_predikat_3' => null,
                'sikap_spiritual' => $params['sikap_spiritual'],
                'sikap_spiritual_desc' => null,
                'sikap_sosial' => $params['sikap_sosial'],
                'sikap_sosial_desc' => null,
                'capaian_kompetensi' => $params['capaian_kompetensi'],
                'susulan_remedial' => $params['susulan_remedial'],
                'p_susulan_1' => null,
                'p_susulan_2' => null,
                'p_susulan_3' => null,
                'k_susulan_1' => null,
                'k_susulan_2' => null,
                'k_susulan_3' => null,
                'p_remedial_1' => null,
                'p_remedial_2' => null,
                'p_remedial_3' => null,
                'k_remedial_1' => null,
                'k_remedial_2' => null,
                'k_remedial_3' => null,
            ];

            // $data_items = [
            //     'nilai_id' => null,
            //     'p_susulan_tugas_1' => null,
            //     'p_susulan_tugas_2' => null,
            //     'p_susulan_tugas_3' => null,
            //     'k_susulan_tugas_1' => null,
            //     'k_susulan_tugas_2' => null,
            //     'k_susulan_tugas_3' => null,
            //     'p_susulan_ujian_1' => null,
            //     'p_susulan_ujian_2' => null,
            //     'p_susulan_ujian_3' => null,
            //     'k_susulan_ujian_1' => null,
            //     'k_susulan_ujian_2' => null,
            //     'k_susulan_ujian_3' => null,
            //     'p_remedial_tugas_1' => null,
            //     'p_remedial_tugas_2' => null,
            //     'p_remedial_tugas_3' => null,
            //     'k_remedial_tugas_1' => null,
            //     'k_remedial_tugas_2' => null,
            //     'k_remedial_tugas_3' => null,
            //     'p_remedial_ujian_1' => null,
            //     'p_remedial_ujian_2' => null,
            //     'p_remedial_ujian_3' => null,
            //     'k_remedial_ujian_1' => null,
            //     'k_remedial_ujian_2' => null,
            //     'k_remedial_ujian_3' => null,
            // ];

            // $test = [];
            for ($i=1; $i <=$jumlah_modul ; $i++) { 
                $data['p_tugas_'.$i] = $params['p_tugas_'.$i] ? $params['p_tugas_'.$i] : null;
                $data['p_ujian_'.$i] = $params['p_ujian_'.$i] ? $params['p_ujian_'.$i] : null;
                $data['p_nilai_'.$i] = (($params['p_tugas_'.$i] ? $params['p_tugas_'.$i] : 0) * $persentase_tm / 100)
                                        + (($params['p_ujian_'.$i] ? $params['p_ujian_'.$i] : 0) * $persentase_um / 100);
                $data['p_predikat_'.$i] = $params['p_predikat_'.$i] ? $params['p_predikat_'.$i] : null;
                $data['k_nilai_'.$i] = $params['k_nilai_'.$i] ? $params['k_nilai_'.$i] : null;
                $data['k_predikat_'.$i] = $params['k_predikat_'.$i] ? $params['k_predikat_'.$i] : null;

                // $data_items['p_susulan_tugas_'.$i] = Misc::castBoolean($params['p_susulan_tugas_'.$i]) ? Misc::castBoolean($params['p_susulan_tugas_'.$i]) : null;
                // $data_items['k_susulan_tugas_'.$i] = Misc::castBoolean($params['k_susulan_tugas_'.$i]) ? Misc::castBoolean($params['k_susulan_tugas_'.$i]) : null;
                // $data_items['p_susulan_ujian_'.$i] = Misc::castBoolean($params['p_susulan_ujian_'.$i]) ? Misc::castBoolean($params['p_susulan_ujian_'.$i]) : null;
                // $data_items['k_susulan_ujian_'.$i] = Misc::castBoolean($params['k_susulan_ujian_'.$i]) ? Misc::castBoolean($params['k_susulan_ujian_'.$i]) : null;
                // $data_items['p_remedial_tugas_'.$i] = Misc::castBoolean($params['p_remedial_tugas_'.$i]) ? Misc::castBoolean($params['p_remedial_tugas_'.$i]) : null;
                // $data_items['k_remedial_tugas_'.$i] = Misc::castBoolean($params['k_remedial_tugas_'.$i]) ? Misc::castBoolean($params['k_remedial_tugas_'.$i]) : null;
                // $data_items['p_remedial_ujian_'.$i] = Misc::castBoolean($params['p_remedial_ujian_'.$i]) ? Misc::castBoolean($params['p_remedial_ujian_'.$i]) : null;
                // $data_items['k_remedial_ujian_'.$i] = Misc::castBoolean($params['k_remedial_ujian_'.$i]) ? Misc::castBoolean($params['k_remedial_ujian_'.$i]) : null;

                // $data['p_susulan_'.$i] = Misc::castBoolean($params['p_susulan_'.$i]) ? null : Misc::castBoolean($params['p_susulan_'.$i]);
                // $data['p_remedial_'.$i] = Misc::castBoolean($params['p_remedial_'.$i]) ? null : Misc::castBoolean($params['p_remedial_'.$i]);
                // $test[$i] = [$params['p_susulan_'.$i], $params['p_tugas_'.$i]];
            }
            // dd($test, $jumlah_modul);

            $nilai = NilaiModel::where('wb_id', $wb_id)
                ->where('kmp_id', $kmp_id)
                ->first();

            if (empty($nilai)) {
                $data_nilai = NilaiModel::create($data);
                // $data_items['nilai_id'] = $data_nilai->id;
                // NilaiItemsModel::create($data_items);
            }else{
                $nilai->update($data);
                // $data_items['nilai_id'] = $nilai->id;
                // $nilai_items = NilaiItemsModel::where('nilai_id', $nilai->id)->first();
                // $nilai_items->update($data_items);
            }
            return response()->json(['error' => false, 'message' => null, 'data' => $nilai ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'line' => $e->getLine()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'line' => $e->getLine()], 400); 
        }
    }

    public function calculateTagihan(Request $request)
    {
        // dd($request->all());
        try {
            $kelas_id = !empty($request->get('kelas_id')) ? $request->get('kelas_id') : null;
            $kmp_id = !empty($request->get('kmp_id')) ? $request->get('kmp_id') : null;

            $nilai = NilaiModel::with(['kmp','items'])
                ->where('kelas_id', $kelas_id)
                ->where('kmp_id', $kmp_id)
                ->where('is_tagihan_created', 0)
                ->get();

            $biaya_susulan_tm = 100000;
            $biaya_susulan_um = 150000;
            $biaya_remedial_tm = 100000;
            $biaya_remedial_um = 150000;
            
            foreach ($nilai as $key => $value) {
                if (empty($value->susulan_remedial)) {
                    continue;
                }

                $susulan_remedial = json_decode($value->susulan_remedial, true);

                $total_susulan_tm = 0;
                $total_susulan_um = 0;
                $total_remedial_tm = 0;
                $total_remedial_um = 0;

                foreach ($susulan_remedial as $i => $v) {
                    foreach ($v as $j => $w) {
                        if ($i == 'susulan') {
                            if ($j == 'p_tugas' || $j == 'k_tugas') {
                                $total_susulan_tm = $total_susulan_tm + count($w);
                            } elseif ($j == 'p_ujian' || $j == 'k_ujian') {
                                $total_susulan_um = $total_susulan_um + count($w);
                            }
                        } elseif ($i == 'remedial') {
                            if ($j == 'p_tugas' || $j == 'k_tugas') {
                                $total_remedial_tm = $total_remedial_tm + count($w);
                            } elseif ($j == 'p_ujian' || $j == 'k_ujian') {
                                $total_remedial_um = $total_remedial_um + count($w);
                            }
                        }
                    }
                }


                // $value->items->p_susulan_tugas_1 ? $total_susulan_tm += 1 : '';
                // $value->items->p_susulan_tugas_2 ? $total_susulan_tm += 1 : '';
                // $value->items->p_susulan_tugas_3 ? $total_susulan_tm += 1 : '';
                // $value->items->k_susulan_tugas_1 ? $total_susulan_tm += 1 : '';
                // $value->items->k_susulan_tugas_2 ? $total_susulan_tm += 1 : '';
                // $value->items->k_susulan_tugas_3 ? $total_susulan_tm += 1 : '';

                // $value->items->p_susulan_ujian_1 ? $total_susulan_um += 1 : '';
                // $value->items->p_susulan_ujian_2 ? $total_susulan_um += 1 : '';
                // $value->items->p_susulan_ujian_3 ? $total_susulan_um += 1 : '';
                // $value->items->k_susulan_ujian_1 ? $total_susulan_um += 1 : '';
                // $value->items->k_susulan_ujian_2 ? $total_susulan_um += 1 : '';
                // $value->items->k_susulan_ujian_3 ? $total_susulan_um += 1 : '';

                // $value->items->p_remedial_tugas_1 ? $total_remedial_tm += 1 : '';
                // $value->items->p_remedial_tugas_2 ? $total_remedial_tm += 1 : '';
                // $value->items->p_remedial_tugas_3 ? $total_remedial_tm += 1 : '';
                // $value->items->k_remedial_tugas_1 ? $total_remedial_tm += 1 : '';
                // $value->items->k_remedial_tugas_2 ? $total_remedial_tm += 1 : '';
                // $value->items->k_remedial_tugas_3 ? $total_remedial_tm += 1 : '';

                // $value->items->p_remedial_ujian_1 ? $total_remedial_um += 1 : '';
                // $value->items->p_remedial_ujian_2 ? $total_remedial_um += 1 : '';
                // $value->items->p_remedial_ujian_3 ? $total_remedial_um += 1 : '';
                // $value->items->k_remedial_ujian_1 ? $total_remedial_um += 1 : '';
                // $value->items->k_remedial_ujian_2 ? $total_remedial_um += 1 : '';
                // $value->items->k_remedial_ujian_3 ? $total_remedial_um += 1 : '';


                // Total biaya
                $total_biaya_susulan_tm = $total_susulan_tm * $biaya_susulan_tm;
                $total_biaya_susulan_um = $total_susulan_um * $biaya_susulan_um;
                $total_biaya_remedial_tm = $total_remedial_tm * $biaya_remedial_tm;
                $total_biaya_remedial_um = $total_remedial_um * $biaya_remedial_um;

                
                // Keterangan
                $keterangan = null;
                $have_bill = true;
                $kmp = $value->kmp->mata_pelajaran_detail->nama;
                if ($total_susulan_tm > 0 || $total_susulan_um > 0) {
                    if ($total_remedial_tm > 0 || $total_remedial_um > 0) {
                        $keterangan = "Susulan & Remedial $kmp";
                    } else {
                        $keterangan = "Susulan $kmp";
                    }
                } elseif ($total_remedial_tm > 0 || $total_remedial_um > 0) {
                    if ($total_susulan_tm > 0 || $total_susulan_um > 0) {
                        $keterangan = "Susulan & Remedial $kmp";
                    } else {
                        $keterangan = "Remedial $kmp";
                    }
                } else {
                    $keterangan = '-';
                    $have_bill = false;
                }

                // Jika mempunyai tagihan
                if ($have_bill) {
                    $total_tagihan = $total_biaya_susulan_tm + $total_biaya_susulan_um + $total_biaya_remedial_tm + $total_biaya_remedial_um;

                    // Save to `Tagihan`
                    $bill = new TagihanModel();
                    $bill->type = TagihanModel::TYPE_SUSULAN_REMEDIAL;
                    $bill->keterangan = $keterangan;
                    $bill->source_table = 'nilai';
                    $bill->source_id = $value->id;
                    $bill->ppdb_id = $value->wb_id;
                    $bill->tagihan = $total_tagihan;
                    $bill->total_tagihan = $total_tagihan;
                    $bill->nominal = 0;
                    $bill->status = TagihanModel::BELUM_LUNAS;
                    $bill->save();


                    // Save to `Tagihan Items`
                    $tagihan_id = $bill->id;
                    $paramsBillItems = [];

                    if (!empty($total_biaya_susulan_tm)) {
                        $paramsBillItems[] = [
                            'tagihan_id' => $tagihan_id,
                            'item' => "Biaya susulan tugas",
                            'nominal' => $total_biaya_susulan_tm,
                        ];
                    }
                    if (!empty($total_biaya_susulan_um)) {
                        $paramsBillItems[] = [
                            'tagihan_id' => $tagihan_id,
                            'item' => "Biaya susulan ujian",
                            'nominal' => $total_biaya_susulan_um,
                        ];
                    }
                    if (!empty($total_biaya_remedial_tm)) {
                        $paramsBillItems[] = [
                            'tagihan_id' => $tagihan_id,
                            'item' => "Biaya remedial tugas",
                            'nominal' => $total_biaya_remedial_tm,
                        ];
                    }
                    if (!empty($total_biaya_remedial_um)) {
                        $paramsBillItems[] = [
                            'tagihan_id' => $tagihan_id,
                            'item' => "Biaya remedial ujian",
                            'nominal' => $total_biaya_remedial_um,
                        ];
                    }

                    TagihanItemsModel::insert($paramsBillItems);
                }

                // Update status is_tagihan_created
                NilaiModel::where('id', $value->id)->update(['is_tagihan_created' => true]);
            }

            return response()->json(['error' => false, 'message' => null, 'data' => null ], 200);
        } catch (\Exception $e) {
            Log::error(__METHOD__ . " | on line: " . $e->getLine() . " | " . $e->getMessage());
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
}
