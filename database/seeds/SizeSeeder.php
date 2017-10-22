<?php

use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	 DB::table('size')->truncate();
         DB::table('size')->insert([
         	'name' => 'All Size',
         	'url' => 'all-size',
         	'created_by' => 0,
        ]);

         DB::table('size')->insert([
         	'name' => 'XS',
         	'url' => 'xs',
         	'created_by' => 0,
        ]);

         DB::table('size')->insert([
         	'name' => 'S',
         	'url' => 's',
         	'created_by' => 0,
        ]);

         DB::table('size')->insert([
         	'name' => 'M',
         	'url' => 'm',
         	'created_by' => 0,
        ]);

         DB::table('size')->insert([
         	'name' => 'L',
         	'url' => 'l',
         	'created_by' => 0,
        ]);

         DB::table('size')->insert([
         	'name' => 'XL',
         	'url' => 'xl',
         	'created_by' => 0,
        ]);
    }
}
