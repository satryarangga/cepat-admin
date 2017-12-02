<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\User;
use App\Models\RequestPartner;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
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
        $this->model = new Partner();
        $this->module = 'master.partner';
        $this->page = 'partner';
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
            'owner_name'    => 'required',
            'store_name'    => 'required',
            'email'			=> 'required',
            'handphone_number' => 'required',
            'homephone_number' => 'required',
            'province_id'	=> 'required',
            'city_id'		=> 'required',
            'address'		=> 'required',
            'postcode'		=> 'required',
            'bank_acc_no'	=> 'required',
            'bank_acc_name'	=> 'required'
        ]);

        $create = [
            'owner_name'  => $request->input('owner_name'),
            'store_name'  => $request->input('store_name'),
            'email'  => $request->input('email'),
            'handphone_number'	=> $request->input('handphone_number'),
            'homephone_number'	=> $request->input('homephone_number'),
            'province_id'	=> $request->input('province_id'),
            'city_id'	=> $request->input('city_id'),
            'address'	=> $request->input('address'),
            'postcode'	=> $request->input('postcode'),
            'bank_acc_no'	=> $request->input('bank_acc_no'),
            'bank_acc_name'	=> $request->input('bank_acc_name'),
            'status'  => 1
        ];

        $partner = $this->model->create($create);

        $randomPass = str_random(10);
        $user = User::create([
            'email'     => $partner->email,
            'password'  => bcrypt($randomPass),
            'first_name'    => $partner->owner_name,
            'last_name'    => '',
            'username'      => RequestPartner::generateUsername($partner->store_name),
            'user_type'  => 2,
            'partner_id'    => $partner->id,
            'status'        => 1,
            'created_by'    => Auth::id()
        ]);

        $user->password = $randomPass;
        $user->store_name = $partner->store_name;
        Partner::sendEmailNotif('approve', $user);


        logUser('Create Partner '.$create['store_name']);

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
            'owner_name'    => 'required',
            'store_name'    => 'required',
            'email'			=> 'required',
            'handphone_number' => 'required',
            'homephone_number' => 'required',
            'province_id'	=> 'required',
            'city_id'		=> 'required',
            'address'		=> 'required',
            'postcode'		=> 'required',
            'bank_acc_no'	=> 'required',
            'bank_acc_name'	=> 'required'
        ]);

        $data = $this->model->find($id);

        $update = [
            'owner_name'  => $request->input('owner_name'),
            'store_name'  => $request->input('store_name'),
            'email'  => $request->input('email'),
            'handphone_number'	=> $request->input('handphone_number'),
            'homephone_number'	=> $request->input('homephone_number'),
            'province_id'	=> $request->input('province_id'),
            'city_id'	=> $request->input('city_id'),
            'address'	=> $request->input('address'),
            'postcode'	=> $request->input('postcode'),
            'bank_acc_no'	=> $request->input('bank_acc_no'),
            'bank_acc_name'	=> $request->input('bank_acc_name'),
            'status'  => 1
        ];

        $data->update($update);

        logUser('Update Partner '. $update['store_name']);

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
        logUser('Delete Partner '.$data->store_name);
        $data->delete();
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
            $desc = 'unblock';
        } else {
            $desc = 'block';
        }

        $data->status = $status;
        $data->save();

        logUser('Change Status Partner '.$data->store_name);

        $message = setDisplayMessage('success', "Success to $desc ".$this->page);
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }
}
