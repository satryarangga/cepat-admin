<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\OrderPaymentNotif;
use App\Mail\OrderFinish;

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
                        ->leftJoin('order_item', 'order_item.order_id', '=', 'order_head.id')
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

    public function salesReport($start, $end) {
        $user = Auth::user();
        $data = parent::select('purchase_code', 'customer_email', 'date', 'total_purchase')
                        ->whereBetween('date', [$start, $end])
                        ->get();

        return $data;
    }

    public function getTodayOrder($partnerId = null) {
        $data = parent::where('date', date('Y-m-d'))->count();
        return $data;
    }

    public function getTodayPurchase() {
        $data = parent::where('date', date('Y-m-d'))->sum('total_purchase');
        return $data;
    }

    public function getGraphPurchaseDaily() {
        $data = parent::select(DB::raw("SUM(total_purchase) as totalSales, 
                                        CONCAT(YEAR(date), '-', MONTH(date), '-', DAY(date)) AS period"))
                        ->whereRaw('date > DATE_SUB(now(), INTERVAL 1 MONTH)')
                        ->groupBy(DB::raw("period"))
                        ->orderBy(DB::raw("period"))
                        ->get();

        $data = json_decode(json_encode($data), True);

        usort($data, function ($a, $b) {
          $a_val = strtotime($a['period']);
          $b_val = strtotime($b['period']);

          if($a_val > $b_val) return 1;
          if($a_val < $b_val) return -1;
          return 0;
        });

        return $data;
    }

    public function orderPartnerList($filter = [], $sort = 'id', $limit = 10) {
        $user = Auth::user();
        $where[] = ['order_head.deleted_at', '=', null];
        $where[] = ['order_item.partner_id', '=', $user->partner_id];

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


        $data = parent::select(DB::raw('order_head.id, purchase_code, customer_email, date, order_payment.status, 
                        (select count(*) from order_item where order_id = order_head.id and partner_id = '.$user->partner_id.' group by order_id) AS total_item, 
                        (select sum(subtotal) from order_item where order_id = order_head.id and partner_id = '.$user->partner_id.' group by order_id) AS total_purchase'))
                        ->leftJoin('order_payment', 'order_payment.order_id', '=', 'order_head.id')
                        ->leftJoin('order_item', 'order_item.order_id', '=', 'order_head.id')
                        ->where($where)
                        ->orderBy($sort, 'desc')
                        ->paginate($limit);

        return $data;
    }

    public function salesReportPartner($start, $end, $partner_id) {
        $where[] = ['order_item.partner_id', '=', $partner_id];
        $data = parent::select(DB::raw('purchase_code, customer_email, date, 
                        (select sum(subtotal) from order_item where order_id = order_head.id and partner_id = '.$partner_id.' group by order_id) AS total_purchase'))
                        ->leftJoin('order_item', 'order_item.order_id', '=', 'order_head.id')
                        ->where($where)
                        ->whereBetween('date', [$start, $end])
                        ->get();

        return $data;
    }

    public static function sendEmailOrder($orderId) {
        $head = parent::find($orderId);
        $customer = Customer::find($head->customer_id);
        $item = OrderItem::select(DB::raw('product_id, color_id, size_id, product_price, qty, subtotal, colors.name, 
                                            size.name, products.name as product_name'))
                            ->leftJoin('colors', 'colors.id', '=', 'order_item.color_id')
                            ->leftJoin('size', 'size.id', '=', 'order_item.size_id')
                            ->leftJoin('products', 'products.id', '=', 'order_item.product_id')
                            ->where('order_id', $orderId)->get();

        $payment = OrderPayment::select(DB::raw('order_payment.status, payment_method.name as payment_method_name, 
                                                payment_method.desc as payment_method_desc'))
                                ->leftJoin('payment_method', 'order_payment.payment_method_id', '=', 'payment_method.id')
                                ->where('order_id', $orderId)
                                ->first();

        Mail::to($customer->email)->send(new OrderFinish($customer, $head, $item, $payment));
    }
}
