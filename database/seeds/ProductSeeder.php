<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->truncate();
        DB::table('product_variants')->truncate();
        DB::table('product_images')->truncate();
        DB::table('product_seo')->truncate();
        DB::table('product_option_map_product')->truncate();
        DB::table('category_maps')->truncate();
        DB::table('inventory_logs')->truncate();
    }
}
