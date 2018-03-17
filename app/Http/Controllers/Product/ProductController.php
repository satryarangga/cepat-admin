<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryMap;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\ProductSeo;
use App\Models\InventoryLog;
use App\Models\ProductCountdown;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use App\Models\ProductOptionMapProduct;

class ProductController extends Controller
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
        $this->model = new Product();
        $this->module = 'product.product-manage';
        $this->page = 'product-manage';
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = [
            'search_by' => $request->input('search_by'),
            'keyword' => $request->input('keyword')
        ];
        $productModel = new Product();
        $list =  $productModel->getListProduct($filter);
        $data = [
            'result' => $list,
            'page' => $this->page,
            'title' => 'Product',
            'filter' => $filter,
        ];
        return view($this->module . ".index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'page' => $this->page,
            'category' => Category::all(),
            'options'   => ProductOption::all()
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
        $user = Auth::user();
        $this->validate($request,[
            'name'     => 'required',
            'weight'    => 'required',
            'original_price'    => 'required',
            'category'    => 'required',
            'has_variant'   => 'required'
        ]);

        $discount_price = $request->input('original_price');
        if($request->input('discount_price') && $request->input('discount_price') != '0') {
            $discount_price = $request->input('discount_price');
        }

        $create = [
            'name'  => $request->input('name'),
            'original_price' => parseMoneyToInteger($request->input('original_price')),
            'discount_price' => parseMoneyToInteger($discount_price),
            'weight' => (float) str_replace(',', '.', $request->input('weight')),
            'description' => $request->input('description'),
            'created_by' => $user->id,
            'has_variant'   => $request->input('has_variant'),
            'partner_id'    => ($user->partner_id) ? $user->partner_id : 1
        ];

        $created = $this->model->create($create);

        $category = $request->input('category');
        foreach ($category as $key => $value) {
            CategoryMap::create([
                'category_id'    => $value,
                'product_id'     => $created->id
            ]);
        }

        ProductSeo::create([
            'product_id'    => $created->id,
            'meta_description' => $request->input('meta_description'),
            'meta_keywords' => $request->input('meta_keywords')
        ]);

        $options = ($request->input('options')) ? $request->input('options') : [];
        $mapProductOptions = ProductOptionMapProduct::map($created->id, $options);

        if($request->input('has_variant') == 0) { // NO VARIANT
            if ($request->file('image')) {
                $x = 0;
                foreach ($request->file('image') as $key => $value) {
                    $x++;
                    $ext = $value->getClientOriginalExtension();
                    $random = strtoupper(str_random(5));
                    $name = $created->id . '-0-' . $random.'.'.$ext;
                    $value->move(
                        base_path() . '/public/images/product/'. $created->id . '/0/' ,$name
                    );

                    ProductImage::create([
                        'product_id'    => $created->id,
                        'color_id'    => 0,
                        'url'    => $name,
                        'defaults' => ($x == 1) ? 1 : 0,
                        'created_by' => Auth::id()
                    ]);
                }
            }
            $createVariant = $this->model->insertVariantProduct($created->id);
            InventoryLog::create([
                'product_id'    => $created->id,
                'purchase_code' => '',
                'user_id'       => Auth::id(),
                'SKU'           => $createVariant->SKU,
                'qty'           => 0,
                'type'          => 1,
                'description'   => "Created",
                'source'        => 2 // ADMIN
            ]);
        }
        logUser('Create Product '.$create['name']);

        $message = setDisplayMessage('success', "Success to create new ".$this->page);
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoryMap = CategoryMap::where('product_id', $id)->pluck('category_id');
        $cat = [];

        foreach ($categoryMap as $key => $value) {
            $cat[] = $value;
        }

        $mapOption = ProductOptionMapProduct::where('product_id', $id)->get();

        $detail = $this->model->find($id);
        $detail->discount_price = ($detail->discount_price == $detail->original_price) ? null : $detail->discount_price;
        $data = [
            'page' => $this->page,
            'row' => $detail,
            'category' => Category::all(),
            'categoryMap' => $cat,
            'seo' => ProductSeo::where('product_id', $id)->first(),
            'options'   => ProductOption::all(),
            'mapOption' => $mapOption
        ];

        if($detail->has_variant == 0) {
            $data['images'] = ProductImage::where('product_id', $id)->get();
        }

        return view($this->module.".edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'     => 'required',
            'weight'    => 'required',
            'original_price'    => 'required',
            'category'    => 'required',
        ]);

        $data = $this->model->find($id);

        $discount_price = $request->input('original_price');
        if($request->input('discount_price') && $request->input('discount_price') != '0') {
            $discount_price = $request->input('discount_price');
        }
        $update = [
            'name'  => $request->input('name'),
            'original_price' => parseMoneyToInteger($request->input('original_price')),
            'discount_price' => parseMoneyToInteger($discount_price),
            'weight' => (float) str_replace(',', '.', $request->input('weight')),
            'description' => $request->input('description'),
            'has_variant'   => $request->input('has_variant'),
            'updated_by' => Auth::id(),
        ];

        $data->update($update);

        $options = ($request->input('options')) ? $request->input('options') : [];
        $mapProductOptions = ProductOptionMapProduct::map($id, $options);

        // CATEGORY MAP PROCESS
        CategoryMap::where('product_id', $id)->delete();
        $category = $request->input('category');
        foreach ($category as $key => $value) {
            CategoryMap::create([
                'category_id'    => $value,
                'product_id'     => $id
            ]);
        }

        // PRODUCT SEO
        $dataSeo = ProductSeo::where('product_id', $id)->first();
        if(isset($dataSeo->id)) {
            $dataSeo->meta_description = $request->input('meta_description');
            $dataSeo->meta_keywords = $request->input('meta_keywords');
            $dataSeo->save();
        } else {
            ProductSeo::create([
                'product_id'    => $id,
                'meta_description' => $request->input('meta_description'),
                'meta_keywords' => $request->input('meta_keywords')
            ]);
        }

        if($data->variant == 0) {
            if ($request->file('image')) {
                $x = 0;
                foreach ($request->file('image') as $key => $value) {
                    $x++;
                    $ext = $value->getClientOriginalExtension();
                    $random = strtoupper(str_random(5));
                    $name = $id . '-0-' . $random.'.'.$ext;
                    $value->move(
                        base_path() . '/public/images/product/'. $id . '/0/' ,$name
                    );

                    ProductImage::create([
                        'product_id'    => $id,
                        'color_id'    => 0,
                        'url'    => $name,
                        'defaults' => ($x == 1) ? 1 : 0,
                        'created_by' => Auth::id()
                    ]);
                }
            }
        }

        logUser('Update Product '.$update['name']);

        $message = setDisplayMessage('success', "Success to update ".$this->page);
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
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

        // DELETE VARIANT
        ProductVariant::where('product_id', $id)->delete();
        ProductImage::where('product_id', $id)->delete();
        CategoryMap::where('product_id', $id)->delete();
        ProductSeo::where('product_id', $id)->delete();

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

    public function setCountdown(Request $request) {
        $type = $request->input('type');
        $value = $request->input('value');
        $product_id = $request->input('product_id');
        $product_name = $request->input('product_name');
        $start_date = $request->input('start_date');
        $start_time = $request->input('start_time');

        $time = explode(' ', $start_time);
        $hour = explode(':', $time[0]);
        if($time[1] == 'PM') {
            $hour[0] = (int) $hour[0] + 12;
        }
        $validHour = ($hour[0] == '24' && $time[1] == 'PM') ? 12 : $hour[0];
        $time = $validHour.':'.$hour[1].':00';
        $start = $start_date.' '.$time;

        if($type == 1) { // DAYS
            $seconds = 86400 * $value;
        } else if($type == 2) {
            $seconds = 3600 * $value;
        } else if($type == 3) {
            $seconds = 60 * $value;
        } else {
            $seconds = $value;
        }

        $time = strtotime($start);
        $ended = $time + $seconds;
        ProductCountdown::create([
            'product_id'    => $product_id,
            'duration'      => $seconds,
            'status'        => 1,
            'start_on'      => $start,
            'end_on'      => date('Y-m-d H:i:s', $ended),
            'created_by'    => Auth::id()
        ]);

        $message = setDisplayMessage('success', "Success to set countdown time for $product_name");
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }

    public function stopCountdown($id, $product_name) {
        $data = ProductCountdown::find($id);
        Product::find($data->product_id)->update([
            'status'    => 1
        ]);

        $data->delete();

        $message = setDisplayMessage('success', "Success to stop countdown time for $product_name");
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }

    public function expiredCountdown() {
        $now = date('Y-m-d H:i:s');
        $data = ProductCountdown::where('end_on', '<', $now)->get();

        foreach ($data as $key => $value) {
            $product = Product::find($value->product_id);
            $product->status = 2;
            $product->save();
        }

        ProductCountdown::where('end_on', '<', $now)->delete();
        
        return redirect(route($this->page.'.index'));
    }

    public function deleteImage(Request $request) {
        $image_id = $request->input('image_id');
        $product_id = $request->input('product_id');
        $data = ProductImage::find($image_id);
        $data->delete();
        logUser('Delete Product Image');
        $message = setDisplayMessage('success', "Success to delete product image");
        return redirect(route($this->page.'.edit', ['id' => $product_id]))->with('displayMessage', $message);
    }
}