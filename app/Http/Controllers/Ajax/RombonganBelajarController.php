<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\KelasWbModel;
use App\Models\RombelModel;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class RombonganBelajarController extends Controller
{
    public function get(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $rombel = RombelModel::with(['kelas', 'tahun_akademik', 'ppdb'])->find($id);
            return response()->json(['error' => false, 'message' => null, 'data' => $rombel ], 200); 
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
            $keterangan = !empty($request->get('keterangan')) ? $request->get('keterangan') : null;
            $kelas = !empty($request->get('kelas')) ? $request->get('kelas') : null;
            $is_active = !empty($request->get('is_active')) ? filter_var($request->get('is_active'), FILTER_VALIDATE_BOOLEAN) : false;
            
            $rombel = RombelModel::find($id);
            if (!empty($rombel)) {
                $rombel->keterangan = $keterangan;
                $rombel->is_active = $is_active;
                
                // Jika kelas diubah
                if ($rombel->kelas_id != $kelas) {
                    // Menghapus data lama pada kelas_wb
                    KelasWbModel::where('wb_id', $rombel->ppdb_id)
                                ->where('kelas_id', $rombel->kelas_id)
                                ->delete();

                    // Cek apakah data baru sudah ada di kelas_wb
                    $kelas_wb_check = KelasWbModel::where('wb_id', $rombel->ppdb_id)
                                ->where('kelas_id', $kelas)
                                ->first();

                    if (empty($kelas_wb_check)) {
                        // Menambah data baru pada kelas_wb
                        $kelas_wb = new KelasWbModel();
                        $kelas_wb->kelas_id = $kelas;
                        $kelas_wb->wb_id = $rombel->ppdb_id;
                        $kelas_wb->save();
    
                        // Mengubah kelas_id pada rombel
                        $rombel->kelas_id = $kelas;
                    } else {
                        // Mengubah kelas_id pada rombel
                        $rombel->kelas_id = $kelas;

                        // Mengubah status is_active pada kelas_wb
                        $kelas_wb_check->is_active = true;
                        $kelas_wb_check->save();
                    }
                }

                if (!$is_active && !empty($keterangan)) {
                    $rombel_kelas_id_temp = $rombel->kelas_id;
                    $rombel->kelas_id = null;

                    /**
                     * Seharusnya data WB terkait tidak dihapus dari kelas_wb
                     * diganti dengan mengubah status is_active menjadi false
                     */
                    // KelasWbModel::where('wb_id', $rombel->ppdb_id)->delete();
                    $kelasWB = KelasWbModel::where('wb_id', $rombel->ppdb_id)
                        ->where('kelas_id', $rombel_kelas_id_temp)
                        ->first();
                    $kelasWB->is_active = false;
                    $kelasWB->save();
                }
                $rombel->save();
            }
            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $rombel ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'trace' => $e->getTrace()], 400); 
        }catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'trace' => $e->getTrace()], 400); 
        }
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            $rombel = RombelModel::find($request->id);
            if (empty($rombel)) {
                throw new \Exception("Data rombel tidak ditemukan");
            }

            $kelas_wb = KelasWbModel::where('wb_id', $rombel->ppdb_id)
                            ->where('kelas_id', $rombel->kelas_id)
                            ->first();
                    
            if (!empty($kelas_wb)) {
                $kelas_wb->delete();
            }

            $rombel->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'trace' => $e->getTrace()], 500);
        }
    }
}
