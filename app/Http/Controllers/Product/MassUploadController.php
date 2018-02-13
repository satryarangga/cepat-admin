<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;

class MassUploadController extends Controller
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
        $this->model = new Product();
        $this->module = 'product.product-manage';
        $this->page = 'mass-upload';
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
            'page'  => $this->page
        ];
        return view($this->module . ".mass-upload", $data);
    }

    public function store(Request $request) {
        if ($request->file('csv')) {
            $name = str_replace(' ', '-', $request->csv->getClientOriginalName());
            $request->csv->move(
                base_path() . '/public/csv/mass-product/', $name
            );
            $file = base_path() . '/public/csv/mass-product/'.$name;
            $upload = Excel::load($file, function($reader) {
            })->get();
        }
        $data = [
            'page'  => $this->page,
            'product'   => $upload
        ];
        return view($this->module . ".mass-upload", $data);
    }

    public function confirm(Request $request) {
        $user = Auth::user();
        $name = $request->input('productname');
        $price = $request->input('price');
        $weight = $request->input('weight');
        $description = $request->input('description');

        foreach ($name as $key => $value) {
            Product::create([
                'name'              => $value,
                'original_price'    => $price[$key],
                'discount_price'    => $price[$key],
                'weight'            => $weight[$key],
                'description'       => $description[$key],
                'created_by'        => Auth::id(),
                'status'            => 0,
                'has_variant'       => 0,
                'partner_id'        => ($user->partner_id) ? $user->partner_id : 1
            ]);                 
        }
        $message = setDisplayMessage('success', "Success to mass upload product");
        return redirect(route('product-manage.index'))->with('displayMessage', $message);
    }
}


