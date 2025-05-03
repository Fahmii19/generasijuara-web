<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoucherModel;
use DataTables;
use DB;


class VoucherController extends Controller
{
    private $select = '
        voucher.*
    ';

    private function getBaseModel()
    {
        $model = VoucherModel::from('voucher')
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
