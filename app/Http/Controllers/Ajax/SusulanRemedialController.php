<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\NilaiModel;
use Illuminate\Http\Request;

class SusulanRemedialController extends Controller
{
    public function getData(Request $request)
    {
        $nilai = NilaiModel::with(
            'kelas:id,nama',
            'kmp.mata_pelajaran_detail:id,nama',
            'wb:id,nama','kmp:id,mata_pelajaran_id',
        );

        $nilai->select('kelas_id','kmp_id','wb_id','susulan_remedial')
            ->where('susulan_remedial', '!=', '');

        if (!empty($request->kelas_id)) {
            $nilai->where('kelas_id', $request->kelas_id);
        }
        if (!empty($request->kmp_id)) {
            $nilai->where('kmp_id', $request->kmp_id);
        }
        if (!empty($request->tutor_id)) {
            $nilai->whereHas('kmp', function ($query) use ($request) {
                $query->where('tutor_id', $request->tutor_id);
            });
        }
        if (!empty($request->tahun_akademik_id)) {
            $nilai->whereHas('kelas', function ($query) use ($request) {
                $query->where('tahun_akademik_id', $request->tahun_akademik_id);
            });
        }
        
        $nilai = $nilai->get();
        
        $nilai->map(function ($item) {
            $item->susulan_remedial = json_decode($item->susulan_remedial);
        });

        $susulan_remedial = [];
        foreach ($nilai as $key => $value) {
            $susulan_remedial_temp = [];
            $susulan_remedial_temp['nama'] = $value->wb->nama ?? '';
            $susulan_remedial_temp['kelas'] = $value->kelas->nama ?? '';
            $susulan_remedial_temp['mp'] = $value->kmp->mata_pelajaran_detail->nama ?? '';

            foreach ($value->susulan_remedial as $key2 => $value2) { // key = susulan | remedial
                $susulan_remedial_temp[$key2] = [];

                foreach ($value2 as $key3 => $value3) { // key = p_ | k_
                    if (empty($value3)) continue;

                    $susulan_remedial_temp[$key2][$key3] = $value3;
                }
            }

            $susulan_remedial[] = $susulan_remedial_temp;
        }

        foreach ($susulan_remedial as $key => $value) {
            if (empty($value['susulan']) && empty($value['remedial'])) {
                unset($susulan_remedial[$key]);
            }
        }

        return response()->json($susulan_remedial);
    }
}
