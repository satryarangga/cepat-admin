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
		        {!! session('displayMessage') !!}
	            <form class="form-horizontal" action="{{route("$page.update", ['id' => $row->id])}}" method="post" enctype="multipart/form-data">
	            	{{csrf_field()}}
	            	<div class="box-body">
		                <div class="form-group">
		                  <label for="name" class="col-sm-3 control-label">Name</label>
		                  <div class="col-sm-8">
		                    <input type="text" class="form-control" name="name" value="{{$row->name}}" id="name" placeholder="Name">
		                  </div>
		                </div>
	              	</div>

	              	<div class="form-group">
	                  <label for="parent_id" class="col-sm-3 control-label">Category Parent</label>
	                  <div class="col-sm-8">
	                  	<select name="parent_id" class="form-control">
	                  		<option disabled selected>Select Category Parent</option>
	                  		@foreach($parent as $key => $val)
	                  			<option @if($row->parent_id == $val->id) selected @endif value="{{$val->id}}">{{$val->name}}</option>
	                  		@endforeach
	                  	</select>
	                  </div>
	                </div>
	              <!-- /.box-body -->
	              <div class="box-footer">
	                <button type="submit" class="btn btn-info pull-right">Submit</button>
	              </div>
	              <!-- /.box-footer -->
	              {{ method_field('PUT') }}
	            </form>
	          </div>
          </div>
    </section>

@endsection