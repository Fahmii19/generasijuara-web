<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PpdbModel;
use App\Models\TagihanModel;
use App\Utils\Constant;
use Illuminate\Http\Request;

class WBController extends Controller
{
    public function edit(Request $request, $id)
    {
        $data_ppdb = PpdbModel::where('id', $id)->first();
        $data = [
            'id' => $id,
            'data_ppdb' => $data_ppdb,
        ];
        return view('admin.wb.abc.edit', $data);
    }
}
