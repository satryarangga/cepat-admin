<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'size';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'url', 'created_by', 'updated_by', 'status'
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

    public static function getAvailableSize($productId, $colorId) {
        $variant = ProductVariant::where('product_id', $productId)
                                    ->where('color_id', $colorId)
                                    ->where('deleted_at', null)
                                    ->get();
        $sizeTaken = [];
        foreach ($variant as $key => $value) {
            $sizeTaken[] = $value->size_id;
        }

        $data = parent::whereNotIn('id', $sizeTaken)->get();
        return $data;
    }
}
