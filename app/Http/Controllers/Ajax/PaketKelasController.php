<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaketKelasModel;
use DB;

class PaketKelasController extends Controller
{
    public function get(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $layanan = PaketKelasModel::find($id);
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
            $type = !empty($request->get('type')) ? $request->get('type') : 0;
            $layanan = PaketKelasModel::where('type', $type)->get();
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
            $paket_kelas = PaketKelasModel::find($id);
            if (empty($paket_kelas)) {
                return response()->json(['error' => true, 'message' => 'Paket Kelas tidak ditemukan'], 400); 
            }
            $paket_kelas->delete();
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
            $type = !empty($request->get('type')) ? $request->get('type') : 0;
            $is_active = !empty($request->get('is_active')) ? filter_var($request->get('is_active'), FILTER_VALIDATE_BOOLEAN) : false;
            
            $paket_kelas = PaketKelasModel::find($id);
            if (!empty($paket_kelas)) {
                // update
                $paket_kelas->nama = $nama;
                $paket_kelas->kode = $kode;
                $paket_kelas->type = $type;
                $paket_kelas->is_active = $is_active;
                $paket_kelas->save();
            }else{
                // new
                $paket_kelas = PaketKelasModel::create([
                    'nama' => $nama,
                    'kode' => $kode,
                    'type' => $type,
                    'is_active' => $is_active,
                ]);
            }
            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $paket_kelas ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
}
