<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderHead;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    /**
     * @var string
     */
    private $page;

    public function __construct() {
		$this->page = 'report';
		$this->middleware('auth');
    }

    public function sales(Request $request) {
        $model = new OrderHead();
    	$start = ($request->input('start')) ? $request->input('start') : date('Y-m-01');
        $end = ($request->input('end')) ? $request->input('end') : date('Y-m-d');
        $result = $model->salesReport($start, $end);
    	$data = [
    		'start' => $start,
            'end' => $end,
            'result' => $result,
            'page' => $this->page,
            'title' => 'Sales Report'
    	];
    	return view($this->page . ".sales", $data);
    }

    public function excelSales(Request $request) {
        $model = new OrderHead();
        $start = ($request->input('start')) ? $request->input('start') : date('Y-m-01');
        $end = ($request->input('end')) ? $request->input('end') : date('Y-m-d');
        $result = $model->salesReport($start, $end);

        $csv = [];
        foreach($result as $key => $value){
            $csv[$key]['Purchase Code'] = $value->purchase_code;
            $csv[$key]['Customer Email'] = $value->customer_email;
            $csv[$key]['Date'] = date('j F Y', strtotime($value->date));
            $csv[$key]['Total Purchase'] = $value->total_purchase;
        }

        return Excel::create('Sales-Report-'.$start.'-'.$end, function($excel) use ($csv) {
            $excel->sheet('Sales Report', function($sheet) use ($csv)
            {
                $sheet->fromArray($csv);
            });
        })->export('csv');
    }
}
