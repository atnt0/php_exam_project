<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayUsers = [
            [
                'name' => 'Arnold Schwarzenegger',
                'email' => 'admin@admin.com',
                'password' => '12345678',
            ],
            [
                'name' => 'Чарльз Дарвин',
                'email' => 'user@user.com',
                'password' => 'super-mega-password',
            ],
        ];

        if( count($arrayUsers) > 0 ){
            foreach ($arrayUsers as $user) {
                $userFound = DB::table('users')->where('email', '=', $user['email'])->first();
                if( !$userFound ) {
                    $admin = new User();
                    $admin->name = $user['name'];
                    $admin->email = $user['email'];
                    $admin->password = bcrypt($user['password']);
                    $admin->save();
                }
            }
        }

    }
}
