<?php

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('order_head')->truncate();
        DB::table('order_head')->insert([
        	'purchase_code'		=> 'PPOOOO123',
        	'date'				=> date('Y-m-d H:i:s'),
        	'customer_id'		=> 1,
        	'customer_email'	=> 'satrya.rangga91@gmail.com',
        	'total_purchase'	=> 300000,
        	'shipping_cost'		=> 13000,
        	'paycode'			=> 102,
        	'discount'			=> 0,
        	'credit_used'		=> 10000,
        	'grand_total'		=> 303102
        ]);

        DB::table('order_head')->insert([
        	'purchase_code'		=> 'XXOOOO123',
        	'date'				=> date('Y-m-d H:i:s'),
        	'customer_id'		=> 1,
        	'customer_email'	=> 'satrya.rangga91@gmail.com',
        	'total_purchase'	=> 200000,
        	'shipping_cost'		=> 9000,
        	'paycode'			=> 103,
        	'discount'			=> 20000,
        	'credit_used'		=> 0,
        	'grand_total'		=> 189103
        ]);

        DB::table('order_item')->truncate();
		DB::table('order_item')->insert([
			'order_id'				=> 1,
			'product_id'			=> 1,
			'product_variant_id'	=> 3,
			'SKU'					=> 'BAILBLU3845',
			'color_id'				=> 1,
			'size_id'				=> 5,
			'product_price'			=> 100000,
			'qty'					=> 1,
			'subtotal'				=> 100000
        ]);

        DB::table('order_item')->insert([
			'order_id'				=> 1,
			'product_id'			=> 1,
			'product_variant_id'	=> 2,
			'SKU'					=> 'TSTXSBLU5144',
			'color_id'				=> 1,
			'size_id'				=> 2,
			'product_price'			=> 200000,
			'qty'					=> 1,
			'subtotal'				=> 200000,
			'notes'					=> 'Jangan lecek'
        ]);        

        DB::table('order_item')->insert([
			'order_id'				=> 2,
			'product_id'			=> 1,
			'product_variant_id'	=> 1,
			'SKU'					=> 'TSTSBLA5296',
			'color_id'				=> 2,
			'size_id'				=> 3,
			'product_price'			=> 200000,
			'qty'					=> 1,
			'subtotal'				=> 200000,
			'notes'					=> 'Jangan bau'
        ]);

        DB::table('order_payment')->truncate();
        DB::table('order_payment')->insert([
			'order_id'				=> 1,
			'payment_method_id'		=> 1,
			'total_amount'			=> 313102
        ]);

        DB::table('order_payment')->insert([
			'order_id'				=> 2,
			'payment_method_id'		=> 1,
			'total_amount'			=> 189103,
			'confirmed_by'			=> 'Jame Wahab',
			'confirmed_bank'		=> 'MANDIRI',
			'confirmed_amount'		=> 199103,
			'total_amount'			=> 199103
        ]);

        DB::table('order_discount')->truncate();
        DB::table('order_discount')->insert([
			'order_id'				=> 2,
			'voucher_code'			=> 'test123',
			'voucher_id'			=> 1,
			'voucher_name'			=> 'Lorem Ipsum Dolor Sit Amet Syalalalala Uwuwuwuwuw',
			'voucher_value'			=> 20000
        ]);

        DB::table('order_delivery')->truncate();
        DB::table('order_delivery')->insert([
			'order_id'				=> 1,
			'order_item_id'			=> 1,
			'from_address'			=> 'Jalan Mangga',
			'from_province_id'		=> 6,
			'from_province_name'	=> 'DKI Jakarta',
			'from_city_id'			=> 152,
			'from_city_name'		=> 'Jakarta Pusat',
			'from_postcode'			=> 12550,
			'from_phone'			=> '082782882',
			'to_address'			=> 'Jalan Sawah',
			'to_province_id'		=> 6,
			'to_province_name'		=> 'DKI Jakarta',
			'to_city_id'			=> 153,
			'to_city_name'			=> 'Jakarta Selatan',
			'to_postcode'			=> 12555,
			'to_phone'				=> '087829202029'
        ]);

        DB::table('order_delivery')->insert([
			'order_id'				=> 1,
			'order_item_id'			=> 2,
			'from_address'			=> 'Jalan Kampung',
			'from_province_id'		=> 6,
			'from_province_name'	=> 'DKI Jakarta',
			'from_city_id'			=> 155,
			'from_city_name'		=> 'Jakarta Utara',
			'from_postcode'			=> 12553,
			'from_phone'			=> '082782882',
			'to_address'			=> 'Jalan Sawah',
			'to_province_id'		=> 6,
			'to_province_name'		=> 'DKI Jakarta',
			'to_city_id'			=> 153,
			'to_city_name'			=> 'Jakarta Selatan',
			'to_postcode'			=> 12555,
			'to_phone'				=> '087829202029'
        ]);

        DB::table('order_delivery')->insert([
			'order_id'				=> 2,
			'order_item_id'			=> 3,
			'from_address'			=> 'Jalan Kampung',
			'from_province_id'		=> 6,
			'from_province_name'	=> 'DKI Jakarta',
			'from_city_id'			=> 155,
			'from_city_name'		=> 'Jakarta Utara',
			'from_postcode'			=> 12553,
			'from_phone'			=> '082782882',
			'to_address'			=> 'Jalan Sawah',
			'to_province_id'		=> 6,
			'to_province_name'		=> 'DKI Jakarta',
			'to_city_id'			=> 153,
			'to_city_name'			=> 'Jakarta Selatan',
			'to_postcode'			=> 12555,
			'to_phone'				=> '087829202029'
        ]);

        DB::table('wallet_log')->truncate();
        DB::table('wallet_log')->insert([
        	'customer_id'	=> 1,
        	'purchase_code'		=> 'PPOOOO123',
        	'description'	=> 'Credit Used',
        	'amount'		=> 10000,
        	'created_at'	=> date('Y-m-d H:i:s')
        ]);
    }
}
