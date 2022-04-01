<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles=[
            [
                'name' => "super",
                'description' => "create,view,edit and delete anything (roles,admins,users,pharmacies,times)"
            ],
            [
                'name' => "users",
                'description' => "create,view,edit and delete users and their time tables"
            ],
            [
                'name' => "pharmacies",
                'description' => "create,view,edit and delete pharmacies and their time tables"
            ],
            [
                'name' => "times",
                'description' => "create,view,edit and delete time tables only"
            ],
            
        ];
        DB::table('roles')->insert($roles);
    }
}
