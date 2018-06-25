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
        'xendit_cc_charge_response', 'xendit_va_number'
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

    CONST UNPAID_DURATION_KEY = "unpaid-transfer-duration";

    public static function getPaymentOrder($orderId) {
        $data = parent::select('logo', 'name', 'desc', 'order_payment.status')
                        ->leftJoin('payment_method', 'payment_method.id', '=', 'order_payment.payment_method_id')
                        ->where('order_id', $orderId)
                        ->first();
        return $data;
    }

    public static function jobCancelOrder() {
        $status = [0, 1];
        $order = parent::where('max_transfer_time', '<', date('Y-m-d H:i:s'))
                        ->whereIn('status', $status)
                        ->pluck('order_id');
        $orderIdToCancel = $order->toArray();

        foreach ($orderIdToCancel as $key => $value) {
            // CHANGE STATUS TO CANCELLED
            $changePaymentStatus = parent::where('order_id', $value)->update([
                'status'    => 3
            ]);

            // UPDATE QTY AND INVENTORY LOG
            OrderItem::cancelOrderItem($value);

            // ORDER LOG
            OrderLog::create([
                'order_id'      => $value,
                'source'        => 'cron',
                'desc'          => 'Cancelled by System',
                'done_by'       => 0
            ]);
        }
        return $orderIdToCancel;
    }
}
