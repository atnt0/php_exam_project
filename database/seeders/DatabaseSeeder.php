<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);
        $this->call(UserRolesSeeder::class);
        $this->call(RoleUserSeeder::class);
        $this->call(InstructionComplaintStatusesSeeder::class);
        $this->call(InstructionsSeeder::class);
        $this->call(InstructionComplaintsSeeder::class);
    }
}
