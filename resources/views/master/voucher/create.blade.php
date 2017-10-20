@extends('layout.main')

@section('title', 'Home')

@section('content')
    <!-- Main content -->
    <section class="content">
    	<div class="col-md-12">
			<div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">Create New {{ucwords(str_replace('-',' ', $page))}}</h3>
	            </div>
	            <!-- /.box-header -->
	            <!-- form start -->
	            @foreach($errors->all() as $message)
		            <div style="margin: 20px 0" class="alert alert-error">
		                {{$message}}
		            </div>
		        @endforeach
	            <form class="form-horizontal" action="{{route("$page.store")}}" method="post" enctype="multipart/form-data">
	            	{{csrf_field()}}
	              <div class="box-body">
	                <div class="form-group">
	                  <label for="name" class="col-sm-2 control-label">Voucher Name</label>
	                  <div class="col-sm-10">
	                    <input type="text" class="form-control" name="name" value="{{old('name')}}" id="name" placeholder="Voucher Name">
	                  </div>
	                </div>
	                
	                <div class="form-group">
	                  <label for="code" class="col-sm-2 control-label">Voucher Code</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control" name="code" value="{{old('code')}}" id="code" placeholder="Voucher Code">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="desc" class="col-sm-2 control-label">Description</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control" name="desc" value="{{old('desc')}}" id="desc" placeholder="Voucher Description">
	                  </div>
	                </div>

	                <div class="form-group">
			               <label for="discount_type" class="col-sm-2 control-label">Discount Type</label>
			               <div class="col-sm-10">
				               <label class="radio-inline"><input @if(old('discount_type') == 1) checked="checked" @endif type="radio" value="1" name="discount_type">Nominal</label>
		                  	   <label class="radio-inline"><input @if(old('discount_type') == 2) checked="checked" @endif type="radio" value="2" name="discount_type">Percentage</label>
			               </div>
			         </div> 

			         <div class="form-group">
			               <label for="transaction_type" class="col-sm-2 control-label">Transaction Type</label>
			               <div class="col-sm-10">
				               <label class="radio-inline"><input @if(old('transaction_type') == 1) checked="checked" @endif type="radio" value="1" name="transaction_type">Single Transaction</label>
		                  	   <label class="radio-inline"><input @if(old('transaction_type') == 2) checked="checked" @endif type="radio" value="2" name="transaction_type">Multiple Transaction</label>
			               </div>
			         </div> 

			         <div class="form-group">
	                  <label for="value" class="col-sm-2 control-label">Value</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control" onkeyup="formatMoney($(this))" name="value" value="{{old('value')}}" id="value" placeholder="Voucher Value">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="start_date" class="col-sm-2 control-label">Start Date</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control datepicker" name="start_date" value="{{old('start_date')}}" id="start_date" placeholder="Start Date">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="end_date" class="col-sm-2 control-label">End Date</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control datepicker" name="end_date" value="{{old('end_date')}}" id="end_date" placeholder="End Date">
	                  </div>
	                </div>

	              </div>
	              <!-- /.box-body -->
	              <div class="box-footer">
	                <button type="submit" class="btn btn-info pull-right">Submit</button>
	              </div>
	              <!-- /.box-footer -->
	            </form>
	          </div>
          </div>
    </section>

@endsection