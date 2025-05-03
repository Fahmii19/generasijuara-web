<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function getBaseModel()
    {
        $model = User::with('roles')->get();
        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();
        // dd($model);
        return DataTables::of($model)
            ->addIndexColumn()
            ->addColumn('role_name', function ($model) {
                return implode(', ', $model->roles->pluck('role_name')->toArray());
            })
            ->rawColumns(['role_name'])
            ->make(true);
    }
}
