<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EkstrakurikulerModel;
use App\Utils\Constant;
use DB;

class EkstrakulikulerController extends Controller
{
    public function get(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $ekskul = EkstrakurikulerModel::find($id);
            return response()->json(['error' => false, 'message' => null, 'data' => $ekskul ], 200); 
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
            $ekskul = EkstrakurikulerModel::find($id);
            if (empty($ekskul)) {
                return response()->json(['error' => true, 'message' => 'Ekstrakulikuler tidak ditemukan'], 400); 
            }
            $ekskul->delete();
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
            $kegiatan = !empty($request->get('kegiatan')) ? $request->get('kegiatan') : null;
            $predikat = !empty($request->get('predikat')) ? $request->get('predikat') : null;
            $deskripsi = !empty($request->get('deskripsi')) ? $request->get('deskripsi') : null;
            
            $db = EkstrakurikulerModel::find($id);
            
            $params = [
                'kwb_id' => $kwb_id,
                'kegiatan' => $kegiatan,
                'predikat' => $predikat,
                'deskripsi' => $deskripsi,
                'updated_by' => $userAuth->id,
            ];

            if (!empty($db)) {
                // update
                $db->update($params);
            }else{
                // new
                $params['created_by'] = $userAuth->id;
                $db = EkstrakurikulerModel::create($params);
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
