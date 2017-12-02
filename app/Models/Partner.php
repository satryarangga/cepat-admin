<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use App\Mail\PartnerNotif;

class Partner extends Model
{
    /**
     * @var string
     */
    protected $table = 'partners';

    /**
     * @var array
     */
    protected $fillable = [
        'store_name', 'owner_name', 'email', 'handphone_number', 'homephone_number', 'province_id', 'city_id', 'address',
        'postcode', 'bank_acc_no', 'bank_acc_name', 'status'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public static function sendEmailNotif($status, $data) {
        Mail::to($data->email)->send(new PartnerNotif($data, $status));
    }
}
