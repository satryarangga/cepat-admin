<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * @var string
     */
    protected $table = 'cities';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'province_id', 'status', 'type'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';
}
