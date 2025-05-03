<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DimensiModel;
use App\Models\ElemenModel;
use App\Models\PointModel;
use App\Models\NilaiPointModel;
use App\Models\CatatanProsesWBModel;
use Illuminate\Support\Facades\DB;

class CapaianDimensiController extends Controller
{
    public function saveOrUpdate(Request $request)
    {   
        $params = $request->all();
        
        DB::beginTransaction();
        try {
            if(isset($params['id'])) {
                $point = PointModel::find($params['id']);
                if(!$point) {
                    throw new \Exception("Point not found with ID: " . $params['id']);
                }
    
                $point->update([
                    'elemen_id' => $params['elemen_id'],
                    'point_name' => $params['point_name'],
                    'fase' => $params['fase']
                ]);
            } else {
                $point = PointModel::create([
                    'elemen_id' => $params['elemen_id'],
                    'point_name' => $params['point_name'],
                    'fase' => $params['fase']
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'line' => $e->getLine()], 400); 
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'line' => $e->getLine()], 400); 
        }
    }

    public function saveOrUpdateNilaiWB(Request $request)
    {
        $params = $request->all();
        $point_id = $params['point_id'];
        $kelas_wb_id = $params['kelas_wb_id'];
        $point_nilai = $params['point_nilai'];
        
        DB::beginTransaction();

        $nilaiPoint = NilaiPointModel::where('kelas_wb_id', $kelas_wb_id)
                                ->where('point_id', $point_id)
                                ->first();
        try {
            if ($nilaiPoint) {
                $nilaiPoint->point_nilai = $point_nilai;
                $nilaiPoint->save();
            } else {
                $nilaiPoint = NilaiPointModel::create([
                    'kelas_wb_id' => $kelas_wb_id,
                    'point_id' => $point_id,
                    'point_nilai' => $point_nilai
                ]);
            }
            // dd($nilaiPoint);
            $data = NilaiPointModel::where('kelas_wb_id', $kelas_wb_id)
                        ->where('point_id', $point_id)
                        ->first();

            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'line' => $e->getLine()], 400); 
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'line' => $e->getLine()], 400); 
        }
    }

    public function saveOrUpdateCatatanProses(Request $request)
    {
        $params = $request->all();
        $dimensi_id = $params['dimensi_id'];
        $kelas_wb_id = $params['kelas_wb_id'];
        $catatan_proses = $params['catatan_proses'];
        
        DB::beginTransaction();

        $catatanProses = CatatanProsesWBModel::where('kelas_wb_id', $kelas_wb_id)
                                ->where('dimensi_id', $dimensi_id)
                                ->first();
        try {
            if ($catatanProses) {
                $catatanProses->catatan_proses = $catatan_proses;
                $catatanProses->save();
            } else {
                $catatanProses = CatatanProsesWBModel::create([
                    'kelas_wb_id' => $kelas_wb_id,
                    'dimensi_id' => $dimensi_id,
                    'catatan_proses' => $catatan_proses
                ]);
            }
            // dd($nilaiPoint);
            $data = CatatanProsesWBModel::where('kelas_wb_id', $kelas_wb_id)
                        ->where('dimensi_id', $dimensi_id)
                        ->first();
            
            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'line' => $e->getLine()], 400); 
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'line' => $e->getLine()], 400); 
        }
    }

    public function getDimensi(Request $request)
    {
        try {
            $dimensi = DimensiModel::all();
            $elemen = ElemenModel::all();
            $data = [
                'dimensi' => $dimensi,
            ];

            return response()->json(['error' => false, 'message' => null, 'data' => $data], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'line' => $e->getLine()], 400); 
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'line' => $e->getLine()], 400); 
        }
    }

    public function getElemen(Request $request)
    {
        try {
            $elemen = ElemenModel::where('dimensi_id', $request->get('dimensi_id'))->get();
            $data = [
                'elemen' => $elemen,
            ];

            return response()->json(['error' => false, 'message' => null, 'data' => $data], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'line' => $e->getLine()], 400); 
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'line' => $e->getLine()], 400); 
        }
    }

    public function getPoint(Request $request)
    {
        try {
            $point = PointModel::find($request->get('id'));
            $elemen = ElemenModel::find($point->elemen_id);
            $dimensi = DimensiModel::find($elemen->dimensi_id);
            $fase = $point->fase;

            $data = [
                'dimensi' => $dimensi,
                'elemen' => $elemen,
                'point' => $point,
                'fase' => $fase,
            ];

            return response()->json(['error' => false, 'message' => null, 'data' => $data], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'line' => $e->getLine()], 400); 
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'line' => $e->getLine()], 400); 
        }
    }

    public function delete(Request $request)
    {
        try {
            $point = PointModel::find($request->get('id'));
            $point->delete();

            return response()->json(['error' => false, 'message' => null, 'data' => null], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'line' => $e->getLine()], 400); 
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'line' => $e->getLine()], 400); 
        }
    }
}
