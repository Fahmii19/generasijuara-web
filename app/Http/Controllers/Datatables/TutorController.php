<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TutorModel;
use DataTables;
use DB;

class TutorController extends Controller
{
    private $select = '
        tutor.*,
        u.name,
        u.username,
        u.email,
        u.phone,
        u.is_active
    ';

    private function getBaseModel()
    {
        $model = TutorModel::from('tutor')
            ->select(DB::raw($this->select))
            ->leftJoin('users as u', 'u.id', '=', 'tutor.user_id');
            
        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();
        return DataTables::of($model)
            ->make(true);
    }
}
