<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KelasMataPelajaranModel;
use DB;

class KelasMataPelajaranController extends Controller
{
    public function get(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $kelas_mata_pelajaran = KelasMataPelajaranModel::with([
                'kelas_detail', 
                'mata_pelajaran_detail',
                'tutor_detail.user_detail'
            ])->find($id);
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas_mata_pelajaran ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function getAll(Request $request)
    {
        try {
            $type = !empty($request->get('type')) ? $request->get('type') : 0;
            $kelas_mata_pelajaran = KelasMataPelajaranModel::where('type', $type)->get();
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas_mata_pelajaran ], 200); 
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
            $kelas_mata_pelajaran = KelasMataPelajaranModel::find($id);
            if (empty($kelas_mata_pelajaran)) {
                return response()->json(['error' => true, 'message' => 'Mata pelajaran tidak ditemukan'], 400); 
            }
            $kelas_mata_pelajaran->delete();
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
            $mata_pelajaran_id = !empty($request->get('mata_pelajaran_id')) ? $request->get('mata_pelajaran_id') : null;
            $kelas_id = !empty($request->get('kelas_id')) ? $request->get('kelas_id') : null;
            $tutor_id = !empty($request->get('tutor_id')) ? $request->get('tutor_id') : null;
            
            $kelas_mata_pelajaran = KelasMataPelajaranModel::find($id);
            $params = [
                'mata_pelajaran_id' => $mata_pelajaran_id,
                'kelas_id' => $kelas_id,
                'tutor_id' => $tutor_id,
            ];

            $checkDuplicateKMP = KelasMataPelajaranModel::query()
                ->where('mata_pelajaran_id', $mata_pelajaran_id)
                ->where('kelas_id', $kelas_id)
                ->where('id', '<>', $id)
                ->first();
            if (!empty($checkDuplicateKMP)) {
                return response()->json(['error' => true, 'message' => "Mata pelajaran sudah terdaftar sebelumnya"], 400); 
            }

            if (!empty($kelas_mata_pelajaran)) {
                // update
                $kelas_mata_pelajaran->update($params);
            }else{
                // new
                $kelas_mata_pelajaran = KelasMataPelajaranModel::create($params);
            }
            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas_mata_pelajaran ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
}
