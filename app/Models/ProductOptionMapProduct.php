<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOptionMapProduct extends Model
{
    /**
     * @var string
     */
    protected $table = 'product_option_map_product';

    /**
     * @var array
     */
    protected $fillable = [
        'product_option_id', 'product_option_value_id', 'product_id'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    public static function map($productId, $options) {
        parent::where('product_id', $productId)->delete();
        foreach ($options as $value) {
            $opt = explode(';', $value);
            $option = $opt[0];
            $optionValue = $opt[1];

            parent::create([
                'product_id'    => $productId,
                'product_option_id' => $option,
                'product_option_value_id'   => $optionValue
            ]);
        }
    }
}
