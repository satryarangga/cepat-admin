<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSeo extends Model
{
    /**
     * @var string
     */
    protected $table = 'product_seo';

    /**
     * @var array
     */
    protected $fillable = [
        'product_id', 'meta_description', 'meta_keywords'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';
}
