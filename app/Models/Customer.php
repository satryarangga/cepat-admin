<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * @var string
     */
    protected $table = 'customers';

    /**
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'addr_street', 'addr_city_name', 'addr_city_id',
        'add_province_name', 'addr_province_id', 'addr_zipcode', 'phone', 'birthdate', 'status', 'wallet', 'gender'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    public function list($query = []) {
    	$limit = (isset($query['limit'])) ? $query['limit'] : 1000000;
    	$offset = (isset($query['offset'])) ? $query['offset'] : 0;

    	$data = parent::limit($limit)
    			->offset($offset)
    			->paginate($limit);

    	return $data;
    }
}
