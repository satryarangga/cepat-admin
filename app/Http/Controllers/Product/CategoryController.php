<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class CategoryController extends Controller
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
        $this->model = new Category();
        $this->module = 'product.category';
        $this->page = 'category';
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
            'result' => $this->formatTree(),
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
            'page' => $this->page
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
            'name'     => 'required'
        ]);

        $create = [
            'name'  => $request->input('name'),
            'url'  => urlFormat($request->input('name')),
            'created_by' => Auth::id()
        ];

        $this->model->create($create);

        logUser('Create Category '.$create['name']);

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
            'row' => $this->model->find($id)
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
}
