<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Alumni\CreateRequest;
use App\Http\Requests\Alumni\UpdateRequest;
use App\Models\AlumniModel;
use App\Imports\AlumniImport;
use DB;
use Excel;

class AlumniController extends Controller
{
    public function importAlumniExcel(Request $request)
    {
        try {
            if ($request->hasFile('import_file_alumni')) {
                Excel::import(new AlumniImport(), $request->file('import_file_alumni'));
            }
            return response()->json([], 200); 
        } catch(\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function create(CreateRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $alumni = AlumniModel::create($params);
            DB::commit();

            return response()->json(['error' => false, 'message' => null, 'data' => $alumni], 200);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function update(UpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $alumni = AlumniModel::findOrFail($id);

            $alumni->update($params);
            DB::commit();

            return response()->json(['error' => false, 'message' => null, 'data' => $alumni], 200);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function delete(Request $request)
    {
        try{
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $alumni = AlumniModel::find($id);
            if (empty($alumni)) {
                return response()->json(['error' => true, 'message' => 'Alumni tidak ditemukan'], 400);
            }
            $alumni->delete();
        } catch(\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }
}
