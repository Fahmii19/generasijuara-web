<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\KelasMataPelajaranModel;
use App\Models\KelasModel;
use App\Models\PerkembanganModel;
use App\Models\PpdbModel;
use Illuminate\Http\Request;

class PerkembanganController extends Controller
{
    public function getInfo(Request $request)
    {
        $data_ppdb = PpdbModel::select('nis','nama')
            ->where('id', $request->ppdb_id)
            ->first();
        $data_kelas = KelasModel::select('nama')
            ->where('id', $request->kelas_id)
            ->first();
        $data_kmp = KelasMataPelajaranModel::with('mata_pelajaran_detail')
            ->select('mata_pelajaran_id')
            ->where('id', $request->kmp_id)
            ->first();

        return response()->json([
            'error' => false,
            'message' => null,
            'data' => [
                'ppdb' => $data_ppdb,
                'kelas' => $data_kelas,
                'kmp' => $data_kmp
            ]
        ], 200); 
    }

    public function getData(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $data = PerkembanganModel::query();

            if (!empty($id)) {
                $data = PerkembanganModel::find($request->id);
            } else {
                $data = $data->get();
            }

            return response()->json(['error' => false, 'message' => null, 'data' => $data ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
    
    public function save(Request $request)
    {
        $id = !empty($request->id) ? $request->id : null;
        $data = null;

        if (!empty($id)) {
            $data = PerkembanganModel::where('id', $id)->first();
            $data->laporan = $request->laporan;
        } else {
            $data = new PerkembanganModel();
            $data->ppdb_id = $request->ppdb_id;
            $data->kelas_id = $request->kelas_id;
            $data->kmp_id = $request->kmp_id;
            $data->laporan = $request->laporan;
        }

        $data->save();
    }

    public function delete(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $data = PerkembanganModel::find($id);
            if (empty($data)) {
                return response()->json(['error' => true, 'message' => 'Data tidak ditemukan'], 400); 
            } else {
                $data->delete();
                return response()->json(['error' => false, 'message' => 'Berhasil dihapus', 'data' => [] ], 200); 
            }
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
}
