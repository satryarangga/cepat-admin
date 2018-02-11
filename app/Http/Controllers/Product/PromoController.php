<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PromoHead;
use App\Models\PromoDetail;
use App\Models\Product;

class PromoController extends Controller
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
        $this->model = new PromoHead();
        $this->module = 'product.promo';
        $this->page = 'promo';
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
            'duration'  => 'required',
            'start_date'  => 'required'
        ]);
        $type = $request->input('type');
        $name = $request->input('name');
        $start_date = $request->input('start_date');
        $start_time = $request->input('start_time');
        $duration = $request->input('duration');

        $time = explode(' ', $start_time);
        $hour = explode(':', $time[0]);
        if($time[1] == 'PM') {
            $hour[0] = (int) $hour[0] + 12;
        }
        $time = $hour[0].':'.$hour[1].':00';
        $start = $start_date.' '.$time;
        if($type == 1) { // DAYS
            $seconds = 86400 * $duration;
        } else if($type == 2) {
            $seconds = 3600 * $duration;
        } else if($type == 3) {
            $seconds = 60 * $duration;
        } else {
            $seconds = $duration;
        }

        $time = strtotime($start);
        $ended = $time + $seconds;

        $create = [
            'name'          => $request->input('name'),
            'duration'      => $duration,
            'start_on'      => $start,
            'type'          => $type,
            'url'           => urlFormat($request->input('name')),
            'end_on'        => date('Y-m-d H:i:s', $ended),
            'status'        => 0,
            'created_by'    => Auth::id()
        ];

        if ($request->file('banner')) {
            $name = str_replace(' ', '-', $request->banner->getClientOriginalName());
            $request->banner->move(
                base_path() . '/public/images/promo/', $name
            );
            $create['banner'] = $name;
        }

        $this->model->create($create);

        logUser('Create Promo '.$create['name']);

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
            'duration'  => 'required',
            'start_date'  => 'required'
        ]);
        $type = $request->input('type');
        $name = $request->input('name');
        $start_date = $request->input('start_date');
        $start_time = $request->input('start_time');
        $duration = $request->input('duration');

        $time = explode(' ', $start_time);
        $hour = explode(':', $time[0]);
        if($time[1] == 'PM') {
            $hour[0] = (int) $hour[0] + 12;
        }
        $time = $hour[0].':'.$hour[1].':00';
        $start = $start_date.' '.$time;
        if($type == 1) { // DAYS
            $seconds = 86400 * $duration;
        } else if($type == 2) {
            $seconds = 3600 * $duration;
        } else if($type == 3) {
            $seconds = 60 * $duration;
        } else {
            $seconds = $duration;
        }

        $time = strtotime($start);
        $ended = $time + $seconds;

        $data = $this->model->find($id);
        $update = [
            'name'          => $name,
            'url'           => urlFormat($name),
            'duration'      => $duration,
            'start_on'      => $start,
            'type'          => $type,
            'end_on'        => date('Y-m-d H:i:s', $ended),
            'status'        => 0,
            'updated_by'    => Auth::id()
        ];

        if ($request->file('banner')) {
            $name = str_replace(' ', '-', $request->banner->getClientOriginalName());
            $request->banner->move(
                base_path() . '/public/images/promo/', $name
            );
            $update['banner'] = $name;
        }

        $data->update($update);

        logUser('Update Promo '.$update['name']);

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
        logUser('Delete Promo '.$data->name);

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

        $desc = ($status == 2) ? 'Stopped' : 'Reactivate';

        $data->save();

        logUser("$desc Promo ".$data->name);

        $message = setDisplayMessage('success', "Success to $desc ".$this->page);
        return redirect(route($this->page.'.index'))->with('displayMessage', $message);
    }

    public function manageProduct($promoId) {
        $product = PromoDetail::listProduct($promoId);
        $promo = PromoHead::find($promoId);
        $data = [
            'result'       => $product,
            'promo'       => $promo,
            'page'          => $this->page,
            'product'       => Product::where('status', 1)->get(),
            'title'         => 'Promo '.$promo->name
        ];

        return view($this->module.".manage-product", $data);        
    }

    public function addProduct(Request $request) {
        $promoId = $request->input('promo_id');
        $product = $request->input('product');
        $promoPrice = $request->input('promo_price');

        PromoDetail::create([
            'product_id'    =>  $product,
            'promo_id'      =>  $promoId,
            'promo_price'   =>  parseMoneyToInteger($promoPrice),
            'created_by'    => Auth::id()
        ]);

        $message = setDisplayMessage('success', "Success to add product ".$this->page);
        return redirect(route($this->page.'.manage-product', ['id' => $promoId]))->with('displayMessage', $message);   
    }

    public function updateProduct(Request $request) {
        $id = $request->input('promo_detail_id');
        $product = $request->input('product');
        $promoPrice = $request->input('promo_price');
        $promo = PromoDetail::find($id);

        $promo->update([
            'product_id'    =>  $product,
            'promo_price'   =>  parseMoneyToInteger($promoPrice),
            'updated_by'    => Auth::id()
        ]);

        $message = setDisplayMessage('success', "Success to edit ".$this->page);
        return redirect(route($this->page.'.manage-product', ['id' => $promo->promo_id]))->with('displayMessage', $message);   
    }

    public function deleteProduct($promoDetailId) {
        PromoDetail::find($promoDetailId)->delete();
        $message = setDisplayMessage('success', "Success to delete ".$this->page);
        return redirect(route($this->page.'.manage-product', ['id' => $promoDetailId]))->with('displayMessage', $message);
    }
}
