<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KelasMataPelajaranModel;
use DataTables;
use DB;


class KelasMataPelajaranController extends Controller
{
    private $select = '
        kmp.*,
        mp.nama as mp_nama,
        mp.kelompok as mp_kelompok,
        k.nama as k_nama,
        k.kode as k_kode,
        ut.name as t_nama
    ';

    private function getBaseModel()
    {
        $model = KelasMataPelajaranModel::from('kelas_mata_pelajaran as kmp')
            ->select(DB::raw($this->select))
            ->leftJoin('kelas as k', 'k.id', '=', 'kmp.kelas_id')
            ->leftJoin('mata_pelajaran as mp', 'mp.id', '=', 'kmp.mata_pelajaran_id')
            ->leftJoin('tutor as t', 't.id', '=', 'kmp.tutor_id')
            ->leftJoin('users as ut', 'ut.id', '=', 't.user_id')
            ;
            
        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();
        if ($request->has('kelas_id')) {
           $model = $model->where('kmp.kelas_id', $request->kelas_id);
        }
        return DataTables::of($model)
            ->make(true);
    }
}
