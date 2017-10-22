<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\City;
use App\Models\CategoryChild;

class AjaxController extends Controller
{
    public function getProvince(Request $request) {
    	$query = $request->input('term');	
    	$data = Province::select('name as label', 'id as value')
    					->where('name', 'like', "%$query%")
    					->get();

    	return json_encode($data);
    }

    public function getCity(Request $request) {
    	$province = $request->input('province');	
    	$data = City::where('province_id', $province)->get();

    	return json_encode($data);
    }

    public function getCategoryChild(Request $request) {
        $parent = $request->input('parent');
        $data = CategoryChild::where('parent_id', $parent)->get();

        return json_encode($data);
    }

}
