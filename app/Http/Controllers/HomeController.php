<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderHead;
use App\Models\OrderItem;
use App\Models\Customer;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = new OrderHead();
        $item = new OrderItem();
        $customer = new Customer();
        $data = [
            'page'  => 'dashboard',
            'num_order' => $order->getTodayOrder(),
            'num_purchase' => $order->getTodayPurchase(),
            'num_user' => $customer->getTodayRegister(),
            'num_item' => $item->getTodaySoldItem()
        ];
        return view('dashboard', $data);
    }
}
