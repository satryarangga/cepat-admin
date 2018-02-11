<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoHead extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'promo_head';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'duration', 'start_on', 'end_on', 'created_by', 'updated_by', 'status', 'type', 'banner', 'url'
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
