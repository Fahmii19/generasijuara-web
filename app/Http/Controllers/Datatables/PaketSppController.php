<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaketSppModel;
use DataTables;
use DB;

class PaketSppController extends Controller
{
    private $select = '
        ps.*,
        lk.nama as lk_nama,
        lk.kode as lk_kode,
        pk.nama as pk_nama,
        pk.kode as pk_kode,
        cb.nama_cabang as cb_nama
    ';

    private function getBaseModel()
    {
        $model = PaketSppModel::from('paket_spp as ps')
            ->select(DB::raw($this->select))
            ->leftJoin('layanan_kelas as lk', 'lk.id', '=', 'ps.layanan_kelas_id')
            ->leftJoin('paket_kelas as pk', 'pk.id', '=', 'ps.paket_kelas_id')
            ->leftJoin('cabang as cb', 'cb.id', '=', 'ps.cabang_id');
            
        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();
        if ($request->has('type')) {
           $model = $model->where('ps.type', $request->type);
        }

        $datatables = DataTables::of($model)
            ->filterColumn('cb_nama', function($query, $keyword) {
                $query->whereRaw("LOWER(cb.nama_cabang) LIKE ?", ["%{$keyword}%"]);
            })
            ->filterColumn('lk_kode', function($query, $keyword) {
                $query->whereRaw("LOWER(lk.kode) LIKE ?", ["%{$keyword}%"]);
            })
            ->filterColumn('pk_kode', function($query, $keyword) {
                $query->whereRaw("LOWER(pk.kode) LIKE ?", ["%{$keyword}%"]);
            })
            ->filterColumn('kelas', function($query, $keyword) {
                $query->whereRaw("LOWER(ps.kelas) LIKE ?", ["%{$keyword}%"]);
            })
            ->filterColumn('semester', function($query, $keyword) {
                $query->whereRaw("LOWER(ps.semester) LIKE ?", ["%{$keyword}%"]);
            })
            ->filterColumn('semester_khusus', function($query, $keyword) {
                $query->whereRaw("LOWER(ps.semester_khusus) LIKE ?", ["%{$keyword}%"]);
            })
            ->filterColumn('biaya', function($query, $keyword) {
                $query->whereRaw("LOWER(ps.biaya) LIKE ?", ["%{$keyword}%"]);
            })
            ->filterColumn('biaya_pendaftaran', function($query, $keyword) {
                $query->whereRaw("LOWER(ps.biaya_pendaftaran) LIKE ?", ["%{$keyword}%"]);
            })
            ->filterColumn('jenis_pendaftaran', function($query, $keyword) {
                if (stristr('Baru', $keyword)) {
                    $keyword = 1;
                } else if (stristr('Ulang', $keyword)) {
                    $keyword = 2;
                }

                $query->whereRaw("LOWER(ps.jenis_pendaftaran) LIKE ?", ["%{$keyword}%"]);
            })
            ->filterColumn('keterangan', function($query, $keyword) {
                $query->whereRaw("LOWER(ps.keterangan) LIKE ?", ["%{$keyword}%"]);
            })
            ->filterColumn('type', function($query, $keyword) {
                if (stristr('ABC', $keyword)) {
                    $keyword = 0;
                } else if (stristr('PAUD', $keyword)) {
                    $keyword = 1;
                }

                $query->whereRaw("LOWER(ps.type) LIKE ?", ["%{$keyword}%"]);
            })
            ->filterColumn('is_active', function($query, $keyword) {
                if(stristr('Aktif', $keyword)) {
                    $keyword = 1;
                } else if(stristr('Tidak Aktif', $keyword)) {
                    $keyword = 0;
                }

                $query->whereRaw("LOWER(ps.is_active) LIKE ?", ["%{$keyword}%"]);
            })
            ->make(true);

        return $datatables;
    }
}
