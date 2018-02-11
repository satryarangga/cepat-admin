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
	                  <label for="name" class="col-sm-3 control-label">Promo Name</label>
	                  <div class="col-sm-9">
	                    <input type="text" class="form-control" name="name" value="{{old('name')}}" id="name" placeholder="Promo Name">
	                  </div>
	                </div>

	                <div class="form-group">
		              <label for="image" class="col-sm-3 control-label">Banner Images * 400 x 400 pixels</label>
		              <div class="col-sm-9">
		                <input type="file" name="banner">
		              </div>
		            </div>

	                <div class="form-group">
		              <label class="col-sm-3 control-label">Start Date</label>
		              <div class="col-sm-9">
		              	<input type="text" name="start_date" class="form-control datepicker">
		          	  </div>
		            </div>

		            <div class="bootstrap-timepicker">
		              <div class="form-group">
		                <label class="control-label col-sm-3">Start Time:</label>

		                <div class="col-sm-9">
		                  <input type="text" name="start_time" class="form-control timepicker">
		                </div>
		                <!-- /.input group -->
		              </div>
		              <!-- /.form group -->
		            </div>

		            <div class="form-group">
	      			  <label class="control-label col-sm-3">Time Type</label>
	      			  <div class="col-sm-9">
	      			  	<select class="form-control" name="type">
			                <option value="1">Days</option>
			                <option value="2">Hours</option>
			                <option value="3">Minutes</option>
			                <option value="4">Seconds</option>
			            </select>
	      			  </div>
	      			</div>
		            <div class="form-group">
		              <label class="control-label col-sm-3">Time Value</label>
		              <div class="col-sm-9">
		              	<input type="number" name="duration" class="form-control">
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