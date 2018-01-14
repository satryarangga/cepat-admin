<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerRegistration;
use App\Mail\CustomerForgotPassword;

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
        'first_name', 'last_name', 'email', 'password', 'addr_street', 'addr_city_id',
        'addr_province_id', 'addr_zipcode', 'phone', 'birthdate', 'status', 'wallet', 'gender'
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

    public function listWalletLog($list) {
        $wallet = [];
        foreach ($list as $key => $value) {
            $data = WalletLog::where('customer_id', $value->id)->get();
            $list[$key]->wallet_logs = $data;
        }
        return $list;
    }

    public function getTodayRegister() {
        $data = parent::whereRaw("DATE(created_at) = '".date('Y-m-d')."' ")->count();
        return $data;
    }

    public static function sendEmailNotif($data) {
        Mail::to($data->email)->send(new CustomerRegistration($data));
    }

    public static function sendResetPassword($data, $token) {
        Mail::to($data->email)->send(new CustomerForgotPassword($data, $token));
    }
}
