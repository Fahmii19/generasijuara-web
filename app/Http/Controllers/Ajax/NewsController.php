<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\NewsModel;

use DB;
use App\Utils\Misc;
use Auth;

class NewsController extends Controller
{
    public function list(Request $request)
    {
        try {
            $query = NewsModel::query();
            $query->orderBy('updated_at', 'desc');
            return response()->json(['error' => false, 'message' => null, 'data' => $query->get() ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function get(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $news = NewsModel::find($id);
            return response()->json(['error' => false, 'message' => null, 'data' => $news ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $news = NewsModel::find($id);
            if (empty($news)) {
                return response()->json(['error' => true, 'message' => 'news tidak ditemukan'], 400); 
            }
            $news->delete();

            return response()->json(['error' => false, 'message' => null, 'data' => [] ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function save(Request $request)
    {
        DB::beginTransaction();
        try {

            $user = Auth::user();

            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $title = !empty($request->get('title')) ? $request->get('title') : null;
            $published_for = !empty($request->get('published_for')) ? $request->get('published_for') : 'public';
            $content = !empty($request->get('content')) ? $request->get('content') : null;
            $is_active = !empty($request->get('is_active')) ? Misc::castBoolean($request->get('is_active')) : false;

            $params = [
                'title' => $title,
                'published_for' => $published_for,
                'content' => $content,
                'is_active' => $is_active,
                'updated_by' => $user->id,
            ];

            $news = NewsModel::find($id);
            if (!empty($news)) {
                // update
                $news->update($params);
            }else{
                // new
                $params['created_by'] = $user->id;
                $news = NewsModel::create($params);
            }
            
            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $news ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
}
