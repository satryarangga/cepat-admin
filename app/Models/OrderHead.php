<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPaymentNotif;

class OrderHead extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'order_head';

    /**
     * @var array
     */
    protected $fillable = [
        'purchase_code', 'date', 'customer_id', 'customer_email', 'total_purchase', 'shipping_cost', 'paycode', 'discount',
        'credit_used', 'grand_total'
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

    public function orderList($filter = [], $sort = 'id', $limit = 10) {
        $where[] = ['order_head.deleted_at', '=', null];

        if($filter['search_by'] == 'email') {
            $where[] = ['customer_email', '=', $filter['keyword']];            
        }

        if($filter['search_by'] == 'purchase_code') {
            $where[] = ['purchase_code', '=', $filter['keyword']];            
        }

        if($filter['status'] == 'to_ship') {
            return $this->getUnshippedOrder($where, $sort, $limit);
        }

        if($filter['status'] == 'to_approve') {
            $where[] = ['order_payment.status', '<>', 2];   
        }


        $data = parent::select('order_head.id', 'purchase_code', 'customer_email', 'date', 'grand_total', 'order_payment.status')
                        ->leftJoin('order_payment', 'order_payment.order_id', '=', 'order_head.id')
                        ->where($where)
                        ->orderBy($sort, 'desc')
                        ->paginate($limit);

        return $data;
    }

    protected function getUnshippedOrder($where = [], $sort, $limit) {
        $where[] = ['order_payment.status', '=', 2];

        $data = parent::select(DB::raw("order_head.id, purchase_code, customer_email, date, grand_total"))
                        ->leftJoin('order_payment', 'order_payment.order_id', '=', 'order_head.id')
                        ->where($where)
                        ->whereRaw('(select count(*) from order_item where order_id = order_head.id and shipping_status = 0) > 0')
                        ->paginate($limit);
        return $data;
    }

    public static function getDataForEmail($orderId) {
        $data = parent::select(DB::raw('purchase_code, customer_email, first_name, last_name, grand_total'))
                        ->leftJoin('customers', 'customers.id', '=', 'order_head.customer_id')
                        ->where('order_head.id', $orderId)
                        ->first();
        return $data;
    }

    public static function sendEmailNotifPayment($orderId) {
        $data = self::getDataForEmail($orderId);
        Mail::to($data->customer_email)->send(new OrderPaymentNotif($data));
    }
}
