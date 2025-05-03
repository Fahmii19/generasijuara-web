<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KelasModel;
use DataTables;
use DB;

class DistribusiMapelController extends Controller
{
    private $select = '
        d.*,
        u.name as tutor_name,
        mp.nama as mp_name
    ';

    private function getBaseModel()
    {
        $model = KelasModel::from('distribusi_mapel as d')
            ->select(DB::raw($this->select))
            ->leftJoin('tutor as t', 't.id', '=', 'd.tutor_id')
            ->leftJoin('users as u', 'u.id', '=', 't.user_id')
            ->leftJoin('mata_pelajaran as mp', 'mp.id', '=', 'd.mapel_id');
            
        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();

        $datatables = DataTables::of($model)
            ->filterColumn('kelas_num', function($query, $keyword) {
                $query->whereRaw("kelas_num like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('mp_name', function($query, $keyword) {
                $query->whereRaw("mp.nama like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('tutor_name', function($query, $keyword) {
                $query->whereRaw("u.name like ?", ["%{$keyword}%"]);
            })
            ->make(true);

        return $datatables;
    }
}
