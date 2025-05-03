<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahunAkademikModel;
use DataTables;
use DB;

class TahunAkademikController extends Controller
{
    private $select = '
        t.*
    ';

    private $valid_id_to_generate_rombel = null;

    private function getBaseModel()
    {
        $model = TahunAkademikModel::from('tahun_akademik as t')
            ->select(DB::raw($this->select));
            
        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();
        $this->valid_id_to_generate_rombel = TahunAkademikModel::select('id')
                                            ->where('id', '>', function($query){
                                                $query->select('id')->from('tahun_akademik')
                                                    ->where('is_active', '1');
                                            })
                                            ->where('is_generate_rombel', '0')
                                            ->orderBy('kode', 'ASC')
                                            ->first();

        // Jika yang aktif adalah data tahun akhir terakhir
        if (empty($this->valid_id_to_generate_rombel)) {
            $this->valid_id_to_generate_rombel = TahunAkademikModel::select('id')
                                                    ->where('is_generate_rombel', '0')
                                                    ->orderBy('kode', 'DESC')
                                                    ->first();
        }

        $datatables = DataTables::of($model)
            ->addColumn('is_valid_to_generate', function($model){
                $validIdToGenerate = $this->valid_id_to_generate_rombel->id ?? 0;
                if($model->id == $validIdToGenerate){
                    return true;
                }else{
                    return false;
                }
            })
            ->filterColumn('kode', function($query, $keyword) {
                $query->whereRaw("t.kode like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('tahun_ajar', function($query, $keyword) {
                $query->whereRaw("t.tahun_ajar like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('keterangan', function($query, $keyword) {
                $query->whereRaw("t.keterangan like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('periode_start', function($query, $keyword) {
                $query->whereRaw("t.periode_start like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('periode_end', function($query, $keyword) {
                $query->whereRaw("t.periode_end like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('tgl_raport', function($query, $keyword) {
                $query->whereRaw("t.tgl_raport like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('is_active', function($query, $keyword) {
                if(stristr('Aktif', $keyword)) {
                    $keyword = 1;
                } else if(stristr('Tidak Aktif', $keyword)) {
                    $keyword = 0;
                }

                $query->whereRaw("t.is_active like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('is_generate_rombel', function($query, $keyword) {
                if(stristr('Sudah', $keyword)) {
                    $keyword = 1;
                } else if(stristr('Belum', $keyword)) {
                    $keyword = 0;
                }

                $query->whereRaw("t.is_generate_rombel like ?", ["%{$keyword}%"]);
            })
            ->make(true);

        return $datatables;
    }
}
