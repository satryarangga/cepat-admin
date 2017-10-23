<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        $color = Color::find($colorId);
        $size = Size::find($sizeId);
        $constraint = [' ', '-', '_'];

        $productName = str_replace($constraint, '', $product->name);
        $startName = substr($productName, 0, 2);
        $endName = substr($productName, -1);

        $sizeName = str_replace($constraint, '', substr($size->url, 0, 2));
        $colorName = str_replace($constraint, '', substr($color->url, 0, 3));
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
}
