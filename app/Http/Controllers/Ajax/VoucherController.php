<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoucherModel;
use DB;
use App\Utils\Misc;
use App\Utils\Constant;

class VoucherController extends Controller
{
    public function get(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $kode = !empty($request->get('kode')) ? $request->get('kode') : null;
            $voucher = VoucherModel::query();
            if (!empty($id)) {
                $voucher->where('id', $id);
            }
            if (!empty($kode)) {
                $voucher->where('kode', $kode);
            }
            return response()->json(['error' => false, 'message' => null, 'data' => $voucher->first() ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
    public function checkCode(Request $request)
    {
        try {
            $kode = !empty($request->get('kode')) ? $request->get('kode') : 'test';
            $voucher = VoucherModel::query()
                ->where('stok', '>', 0)
                ->where('is_active', true);
            if (!empty($kode)) {
                $voucher->where('kode', $kode);
            }
            return response()->json(['error' => false, 'message' => null, 'data' => $voucher->first() ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function getAll(Request $request)
    {
        try {
            $voucher = VoucherModel::get();
            return response()->json(['error' => false, 'message' => null, 'data' => $voucher ], 200); 
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
            $voucher = VoucherModel::find($id);
            if (empty($voucher)) {
                return response()->json(['error' => true, 'message' => 'voucher tidak ditemukan'], 400); 
            }
            $voucher->delete();
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
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            // $kode = !empty($request->get('kode')) ? $request->get('kode') : null;
            $params['stok'] = !empty($request->get('stok')) ? $request->get('stok') : 1;
            $params['type'] = !empty($request->get('type')) ? $request->get('type') : VoucherModel::TYPE_FIXED;
            $params['discount'] = !empty($request->get('discount')) ? $request->get('discount') : 0;
            $params['is_active'] = !empty($request->get('is_active')) ? Misc::castBoolean($request->get('is_active')) : false;

            $voucher = VoucherModel::find($id);

            if (empty($voucher)) {
                $params['kode'] = VoucherModel::generateKode();
                $voucher = VoucherModel::create($params);
            } else {
                $voucher->update($params);
            }

            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $voucher ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
}
