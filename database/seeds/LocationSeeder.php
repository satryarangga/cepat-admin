<?php

use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->truncate();
        DB::table('provinces')->truncate();

        $json = File::get("database/data/cities.json");
        $city = json_decode($json);

        $json = File::get("database/data/provinces.json");
        $province = json_decode($json);

        foreach ($city as $obj) {
            DB::table('cities')->insert([
                'name'   		=> $obj->name,
                'province_id'   => $obj->province_id,
            ]);
        }

        foreach ($province as $obj) {
            DB::table('provinces')->insert([
                'name'   		=> $obj->name
            ]);
        }


    }
}
