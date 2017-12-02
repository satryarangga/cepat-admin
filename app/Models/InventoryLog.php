<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    /**
     * @var string
     */
    protected $table = 'inventory_logs';

    /**
     * @var array
     */
    protected $fillable = [
        'product_id', 'purchase_code', 'user_id', 'SKU', 'qty', 'type', 'description', 'source', 'product_variant_id', 'order_id'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    public static function getSource($source) {
    	switch ($source) {
    		case 1:
    			return 'Front End';
    		break;
    		case 2:
    			return 'Admin Panel';
    		break;
    		case 2:
    			return 'Cron';
    		break;
    		default:
    			return 'Unknown';
    		break;
    	}
    }
}
