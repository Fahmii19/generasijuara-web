<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use App\Models\TagihanModel;
use Illuminate\Http\Request;
use DataTables;

class PembayaranController extends Controller
{

    public function getBaseModel()
    {
        $model = TagihanModel::with('ppdb')->select('tagihan.*');

        return $model;
    }

    public function getAll(Request $request, $kelas_id = null)
    {
        $kelas_id = $kelas_id ?? $request->kelas_id;

        $model = $this->getBaseModel();

        if ($kelas_id != null) {
            $model = $model->whereHas('ppdb', function ($query) use ($kelas_id) {
                $query->where('ppdb.kelas_id', $kelas_id);
            });
        }

        if ($kelas_id != null) {
            $model = $model->where(function ($q) use ($kelas_id) {
                $q->whereHas('ppdb', function ($query) use ($kelas_id) {
                    $query->where('ppdb.kelas_id', $kelas_id);
                })->orWhereDoesntHave('ppdb');
            });
        }


        return DataTables::of($model)
            ->addIndexColumn()
            ->make(true);
    }
}
