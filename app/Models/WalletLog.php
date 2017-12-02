<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletLog extends Model
{
    protected $table = 'wallet_log';

    /**
     * @var array
     */
    protected $fillable = [
        'customer_id', 'purchase_code', 'description', 'adjusted_by', 'amount', 'type'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';
}
