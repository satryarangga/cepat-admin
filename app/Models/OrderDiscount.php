<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDiscount extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'order_discount';

    /**
     * @var array
     */
    protected $fillable = [
        'order_id', 'voucher_code', 'voucher_id', 'voucher_value', 'voucher_name'
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
