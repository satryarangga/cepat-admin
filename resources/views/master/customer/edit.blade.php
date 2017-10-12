@extends('layout.main')

@section('title', 'Home')

@section('content')
    <!-- Main content -->
    <section class="content">
    	<div class="col-md-12">
			<div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">Edit {{ucwords(str_replace('-',' ', $page))}}</h3>
	            </div>
	            <!-- /.box-header -->
	            <!-- form start -->
	            @foreach($errors->all() as $message)
		            <div style="margin: 20px 0" class="alert alert-error">
		                {{$message}}
		            </div>
		        @endforeach
	            <form class="form-horizontal" action="{{route("$page.update", ['id' => $row->id])}}" method="post" enctype="multipart/form-data">
	            	{{csrf_field()}}
	              <div class="box-body">
	                
	                <div class="form-group">
	                  <label for="first_name" class="col-sm-2 control-label">First Name</label>
	                  <div class="col-sm-10">
	                    <input type="text" class="form-control" name="first_name" value="{{$row->first_name}}" id="first_name" placeholder="First Name">
	                  </div>
	                </div>
	                
	                <div class="form-group">
	                  <label for="last_name" class="col-sm-2 control-label">Last Name</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control" name="last_name" value="{{$row->last_name}}" id="last_name" placeholder="Last Name">
	                  </div>
	                </div>

	                <div class="form-group">
			               <label for="gender" class="col-sm-2 control-label">Gender</label>
			               <div class="col-sm-10">
				               <label class="radio-inline"><input @if($row->gender == 1) checked="checked" @endif type="radio" value="1" name="gender">Male</label>
		                  	   <label class="radio-inline"><input @if($row->gender == 2) checked="checked" @endif type="radio" value="2" name="gender">Female</label>
			               </div>
			         </div> 

	                <div class="form-group">
	                  <label for="phone" class="col-sm-2 control-label">Phone Number</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control" name="phone" value="{{$row->phone}}" id="phone" placeholder="Phone Number">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="email" class="col-sm-2 control-label">Email</label>
	                  <div class="col-sm-10">
	                  	<input type="email" class="form-control" name="email" readonly value="{{$row->email}}" id="email" placeholder="Email Address">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="province" class="col-sm-2 control-label">Province</label>
	                  <div class="col-sm-10">
	                  	<input type="province" class="form-control" name="province" value="{{getFieldOfTable('provinces', $row->addr_province_id, 'name')}}" id="province" placeholder="Province Address">
	                  	<input type="hidden" name="province_id" id="province_id" value="{{$row->addr_province_id}}">
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
	                  <label for="address" class="col-sm-2 control-label">Address</label>
	                  <div class="col-sm-10">
	                  	<textarea rows="5" name="addr_street" style="width:100%">{{$row->addr_street}}</textarea>
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="zipcode" class="col-sm-2 control-label">Zipcode</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control" name="zipcode" value="{{$row->addr_zipcode}}" id="zipcode" placeholder="Zipcode">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="birthdate" class="col-sm-2 control-label">Birthdate</label>
	                  <div class="col-sm-10">
	                  	<input type="text" class="form-control datepicker" name="birthdate" value="{{$row->birthdate}}" id="birthdate" placeholder="Birthdate">
	                  </div>
	                </div>

	              </div>
	              <!-- /.box-body -->
	              
	              <!-- /.box-footer -->
	              {{ method_field('PUT') }}
		            <!-- /.tab-content -->
		            <div class="box-footer">
	                	<button type="submit" class="btn btn-info">Submit</button>
	              	</div>
	            </form>
	          </div>
          </div>

    </section>

@endsection