<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayRoleUsers = [
            [
                'role' => 'admin',
                'email' => 'admin@admin.com', // Chuck Norris
            ],
            [
                'role' => 'user',
                'email' => 'user@user.com', // Алексей Гайдаров
            ],
        ];

        if( count($arrayRoleUsers) > 0 ) {
            foreach ($arrayRoleUsers as $roleUser) {
                $userFound = DB::table('users')->where('email', '=', $roleUser['email'])->first();

                if ( $userFound ) {
                    $roleFound = DB::table('role_user')->where('user_id', '=', $userFound->id)->first();

                    if ( !$roleFound ) {
                        $user = User::where('email', '=', $roleUser['email'])->firstOrFail();
                        $role = Role::where('name', '=', $roleUser['role'])->firstOrFail();

                        $user->roles()->attach($role);
                    }
                }
            }
        }
    }
}
