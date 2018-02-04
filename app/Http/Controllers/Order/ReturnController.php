<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderHead;
use App\Models\OrderItem;
use App\Models\OrderReturn;
use App\Models\ProductVariant;
use App\Models\InventoryLog;
use Illuminate\Support\Facades\Auth;

class ReturnController extends Controller 
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
		$this->model = new OrderReturn();
		$this->module = 'order.return';
		$this->page = 'return';
    }

    public function index (Request $request) {
        $return = $this->model->list();
        $data = [
            'result'    => $return,
            'page'      => $this->page
        ];
        return view($this->module . ".index", $data);
    }

    public function changeStatus($id, $status) {
        $data = $this->model->find($id);

        $data->status = $status;

        $desc = ($status == 1) ? 'received' : 'void received';

        $data->save();

        logUser($desc.' return '.$data->order_item_id);

        // TO DO CHANGE INVENTORY AND LOG PRODUCT
        $orderItemId = $data->order_item_id;
        $order = OrderItem::find($orderItemId);
        $purchaseCode = OrderHead::where('id', $order->order_id)->value('purchase_code');
        $qty = $order->qty;
        $variant = ProductVariant::find($order->product_variant_id);
        $variant->qty_order = ($status == 1) ? $variant->qty_order + $qty : $variant->qty_order - $qty;
        $variant->qty_warehouse = ($status == 1) ? $variant->qty_warehouse + $qty : $variant->qty_warehouse - $qty;
        $variant->save();

        InventoryLog::create([
            'product_id'    => $variant->product_id,
            'purchase_code' => $purchaseCode,
            'product_variant_id' => $variant->id,
            'order_id'      => $order->order_id,
            'user_id'       => Auth::id(),
            'SKU'           => $variant->SKU,
            'qty'           => $qty,
            'type'          => ($status == 1) ? 1 : 2,
            'description'   => ($status == 1) ? 'Return Order Received' : 'Void Received Return',
            'source'        => 2 // ADMIN
        ]);

        $message = setDisplayMessage('success', "Success to $desc ".$this->page);
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }

    public function edit ($id, $status) {
        $return = $this->model->list();
        $data = [
            'result'    => $return,
            'page'      => $this->page
        ];
        return view($this->module . ".index", $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->model->find($id);
        $data->delete();
        logUser('Delete Return Order '.$data->order_item_id);

        $message = setDisplayMessage('success', "Success to delete ".$this->page);
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }
}
