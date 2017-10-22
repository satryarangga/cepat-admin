<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryChild extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'category_childs';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'parent_id', 'url', 'created_by', 'updated_by', 'status'
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
