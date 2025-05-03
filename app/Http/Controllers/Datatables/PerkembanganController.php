<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use App\Models\PerkembanganModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PerkembanganController extends Controller
{
    public function getBaseModel()
    {
        $model = PerkembanganModel::with(['ppdb','kelas','kmp.mata_pelajaran_detail'])->select('perkembangan.*');
        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();
        if ($request->has('ppdb_id') && $request->ppdb_id != null) {
            $model = $model->where('perkembangan.ppdb_id', $request->ppdb_id);
        }
        if ($request->has('kelas_id') && $request->kelas_id != null) {
            $model = $model->where('perkembangan.kelas_id', $request->kelas_id);
        }
        if ($request->has('kmp_id') && $request->kmp_id != null) {
            $model = $model->where('perkembangan.kmp_id', $request->kmp_id);
        }
        return DataTables::of($model)
            ->addIndexColumn()
            ->make(true);
    }
}
