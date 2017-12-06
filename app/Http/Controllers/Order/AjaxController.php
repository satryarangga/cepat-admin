<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderHead;

class AjaxController extends Controller
{
    public function graphSales(Request $request) {
        $order = new OrderHead();
        $result = $order->getGraphPurchaseDaily();

        return json_encode($result);
    }
}
