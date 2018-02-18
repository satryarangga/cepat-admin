<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    /**
     * @var string
     */
    protected $table = 'banners';

    /**
     * @var array
     */
    protected $fillable = [
        'filename', 'position', 'status', 'created_by', 'updated_by', 'link', 'target'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';
}
