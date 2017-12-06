@extends('layout.main')

@section('title', 'Home')

@section('content')

<section class="content">
	<div class="col-md-12">
		{!! session('displayMessage') !!}
		<div class="box">
            <!-- /.box-header -->
            <div class="box-header">
              <form class="form-inline pull-left">

                <div class="form-group">
                  <label>Start</label>
                  <input type="text" name="start" value="{{$start}}" class="form-control datepicker">
                </div>

                <div class="form-group" style="margin-left:15px" >
                  <label>End</label>
                  <input type="text" name="end" value="{{$end}}" class="form-control datepicker">
                </div>

                <div class="form-group" style="margin-left:15px" >
                  <input type="submit" value="Search" class="btn btn-primary">
                </div>

              </form>
              <div class="pull-right">
                <a href="{{route('report.excel.sales')}}?start={{$start}}&end={{$end}}" class="btn btn-primary" href="">Export to CSV</a>
              </div>
            </div>
            <div class="box-body">
              <div style="text-align: center;">
                <span style="font-size: 20px;font-weight: 500">{{date('j F Y', strtotime($start))}} - {{date('j F Y', strtotime($end))}}</span>
              </div>
              <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                  <th>Purchase Code</th>
                  <th>Customer</th>
                  <th>Date</th>
                  <th>Total Sales</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($result as $key => $val)
                  <tr>
                    <td>{{$val->purchase_code}}</td>
                    <td>{{$val->customer_email}}</td>
                    <td>{{date('j F Y', strtotime($val->date))}}</td>
                    <td>{{moneyFormat($val->total_purchase)}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
	</div>
</section>

@endsection