<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestPartner extends Model
{
	use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'request_partner';

    /**
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'handphone_number', 'homephone_number', 'province_id', 'city_id', 'address',
        'status', 'updated_by'
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

    public static function getStatus ($status) {
    	switch ($status) {
    		case 1:
    			$label = 'Rejected';
    			$type = 'danger';
    			break;
    		case 2:
    			$label = 'Approved';
    			$type = 'success';
    			break;
    		default:
    			$label = 'Pending';
    			$type = 'primary';
    			break;
    	}

    	return '<span class="btn btn-'.$type.'">'.$label.'</span>';
    }

    public static function generateUsername($storeName) {
        $filter = str_replace(' ', '', strtolower($storeName));
        $shorter = substr($filter, 0, 5);
        $random = strtolower(str_random(3));
        return $shorter.$random;
    }
}
