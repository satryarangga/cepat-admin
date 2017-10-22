<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryParent extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'category_parents';

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
}
