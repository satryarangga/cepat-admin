<?php

use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banners')->truncate();
        DB::table('banners')->insert([
        	'filename'		=> "",
        	'position'		=> "Home Top Left",
        	'link'			=> "#",
        	'status'		=> 1,
        	'created_by'	=> 0,
        ]);
        DB::table('banners')->insert([
        	'filename'		=> "",
        	'position'		=> "Home Top Right",
        	'link'			=> "#",
        	'status'		=> 1,
        	'created_by'	=> 0,
        ]);
        DB::table('banners')->insert([
        	'filename'		=> "",
        	'position'		=> "Home Bottom Left",
        	'link'			=> "#",
        	'status'		=> 1,
        	'created_by'	=> 0,
        ]);
        DB::table('banners')->insert([
        	'filename'		=> "",
        	'position'		=> "Home Bottom Right",
        	'link'			=> "#",
        	'status'		=> 1,
        	'created_by'	=> 0,
        ]);
        DB::table('banners')->insert([
        	'filename'		=> "",
        	'position'		=> "Home Bottom Middle",
        	'link'			=> "#",
        	'status'		=> 1,
        	'created_by'	=> 0,
        ]);
    }
}
