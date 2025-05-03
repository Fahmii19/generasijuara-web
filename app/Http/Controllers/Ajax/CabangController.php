<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\CabangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CabangController extends Controller
{
    public function getCabang(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $cabang = CabangModel::query();

            if (!empty($id)) {
                $cabang = $cabang->where('id', $id);
                $cabang = $cabang->first();
            } else {
                $cabang = $cabang->get();
            }

            return response()->json(['error' => false, 'message' => null, 'data' => $cabang ], 200); 
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
            $nama_cabang = !empty($request->get('nama_cabang')) ? $request->get('nama_cabang') : null;
            $cabang = CabangModel::find($id);

            if (!empty($cabang)) {
                // Update
                $cabang->nama_cabang = $nama_cabang;
                $cabang->save();
            } else {
                // New
                $cabang = CabangModel::create([
                    'nama_cabang' => $nama_cabang,
                ]);
            }

            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $cabang ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $cabang = CabangModel::find($id);
            if (empty($cabang)) {
                return response()->json(['error' => true, 'message' => 'Cabang tidak ditemukan'], 400); 
            }
            $cabang->delete();
            return response()->json(['error' => false, 'message' => null, 'data' => [] ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
}
