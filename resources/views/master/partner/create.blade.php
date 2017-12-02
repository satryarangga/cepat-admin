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
	                  <label for="store_name" class="col-sm-2 control-label">Store Name</label>
	                  <div class="col-sm-10">
	                    <input type="text" class="form-control" name="store_name" value="{{old('store_name')}}" id="store_name" placeholder="Store Name">
	                  </div>
	                </div>
	                
	                <div class="form-group">
	                  <label for="owner_name" class="col-sm-2 control-label">Owner Name</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control" name="owner_name" value="{{old('owner_name')}}" id="owner_name" placeholder="Owner Name">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="handphone_number" class="col-sm-2 control-label">Handphone Number</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control" name="handphone_number" value="{{old('handphone_number')}}" id="handphone_number" placeholder="Handphone Number">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="homephone_number" class="col-sm-2 control-label">Homephone Number</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control" name="homephone_number" value="{{old('homephone_number')}}" id="homephone_number" placeholder="Home / Store Phone Number">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="email" class="col-sm-2 control-label">Email </label>
	                  <div class="col-sm-10">
	                  	<input type="email" class="form-control" name="email" value="{{old('email')}}" id="email" placeholder="Email Address">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="province" class="col-sm-2 control-label">Province</label>
	                  <div class="col-sm-10">
	                  	<input type="province" class="form-control" name="province" value="{{old('province_name')}}" id="province" placeholder="Province Address">
	                  	<input type="hidden" name="province_id" id="province_id" value="{{old('province_id')}}">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="city" class="col-sm-2 control-label">City</label>
	                  <div class="col-sm-10">
	                  	<select class="form-control" id="city_id" name="city_id">
	                  		<option>Choose City</option>
	                  	</select>
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="address" class="col-sm-2 control-label">Address Street Name</label>
	                  <div class="col-sm-10">
	                  	<textarea rows="5" name="address" style="width:100%">{{old('address')}}</textarea>
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="postcode" class="col-sm-2 control-label">Zipcode</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control" name="postcode" value="{{old('postcode')}}" id="postcode" placeholder="Zipcode">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="bank_acc_no" class="col-sm-2 control-label">Bank Account Number</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control" name="bank_acc_no" value="{{old('bank_acc_no')}}" id="bank_acc_no" placeholder="Account Number">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="bank_acc_name" class="col-sm-2 control-label">Bank Account Name</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control" name="bank_acc_name" value="{{old('bank_acc_name')}}" id="bank_acc_name" placeholder="Bank Name">
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