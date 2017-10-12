<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    /**
     * @var string
     */
    protected $table = 'provinces';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'status'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';
}
