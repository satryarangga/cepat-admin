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

    public static function getItemDetail($orderId) {
        $data = parent::select('order_item.id', 'products.name as product_name', 'size.name as size_name', 'colors.name as color_name', 
                                'SKU', 'qty', 'subtotal', 'shipping_status', 'resi', 'shipping_status', 'shipping_notes')
                        ->leftJoin('products', 'products.id', '=', 'order_item.product_id')
                        ->leftJoin('colors', 'colors.id', '=', 'order_item.color_id')
                        ->leftJoin('size', 'size.id', '=', 'order_item.size_id')
                        ->where('order_id', $orderId)
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
}
