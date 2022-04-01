<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => "Admin1",
            'email' => "admin@gmail.com",
            'password' => Hash::make('123456'),
            'roles' => "users,pharmacies,times,admins,roles",
        ]);
    }
}
