@extends('layout.main')

@section('title', 'Home')

@section('content')
    <!-- Main content -->
    <section class="content">
    	<div class="col-md-12">
			<div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">{{ucwords(str_replace('-',' ', $page))}} #{{$row->id}}</h3>
	            </div>
	            <!-- /.box-header -->
	            <!-- form start -->
	            @foreach($errors->all() as $message)
		            <div style="margin: 20px 0" class="alert alert-error">
		                {{$message}}
		            </div>
		        @endforeach
		        {!! session('displayMessage') !!}
	            <form class="form-horizontal" action="{{route("$page.update", ['id' => $row->id])}}" method="post" enctype="multipart/form-data">
	            	{{csrf_field()}}
	              <div class="box-body">
	                
	                <div class="form-group">
	                  <label for="first_name" class="col-sm-3 control-label">First Name</label>
	                  <div class="col-sm-8">
	                    <input type="text" class="form-control" name="first_name" readonly value="{{$row->first_name}}">
	                  </div>
	                </div>
	                
	                <div class="form-group">
	                  <label for="last_name" class="col-sm-3 control-label">Last Name</label>
	                  <div class="col-sm-8">
	                  	<input type="text" class="form-control" name="last_name" readonly value="{{$row->last_name}}">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="email" class="col-sm-3 control-label">Email</label>
	                  <div class="col-sm-8">
	                  	<input type="text" class="form-control" name="email" readonly value="{{$row->email}}" id="email">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="email" class="col-sm-3 control-label">Handphone Number</label>
	                  <div class="col-sm-8">
	                  	<input type="text" class="form-control" name="email" readonly value="{{$row->handphone_number}}">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="email" class="col-sm-3 control-label">Home / Office Phone Number</label>
	                  <div class="col-sm-8">
	                  	<input type="text" class="form-control" name="email" readonly value="{{$row->homephone_number}}">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="email" class="col-sm-3 control-label">Province</label>
	                  <div class="col-sm-8">
	                  	<input type="text" class="form-control" name="email" readonly value="{{getFieldOfTable('provinces', $row->province_id, 'name')}}">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="email" class="col-sm-3 control-label">City</label>
	                  <div class="col-sm-8">
	                  	<input type="text" class="form-control" name="email" readonly value="{{getFieldOfTable('cities', $row->province_id, 'name')}}">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="email" class="col-sm-3 control-label">Address</label>
	                  <div class="col-sm-8">
	                  	<textarea readonly class="form-control">{{$row->address}}</textarea>
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="email" class="col-sm-3 control-label">Description</label>
	                  <div class="col-sm-8">
	                  	<textarea readonly class="form-control">{{$row->description}}</textarea>
	                  </div>
	                </div>

	              </div>
	              <!-- /.box-body -->
	              <div class="box-footer" style="text-align: center;">
	              	<a class="btn btn-danger" href="{{ route($page.'.change-status', ['id' => $row->id, 'status' => 1]) }}" onclick="return confirm('You will reject this {{$page}}, continue')">
	              		Reject
	              	</a>
	              	<a class="btn btn-success" href="{{ route($page.'.change-status', ['id' => $row->id, 'status' => 2]) }}" onclick="return confirm('You will approve this {{$page}}, continue')">
	              		Approve
	              	</a>
	              </div>
	              <!-- /.box-footer -->
	            </form>
	          </div>
          </div>
    </section>

@endsection