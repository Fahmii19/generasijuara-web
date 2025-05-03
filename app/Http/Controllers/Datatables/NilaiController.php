<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KelasWbModel;
use App\Models\PpdbModel;
use App\Models\KelasMataPelajaranModel;
use DataTables;
use DB;

class NilaiController extends Controller
{
    private $select = '
        kelas_wb.*, 
        p.nama, 
        n.kmp_id,
        n.p_tugas_1,
        n.p_ujian_1,
        n.p_nilai_1,
        n.p_predikat_1,
        n.k_nilai_1,
        n.k_predikat_1,
        n.p_tugas_2,
        n.p_ujian_2,
        n.p_nilai_2,
        n.p_predikat_2,
        n.k_nilai_2,
        n.k_predikat_2,
        n.p_tugas_3,
        n.p_ujian_3,
        n.p_nilai_3,
        n.p_predikat_3,
        n.k_nilai_3,
        n.k_predikat_3,
        n.sikap_spiritual,
        n.sikap_spiritual_desc,
        n.sikap_sosial,
        n.sikap_sosial_desc
    ';

    private function getBaseModel($kmp_id)
    {
        $model = KelasWbModel::from('kelas_wb')
            ->select(DB::raw($this->select))
            ->leftJoin('nilai as n', function($join) use ($kmp_id){
                $join->on('n.kelas_id', '=', 'kelas_wb.kelas_id');
                $join->on('n.wb_id', '=', 'kelas_wb.wb_id');
                $join->where('n.kmp_id', '=', $kmp_id);
            })
            ->leftJoin('ppdb as p', 'p.id', '=', 'kelas_wb.wb_id')
            ;
            
        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel($request->kmp_id);
        if ($request->has('kelas_id')) {
           $model = $model->where('kelas_wb.kelas_id', $request->kelas_id);
        }

        return DataTables::of($model)
            ->make(true);
    }

    public function getByWB(Request $request)
    {
        $ppdb = PpdbModel::where('user_id', $request->user_id_wb)->first();
        $model = KelasMataPelajaranModel::from('kelas_mata_pelajaran as kmp')
            ->select(DB::raw('kmp.*, n.*, mp.nama as mp_nama'))
            ->leftJoin('mata_pelajaran as mp', 'mp.id', '=', 'kmp.mata_pelajaran_id')
            ->leftJoin('nilai as n', function($join) use($ppdb){
                $join->on('n.kelas_id', '=', 'kmp.kelas_id');
                $join->on('n.kmp_id', '=', 'kmp.id');
                $join->where('n.wb_id', '=', $ppdb->id);
            });
        // $model = $model->where('n.wb_id', $ppdb->id);
        if ($request->has('kelas_id')) {
           $model = $model->where('kmp.kelas_id', $request->kelas_id);
        }

        return DataTables::of($model)
            ->make(true);
    }
}
