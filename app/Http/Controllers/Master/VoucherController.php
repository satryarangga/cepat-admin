<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Voucher;

class VoucherController extends Controller
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
        $this->model = new Voucher();
        $this->module = 'master.voucher';
        $this->page = 'voucher';
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
            'code'  => 'required|unique:vouchers',
            'discount_type'  => 'required',
            'transaction_type'  => 'required',
            'value'  => 'required',
            'start_date'  => 'required',
            'end_date'  => 'required',
        ]);

        $create = [
            'name'  => $request->input('name'),
            'code'  => $request->input('code'),
            'description'  => $request->input('desc'),
            'discount_type'  => $request->input('discount_type'),
            'transaction_type'  => $request->input('transaction_type'),
            'value'  => parseMoneyToInteger($request->input('value')),
            'start_date'  => $request->input('start_date'),
            'end_date'  => $request->input('end_date'),
            'created_by' => Auth::id()
        ];

        $this->model->create($create);

        logUser('Create Voucher Code '.$create['code']);

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
            'discount_type'  => 'required',
            'transaction_type'  => 'required',
            'value'  => 'required',
            'start_date'  => 'required',
            'end_date'  => 'required',
        ]);

        $data = $this->model->find($id);

        $update = [
            'name'  => $request->input('name'),
            'description'  => $request->input('desc'),
            'discount_type'  => $request->input('discount_type'),
            'transaction_type'  => $request->input('transaction_type'),
            'value'  => parseMoneyToInteger($request->input('value')),
            'start_date'  => $request->input('start_date'),
            'end_date'  => $request->input('end_date'),
            'updated_by' => Auth::id()
        ];

        $data->update($update);

        logUser('Update Voucher Code '.$data->code);

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
        logUser('Update Voucher Code '.$data->code);

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

        logUser('Change Status Voucher '.$data->code);

        $message = setDisplayMessage('success', "Success to $desc ".$this->page);
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }
}
