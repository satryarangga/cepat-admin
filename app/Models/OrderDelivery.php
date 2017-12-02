<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDelivery extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'order_delivery';

    /**
     * @var array
     */
    protected $fillable = [
        'order_id', 'order_item_id', 'from_address', 'from_province_id', 'from_province_name', 'from_city_id', 'from_city_name', 'from_postcode',
        'from_phone', 'to_address', 'to_province_id', 'to_province_name', 'to_city_id', 'to_city_name', 'to_postcode', 'to_phone',
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
