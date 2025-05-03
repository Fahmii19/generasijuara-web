<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Imports\DistribusiMapelImport;
use App\Models\DistribusiMapelModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DistribusiMapelController extends Controller
{
    public function importExcel(Request $request)
    {
        if ($request->hasFile('import_file')) {
            Excel::import(new DistribusiMapelImport(1), $request->file('import_file'));
        }
        return response()->json([], 200); 
    }
}
