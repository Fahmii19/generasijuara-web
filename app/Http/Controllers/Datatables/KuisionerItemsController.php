<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use App\Models\KuisionerItemsModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KuisionerItemsController extends Controller
{
    public function getAll(Request $request)
    {
        $data = KuisionerItemsModel::with(['kuisioner'])
                    ->selectRaw('id, no_urut, item, input_type, input_value, input_label');

        if ($request->has('kuisioner_id') && $request->kuisioner_id != null) {
            $data = $data->where('kuisioner_id', $request->kuisioner_id);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
