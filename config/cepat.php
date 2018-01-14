<?php

return [

	'order_expired_duration'	=> env('ORDER_EXPIRED_DURATION', 2),

	'shipping_status'			=> [
										0	=> 'Not Shipped',
										1	=> 'Shipped',
										2	=> 'Delivered',
										3	=> 'Failed Delivered',
										4	=> 'Returned'
									],

	'rajaongkir_key'			=>	env('RAJAONGKIR_KEY'),

	'rajaongkir_url'			=>	env('RAJAONGKIR_URL'),

	'rajaongkir_courier'		=> [
										'jne'	=> 'JNE',
										'pos'	=> 'POS Indonesia',
										'tiki'	=> 'TIKI',
										'jet'	=> 'JET Express',
										'jnt'	=> 'J&T Express',
										'rpx'	=> 'RPX',
										'esl'	=> 'ESL Express',
										'pcp'	=> 'PCP Express',
										'pahala'	=> 'Pahala Express',
										'sap'	=> 'SAP Express',
										'wahana' => 'Wahana',
										'sicepat' => 'SICepat',
										'pandu'	=> 'Pandu Logistic',
										'cahaya' => 'Cahaya Logistik',
										'indah' => 'Indah Jaya Express'
								   ],

	'front_end_host'			=> env('FRONT_END_HOST')

];