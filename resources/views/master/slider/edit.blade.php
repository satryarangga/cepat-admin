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
	                  <img src="{{asset('images/slider/'.$row->filename)}}" style="width: 200px; height: 200px" />
	                  <label for="logo" class="col-sm-2 control-label">Slider Image</label>
	                  <div class="col-sm-10">
	                  	<input type="file" name="filename">
	                  </div>
	                </div>
	                <div class="form-group">
	                  <label for="caption" class="col-sm-2 control-label">Caption</label>
	                  <div class="col-sm-10">
	                    <input type="text" class="form-control" name="caption" value="{{$row->caption}}" id="caption" placeholder="Caption">
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