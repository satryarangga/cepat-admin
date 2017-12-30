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
use App\Models\ProductCountdown;

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
            'category' => Category::all()
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

        $create = [
            'name'  => $request->input('name'),
            'original_price' => parseMoneyToInteger($request->input('original_price')),
            'weight' => (float) str_replace(',', '.', $request->input('weight')),
            'description' => $request->input('description'),
            'created_by' => $user->id,
            'has_variant'   => $request->input('has_variant'),
            'partner_id'    => ($user->partner_id) ? $user->partner_id : 0
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

        if($request->input('has_variant') == 0) {
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
                        'default' => ($x == 1) ? 1 : 0,
                        'created_by' => Auth::id()
                    ]);
                }
            }
            $createVariant = $this->model->insertVariantProduct($created->id);
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

        $detail = $this->model->find($id);
        $data = [
            'page' => $this->page,
            'row' => $detail,
            'category' => Category::all(),
            'categoryMap' => $cat,
            'seo' => ProductSeo::where('product_id', $id)->first()
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

        $update = [
            'name'  => $request->input('name'),
            'original_price' => parseMoneyToInteger($request->input('original_price')),
            'weight' => (float) str_replace(',', '.', $request->input('weight')),
            'description' => $request->input('description'),
            'updated_by' => Auth::id(),
        ];

        $data->update($update);

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
        $data = ProductSeo::where('product_id', $id)->first();
        if(isset($data->id)) {
            $data->meta_description = $request->input('meta_description');
            $data->meta_keywords = $request->input('meta_keywords');
            $data->save();
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
                        'default' => ($x == 1) ? 1 : 0,
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
        $time = $hour[0].':'.$hour[1].':00';
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
        $data = ProductCountdown::find($id)->delete();

        $message = setDisplayMessage('success', "Success to stop countdown time for $product_name");
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }

    public function expiredCountdown() {
        $data = ProductCountdown::where('end_on', '<', date('Y-m-d H:i:s'))->delete();
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