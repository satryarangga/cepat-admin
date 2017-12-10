<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderHead;
use App\Models\OrderItem;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        if($user->user_type == 2) {
            return redirect('/dashboard-partner');
        }

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

    public function partner()
    {
        $user = Auth::user();
        $item = new OrderItem();
        $data = [
            'page'  => 'dashboard',
            'num_order' => $item->getPartnerTodayOrder($user->partner_id),
            'num_purchase' => $item->getPartnerTodayPurchase($user->partner_id),
            'num_user' => $item->getPartnerUniqueBuyer($user->partner_id),
            'num_item' => $item->getTodaySoldItem($user->partner_id)
        ];
        return view('dashboard-partner', $data);
    }
}
