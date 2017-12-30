<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ProductVariant extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'product_variants';

    /**
     * @var array
     */
    protected $fillable = [
        'product_id', 'color_id', 'size_id', 'SKU', 'default', 'qty_order', 'qty_warehouse', 'max_order_qty',
        'status', 'created_by', 'updated_by'
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

    public function listByColor($productId) {
        $data = parent::where('product_id', $productId)
                        ->get();

        $color = [];
        $total = [];
        foreach ($data as $key => $value) {
            $color[$value->color_id] = $value;
            $total[$value->color_id][] = $value->id;
        }

        $data = $this->getImage($color);

        $return = [
            'data' => $color,
            'total' => $total,
        ];

        return $return;
    }

    public function listBySize($productId) {
        $data = parent::where('product_id', $productId)->get();

        $variant = [];
        foreach ($data as $key => $value) {
            $variant[$value->color_id][] = $value;
        }

        return $variant;
    }

    public function generateSKU($productId, $colorId, $sizeId) {
        $product = Product::find($productId);

        if($colorId != 0) {
            $color = Color::find($colorId);
            $size = Size::find($sizeId);
        }
        $constraint = [' ', '-', '_'];

        $productName = str_replace($constraint, '', $product->name);
        $startName = substr($productName, 0, 2);
        $endName = substr($productName, -1);

        if(isset($color)) {
            $sizeName = str_replace($constraint, '', substr($size->url, 0, 2));
            $colorName = str_replace($constraint, '', substr($color->url, 0, 3));
        } else {
            $sizeName = 'ns';
            $colorName = 'ncl';
        }

        $time = substr(time(), -4);

        $sku = strtoupper($startName.$endName.$sizeName.$colorName.$time);
        return $sku;
    }

    protected function getImage($data) {
        foreach ($data as $key => $value) {
            $image = ProductImage::where('product_id', $value->product_id)
                                    ->where('color_id', $value->color_id)
                                    ->where('deleted_at', null)
                                    ->orderBy('default', 'desc')
                                    ->first();
            $data[$key]['image'] = (isset($image->id)) ? $image->url : null;
        }
        return $data;
    }

    public function getListSKU ($filter = [], $sortBy = 'updated_at', $limit = 20) {
        $user = Auth::user();
        $where = [];

        $keyword = $filter['keyword'];
        if($filter['search_by'] == 'sku' && $keyword) {
            $where[] = ['SKU', '=', $keyword];
        }

        if($filter['search_by'] == 'product_name' && $keyword) {
            $where[] = ['products.name', 'like', "%$keyword%"];
        }

        if($user->partner_id) {
            $where[] = ['partner_id', '=', $user->partner_id];   
        }

        $data = parent::select('SKU', 'qty_order', 'qty_warehouse', 'products.name as product_name', 'colors.name as color_name', 'size.name as size_name')
                        ->join('products', 'products.id', '=', 'product_variants.product_id')
                        ->leftJoin('colors', 'colors.id', '=', 'product_variants.color_id')
                        ->leftJoin('size', 'size.id', '=', 'product_variants.size_id')
                        ->where($where)
                        ->orderBy('product_variants.updated_at', 'desc')
                        ->paginate($limit);
        return $data;

    }

    public static function variantShipped($productVariantId, $qty, $orderId, $shippingStatus) {
        $data = parent::find($productVariantId);
        $order = OrderHead::find($orderId);
        $oldQtyWarehouse = $data->qty_warehouse;

        if($shippingStatus == 1) { //SHIPPED
            $data->qty_warehouse = $oldQtyWarehouse - $qty;
        } else if ($shippingStatus == 4) { // RETURNED
            $data->qty_warehouse = $oldQtyWarehouse + $qty;
        }
        $data->save();
        $listStatus = config('cepat.shipping_status');

        // INSERT TO INVENTORY LOG
        if($shippingStatus == 1 || $shippingStatus == 4) { // ONLYC CREATE INVENTORY LOG FOR SHIPPED AND RETURNED
            InventoryLog::create([
                'product_id'    => $data->product_id,
                'purchase_code' => $order->purchase_code,
                'user_id'       => Auth::id(),
                'SKU'           => $data->SKU,
                'qty'           => $qty,
                'type'          => ($shippingStatus == 1 ) ? 2 : 1,
                'description'   => 'Order '.$listStatus[$shippingStatus],
                'source'        => 2,
                'product_variant_id'    => $productVariantId,
                'order_id'      => $orderId
            ]);
        }
    }
}
