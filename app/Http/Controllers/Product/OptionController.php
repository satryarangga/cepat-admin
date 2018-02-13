<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use App\Models\ProductOptionMapCategory;
use App\Models\Category;

class OptionController extends Controller
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
        $this->model = new ProductOption();
        $this->module = 'product.option';
        $this->page = 'option';
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
            'result' => $this->model->listOption(),
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
            'category'  => Category::all()
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
            'category'  => 'required',
            'values'     => 'required'
        ]);

        $create = [
            'name'  => $request->input('name'),
            'url'  => urlFormat($request->input('name')),
            'created_by'    => Auth::id()
        ];

        $option = $this->model->create($create);

        // MAP CATEGORY
        $category = ($request->input('category')) ? $request->input('category') : [];
        foreach ($category as $key => $value) {
            ProductOptionMapCategory::create([
                'product_option_id'     => $option->id,
                'category_id'           => $value
            ]);
        }

        $values = explode(';', $request->input('values'));
        foreach ($values as $key => $value) {
            ProductOptionValue::create([
                'product_option_id'     => $option->id,
                'name'           => $value,
                'url'           => urlFormat($value),
                'created_by'    => Auth::id()
            ]);
        }

        logUser('Create Product Option '.$create['name']);

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
        $categoryMap = ProductOptionMapCategory::where('product_option_id', $id)->pluck('category_id');
        $cat = [];

        foreach ($categoryMap as $key => $value) {
            $cat[] = $value;
        }

        $mapValues = ProductOptionValue::where('product_option_id', $id)->get();
        $data = [
            'page' => $this->page,
            'row' => $this->model->find($id),
            'categoryMap' => $cat,
            'category' => Category::all(),
            'values'    => $mapValues
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
            'name'     => 'required'
        ]);

        $data = $this->model->find($id);

        $category = ($request->input('category')) ? $request->input('category') : [];
        ProductOptionMapCategory::where('product_option_id', $id)->delete();
        foreach ($category as $key => $value) {
            ProductOptionMapCategory::create([
                'product_option_id'     => $id,
                'category_id'           => $value
            ]);
        }

        $update = [
            'name'  => $request->input('name'),
            'url'  => urlFormat($request->input('name')),
            'updated_by' => Auth::id()
        ];

        $data->update($update);

        logUser('Update Category '.$update['name']);

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
        logUser('Delete Category '.$data->name);
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

        logUser('Change Status Category '.$data->name);

        $message = setDisplayMessage('success', "Success to $desc ".$this->page);
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }

    public function formatTree() {
        $data = $this->model->orderBy('parent')->get();

        $category = [
            'categories'    => [],
            'parent_cats'   => []
        ];

        foreach ($data as $key => $value) {
            $category['categories'][$value->id] = $value;
            $category['parent_cats'][$value->parent][] = $value->id;
        }

        $tree = buildCategoryTreeArray(0, $category);
        return $tree;
    }

    public function updateState(Request $request) {
        $id = $request->input('id');
        $position = $request->input('position');
        $target = $request->input('target');

        if($position == 'after') { // BECOME ROOT
            $data = $this->model->find($id)->update([
                'parent'    => 0
            ]);
        } else { // CHANGE PARENT
            $data = $this->model->find($id)->update([
                'parent'    => $target
            ]);
        }

        echo 1; die;
    }

    public function delete($id) {
        $data = $this->model->find($id);
        $message = setDisplayMessage('success', "Success to delete ".$this->page);
        logUser('Delete Category '.$data->name);
        $data->deleted_at = date('Y-m-d H:i:s');
        $data->save();
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }

    public function updateValue(Request $request) {
        $optionId = $request->input('option_id');
        $optionValueId = $request->input('option_value_id');
        $name = $request->input('name');

        ProductOptionValue::find($optionValueId)->update([
            'name'  => $name,
            'url'   => urlFormat($name),
            'updated_by'    => Auth::id()
        ]);

        $message = setDisplayMessage('success', "Success to update values");
        return redirect(route($this->page.'.edit', ['id' => $optionId]))->with('displayMessage', $message);
    }

    public function deleteValue($id) {
        $data = ProductOptionValue::find($id);
        $data->deleted_at = date('Y-m-d H:i:s');
        $data->updated_by = Auth::id();
        $data->save();

        $message = setDisplayMessage('success', "Success to delete values");
        return redirect(route($this->page.'.edit', ['id' => $data->product_option_id]))->with('displayMessage', $message);
    }

    public function addValue(Request $request) {
        $optionId = $request->input('option_id');
        $name = $request->input('name');

        ProductOptionValue::create([
            'name'  => $name,
            'url'   => urlFormat($name),
            'product_option_id' => $optionId,
            'created_by'    => Auth::id()
        ]);

        $message = setDisplayMessage('success', "Success to add values");
        return redirect(route($this->page.'.edit', ['id' => $optionId]))->with('displayMessage', $message);
    }

    public function getValue(Request $request) {
        $optionId = $request->input('option_id');
        $data = ProductOptionValue::where('product_option_id', $optionId)->get();
        $result = [];
        foreach ($data as $key => $value) {
            $result[] = [
                'id'    => $value->id,
                'name'  => $value->name
            ];
        }

        echo json_encode($result); die;
    }
}




