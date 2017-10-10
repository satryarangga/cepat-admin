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
	                  <label for="first_name" class="col-sm-2 control-label">First Name</label>
	                  <div class="col-sm-10">
	                    <input type="text" class="form-control" name="first_name" value="{{old('first_name')}}" id="first_name" placeholder="First Name">
	                  </div>
	                </div>
	                
	                <div class="form-group">
	                  <label for="last_name" class="col-sm-2 control-label">Last Name</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control" name="last_name" value="{{old('last_name')}}" id="last_name" placeholder="Last Name">
	                  </div>
	                </div>

	                <div class="form-group">
			               <label for="gender" class="col-sm-2 control-label">Gender</label>
			               <div class="col-sm-10">
				               <label class="radio-inline"><input @if(old('gender') == 1) checked="checked" @endif type="radio" value="1" name="gender">Male</label>
		                  	   <label class="radio-inline"><input @if(old('gender') == 2) checked="checked" @endif type="radio" value="2" name="gender">Female</label>
			               </div>
			         </div> 

	                <div class="form-group">
	                  <label for="phone" class="col-sm-2 control-label">Phone Number</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control" name="phone" value="{{old('phone')}}" id="phone" placeholder="Phone Number">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="email" class="col-sm-2 control-label">Email * For Login</label>
	                  <div class="col-sm-10">
	                  	<input type="email" class="form-control" name="email" value="{{old('email')}}" id="email" placeholder="Email Address">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="addr_street" class="col-sm-2 control-label">Address Street Name</label>
	                  <div class="col-sm-10">
	                  	<textarea rows="5" name="addr_street" style="width:100%">{{old('addr_street')}}</textarea>
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="zipcode" class="col-sm-2 control-label">Zipcode</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control" name="zipcode" value="{{old('zipcode')}}" id="zipcode" placeholder="Zipcode">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="birthdate" class="col-sm-2 control-label">Birthdate</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control datepicker" name="birthdate" value="{{old('birthdate')}}" id="birthdate" placeholder="Birthdate">
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