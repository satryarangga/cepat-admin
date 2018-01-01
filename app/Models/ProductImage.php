<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'product_images';

    /**
     * @var array
     */
    protected $fillable = [
        'product_id', 'color_id', 'url', 'defaults', 'created_by', 'updated_by'
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

    public static function listByProductID($productId) {
        $data = parent::where('product_id', $productId)->get();

        $image = [];
        foreach ($data as $key => $value) {
            $image[$value->color_id][] = $value;
        }

        return $image;
    }
}
