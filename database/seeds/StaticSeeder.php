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
        DB::table('static_content')->insert([
            'name'  => "Call Center",
            'url'   => "call-center",
            'type'  => 2,
            'content'   => "021-570182929",
            'created_by'    => 0,
        ]);
        DB::table('static_content')->insert([
            'name'  => "Company Address",
            'url'   => "company-address",
            'type'  => 2,
            'content'   => "Dipo Business Center",
            'created_by'    => 0,
        ]);
        DB::table('static_content')->insert([
            'name'  => "Facebook Link",
            'url'   => "facebook-link",
            'type'  => 2,
            'content'   => "http://facebook.com",
            'created_by'    => 0,
        ]);
        DB::table('static_content')->insert([
            'name'  => "Instagram Link",
            'url'   => "instagram-link",
            'type'  => 2,
            'content'   => "http://instagram.com",
            'created_by'    => 0,
        ]);
        DB::table('static_content')->insert([
            'name'  => "Twitter Link",
            'url'   => "twitter-link",
            'type'  => 2,
            'content'   => "http://twitter.com",
            'created_by'    => 0,
        ]);
        DB::table('static_content')->insert([
            'name'  => "Youtube Link",
            'url'   => "youtube-link",
            'type'  => 2,
            'content'   => "http://youtube.com",
            'created_by'    => 0,
        ]);
        DB::table('static_content')->insert([
            'name'  => "Unpaid Transfer Duration",
            'url'   => "unpaid-transfer-duration",
            'type'  => 2,
            'content'   => "60",
            'created_by'    => 0,
        ]);
    }
}
