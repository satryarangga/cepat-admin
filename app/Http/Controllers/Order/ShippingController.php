<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use App\Models\City;

class ShippingController extends Controller 
{
    /**
     * @var string
     */
    private $module;

    /**
     * @var string
     */
    private $page;

    public function __construct() {
		$this->module = 'order.shipping';
		$this->page = 'shipping';
        $this->middleware('auth');
    }

    public function checkCost(Request $request) {
        if($request->input()) {
            $sender_city_id = $request->input('sender_city_id');
            $receiver_city_id = $request->input('receiver_city_id');
            $weight = $request->input('weight');
            $sender_province_name = $request->input('sender_province_name');
            $receiver_province_name = $request->input('receiver_province_name');
            $sender_province_id = $request->input('sender_province_id');
            $receiver_province_id = $request->input('receiver_province_id');
            $courier = $request->input('courier');

            $key = config('cepat.rajaongkir_key');
            $params['form_params'] = [
                'key'           => $key,
                'origin'        => $sender_city_id,
                'originType'    => 'city',
                'destination'   => $receiver_city_id,
                'weight'        => $weight,
                'destinationType' => 'city',
                'courier'       => implode(':', $courier)
            ];
            $url = config('cepat.rajaongkir_url')."/cost";
            $client = new Client();
            $res = $client->request('POST', $url, $params);
            $res =  json_decode($res->getBody(), true);
            $cost = $res['rajaongkir']['results'];
        }
        $data = [
            'page'  => $this->page,
            'cost'  => isset($cost) ? $cost : [],
            'sender_province_name'  => isset($sender_province_name) ? $sender_province_name : null,
            'receiver_province_name'  => isset($receiver_province_name) ? $receiver_province_name : null,
            'sender_province_id'  => isset($sender_province_id) ? $sender_province_id : null,
            'receiver_province_id'  => isset($receiver_province_id) ? $receiver_province_id : null,
            'sender_city_id'  => isset($sender_city_id) ? $sender_city_id : null,
            'receiver_city_id'  => isset($receiver_city_id) ? $receiver_city_id : null,
            'weight'  => isset($weight) ? $weight : null,
            'courier'    => config('cepat.rajaongkir_courier'),
            'selectedCourier'   => isset($courier) ? $courier : []
        ];
        return view($this->module . '.check-cost', $data);
    }

    public function exportCity() {
        $key = config('cepat.rajaongkir_key');
        $url = config('cepat.rajaongkir_url')."/city?key=$key";

        $client = new Client();
        $res = $client->request('GET', $url);
        $data =  json_decode($res->getBody(), true);

        City::truncate();
        foreach ($data['rajaongkir']['results'] as $key => $value) {
            City::create([
                'name'          => $value['city_name'],
                'province_id'   => $value['province_id'],
                'status'        => 1,
                'type'          => $value['type']
            ]);
        }

        echo 'Done'; die;
    }

    protected function formatCost($cost) {
        foreach ($cost as $key => $value) {
            
        }
    }
}
