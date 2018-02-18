<?php

use Illuminate\Database\Seeder;

class StaticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('static_content')->truncate();
        DB::table('static_content')->insert([
        	'name'	=> "About Us",
        	'url'	=> "about-us",
        	'type'	=> 1,
        	'content'	=> "This is about us page",
        	'created_by'	=> 0,
        ]);
        DB::table('static_content')->insert([
        	'name'	=> "Contact Us",
        	'url'	=> "contact-us",
        	'type'	=> 1,
        	'content'	=> "This is contact us page",
        	'created_by'	=> 0,
        ]);
        DB::table('static_content')->insert([
        	'name'	=> "Privacy Policy",
        	'url'	=> "privacy-policy",
        	'type'	=> 1,
        	'content'	=> "This is privacy policy page",
        	'created_by'	=> 0,
        ]);
        DB::table('static_content')->insert([
        	'name'	=> "Terms and Condition",
        	'url'	=> "terms-condition",
        	'type'	=> 1,
        	'content'	=> "This is terms condition page",
        	'created_by'	=> 0,
        ]);
    }
}
