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
	                  <label for="name" class="col-sm-2 control-label">Promo Name</label>
	                  <div class="col-sm-10">
	                    <input type="text" class="form-control" name="name" value="{{$row->name}}" id="name" placeholder="Promo Name">
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label for="logo" class="col-sm-2 control-label">Banner</label>
	                  <img src="{{asset('images/promo/'.$row->banner)}}" style="width: 100px; height: 100px" />
	                  <div class="col-sm-10">
	                  	<input type="file" name="banner">
	                  </div>
	                </div>

	                <div class="form-group">
		              <label class="col-sm-2 control-label">Start Date</label>
		              <div class="col-sm-10">
		              	<input type="text" name="start_date" value="{{date('Y-m-d', strtotime($row->start_on))}}" class="form-control datepicker">
		          	  </div>
		            </div>

		            <div class="bootstrap-timepicker">
		              <div class="form-group">
		                <label class="control-label col-sm-2">Start Time:</label>

		                <div class="col-sm-10">
		                  <input type="text" name="start_time" value="{{date('g:i A', strtotime($row->start_on))}}" class="form-control timepicker">
		                </div>
		                <!-- /.input group -->
		              </div>
		              <!-- /.form group -->
		            </div>

		            <div class="form-group">
	      			  <label class="control-label col-sm-2">Time Type</label>
	      			  <div class="col-sm-10">
	      			  	<select class="form-control" name="type">
			                <option @if($row->type == 1) selected @endif value="1">Days</option>
			                <option @if($row->type == 2) selected @endif value="2">Hours</option>
			                <option @if($row->type == 3) selected @endif value="3">Minutes</option>
			                <option @if($row->type == 4) selected @endif value="4">Seconds</option>
			            </select>
	      			  </div>
	      			</div>
		            <div class="form-group">
		              <label class="control-label col-sm-2">Time Value</label>
		              <div class="col-sm-10">
		              	<input type="number" value="{{$row->duration}}" name="duration" class="form-control">
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