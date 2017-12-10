<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderHead;
use App\Models\OrderDelivery;
use App\Models\OrderDiscount;
use App\Models\OrderItem;
use App\Models\OrderLog;
use App\Models\OrderPayment;
use App\Models\ProductVariant;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller 
{
    /**
     * @var string
     */
    private $module;

    /**
     * @var string
     */
    private $page;

    /**
     * @var string
     */
    private $model;

    public function __construct() {
		$this->model = new OrderHead();
		$this->module = 'order.order-partner';
		$this->page = 'order-partner';
        $this->middleware('auth');
    }

    public function index($status, Request $request) {
    	$filter = [
    		'search_by'	=> $request->input('search_by'),
    		'keyword'	=> $request->input('keyword'),
            'status'    => $status
    	];

    	$sort = ($request->input('sort_by')) ? $request->input('sort_by') : 'id';

    	$list = $this->model->orderPartnerList($filter, $sort);

    	$data = [
    		'result'	=> $list,
    		'filter'	=> $filter,
    		'sort'		=> $sort,
    		'page'		=> $this->page,
            'status'    => $status,
            'title'     => $this->setTitle($status)
    	];

    	return view($this->module . ".index", $data);
    }

    public function detail($orderId) {
        $user = Auth::user();
    	$headId = $this->model->find($orderId);
        $customer = Customer::find($headId->customer_id);
    	$items = OrderItem::getItemDetail($orderId, $user->partner_id);
    	$payment = OrderPayment::getPaymentOrder($orderId);
        $durationToExpired = config('cepat.order_expired_duration');
        $dueDate = date('j F Y', strtotime($headId->date. " +$durationToExpired days"));
        $isItemShipped = OrderItem::isItemShipped($items);
        $delivery = OrderDelivery::where('order_id', $orderId)->first();

    	$data = [
    		'id'	=> $orderId,
    		'page'		=> $this->page,
    		'head'		=> $headId,
    		'title'		=> 'Purchase '.$headId->purchase_code,
    		'items'		=> $items,
    		'payment'	=> $payment,
            'dueDate'   => $dueDate,
            'delivery'  => $delivery,
            'customer'  => $customer,
            'isItemShipped' => $isItemShipped,
            'shipping_status'   => config('cepat.shipping_status')
    	];
    	return view($this->module . ".detail", $data);	
    }

    private function setTitle($status) {
        if($status == 'to_approve') {
            return "List Order to Approve";
        }

        if($status == 'to_ship') {
            return "List Order to Ship";
        }

        return "All Order";
    }

}
