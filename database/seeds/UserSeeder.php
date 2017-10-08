<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
         	'first_name' => 'Admin',
         	'last_name' => 'Admin',
         	'username' => 'admin',
         	'password' => bcrypt('123456'),
         	'created_by' => 0,
        ]);
    }
}
