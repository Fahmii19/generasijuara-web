<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Constant;

class PpdbController extends Controller
{
    public function home(Request $request)
    {
        return view('ppdb.index');
    }

    public function abc(Request $request)
    {
        $data = [
            'type' => Constant::TYPE_KELAS_ABC,
        ];
        return view('ppdb.abc', $data);
    }
    
    public function paud(Request $request)
    {
        $data = [
            'type' => Constant::TYPE_KELAS_PAUD,
        ];
        return view('ppdb.paud', $data);
    }
}
