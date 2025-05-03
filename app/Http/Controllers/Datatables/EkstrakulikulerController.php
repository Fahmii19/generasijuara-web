<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EkstrakurikulerModel;
use DataTables;
use DB;

class EkstrakulikulerController extends Controller
{
    private $select = '
        e.*
    ';

    private function getBaseModel()
    {
        $model = EkstrakurikulerModel::from('ekstrakurikuler as e')
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
