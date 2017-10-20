<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
	use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'vouchers';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'description', 'discount_type', 'transaction_type', 'value', 'usage', 'start_date', 'end_date',
        'status', 'created_by', 'updated_by'
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
