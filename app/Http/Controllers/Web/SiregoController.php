<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiregoController extends Controller
{
    public function home(Request $request)
    {
        if(session()->get('apps') != 'sirego') return redirect()->route('web.index');
        return view('admin.index');
    }

    public function userList(Request $request)
    {
        return view('admin.user.list');
    }
}
