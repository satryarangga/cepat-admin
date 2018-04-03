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

class OrderController extends Controller 
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
		$this->module = 'order.order-manage';
		$this->page = 'order-manage';
        $this->middleware('auth', ['except' => ['sendEmailOrder']]);
    }

    public function index($status, Request $request) {
    	$filter = [
    		'search_by'	=> $request->input('search_by'),
    		'keyword'	=> $request->input('keyword'),
            'status'    => $status
    	];

    	$sort = ($request->input('sort_by')) ? $request->input('sort_by') : 'id';

    	$list = $this->model->orderList($filter, $sort);

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
    	$headId = $this->model->find($orderId);
        $customer = Customer::find($headId->customer_id);
    	$items = OrderItem::getItemDetail($orderId);
    	$payment = OrderPayment::getPaymentOrder($orderId);
    	$discount = OrderDiscount::where('order_id', $orderId)->first();
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
    		'discount'	=> $discount,
            'delivery'  => $delivery,
            'dueDate'   => $dueDate,
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

    public function changeStatus($orderId, $type) {
        $item = OrderItem::where('order_id', $orderId)->get();

        foreach ($item as $key => $value) {
            OrderLog::create([
                'order_id'          => $orderId,
                'order_item_id'     => $value->id,
                'desc'              => ($type == 1) ? 'Set Paid' : 'Void Paid',
                'done_by'           => Auth::id()
            ]);

            OrderItem::find($value->id)->update([
                'purchase_status'   => ($type == 1) ? 3 : 1,
                'approved_time'     => ($type == 1) ? date('Y-m-d H:i:s') : null
            ]);
        }

        OrderPayment::where('order_id', $orderId)->update([
            'status'    => ($type == 1) ? 2 : 0
        ]);

        if($type == 1) {
            OrderHead::sendEmailNotifPayment($orderId);
        }

        $message = setDisplayMessage('success', "Success to change status");
        return redirect(route($this->page.'.detail', ['id' => $orderId]))->with('displayMessage', $message);
    }

    public function setShipment(Request $request) {
        $resi = $request->input('resi');
        $orderItemId = $request->input('order_item_id');
        $status = $request->input('status');
        $notes = $request->input('notes');
        $listStatus = config('cepat.shipping_status');

        $item = OrderItem::find($orderItemId);

        $item->update([
                    'shipping_status'   => $status,
                    'resi'              => $resi,
                    'shipping_notes'    => $notes
                ]);

        OrderLog::create([
            'order_id'          => $item->order_id,
            'order_item_id'     => $orderItemId,
            'desc'              => $listStatus[$status].' '.$notes,
            'done_by'           => Auth::id()
        ]);

        OrderItem::sendEmailNotifShipping($orderItemId, $status);

        // DEDUCT QTY WAREHOUSE
        ProductVariant::variantShipped($item->product_variant_id, $item->qty, $item->order_id, $status);

        $message = setDisplayMessage('success', "Success to ship order item");
        return redirect(route($this->page.'.detail', ['id' => $item->order_id]))->with('displayMessage', $message);
    }

    public function sendEmailOrder($orderId) {
        OrderHead::sendEmailOrder($orderId);
        return 'Done';
    }

    public function print($orderId) {
        $headId = $this->model->find($orderId);
        $customer = Customer::find($headId->customer_id);
        $items = OrderItem::getItemDetail($orderId);
        $payment = OrderPayment::getPaymentOrder($orderId);
        $discount = OrderDiscount::where('order_id', $orderId)->first();
        $durationToExpired = config('cepat.order_expired_duration');
        $dueDate = date('j F Y', strtotime($headId->date. " +$durationToExpired days"));
        $isItemShipped = OrderItem::isItemShipped($items);
        $delivery = OrderDelivery::where('order_id', $orderId)->first();

        $data = [
            'id'    => $orderId,
            'page'      => $this->page,
            'head'      => $headId,
            'title'     => 'Purchase '.$headId->purchase_code,
            'items'     => $items,
            'payment'   => $payment,
            'discount'  => $discount,
            'delivery'  => $delivery,
            'dueDate'   => $dueDate,
            'customer'  => $customer,
            'isItemShipped' => $isItemShipped,
            'shipping_status'   => config('cepat.shipping_status')
        ];
        return view($this->module . ".print", $data);        
    }
}
