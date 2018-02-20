<?php

use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('partners')->truncate();
        DB::table('partners')->insert([
            'id'        => 1,
         	'store_name' => 'Kreatif City',
         	'owner_name' => 'Ryan',
         	'email' => 'ryan@kreatifcity.com',
         	'handphone_number' => '082919299292',
            'province_id' => 6,
         	'city_id' => 151,
            'address'   => 'Dipo Business',
            'postcode'  => '12029'
        ]);
    }
}
