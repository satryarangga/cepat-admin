<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderReturn extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'order_return';

    /**
     * @var array
     */
    protected $fillable = [
        'order_item_id', 'product_id', 'product_variant_id', 'reason', 'status', 'updated_by'
    ];

    protected $dates = ['deleted_at'];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    public function list() {
        $user = Auth::user();
        $data = parent::select(DB::raw('order_return.id, order_item_id, products.name as product_name, 
                                        reason, purchase_code, order_return.status'))
                        ->leftJoin('order_item', 'order_item.id', '=', 'order_return.order_item_id')
                        ->leftJoin('products', 'products.id', '=', 'order_return.product_id')
                        ->leftJoin('order_head', 'order_head.id', '=', 'order_item.order_id')
                        ->get();
        return $data;
    }
}
