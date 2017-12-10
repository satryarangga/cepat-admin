<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Mail\OrderShippingNotif;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class OrderItem extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'order_item';

    /**
     * @var array
     */
    protected $fillable = [
        'order_id', 'product_id', 'product_variant_id', 'SKU', 'color_id', 'size_id', 'product_price', 'qty', 'subtotal', 
        'purchase_status', 'shipping_status', 'resi', 'notes', 'approved_time', 'shipping_time', 'delivery_time', 'partner_id',
        'shipping_notes', 'delivery_notes'
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

    public static function getItemDetail($orderId, $partnerId = null) {
        $where[] = ['order_id', '=', $orderId];

        if($partnerId) {
            $where[] = ['order_item.partner_id', '=', $partnerId];            
        }

        $data = parent::select('order_item.id', 'products.name as product_name', 'size.name as size_name', 
                                'colors.name as color_name', 'SKU', 'qty', 'subtotal', 'shipping_status', 
                                'resi', 'shipping_status', 'shipping_notes', 'partners.store_name as partner_name')
                        ->leftJoin('products', 'products.id', '=', 'order_item.product_id')
                        ->leftJoin('partners', 'order_item.partner_id', '=', 'partners.id')
                        ->leftJoin('colors', 'colors.id', '=', 'order_item.color_id')
                        ->leftJoin('size', 'size.id', '=', 'order_item.size_id')
                        ->where($where)
                        ->get();

        return $data;
    }

    public static function isItemShipped($items) {
        $shipped = false;
        foreach ($items as $key => $value) {
            if($value->shipping_status == 1 || $value->shipping_status == 2 || $value->shipping_status == 3 || $value->shipping_status == 4) {
                return true;
            }
        }
        return $shipped;
    }

    public static function getDataForEmail($orderItemId) {
        $data = parent::select(DB::raw('purchase_code, customer_email, first_name, last_name, grand_total, colors.name as color_name,
                                        size.name as size_name, products.name as product_name, resi, SKU, shipping_notes'))
                        ->leftJoin('order_head', 'order_head.id', '=', 'order_item.order_id')
                        ->leftJoin('customers', 'customers.id', '=', 'order_head.customer_id')
                        ->leftJoin('colors', 'colors.id', '=', 'order_item.color_id')
                        ->leftJoin('size', 'size.id', '=', 'order_item.size_id')
                        ->leftJoin('products', 'products.id', '=', 'order_item.product_id')
                        ->where('order_item.id', $orderItemId)
                        ->first();
        return $data;
    }

    public static function sendEmailNotifShipping($orderItemId, $status) {
        $data = self::getDataForEmail($orderItemId);
        Mail::to($data->customer_email)->send(new OrderShippingNotif($data, $status));
    }

    public function getTodaySoldItem($partnerId = null) {
        $where = [];
        if($partnerId) {
            $where[] = ['partner_id', '=', $partnerId];
        }
        $data = parent::whereRaw("DATE(created_at) = '".date('Y-m-d')."' ")
                        ->where($where)
                        ->sum('qty');
        return $data;
    }

    public function getPartnerTodayOrder($partnerId) {
        $data = parent::where('partner_id', $partnerId)
                        ->whereRaw("DATE(created_at) = '".date('Y-m-d')."' ")
                        ->count();

        return $data;
    }

    public function getPartnerTodayPurchase($partnerId) {
        $data = parent::where('partner_id', $partnerId)
                        ->whereRaw("DATE(created_at) = '".date('Y-m-d')."' ")
                        ->sum('subtotal');

        return $data;
    }

    public function getPartnerUniqueBuyer($partnerId) {
        $data = parent::where('partner_id', $partnerId)
                        ->leftJoin('order_head', 'order_item.order_id', '=', 'order_head.id')
                        ->distinct('customer_id')
                        ->count();
        return $data;
    }

    public function getPartnerGraphPurchase($partnerId) {
        $data = parent::select(DB::raw("SUM(subtotal) as totalSales, 
                                        CONCAT(YEAR(created_at), '-', MONTH(created_at), '-', DAY(created_at)) AS period"))
                        ->whereRaw('created_at > DATE_SUB(now(), INTERVAL 1 MONTH)')
                        ->where('partner_id', $partnerId)
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
}
