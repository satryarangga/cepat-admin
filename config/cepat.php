<?php

return [

	'order_expired_duration'	=> env('ORDER_EXPIRED_DURATION', 2),

	'shipping_status'			=> [
										0	=> 'Not Shipped',
										1	=> 'Shipped',
										2	=> 'Delivered',
										3	=> 'Failed Delivered',
										4	=> 'Returned'
								   ]

];