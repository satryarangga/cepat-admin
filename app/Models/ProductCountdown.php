<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCountdown extends Model
{
    protected $table = 'product_countdown';

    /**
     * @var array
     */
    protected $fillable = [
        'product_id', 'duration', 'start_on', 'end_on', 'status', 'created_by', 'updated_by'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';
}
