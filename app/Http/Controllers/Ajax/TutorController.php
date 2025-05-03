<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TutorModel;
use App\Models\User;
use App\Models\UserRoleModel;
use App\Models\RoleModel;
use DB;
use Excel;
use App\Imports\TutorImport;

class TutorController extends Controller
{
    public function importExcel(Request $request)
    {
        if ($request->hasFile('import_file')) {
            Excel::import(new TutorImport(1), $request->file('import_file'));
        }
        return response()->json([], 200); 
    }

    public function get(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $tutor = TutorModel::with(['user_detail'])->find($id);
            return response()->json(['error' => false, 'message' => null, 'data' => $tutor ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function getAll(Request $request)
    {
        try {
            $tutor = TutorModel::with(['user_detail'])->get();
            return response()->json(['error' => false, 'message' => null, 'data' => $tutor ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function getByName(Request $request)
    {
        try {
            $tutor = TutorModel::select('tutor.id','user_id','nip','name')
                                ->join('users', 'users.id', '=', 'tutor.user_id')
                                ->where('name', 'like', "%$request->keyword%")
                                ->limit(10)
                                ->get();
            return response()->json(['error' => false, 'message' => null, 'data' => $tutor ], 200); 
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
            $tutor = TutorModel::find($id);
            if (empty($tutor)) {
                return response()->json(['error' => true, 'message' => 'Tutor tidak ditemukan'], 400); 
            }
            User::where('id', $tutor->user_id)->delete();
            $tutor->delete();
            return response()->json(['error' => false, 'message' => null, 'data' => [] ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $password = !empty($request->get('password')) ? $request->get('password') : null;
            $tutor = TutorModel::find($id);
            if (empty($tutor)) {
                return response()->json(['error' => true, 'message' => 'Tutor tidak ditemukan'], 400); 
            }
            $user = User::where('id', $tutor->user_id)->update([
                'password' => bcrypt($password),
            ]);
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
            $nip = !empty($request->get('nip')) ? $request->get('nip') : null;
            $username = !empty($request->get('username')) ? $request->get('username') : $nip;
            $name = !empty($request->get('name')) ? $request->get('name') : null;
            $email = !empty($request->get('email')) ? $request->get('email') : null;
            $phone = !empty($request->get('phone')) ? $request->get('phone') : null;
            $is_active = !empty($request->get('is_active')) ? filter_var($request->get('is_active'), FILTER_VALIDATE_BOOLEAN) : false;
            $role = RoleModel::where('role_name', 'Tutor')->first();

            $tutor = TutorModel::find($id);
            if (!empty($tutor)) {
                // error_log('update tutor');
                // update
                $user = User::find($tutor->user_id);
                $tutor->nip = $nip;
                if (!empty($user)) {
                    // update user
                    $user->username = $username;
                    $user->email = $email;
                    $user->phone = $phone;
                    $user->name = $name;
                    $user->is_active = $is_active;
                    $user->save();
                }else{
                    // new user
                    $user = User::create([
                        'username' => $username,
                        'email' => $email,
                        'phone' => $phone,
                        'name' => !empty($name) ? $name : $nip,
                        'is_active' => $is_active,
                        'password' => bcrypt($username),
                    ]);
                    $tutor->user_id = $user->id;
                }

                $user_role = UserRoleModel::where('user_id', $user->id)
                    ->where('role_id', $role->id)
                    ->first();
                if (empty($user_role)) {
                    $user_role = UserRoleModel::create([
                        'user_id' => $user->id,
                        'role_id' => $role->id,
                    ]);
                }

                $tutor->save();
            }else{
                // new
                // error_log('new tutor');
                $user = User::create([
                    'username' => $username,
                    'password' => bcrypt($username),
                    'email' => $email,
                    'phone' => $phone,
                    'name' => !empty($name) ? $name : $nip,
                    'is_active' => $is_active,
                ]);

                $user_role = UserRoleModel::where('user_id', $user->id)
                    ->where('role_id', $role->id)
                    ->first();
                if (empty($user_role)) {
                    $user_role = UserRoleModel::create([
                        'user_id' => $user->id,
                        'role_id' => $role->id,
                    ]);
                }

                $tutor = TutorModel::create([
                    'user_id' => $user->id,
                    'nip' => $nip,
                ]);
            }
            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $tutor ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
}
