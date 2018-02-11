<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoDetail extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'promo_detail';

    /**
     * @var array
     */
    protected $fillable = [
        'promo_id', 'product_id', 'promo_price', 'created_by', 'updated_by'
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

    public static function listProduct($promoId) {
        $data = parent::select('promo_detail.id as id', 'original_price', 'products.id as product_id', 'products.name', 'promo_price')
                        ->leftJoin('products', 'products.id', '=', 'promo_detail.product_id')
                        ->where('promo_id', $promoId)
                        ->get();
        return $data;
    }
}
