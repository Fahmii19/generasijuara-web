<?php

namespace App\Http\Controllers\Ajax;

use App\Exports\LedgerExport;
use App\Http\Controllers\Controller;
use App\Models\KelasWbModel;
use App\Models\NilaiModel;
use App\Models\TahunAkademikModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LedgerController extends Controller
{
    public function exportExcel(Request $request)
    {

        // $nilai = NilaiModel::from('nilai as n')
        //     ->selectRaw('k.id as k_id, k.kelas , k.semester, mp.id as mp_id, n.* ')
        //     ->leftJoin('kelas as k', 'k.id', '=', 'n.kelas_id')
        //     ->leftJoin('kelas_mata_pelajaran as kmp', 'kmp.id', '=', 'n.kmp_id')
        //     ->leftJoin('mata_pelajaran as mp', 'mp.id', '=', 'kmp.mata_pelajaran_id')
        //     ->where('n.wb_id', 1012)
        //     ->get();
        // // dd($nilai->toArray());

        // $nilaiArr = [];
        // foreach ($nilai as $key => $n) {
        //     // dd($n->kelas);
        //     $nilaiArr[$n->kelas][$n->mp_id][$n->semester] =
        //         [
        //             'p1' => $n->p_nilai_1,
        //             'p2' => $n->p_nilai_2,
        //             'p3' => $n->p_nilai_3,
        //             'k1' => $n->k_nilai_1,
        //             'k2' => $n->k_nilai_2,
        //             'k3' => $n->k_nilai_3,
        //         ];
        // }
        // dd($nilaiArr);

        $file_name = "Semua";
        $date = Carbon::now();

        $tahun_akademik_id = !empty($request->tahun_akademik_id) ? $request->tahun_akademik_id : null;
        $kelas_num = !empty($request->kelas_num) ? $request->kelas_num : null;

        $tahunAkademik = TahunAkademikModel::find($tahun_akademik_id);
        $tahunAjar = str_replace('/', '_', $tahunAkademik->tahun_ajar);

        return Excel::download(new LedgerExport($tahun_akademik_id, $kelas_num), 'Ledger - Kelas ' . $kelas_num . ' - ' . $tahunAjar . ' [' . $date->format('d M Y') . '].xlsx');
    }
}
