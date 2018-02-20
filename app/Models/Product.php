<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'original_price', 'discount_price', 'modal_price', 'weight', 'description', 'created_by', 'updated_by', 'status',
        'partner_id', 'has_variant'
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

    public function getListProduct($filter = [], $sortBy = 'products.updated_at', $limit = 10) {
        $user = Auth::user();
        $where = [];

        $keyword = $filter['keyword'];
        if($filter['search_by'] == 'product_name' && $keyword) {
            $where[] = ['products.name', 'like', "%$keyword%"];
        }

        if($user->partner_id) {
            $where[] = ['partner_id', '=', $user->partner_id];   
        }

        $data = parent::select('products.id', 'name', 'original_price', 'weight', 'duration',
                                'product_countdown.id as countdown_id', 'end_on', 'start_on', 'products.status', 'has_variant')
                        ->leftJoin('product_countdown', 'product_countdown.product_id', '=', 'products.id')
                        ->orderBy($sortBy, 'desc')
                        ->where($where)
                        ->paginate($limit);

        return $data;
    }

    public function insertVariantProduct($productId, $qty = 0) {
        $variant = new ProductVariant();
        $createVariant = ProductVariant::create([
            'product_id'    => $productId,
            'color_id'      => 0,
            'size_id'       => 0,
            'qty_order'     => $qty,
            'qty_warehouse'     => $qty,
            'SKU'           => $variant->generateSKU($productId, $color = 0, $size = 0),
            'default'       => 1,
            'max_order_qty' => 100, // TEMPORARY, WILL CHANGE IF NEEDED BY
            'created_by'    => Auth::id()
        ]);

        return $createVariant;
    }
}
