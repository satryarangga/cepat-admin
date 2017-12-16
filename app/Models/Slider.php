<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    /**
     * @var string
     */
    protected $table = 'sliders';

    /**
     * @var array
     */
    protected $fillable = [
        'filename', 'caption', 'status', 'created_by', 'updated_by', 'link', 'target'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';
}
