<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\UserLogs;
// use App\Role;
// use App\RoleUser;
// use App\Models\Dealer;
// use App\Models\UserDealer;


class UserController extends Controller
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
        $this->model = new User();
        $this->module = 'master.user';
        $this->page = 'user';
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
            'result' => $this->model->where('deleted_at', null)->get(),
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
            // 'position' => Role::all(),
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
            'username'     => 'required|unique:users',
            'password' => 'required|string|min:4',
        ]);

        $create = [
            'first_name'  => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'username'  => $request->input('username'),
            'email'  => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'created_by' => Auth::id()
        ];

        $user = $this->model->create($create);

        logUser('Create User '.$create['first_name'].' '.$create['last_name']);

        // $role = $request->input('roles');
        // $this->assignRole($role, $user);

        $message = setDisplayMessage('success', "Success to create new ".$this->page);
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $type = $request->input('type');
        $data = [
            'page' => $this->page,
            'row' => $this->model->find($id),
            'type' => $type,
            // 'validRole' => RoleUser::getRoleForUser($id)
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
            'last_name'     => 'required'
        ]);

        $data = $this->model->find($id);

        $update = [
            'first_name'  => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'email'  => $request->input('email'),
            'updated_by' => Auth::id()
        ];

        if($request->input('password')) {
            $update['password'] = bcrypt($request->input('password'));
        }

        $data->update($update);

        logUser('Update User '.$update['first_name'] . ' ' . $update['last_name']);


        // $role = $request->input('roles');
        // $this->assignRole($role, $data);

        $type = $request->input('type');

        $message = setDisplayMessage('success', "Success to update ".$this->page);

        if($type == 'profile') {
            $message = setDisplayMessage('success', "Success to update your profile");
            return redirect(route($this->page.'.edit', ['id' => $id]).'?type=profile')->with('displayMessage', $message);
        }

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
        logUser('Delete User '.$data->first_name . ' ' . $data->last_name);
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

        if($status == 1) { // ACTIVATE USER
            $desc = 'activate';
        } else {
            $desc = 'suspend';
        }

        $data->status = $status;
        $data->save();

        logUser('Change Status User '.$data->first_name . ' ' . $data->last_name);

        $message = setDisplayMessage('success', "Success to $desc ".$this->page);
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }

    // protected function assignRole($role, $user) {
    //     RoleUser::where('user_id', $user->id)->delete();
    //     foreach ($role as $key => $value) {
    //         $user->attachRole($value);
    //     }
    // }
}
