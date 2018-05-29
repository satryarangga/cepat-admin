<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'payment_method';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'logo', 'desc', 'minimum_payment', 'confirm_type', 'use_paycode', 'status', 'created_by', 'updated_by', 'code',
        'is_virtual_account', 'va_bank_code'
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
