<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LayananKelasModel;
use DB;

class LayananKelasController extends Controller
{
    public function get(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $layanan = LayananKelasModel::find($id);
            return response()->json(['error' => false, 'message' => null, 'data' => $layanan ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
    public function getAll(Request $request)
    {
        try {
            $layanan = LayananKelasModel::get();
            return response()->json(['error' => false, 'message' => null, 'data' => $layanan ], 200); 
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
            $layanan_kelas = LayananKelasModel::find($id);
            if (empty($layanan_kelas)) {
                return response()->json(['error' => true, 'message' => 'Layanan Kelas tidak ditemukan'], 400); 
            }
            $layanan_kelas->delete();
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
            $nama = !empty($request->get('nama')) ? $request->get('nama') : null;
            $kode = !empty($request->get('kode')) ? $request->get('kode') : null;
            $is_active = !empty($request->get('is_active')) ? filter_var($request->get('is_active'), FILTER_VALIDATE_BOOLEAN) : false;
            
            $layanan_kelas = LayananKelasModel::find($id);
            if (!empty($layanan_kelas)) {
                // update
                $layanan_kelas->nama = $nama;
                $layanan_kelas->kode = $kode;
                $layanan_kelas->is_active = $is_active;
                $layanan_kelas->save();
            }else{
                // new
                $layanan_kelas = LayananKelasModel::create([
                    'nama' => $nama,
                    'kode' => $kode,
                    'is_active' => $is_active,
                ]);
            }
            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $layanan_kelas ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
}
