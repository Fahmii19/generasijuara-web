<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleModel;
use App\Utils\Constant;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Constant::IMPORTANT_ROLES as $key => $role_name) {
            $role = RoleModel::where('role_name', $role_name)->first();
            if (empty($role)) {
                $role = RoleModel::create([
                    'role_name'=> $role_name,
                ]);
            }
            $role->scopes = '';
            $role->save();
        }
    }
}
