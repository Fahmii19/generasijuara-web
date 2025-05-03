<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingsModel;
use DataTables;
use DB;

class SettingsController extends Controller
{
    private $select = '
        s.*
    ';

    private function getBaseModel()
    {
        $model = SettingsModel::from('settings as s')
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
