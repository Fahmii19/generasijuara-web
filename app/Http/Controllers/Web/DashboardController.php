<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PpdbModel;
use Illuminate\Http\Request;
use SnappyPDF;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->get('apps') == 'siab') {
            return redirect()->route('web.siab.home');
        }
        if ($request->session()->get('apps') == 'su') {
            return redirect()->route('web.su.home');
        }
        if ($request->session()->get('apps') == 'situ') {
            return redirect()->route('web.situ.home');
        }
        return view('index');
    }

    public function dashboard(Request $request)
    {
        return view('admin.index');
        // return view('siswa.index');
    }

    public function forgotPassword()
    {
        return view('auth.passwords.email');
    }

    public function forgotPasswordSiab()
    {
        return view('auth.passwords.custom.siab-email');
    }

    public function resetPasswordSiab($token)
    {
        $ppdb = PpdbModel::where('nis', request()->nis)->first();
        return view('auth.passwords.custom.siab-reset', [
            'token' => $token,
            'nis' => request()->nis,
            'email' => $ppdb->email,
        ]);
    }
}
