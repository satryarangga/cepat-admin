<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderPayment extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'order_payment';

    /**
     * @var array
     */
    protected $fillable = [
        'order_id', 'payment_method_id', 'confirmed_by', 'confirmed_bank', 'confirmed_amount', 'total_amount', 'status',
        'xendit_cc_charge_response'
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

    public static function getPaymentOrder($orderId) {
        $data = parent::select('logo', 'name', 'desc', 'order_payment.status')
                        ->leftJoin('payment_method', 'payment_method.id', '=', 'order_payment.payment_method_id')
                        ->where('order_id', $orderId)
                        ->first();
        return $data;
    }
}
