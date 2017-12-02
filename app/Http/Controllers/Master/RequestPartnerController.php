<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\RequestPartner;
use App\Models\Partner;
use App\User;

class RequestPartnerController extends Controller
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
        $this->model = new RequestPartner();
        $this->module = 'master.request-partner';
        $this->page = 'request-partner';
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
            'row' => $this->model->find($id),
            'page' => $this->page
        ];
        return view($this->module . ".edit", $data);   
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
        logUser('Delete Request Partner '.$data->first_name . ' ' . $data->last_name);
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

        if($status == 1) { // ACTIVATE USER
            $desc = 'Reject';
            Partner::sendEmailNotif('reject', $data);
        } else {
            $desc = 'Approve';
            $this->insertToPartner($data);
        }

        $data->status = $status;
        $data->save();

        logUser('Change Status Request Partner '.$data->first_name . ' ' . $data->last_name);

        $message = setDisplayMessage('success', "Success to $desc ".$this->page);
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }

    private function insertToPartner($data) {
        $partner = Partner::create([
            'store_name'    => $data->store_name,
            'owner_name'    => $data->first_name .' '. $data->last_name,
            'email'         => $data->email,
            'handphone_number' => $data->handphone_number,
            'homephone_number' => $data->homephone_number,
            'province_id'   => $data->province_id,
            'city_id'   => $data->city_id,
            'address'   => $data->address,
            'postcode'   => $data->postcode
        ]);

        $randomPass = str_random(10);
        $user = User::create([
            'email'     => $data->email,
            'password'  => bcrypt($randomPass),
            'first_name'    => $data->first_name,
            'last_name'    => $data->last_name,
            'username'      => RequestPartner::generateUsername($data->store_name),
            'user_type'  => 2,
            'partner_id'    => $partner->id,
            'status'        => 1,
            'created_by'    => Auth::id()
        ]);
        $user->password = $randomPass;
        $user->store_name = $partner->store_name;

        logUser('Partner '.$data->store_name.' is registered');

        Partner::sendEmailNotif('approve', $user);
    }
}




