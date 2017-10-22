<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\CategoryChild;
use App\Models\CategoryParent;
use App\Models\CategoryMap;

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
    public function index()
    {
        $data = [
            'result' => $this->model->all(),
            'page' => $this->page
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
            'categoryParent' => CategoryParent::all()
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
            'name'     => 'required',
            'weight'    => 'required',
            'original_price'    => 'required',
            'cat_parent_id'    => 'required',
            'cat_child_id'    => 'required'
        ]);

        $create = [
            'name'  => $request->input('name'),
            'original_price' => parseMoneyToInteger($request->input('original_price')),
            'weight' => (float) str_replace(',', '.', $request->input('weight')),
            'description' => $request->input('description'),
            'created_by' => Auth::id()
        ];

        $created = $this->model->create($create);

        CategoryMap::create([
            'category_parent_id'    => $request->input('cat_parent_id'),
            'category_child_id'     => $request->input('cat_child_id'),
            'product_id'            => $created->id
        ]);

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
        $data = [
            'page' => $this->page,
            'row' => $this->model->find($id),
            'categoryParent' => CategoryParent::all(),
            'categoryMap' => CategoryMap::where('product_id', $id)->first()
        ];

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
            'cat_parent_id'    => 'required',
            'cat_child_id'    => 'required'
        ]);

        $data = $this->model->find($id);

        $update = [
            'name'  => $request->input('name'),
            'original_price' => parseMoneyToInteger($request->input('original_price')),
            'weight' => (float) str_replace(',', '.', $request->input('weight')),
            'description' => $request->input('description'),
            'updated_by' => Auth::id()
        ];

        $data->update($update);

        // CATEGORY MAP PROCESS
        CategoryMap::where('product_id', $id)->delete();
        CategoryMap::create([
            'category_parent_id'    => $request->input('cat_parent_id'),
            'category_child_id'     => $request->input('cat_child_id'),
            'product_id'            => $id
        ]);

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
}
