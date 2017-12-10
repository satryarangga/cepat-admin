<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderHead;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        $model = new OrderHead();
    	$start = ($request->input('start')) ? $request->input('start') : date('Y-m-01');
        $end = ($request->input('end')) ? $request->input('end') : date('Y-m-d');
        $result = (!$user->partner_id) ? $model->salesReport($start, $end) : $model->salesReportPartner($start, $end, $user->partner_id);
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
        $user = Auth::user();
        $model = new OrderHead();
        $start = ($request->input('start')) ? $request->input('start') : date('Y-m-01');
        $end = ($request->input('end')) ? $request->input('end') : date('Y-m-d');
        $result = (!$user->partner_id) ? $model->salesReport($start, $end) : $model->salesReportPartner($start, $end, $user->partner_id);

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
