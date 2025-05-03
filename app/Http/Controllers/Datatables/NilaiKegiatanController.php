<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NilaiKegiatanModel;
use DataTables;
use DB;

class NilaiKegiatanController extends Controller
{
    private $select = '
        n.*
    ';

    private function getBaseModel()
    {
        $model = NilaiKegiatanModel::from('nilai_kegiatan as n')
            ->select(DB::raw($this->select))
            ;
            
        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();

        if (!empty($request->kwb_id)) {
            $model->where('kwb_id', $request->kwb_id);
        }
        return DataTables::of($model)
            ->make(true);
    }
}
