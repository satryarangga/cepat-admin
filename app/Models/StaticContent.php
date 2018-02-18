<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaticContent extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'static_content';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'url', 'type', 'content', 'created_by', 'updated_by'
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
