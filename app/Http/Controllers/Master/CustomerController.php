<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;

class CustomerController extends Controller
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
        $this->model = new Customer();
        $this->module = 'master.customer';
        $this->page = 'customer';
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = ($request->input('limit')) ? $request->input('limit') : 10000000;
        $offset = ($request->input('offset')) ? $request->input('offset') : 0;
        $data = [
            'result'  => $this->model->list(),
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
            'first_name'     => 'required',
            'last_name'     => 'required',
            'email'     => 'required|unique:customers',
            'phone'     => 'required',
            'gender'     => 'required',
        ]);

        $create = [
            'first_name'  => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'email'  => $request->input('email'),
            'phone'  => $request->input('phone'),
            'gender'  => $request->input('gender'),
            'password' => bcrypt('cepat123'),
            'addr_street'  => $request->input('addr_street'),
            'addr_zipcode'  => $request->input('zipcode'),
            'status'  => 1,
            'birthdate'  => $request->input('birthdate')
        ];

        $user = $this->model->create($create);

        logUser('Create Customer '.$create['first_name'].' '.$create['last_name']);

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
            'first_name'     => 'required',
            'last_name'     => 'required',
            'phone'         => 'required',
            'gender'        => 'required'
        ]);

        $data = $this->model->find($id);

        $update = [
            'first_name'  => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'phone'  => $request->input('phone'),
            'gender'  => $request->input('gender'),
            'addr_street'  => $request->input('addr_street'),
            'addr_zipcode'  => $request->input('zipcode'),
            'birthdate'  => $request->input('birthdate')
        ];

        if($request->input('password')) {
            $update['password'] = bcrypt($request->input('password'));
        }

        $data->update($update);

        logUser('Update Customer '.$update['first_name'] . ' ' . $update['last_name']);

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
        //
    }

    /**
     * @param $id
     * @param $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus($id, $status) {
        $data = $this->model->find($id);

        if($status == 1) { // ACTIVATE CUSTOMER
            $desc = 'unblock';
        } else {
            $desc = 'block';
        }

        $data->status = $status;
        $data->save();

        logUser('Change Status Customer '.$data->first_name . ' ' . $data->last_name);

        $message = setDisplayMessage('success', "Success to $desc ".$this->page);
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }
}
