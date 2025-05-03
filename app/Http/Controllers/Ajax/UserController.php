<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserRoleModel;
use App\Models\RoleModel;
use App\Models\User;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use DB;

class UserController extends Controller
{
    public function get(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $user = User::with('roles')
                ->findOrFail($id);

            $data = [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'phone' => $user->phone,
                'password' => $user->password,
                'role' => $user->roles->first()->id,
                'status' => $user->is_active
            ];

            return response()->json(['error' => false, 'message' => null, 'data' => $data ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }


    public function create(CreateRequest $request)
    {
        DB::beginTransaction();
        try {
            $requestData = $request->validated();
            // dd($requestData);
            $requestData['password'] = bcrypt($requestData['password']);
            $requestData['is_active'] = (int) $requestData['is_active'] == 1 ? true : false;

            $user = User::create($requestData);
            // dd($user);
            if ($user && !empty($requestData['role'])) {
                $role = UserRoleModel::where('user_id', $user->id)->first();
                if ($role) {
                    $role->role_id = $requestData['role'];
                    $role->save();
                } else {
                    UserRoleModel::create(['user_id' => $user->id, 'role_id' => $requestData['role']]);
                }
            }
            
            DB::commit();
        
            return response()->json(['error' => false, 'message' => null, 'data' => $user ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function update(UpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $requestData = $request->validated();
            // dd($requestData);
            $requestData['is_active'] = (int) $requestData['is_active'] == 1 ? true : false;
            $user = User::find($requestData['id']);
            $requestData['password'] = bcrypt($requestData['password']); 
            
            $userRole = UserRoleModel::where('user_id', $user->id)->first();

            if ($user->role != $userRole->role_id) {
                $userRole->role_id = $requestData['role'];
            }

            $user->update($requestData);

            DB::commit();
        
            return response()->json(['error' => false, 'message' => null, 'data' => $user ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $user = User::find($id);
            $userRole = UserRoleModel::where('user_id', $id)->delete();

            if (empty($user)) {
                return response()->json(['error' => true, 'message' => 'User tidak ditemukan'], 400); 
            }
            $user->delete();
            return response()->json(['error' => false, 'message' => null, 'data' => [] ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function getRoles(Request $request)
    {
        try {
            $roles = RoleModel::all();
            return response()->json(['error' => false, 'message' => null, 'data' => $roles ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
}
