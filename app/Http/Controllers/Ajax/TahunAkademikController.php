<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\KelasMataPelajaranModel;
use App\Models\KelasModel;
use App\Models\KelasWbModel;
use App\Models\RombelModel;
use Illuminate\Http\Request;
use App\Models\TahunAkademikModel;
use App\Models\SettingsModel;
use App\Services\KelasService;
use App\Utils\Misc;
use Illuminate\Support\Facades\DB;

class TahunAkademikController extends Controller
{
    public function list(Request $request)
    {
        try {
            $query = TahunAkademikModel::query();
            $query->orderBy('kode', 'desc');
            return response()->json(['error' => false, 'message' => null, 'data' => $query->get() ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
    public function get(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $tahun_akademik = TahunAkademikModel::find($id);
            return response()->json(['error' => false, 'message' => null, 'data' => $tahun_akademik ], 200); 
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
            $tahun_akademik = TahunAkademikModel::find($id);
            if (empty($tahun_akademik)) {
                return response()->json(['error' => true, 'message' => 'tahun_akademik tidak ditemukan'], 400); 
            }
            $tahun_akademik->delete();

            $tahun_aktif = TahunAkademikModel::where('is_active', true)->first();
            $tahun_ajaran_aktif = !empty($tahun_aktif) ? $tahun_aktif->tahun : null;
            SettingsModel::where('key', 'tahun_ajaran_aktif')->update(['value' => $tahun_ajaran_aktif]);

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
            $kode = !empty($request->get('kode')) ? $request->get('kode') : null;
            $tahun_ajar = !empty($request->get('tahun_ajar')) ? $request->get('tahun_ajar') : null;
            $keterangan = !empty($request->get('keterangan')) ? $request->get('keterangan') : null;
            $periode_start = !empty($request->get('periode_start')) ? $request->get('periode_start') : null;
            $periode_end = !empty($request->get('periode_end')) ? $request->get('periode_end') : null;
            $tgl_cover_raport = !empty($request->get('tgl_cover_raport')) ? $request->get('tgl_cover_raport') : null;
            $tgl_raport = !empty($request->get('tgl_raport')) ? $request->get('tgl_raport') : null;
            $is_active = !empty($request->get('is_active')) ? Misc::castBoolean($request->get('is_active')) : false;

            $params = [
                'kode' => $kode,
                'tahun_ajar' => $tahun_ajar,
                'keterangan' => $keterangan,
                'periode_start' => $periode_start,
                'periode_end' => $periode_end,
                'tgl_cover_raport' => $tgl_cover_raport,
                'tgl_raport' => $tgl_raport,
                'is_active' => $is_active,
            ];

            $tahun_ajaran_aktif = null;

            if ($is_active) {
                $tahun_aktif = TahunAkademikModel::where('is_active', true)->first();
                $param_duplicate_kelas = [
                    'id' => $id,
                    'kode' => $kode,
                    'tahun_ajar' => $tahun_ajar,
                    'tahun_aktif' => $tahun_aktif->id,
                ];
                // $this->duplicateKelas($param_duplicate_kelas);

                TahunAkademikModel::query()->update(['is_active' => false]);
                $tahun_ajaran_aktif = $params['kode'];
            }else{
                $tahun_aktif = TahunAkademikModel::where('is_active', true)->first();
                $tahun_ajaran_aktif = !empty($tahun_aktif) ? $tahun_aktif->kode : null;
            }

            $tahun_akademik = TahunAkademikModel::find($id);
            if (!empty($tahun_akademik)) {
                // update
                $request->validate([
                    'kode' => 'required|unique:tahun_akademik,kode,'.$tahun_akademik->id,
                ]);
                $tahun_akademik->update($params);
            }else{
                // new
                $request->validate([
                    'kode' => 'required|unique:tahun_akademik,kode',
                ]);
                $tahun_akademik = TahunAkademikModel::create($params);
            }

            SettingsModel::where('key', 'tahun_ajaran_aktif')->update(['value' => $tahun_ajaran_aktif]);
            
            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $tahun_akademik ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function duplicateKelas(Request $request)
    {
        $tahun_aktif = TahunAkademikModel::where('is_active', true)->first();
        $param_duplicate_kelas = [
            'id' => $request->id,
            'kode' => $request->kode,
            'tahun_ajar' => $request->tahun_ajar,
            'tahun_aktif' => $tahun_aktif->id,
        ];

        $kelasService = new KelasService();
        $duplicate = $kelasService->duplicateKelas($param_duplicate_kelas);

        if (!$duplicate['error']) {
            $tahun_akademik = TahunAkademikModel::where('id', $request->id)->first();
            $tahun_akademik->is_generate_rombel = true;
            $tahun_akademik->save();
            
            return response()->json([
                $duplicate['error'],
                $duplicate['message']
            ], $duplicate['response_code']);
        } else {
            return response()->json([
                $duplicate['error'],
                $duplicate['message'],
                $duplicate['trace']
            ], $duplicate['response_code']);
        }
    }
}
