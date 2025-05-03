<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\RaportSettingModel;
use App\Models\SettingsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RaportSettingController extends Controller
{
    public function getData(Request $request)
    {
        try {
            $kelas_id = !empty($request->get('kelas_id')) ? $request->get('kelas_id') : null;
            $data = RaportSettingModel::where('kelas_id', $kelas_id)->first();

            $settingGlobal = SettingsModel::whereIn('key', ['nama_kepala_pkbm', 'nip_kepala_pkbm', 'ttd_kepala_pkbm'])->get();

            $values = [];
            foreach ($settingGlobal as $setting) {
                $values[$setting->key] = $setting->value;
            }

            $data['nama_ketua_pkbm'] = $values['nama_kepala_pkbm'];
            $data['nip_ketua_pkbm'] = $values['nip_kepala_pkbm'];
            $data['url_ttd_ketua'] = $values['ttd_kepala_pkbm'];

            return response()->json(['error' => false, 'message' => null, 'data' => $data ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function saveOrUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $ttdKetuaPath = null;
            $ttdPjPath = null;

            if (!empty($request->ttd_ketua_pkbm)) {
                $ttdKetuaPath = Storage::disk('public_path')->put('ttd', $request->ttd_ketua_pkbm);
            }
            if (!empty($request->ttd_pj_rombel)) {
                $ttdPjPath = Storage::disk('public_path')->put('ttd', $request->ttd_pj_rombel);
            }

            $ttdSetting = RaportSettingModel::where('kelas_id', $request->kelas_id)->first();
            if (!empty($ttdSetting)) {
                // UPDATE
                $ttdSetting->nama_ketua_pkbm = $request->nama_ketua_pkbm;
                $ttdSetting->nip_ketua_pkbm = $request->nip_ketua_pkbm;
                if (!empty($ttdKetuaPath)) {
                    $ttdSetting->url_ttd_ketua = '/uploads/' . $ttdKetuaPath;
                }
                $ttdSetting->nama_pj_rombel = $request->nama_pj_rombel;
                $ttdSetting->nip_pj_rombel = $request->nip_pj_rombel;
                if (!empty($ttdPjPath)) {
                    $ttdSetting->url_ttd_pj = url('/') . '/uploads/' . $ttdPjPath;
                }
                $ttdSetting->save();
            } else {
                // NEW
                $ttdSetting = new RaportSettingModel();
                $ttdSetting->kelas_id = $request->kelas_id;
                $ttdSetting->nama_ketua_pkbm = $request->nama_ketua_pkbm;
                $ttdSetting->nip_ketua_pkbm = $request->nip_ketua_pkbm;
                if (!empty($ttdKetuaPath)) {
                    $ttdSetting->url_ttd_ketua = '/uploads/' . $ttdKetuaPath;
                }
                $ttdSetting->nama_pj_rombel = $request->nama_pj_rombel;
                $ttdSetting->nip_pj_rombel = $request->nip_pj_rombel;
                if (!empty($ttdPjPath)) {
                    $ttdSetting->url_ttd_pj = url('/') . '/uploads/' . $ttdPjPath;
                }
                $ttdSetting->save();
            }

            DB::commit();
            return response()->json(['error' => false, 'message' => 'Data berhasil disimpan', 'data' => null ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
}
