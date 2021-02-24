<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayRoles = [
            [
                'name' => 'admin', // администратор
                'title' => 'Admin',
            ],
            [
                'name' => 'user', // пользователь
                'title' => 'User',
            ],
        ];

        if( count($arrayRoles) > 0 ) {
            foreach ($arrayRoles as $role) {
                $roleFound = DB::table('user_roles')->where('name', '=', $role['name'])->first();
                if( !$roleFound ) {
                    $admin = new Role();
                    $admin->name = $role['title'];
                    $admin->title = $role['title'];
                    $admin->save();
                }
            }
        }
    }
}
