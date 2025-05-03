<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NilaiKegiatanModel;
use App\Utils\Constant;
use DB;

class NilaiKegiatanController extends Controller
{
    public function get(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $db = NilaiKegiatanModel::find($id);
            return response()->json(['error' => false, 'message' => null, 'data' => $db ], 200); 
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
            $db = NilaiKegiatanModel::find($id);
            if (empty($db)) {
                return response()->json(['error' => true, 'message' => 'Kegiatan tidak ditemukan'], 400); 
            }
            $db->delete();
            return response()->json(['error' => false, 'message' => null, 'data' => [] ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function save(Request $request)
    {
        $userAuth = auth()->user();

        DB::beginTransaction();
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $kwb_id = !empty($request->get('kwb_id')) ? $request->get('kwb_id') : null;
            $jenis_kegiatan = !empty($request->get('jenis_kegiatan')) ? $request->get('jenis_kegiatan') : null;
            $prestasi = !empty($request->get('prestasi')) ? $request->get('prestasi') : null;
            
            $db = NilaiKegiatanModel::find($id);
            
            $params = [
                'kwb_id' => $kwb_id,
                'jenis_kegiatan' => $jenis_kegiatan,
                'prestasi' => $prestasi,
                'updated_by' => $userAuth->id,
            ];

            if (!empty($db)) {
                // update
                $db->update($params);
            }else{
                // new
                $params['created_by'] = $userAuth->id;
                $db = NilaiKegiatanModel::create($params);
            }
            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $db ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
}
