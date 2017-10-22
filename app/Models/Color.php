<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'colors';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'hexa', 'url', 'created_by', 'updated_by', 'status'
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

    public static function getAvailableColor($productId) {
        $variant = ProductVariant::where('product_id', $productId)
                                ->where('deleted_at', null)
                                ->get();
        $colorTaken = [];
        foreach ($variant as $key => $value) {
            $colorTaken[] = $value->color_id;
        }

        $data = parent::whereNotIn('id', $colorTaken)->get();
        return $data;
    }
}
