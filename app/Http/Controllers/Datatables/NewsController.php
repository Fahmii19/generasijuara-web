<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsModel;
use DataTables;
use DB;

class NewsController extends Controller
{
    private $select = '
        n.*
    ';

    private function getBaseModel()
    {
        $model = NewsModel::from('news as n')
            ->select(DB::raw($this->select));
            
        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();
        return DataTables::of($model)
            ->make(true);
    }
}
