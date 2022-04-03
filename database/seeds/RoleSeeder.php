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
                'name' => "admins",
                'description' => "create,view,edit and delete admins"
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
                'description' => "create,view,edit and delete times"
            ],
            [
                'name' => "roles",
                'description' => "create,view,edit and delete roles"
            ],
            
        ];
        DB::table('roles')->insert($roles);
    }
}
