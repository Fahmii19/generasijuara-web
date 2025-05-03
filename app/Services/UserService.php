<?php

namespace App\Services;

use App\Models\RoleModel;
use App\Models\UserRoleModel;
use App\Models\User;
use DB;
use Log;

/**
 * 
 */
class UserService
{
    function __construct()
    {
        
    }

    public function createUser(array $data, int $roleId, $isMultipleRole = false)
    {
        try {
            /**
             * 
             * data = [
             *  'name' => ''
             *  'username'  => ''
             *  'password'  => ''
             *  'is_active'  => ''
             * ]
             */

            $role = RoleModel::find($roleId);
            if (empty($role)) {
                throw new \Exception("Role not found");
            }

            $user = User::getByUsername($data['username']);

            if (!empty($user) && !$isMultipleRole) {
                throw new \Exception("User already exists");
            }

            $user = User::create([
                'name' => $data['name'] ?? null,
                'username' => $data['username'] ?? null,
                'password' => bcrypt($data['password']),
                'is_active' => $data['is_active'] ?? true,
            ]);

            $user_role = UserRoleModel::query()
                ->where('user_id', $user->id)
                ->where('role_id', $roleId)
                ->first();

            if (empty($user_role)) {
                $user_role = UserRoleModel::create([
                    'user_id' => $user->id,
                    'role_id' => $roleId,
                ]);
            }

            return ['error' => false, 'data' => $user];
        } catch (\Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

}