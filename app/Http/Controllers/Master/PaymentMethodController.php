<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
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
        $this->model = new PaymentMethod();
        $this->module = 'master.payment-method';
        $this->page = 'payment-method';
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
            'name'  => 'required',
            'desc'  => 'required',
            'logo'  => 'required',
            'confirm_type'  => 'required'
        ]);

        $create = [
            'name'          => $request->input('name'),
            'desc'          => $request->input('desc'),
            'code'          => urlFormat($request->input('name')),
            'minimum_payment' => $request->input('minimum_payment'),
            'use_paycode' => $request->input('use_paycode'),
            'confirm_type' => $request->input('confirm_type'),
            'status' => 1,
            'created_by' => Auth::id()
        ];

        if ($request->file('logo')) {
            $name = str_replace(' ', '-', $request->logo->getClientOriginalName());
            $request->logo->move(
                base_path() . '/public/images/payment-method/', $name
            );
            $create['logo'] = $name;
        }

        $this->model->create($create);

        logUser('Create Payment Method '.$create['name']);

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
        $this->validate($request,[
            'name'  => 'required',
            'desc'  => 'required',
            'confirm_type'  => 'required'
        ]);

        $data = $this->model->find($id);

        $update = [
            'name'          => $request->input('name'),
            'desc'          => $request->input('desc'),
            'code'          => ($data->confirm_type == 2) ? $data->code : urlFormat($request->input('name')),
            'minimum_payment' => $request->input('minimum_payment'),
            'use_paycode' => $request->input('use_paycode'),
            'confirm_type' => ($data->confirm_type == 2) ? $data->confirm_type : $request->input('confirm_type'),
            'updated_by' => Auth::id()
        ];

        if ($request->file('logo')) {
            $name = str_replace(' ', '-', $request->logo->getClientOriginalName());
            $request->logo->move(
                base_path() . '/public/images/payment-method/', $name
            );
            $update['logo'] = $name;
        }

        $data->update($update);

        logUser('Update Payment Method '.$update['name']);

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
        logUser('Delete Payment Method '.$data->name);

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

        logUser($desc.' Payment Method '.$data->name);

        $message = setDisplayMessage('success', "Success to $desc ".$this->page);
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }
}
