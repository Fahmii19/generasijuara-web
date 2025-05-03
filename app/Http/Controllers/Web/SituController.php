<?php

namespace App\Http\Controllers\Web;

use App\Exports\NilaiExport;
use App\Exports\SusulanRemedialExport;
use App\Http\Controllers\Controller;
use App\Models\KelasModel;
use App\Models\TutorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SituController extends Controller
{
    public function home(Request $request)
    {
        return view('admin.index');
    }

    public function nilaiList(Request $request)
    {
        return view('tutor.nilai.list');
    }

    public function perkembanganList(Request $request)
    {
        return view('admin.perkembangan.list');
    }

    public function nilaiExportExcel(Request $request)
    {
        $userAuth = auth()->user();
        $tutor = TutorModel::where('user_id', $userAuth->id)->first();

        $kelasId = !empty($request->kelas_id) ? $request->kelas_id : null;
        $kelas = KelasModel::find($kelasId);
        
        if (empty($kelas)) {
            return back()->with('message', 'Kelas tidak ditemukan');
        }

        if (empty($tutor)) {
            return back()->with('message', 'Tutor tidak ditemukan');
        }

        return Excel::download(new NilaiExport($kelas, $tutor->id), 'Nilai - '.$kelas->nama.'.xlsx');
    }

    public function jadwalPelajaranList(Request $request)
    {
        return view('tutor.jadwal_pelajaran.list');
    }

    public function susulanRemedialList()
    {
        $user_id = Auth::user()->id;
        $tutor_id = TutorModel::where('user_id', $user_id)->first()->id;

        $data = [
            'tutor_id' => $tutor_id
        ];

        return view('tutor.susulan_remedial.list', $data);
    }

    public function susulanRemedialExport(Request $request)
    {
        $kelas_id = $request->kelas_id ?? null;
        $kmp_id = $request->kmp_id ?? null;
        $tutor_id = $request->tutor_id ?? null;
        $tahun_akademik_id = $request->tahun_akademik_id ?? null;

        $data = [
            'kelas_id' => $kelas_id,
            'kmp_id' => $kmp_id,
            'tutor_id' => $tutor_id,
            'tahun_akademik_id' => $tahun_akademik_id,
        ];

        return Excel::download(
            new SusulanRemedialExport($data),
            'Susulan Remedial_'.time().'.xlsx'
        );
    }
}
