<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SialumController extends Controller
{
    public function add(Request $request)
    {
        return view('alumni.add');
    }
}
