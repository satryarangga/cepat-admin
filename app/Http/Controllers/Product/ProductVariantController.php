<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Color;
use App\Models\Size;

class ProductVariantController extends Controller
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
        $this->model = new ProductVariant();
        $this->module = 'product.product-variant';
        $this->page = 'product-variant';
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product_id = $request->input('product_id');
        if(!$product_id) {
            abort(404);
        }
        $product = Product::findOrFail($product_id);
        $data = [
            'resultPerColor' => $this->model->listByColor($product_id),
            'resultPerSize' => $this->model->listBySize($product_id),
            'page' => $this->page,
            'title' => 'List Variant Color '.$product->name,
            'product' => $product,
        ];
        return view($this->module . ".index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $product_id = $request->input('product_id');
        if(!$product_id) {
            abort(404);
        }
        $product = Product::findOrFail($product_id);
        $data = [
            'page' => $this->page,
            'title' => 'Create Variant Color '.$product->name,
            'product' => $product,
            'color' => Color::getAvailableColor($product_id),
            'size'  => Size::all()
        ];

        return view($this->module.".create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'size_id'     => 'required',
            'color_id'    => 'required',
            'qty'    => 'required',
            'product_id'    => 'required'
        ]);

        $create = [
            'color_id'  => $request->input('color_id'),
            'size_id'  => $request->input('size_id'),
            'product_id'  => $request->input('product_id'),
            'default'  => 1,
            'qty_order'  => $request->input('qty'),
            'qty_warehouse'  => $request->input('qty'),
            'max_order_qty'  => 100, // TEMPORARY, WILL CHANGE IF NEEDED BY
            'status'   => 0,
            'created_by' => Auth::id()
        ];

        $create['SKU'] = $this->model->generateSKU($create['product_id'], $create['color_id'], $create['size_id']);

        $created = $this->model->create($create);

        $log = 'Create Product Variant Product ID:'.$create['product_id']. ' Color : '. $create['color_id'] . ' Size:'.$create['size_id'];
        logUser($log);

        $message = setDisplayMessage('success', "Success to create new ".$this->page);
        return redirect(route($this->page.'.index').'?product_id='.$create['product_id'])->with('displayMessage', $message);
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
        $message = setDisplayMessage('success', "Success to delete ".$this->page);
        logUser('Delete Product '.$data->name);
        $data->deleted_at = date('Y-m-d H:i:s');
        $data->save();
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }

    /**
     * @param $id
     * @param $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus($id, $status) {
        $data = $this->model->find($id);

        if($status == 1) { // ACTIVATE CUSTOMER
            $desc = 'activate';
        } else {
            $desc = 'deacticate';
        }

        $data->status = $status;
        $data->save();

        logUser('Change Status Product '.$data->name);

        $message = setDisplayMessage('success', "Success to $desc ".$this->page);
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }

    public function changeStatusSize(Request $request) {
        $variant_id = $request->input('variant_id');
        $status = $request->input('status');
        $data = $this->model->find($variant_id);

        $data->status = $status;
        $data->save();

        logUser('Change Status Product Variant Size');
        return 1;
    }

    public function deleteSize(Request $request) {
        $variant_id = $request->input('variant_id');
        $data = $this->model->find($variant_id);
        $data->delete();
        logUser('Delete Product Variant Size');
        return 1;
    }
}
