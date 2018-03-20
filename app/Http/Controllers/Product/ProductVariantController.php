<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\InventoryLog;
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
            'resultPerImage' => ProductImage::listByProductID($product_id),
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
            'defaults'  => 1,
            'qty_order'  => $request->input('qty'),
            'qty_warehouse'  => $request->input('qty'),
            'max_order_qty'  => 100, // TEMPORARY, WILL CHANGE IF NEEDED BY
            'status'   => 0,
            'created_by' => Auth::id()
        ];

        $create['SKU'] = $this->model->generateSKU($create['product_id'], $create['color_id'], $create['size_id']);

        $created = $this->model->create($create);

        // IMAGE PROCESS
        if ($request->file('image')) {
            $x = 0;
            foreach ($request->file('image') as $key => $value) {
                $x++;
                $ext = $value->getClientOriginalExtension();
                $random = strtoupper(str_random(5));
                $name = $create['product_id'] . '-' . $create['color_id'] . '-' . $random.'.'.$ext;
                $value->move(
                    base_path() . '/public/images/product/'. $create['product_id'] . '/' . $create['color_id'] . '/' ,$name
                );

                ProductImage::create([
                    'product_id'    => $create['product_id'],
                    'color_id'    => $create['color_id'],
                    'url'    => $name,
                    'defauls' => ($x == 1) ? 1 : 0,
                    'created_by' => Auth::id()
                ]);
            }
        }

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

    public function deleteImage(Request $request) {
        $image_id = $request->input('image_id');
        $data = ProductImage::find($image_id);
        $data->delete();
        logUser('Delete Product Image');
        return 1;
    }

    public function addImage(Request $request) {
        $colorId = $request->input('color_id');
        $productId = $request->input('product_id');

        $dataColor = Color::find($colorId);

        if ($request->file('image')) {
            $x = 0;
            foreach ($request->file('image') as $key => $value) {
                $x++;
                $ext = $value->getClientOriginalExtension();
                $random = strtoupper(str_random(5));
                $name = $productId . '-' . $colorId . '-' . $random.'.'.$ext;
                $value->move(
                    base_path() . '/public/images/product/'. $productId . '/' . $colorId . '/' ,$name
                );

                ProductImage::create([
                    'product_id'    => $productId,
                    'color_id'    => $colorId,
                    'url'    => $name,
                    'defaults' => ($x == 1) ? 1 : 0,
                    'created_by' => Auth::id()
                ]);
            }
        }
        $colorName = isset($dataColor->name) ? $dataColor->name : $colorId;
        $message = setDisplayMessage('success', "Success to add image for variant color ".$colorName);
        return redirect(route($this->page.'.index').'?product_id='.$productId)->with('displayMessage', $message);
    }

    public function inventoryControl(Request $request) {
        $filter = [
            'search_by' => $request->input('search_by'),
            'keyword' => $request->input('keyword')
        ];
        $variantModel = new ProductVariant();
        $listSKU =  $variantModel->getListSKU($filter);


        foreach ($listSKU as $key => $value) {
            $logs = InventoryLog::where('SKU', $value->SKU)->get();
            $listSKU[$key]->logs = $logs;
        }

        $data = [
            'list'  => $listSKU,
            'page' => 'inventory-control',
            'filter' => $filter,
            'inventoryLog'  => new InventoryLog()
        ];

        return view($this->module . ".inventory-control", $data);
    }

    public function changeInventory(Request $request) {
        $current = $request->input('current');
        $new = $request->input('new');
        $reason = $request->input('reason');
        $sku = $request->input('sku');
        $delta = $new - $current;

        $data = ProductVariant::where('SKU', $sku)->first();
        $productId = $data->product_id;
        $newQtyOrder = $data->qty_order + $delta;

        $data->qty_order = $new;
        $data->qty_warehouse = $new;
        $data->status = ($new > 0) ? 1 : 0;
        $data->save();

        $description = ($delta < 0) ? 'Inventory Correction Out' : 'Inventory Correction In';

        if($delta != 0) {
            InventoryLog::create([
                'product_id'    => $productId,
                'purchase_code' => '',
                'user_id'       => Auth::id(),
                'SKU'           => $sku,
                'qty'           => abs($delta),
                'type'          => ($delta < 0) ? 4 : 3,
                'description'   => ($reason) ? $description.' - '.$reason : $description,
                'source'        => 2 // ADMIN
            ]);
        }

        $message = setDisplayMessage('success', "Success to change inventory SKU ".$sku);
        return redirect(route($this->page.'.inventoryControl'))->with('displayMessage', $message);        
    }
}
