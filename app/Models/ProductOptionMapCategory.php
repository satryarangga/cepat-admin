<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOptionMapCategory extends Model
{
    /**
     * @var string
     */
    protected $table = 'product_option_map_category';

    /**
     * @var array
     */
    protected $fillable = [
        'product_option_id', 'category_id'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';
}
