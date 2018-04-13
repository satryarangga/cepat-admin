<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\InventoryLog;
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
        $isVariant = $request->input('variant');
        if ($request->file('csv')) {
            if($request->csv->getClientOriginalExtension() != 'csv') {
                $message = setDisplayMessage('danger', 'Please import a csv file.');
                return redirect(route('mass-upload.index'))->with('displayMessage', $message);
            }

            $name = str_replace(' ', '-', $request->csv->getClientOriginalName());
            $request->csv->move(
                base_path() . '/public/csv/mass-product/', $name
            );
            $file = base_path() . '/public/csv/mass-product/'.$name;
            $upload = Excel::load($file, function($reader) {

            })->get();
        }

        $validate = $this->csvValidation($upload, $isVariant);
        if(!$validate) {
            $message = setDisplayMessage('danger', 'Missing required column. Please follow the example');
            return redirect(route('mass-upload.index'))->with('displayMessage', $message);
        }

        $product = $this->distinctProduct($upload, $isVariant);
        
        $data = [
            'page'  => $this->page,
            'product'   => $product,
            'isVariant' => $isVariant
        ];
        return view($this->module . ".mass-upload", $data);
    }

    public function confirm(Request $request) {
        $user = Auth::user();
        $name = $request->input('productname');
        $price = $request->input('price');
        $discountprice = $request->input('discountprice');
        $weight = $request->input('weight');
        $description = $request->input('description');
        $quantity = $request->input('quantity');
        $color = $request->input('color');
        $size = $request->input('size');
        $isVariant = $request->input('is_variant');

        if(!$isVariant) {
            foreach ($name as $key => $value) {
                $created = Product::create([
                    'name'              => $value,
                    'original_price'    => $price[$key],
                    'discount_price'    => $discountprice[$key],
                    'weight'            => $weight[$key],
                    'description'       => $description[$key],
                    'created_by'        => Auth::id(),
                    'status'            => 0,
                    'has_variant'       => 0,
                    'partner_id'        => ($user->partner_id) ? $user->partner_id : 1
                ]);

                $createVariant = $this->model->insertVariantProduct($created->id, $quantity[$key]);

                InventoryLog::create([
                    'product_id'    => $created->id,
                    'purchase_code' => '',
                    'user_id'       => Auth::id(),
                    'SKU'           => $createVariant->SKU,
                    'qty'           => $quantity[$key],
                    'type'          => 1,
                    'description'   => "Created",
                    'source'        => 2 // ADMIN
                ]);
            }
        } else {
            $variant = [];
            foreach ($name as $key => $value) {
                $variant[$value]['price'] = $price[$key];
                $variant[$value]['discountprice'] = $discountprice[$key];
                $variant[$value]['weight'] = $weight[$key];
                $variant[$value]['description'] = $description[$key];
                $variant[$value]['variant'][] = [
                    'color'         => $color[$key],
                    'size'         => $size[$key],
                    'quantity'     => $quantity[$key],
                ];
            }

            foreach ($variant as $key => $value) {
                $created = Product::create([
                    'name'              => $key,
                    'original_price'    => $value['price'],
                    'discount_price'    => $value['discountprice'],
                    'weight'            => $value['weight'],
                    'description'       => $value['description'],
                    'created_by'        => Auth::id(),
                    'status'            => 0,
                    'has_variant'       => 1,
                    'partner_id'        => ($user->partner_id) ? $user->partner_id : 1
                ]);

                foreach ($value['variant'] as $keyVariant => $valueVariant) {
                    $createVariant = ProductVariant::insertVariantProductFromCSV($created->id, $valueVariant['quantity'], $valueVariant['color'], $valueVariant['size']);

                    InventoryLog::create([
                        'product_id'    => $created->id,
                        'purchase_code' => '',
                        'user_id'       => Auth::id(),
                        'SKU'           => $createVariant->SKU,
                        'qty'           => $valueVariant['quantity'],
                        'type'          => 1,
                        'description'   => "Created",
                        'source'        => 2 // ADMIN
                    ]);
                }
            }
        }

        $message = setDisplayMessage('success', "Success to mass upload product");
        return redirect(route('product-manage.index'))->with('displayMessage', $message);
    }

    private function csvValidation($upload = [], $variant = 0) {
        if($variant) {
            $required = ['productname', 'price', 'discountprice', 'weight', 'description', 'color', 'size', 'quantity'];
        } else {
            $required = ['productname', 'price', 'discountprice', 'weight', 'description', 'quantity'];
        }

        foreach ($upload as $key => $value) {
            foreach ($required as $valColumns) {
                if(!isset($value[$valColumns])) {
                    return false;
                }
            }
        }
        return true;
    }

    private function distinctProduct($upload = [], $variant = 0) {
        $product = [];
        if($variant) {
            $distictColorSize = [];
            foreach ($upload as $key => $value) {
                $colorSize = $value['color']."-".$value['size'];
                if(!in_array($colorSize, $distictColorSize)) {
                    $product[] = $value;
                    $distictColorSize[] = $colorSize;
                }
            }
            return $product;
        }

        return $upload;
    }
}