<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaketSppModel;
use DB;
use Constant;

class PaketSppController extends Controller
{
    public function get(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $paket_spp = PaketSppModel::find($id);
            return response()->json(['error' => false, 'message' => null, 'data' => $paket_spp ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function getAll(Request $request)
    {
        try {
            $type = !empty($request->get('type')) ? $request->get('type') : Constant::TYPE_KELAS_ABC;
            $paket_spp = PaketSppModel::query()
                ->with([
                    'layanan_kelas_detail',
                    'paket_kelas_detail'
                ])
                ->where('type', $type);
            if (!empty($request->get('cabang_id'))) {
                $paket_spp->where('cabang_id', $request->get('cabang_id'));
            } else {
                $paket_spp->where('cabang_id', null);
            }
            if (!empty($request->get('kelas'))) {
                $paket_spp->where('kelas', $request->get('kelas'));
            }
            if (!empty($request->get('semester'))) {
                if ($request->get('layanan_kelas_id') == 4) {
                    $paket_spp->where('semester_khusus', $request->get('semester'));
                } else {
                    $paket_spp->where('semester', $request->get('semester'));
                }
            }
            if (!empty($request->get('layanan_kelas_id'))) {
                $paket_spp->where('layanan_kelas_id', $request->get('layanan_kelas_id'));

            }
            if (!empty($request->get('paket_kelas_id'))) {
                $paket_spp->where('paket_kelas_id', $request->get('paket_kelas_id'));
            }
            if (!empty($request->get('jenis_pendaftaran'))) {
                $paket_spp->where('jenis_pendaftaran', $request->get('jenis_pendaftaran'));
            }
            return response()->json(['error' => false, 'message' => null, 'data' => $paket_spp->get() ], 200); 
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
            $paket_spp = PaketSppModel::find($id);
            if (empty($paket_spp)) {
                return response()->json(['error' => true, 'message' => 'Paket Kelas tidak ditemukan'], 400); 
            }
            $paket_spp->delete();
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
            $layanan_kelas_id = !empty($request->get('layanan_kelas_id')) ? $request->get('layanan_kelas_id') : null;
            $paket_kelas_id = !empty($request->get('paket_kelas_id')) ? $request->get('paket_kelas_id') : null;
            $type = !empty($request->get('type')) ? $request->get('type') : 0;
            $semester = !empty($request->get('semester')) ? $request->get('semester') : null;
            $semester_khusus = !empty($request->get('semester_khusus')) ? $request->get('semester_khusus') : null;
            $kelas = !empty($request->get('kelas')) ? $request->get('kelas') : null;
            $biaya = !empty($request->get('biaya')) ? $request->get('biaya') : 0;
            $biaya_program = !empty($request->get('biaya_program')) ? $request->get('biaya_program') : 0;
            $biaya_pendaftaran = !empty($request->get('biaya_pendaftaran')) ? $request->get('biaya_pendaftaran') : 0;
            $jenis_pendaftaran = !empty($request->get('jenis_pendaftaran')) ? $request->get('jenis_pendaftaran') : null;
            $keterangan = !empty($request->get('keterangan')) ? $request->get('keterangan') : null;
            $cabang_id = !empty($request->get('cabang_id')) ? $request->get('cabang_id') : null;
            $is_active = !empty($request->get('is_active')) ? filter_var($request->get('is_active'), FILTER_VALIDATE_BOOLEAN) : false;
            $biaya_kk = !empty($request->get('biaya_kk')) ? $request->get('biaya_kk') : null;
            $selected_kk = !empty($request->get('selected_kk')) ? $request->get('selected_kk') : null;
            $jumlah_smt_kk = !empty($request->get('jumlah_smt_kk')) ? $request->get('jumlah_smt_kk') : null;
            
            $paket_spp = PaketSppModel::find($id);
            $params = [
                'layanan_kelas_id' => $layanan_kelas_id,
                'paket_kelas_id' => $paket_kelas_id,
                'type' => $type,
                'semester' => $semester,
                'semester_khusus' => $semester_khusus,
                'biaya' => $biaya,
                'kelas' => $kelas,
                'biaya_program' => $biaya_program,
                'biaya_pendaftaran' => $biaya_pendaftaran,
                'jenis_pendaftaran' => $jenis_pendaftaran,
                'keterangan' => $keterangan,
                'cabang_id' => $cabang_id,
                'is_active' => $is_active,
                'biaya_kk' => $biaya_kk,
                'selected_kk' => json_encode($selected_kk),
                'jumlah_smt_kk' => $jumlah_smt_kk,
            ];

            if (!empty($paket_spp)) {
                // update
                $paket_spp->update($params);
            }else{
                // new
                $paket_spp = PaketSppModel::create($params);
            }
            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $paket_spp ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
}
