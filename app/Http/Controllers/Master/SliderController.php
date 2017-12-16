<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Slider;

class SliderController extends Controller
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
        $this->model = new Slider();
        $this->module = 'master.slider';
        $this->page = 'slider';
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
            'result'  => $this->model->all(),
            'page'    => $this->page
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
            'filename'  => 'required'
        ]);
        $name = str_replace(' ', '-', $request->filename->getClientOriginalName());
        $request->filename->move(
            base_path() . '/public/images/slider/', $name
        );
        $create['filename'] = $name;
        $create['created_by'] = Auth::id();
        $create['caption'] = $request->input('caption');
        $create['link'] = $request->input('link');
        $create['target'] = $request->input('target');

        $this->model->create($create);
        logUser('Create Slider '.$create['filename']);

        $message = setDisplayMessage('success', "Success to create new ".$this->page);
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $data = $this->model->find($id);
        $update = [
            'caption'          => $request->input('caption'),
            'updated_by' => Auth::id(),
            'link'              => $request->input('link'),
            'target'              => $request->input('target'),
        ];

        if($request->input('filename')) {
            $name = str_replace(' ', '-', $request->filename->getClientOriginalName());
            $request->filename->move(
                base_path() . '/public/images/slider/', $name
            );

            $update['filename'] = $name;
        }


        $data->update($update);

        logUser('Update Slider');

        $message = setDisplayMessage('success', "Success to update new ".$this->page);
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
        $data->delete();
        logUser('Delete Slider');

        $message = setDisplayMessage('success', "Success to delete ".$this->page);
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }

    /**
     * @param $id
     * @param $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus($id, $status) {
        $data = $this->model->find($id);

        $data->status = $status;

        $desc = ($status == 1) ? 'activate' : 'deactivate';

        $data->save();

        logUser($desc.' Slider '.$data->name);

        $message = setDisplayMessage('success', "Success to $desc ".$this->page);
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }
}
