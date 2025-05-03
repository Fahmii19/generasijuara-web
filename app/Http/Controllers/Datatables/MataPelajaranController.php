<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataPelajaranModel;
use DataTables;
use DB;

class MataPelajaranController extends Controller
{
    private $select = '
        mp.*
    ';

    private function getBaseModel()
    {
        $model = MataPelajaranModel::from('mata_pelajaran as mp')
            ->select(DB::raw($this->select));
            
        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();
        // if ($request->has('type')) {
        //    $model = $model->where('ps.type', $request->type);
        // }

        $datatables = DataTables::of($model)
            ->filterColumn('nama', function($query, $keyword) {
                $query->whereRaw("mp.nama like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('kelompok', function($query, $keyword) {
                $query->whereRaw("mp.kelompok like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('sub_kelompok', function($query, $keyword) {
                $query->whereRaw("mp.sub_kelompok like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('is_active', function($query, $keyword) {
                if(stristr('Aktif', $keyword)) {
                    $keyword = 1;
                } else if(stristr('Tidak Aktif', $keyword)) {
                    $keyword = 0;
                }

                $query->whereRaw("mp.is_active like ?", ["%{$keyword}%"]);
            })
            ->make(true);

        return $datatables;
    }
}
