@extends('layout.main')

@section('title', 'Home')

@section('content')

<section class="content">
	<div class="col-md-12">
		{!! session('displayMessage') !!}
		<div class="box">
            <div class="box-header">
                <form style="float: left;" class="form-inline">
                  <div class="form-group">
                    <label class="control-label">Search by</label>
                    <select name="search_by" class="form-control">
                      <option @if($filter['search_by'] == 'purchase_code') selected @endif value="purchase_code">Purchase Code</option>
                      <option @if($filter['search_by'] == 'email') selected @endif value="email">Customer Email</option>
                    </select>
                  </div>
                  <div class="form-group" style="margin-left: 10px">
                    <label class="control-label">Keyword</label>
                    <input type="text" name="keyword" value="{{$filter['keyword']}}" class="form-control" />
                  </div>
                  <div class="form-group" style="margin-left: 10px">
                    <input type="submit" value="Search" class="btn btn-primary">
                    <a class="btn btn-success" href="{{route('order-manage.index', ['status' => $status])}}">Clear</a>
                  </div>
                </form>

                <form style="float: right;" class="form-inline">
                  <div class="form-group">
                    <label class="control-label">Sort by</label>
                    <select name="sort_by" onchange="this.form.submit()" class="form-control">
                      <option @if($sort == 'id') selected @endif value="id">Latest</option>
                      <option @if($sort == 'grand_total') selected @endif value="grand_total">Most Expensive</option>
                    </select>
                    <input type="hidden" name="search_by" value="{{$filter['search_by']}}">
                    <input type="hidden" name="keyword" value="{{$filter['keyword']}}">
                  </div>
                </form>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                  <th>Purchase Code</th>
                  <th>Customer</th>
                  <th>Purchase Date</th>
                  <th>Total Item</th>
                  <th>Total Purchase</th>
                  <th>Payment Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($result as $key => $val)
                <tr>
                  <td>{{$val->purchase_code}}</td>
                  <td>{{$val->customer_email}}</td>
                  <td>{{date('j F Y',strtotime($val->date))}}</td>
                  <td>{{$val->total_item}}</td>
                  <td>{{moneyFormat($val->total_purchase)}}</td>
                  <td>{{getPaymentStatus($val->status)}}</td>
                <td>
                	<div class="btn-group">
	                  <button type="button" class="btn btn-info">Action</button>
	                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
	                    <span class="caret"></span>
	                    <span class="sr-only">Toggle Dropdown</span>
	                  </button>
	                  <ul class="dropdown-menu" role="menu">
                      <li><a href="{{route('order-partner.detail', ['id' => $val->id])}}">View Detail</a></li>
	                  </ul>
                	</div>
                </td>
                </tr>
                @endforeach
              </table>
              {{$result->links()}}
            </div>
            <!-- /.box-body -->
          </div>
	</div>
</section>

@endsection