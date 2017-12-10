<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderHead;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function graphSales(Request $request) {
    	$user = Auth::user();
        $order = new OrderHead();
        $item = new OrderItem();

        $result = ($user->user_type == 1) ? $order->getGraphPurchaseDaily() : $item->getPartnerGraphPurchase($user->partner_id);

        return json_encode($result);
    }
}
