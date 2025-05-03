<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\WB\UpdateRequest;
use App\Jobs\SendVerificationPpdbJob;
use App\Models\PpdbModel;
use App\Utils\Constant;
use App\Utils\Misc;
use Illuminate\Support\Facades\DB;

class WBController extends Controller
{
    public function update(UpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;

            if (empty($id)) {
                return response()->json(['error' => true, 'message' => 'ppdb not found'], 400);
            }

            $ppdb = PpdbModel::with([
                'user_detail',
                'layanan_kelas',
                'paket_kelas',
                'paket_spp',
                'kelas',
            ])->find((int) $id);

            if (empty($ppdb)) {
                return response()->json(['error' => true, 'message' => 'ppdb not found'], 400);
            }

            $params = $request->validated();
            $params['is_active'] = !empty($params['is_active']) ? Misc::castBoolean($params['is_active']) : false;
            $params['kelamin'] = $params['jenis_kelamin'];
            
            // checking if the sent NIS differs from the value in the database
            // maka pakai nis dari form
            if ($params['nis'] != $ppdb->nis) {
                $ppdb->nis = $params['nis'];
            }

            $params['nis'] = $ppdb->nis;
            
            if ($params['is_active'] && empty($ppdb->nis)) {
                $params['nis'] = PpdbModel::generateNis();
            }

            if (!$ppdb->is_active && $params['is_active']) {
                $password = Constant::PPDB_DEFAULT_PASSWORD;
                $username = $params['nis'] ?? $ppdb->user_detail->email;
                $params['tgl_terima'] = $params['tgl_terima'] ?? date('Y-m-d');

                $ppdb->user_detail->password = bcrypt($password);
                $ppdb->user_detail->username = $username;
                $ppdb->user_detail->save();

                SendVerificationPpdbJob::dispatch(
                    [
                        'name' => $ppdb->user_detail->name,
                        'username' => $username,
                        'nik' => $params['nik_siswa'],
                        'password' => $password,
                    ],
                    [
                        'email' => $ppdb->email,
                        'name' => $ppdb->user_detail->name,
                    ]
                );
            }

            $ppdb->update($params);

            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $ppdb], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }
}
