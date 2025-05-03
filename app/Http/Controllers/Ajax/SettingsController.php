<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingsModel;
use DB;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function get(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $settings = SettingsModel::find($id);
            return response()->json(['error' => false, 'message' => null, 'data' => $settings ], 200); 
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
            $settings = SettingsModel::find($id);
            if (empty($settings)) {
                return response()->json(['error' => true, 'message' => 'settings tidak ditemukan'], 400); 
            }
            // $settings->delete();
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
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $key = !empty($request->get('key')) ? $request->get('key') : null;
            // $value = ($key == 'ttd_kepala_pkbm') ? $request->file('value') : $request->input('value');
            if (!empty($key)) {
                $value = ($key == 'ttd_kepala_pkbm') ? $request->file('value') : $request->get('value');
            } else {
                $value = null;
            }
            $datatype = $request->input('datatype', 'string');

            if ($key == 'ttd_kepala_pkbm') {
                $storeFilePath = Storage::disk('public_path')->put('setting_var', $value);
                $value = url('/') . '/uploads/' . $storeFilePath;
            }

            $params = [
                'value' => $value,
                'datatype' => $datatype,
            ];
            
            $settings = SettingsModel::find($id);
            // return response()->json(['error' => true, 'data' => $settings], 400); 
            if (!empty($settings)) {
                // update
                $settings->update($params);
            }else{
                // new
                // $settings = SettingsModel::create($params);
            }
            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $settings ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function getKepalaPkbm() {
        try {
            $dataKepalaPkbm = DB::table('settings')
                ->whereIn('key', ['nama_kepala_pkbm', 'nip_kepala_pkbm', 'ttd_kepala_pkbm'])
                ->get();

            $result = [];

            foreach ($dataKepalaPkbm as $item) {
                $result[$item->key] = $item->value;
            }

            return response()->json(['error' => false, 'message' => null, 'data' => $result ], 200);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
}
