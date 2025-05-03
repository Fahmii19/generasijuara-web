<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KmpSettingModel;
use App\Models\SettingsModel;
use DB;
use App\Utils\Misc;

class KmpSettingController extends Controller
{
    public function get(Request $request)
    {
        try {
            if ($request->has('kmp_id')) {
                $kmp_setting = KmpSettingModel::where('kmp_id', $request->kmp_id)->first();
                return response()->json(['error' => false, 'message' => null, 'data' => $kmp_setting ], 200); 
            }
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $kmp_setting = KmpSettingModel::find($id);
            return response()->json(['error' => false, 'message' => null, 'data' => $kmp_setting ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function getAll(Request $request)
    {
        try {
            $kmp_setting = KmpSettingModel::get();
            return response()->json(['error' => false, 'message' => null, 'data' => $kmp_setting ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $kmp_setting = KmpSettingModel::find($id);
            if (empty($kmp_setting)) {
                return response()->json(['error' => true, 'message' => 'Mata pelajaran tidak ditemukan'], 400); 
            }
            $kmp_setting->delete();
            return response()->json(['error' => false, 'message' => null, 'data' => [] ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function save(Request $request)
    {
        DB::beginTransaction();
        try {
            $kmp_id = !empty($request->get('kmp_id')) ? $request->get('kmp_id') : null;
            $persentase_tm = !empty($request->get('persentase_tm')) ? $request->get('persentase_tm') : 0;
            $persentase_um = !empty($request->get('persentase_um')) ? $request->get('persentase_um') : 0;
            $k_persentase_tm = !empty($request->get('k_persentase_tm')) ? $request->get('k_persentase_tm') : 0;
            $k_persentase_um = !empty($request->get('k_persentase_um')) ? $request->get('k_persentase_um') : 0;
            $kkm = !empty($request->get('kkm')) ? $request->get('kkm') : SettingsModel::getByKey('default_kkm');
            $skk = !empty($request->get('skk')) ? $request->get('skk') : 0;
            $jumlah_modul = !empty($request->get('jumlah_modul')) ? $request->get('jumlah_modul') : 3;
            $need_nilai_sikap = !empty($request->get('need_nilai_sikap')) ? Misc::castBoolean($request->get('need_nilai_sikap')) : null;
            
            $kmp_setting = KmpSettingModel::where('kmp_id', $kmp_id)->first();
            $params = [
                'kmp_id' => $kmp_id,
                'persentase_tm' => $persentase_tm,
                'persentase_um' => $persentase_um,
                'k_persentase_tm' => $k_persentase_tm,
                'k_persentase_um' => $k_persentase_um,
                'jumlah_modul' => $jumlah_modul,
                'need_nilai_sikap' => $need_nilai_sikap,
                'kkm' => $kkm,
                'skk' => $skk,
            ];
            if (!empty($kmp_setting)) {
                // update
                $kmp_setting->update($params);
            }else{
                // new
                $kmp_setting = KmpSettingModel::create($params);
            }
            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $kmp_setting ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
}
