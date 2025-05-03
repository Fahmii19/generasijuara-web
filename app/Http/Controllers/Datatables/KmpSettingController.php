<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KmpSettingModel;
use DataTables;
use DB;

class KmpSettingController extends Controller
{
    private $select = '
        kmps.*
    ';

    private function getBaseModel()
    {
        $model = KmpSettingModel::from('kmp_setting as kmps')
            ->select(DB::raw($this->select))
            ;
            
        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();
        if ($request->has('kmp_id')) {
           $model = $model->where('kmps.kmp_id', $request->kmp_id);
        }
        return DataTables::of($model)
            ->make(true);
    }
}
