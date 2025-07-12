<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AlumniModel;
use DataTables;
use DB;

class AlumniController extends Controller
{
    private function getBaseModel()
    {
        $model = AlumniModel::select([
            'alumni.id',
            'nama',
            'nis',
            'no_hp',
            'tahun_akademik.keterangan as tahun_akademik_ket',
            'lanjut_kuliah'
        ])->join('tahun_akademik', 'alumni.tahun_akademik_id', '=', 'tahun_akademik.id');

        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();
        return DataTables::of($model)
            ->make(true);
    }
}
