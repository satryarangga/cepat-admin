<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryMap extends Model
{
    /**
     * @var string
     */
    protected $table = 'category_maps';

    /**
     * @var array
     */
    protected $fillable = [
        'category_id', 'product_id'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';
}
